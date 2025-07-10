<?php

namespace Tangibledesign\Framework\Models\User\Helpers;

use Tangibledesign\Framework\Models\Helpers\HasMeta;

trait HasPhone
{
    use HasMeta;

    public function setPhone($phone): bool
    {
        if (!empty($phone) && tdf_settings()->isUserPhoneUnique()) {
            $users = tdf_query_users()->wherePhone($phone)->get();
            if ($users->count() > 0) {
                $user = $users->first();
                if ($user->getId() !== $this->getId()) {
                    return false;
                }
            }
        }

        if ($phone !== $this->getPhone()) {
            update_user_meta($this->getId(), UserSettingKey::VERIFIED, 0);
        }

        $this->setMeta(UserSettingKey::PHONE, $phone);

        return true;
    }

    public function getPhone(): string
    {
        $phone = (string)$this->getMeta(UserSettingKey::PHONE);

        if (!tdf_settings()->isPhoneCountryCodeSelectEnabled()) {
            return $phone;
        }

        return str_replace('+' . $this->getPhoneNumberCountryCode(), '', $phone);
    }

    public function getDisplayPhone(): string
    {
        if (tdf_settings()->isPhoneCountryCodeSelectEnabled()) {
            return $this->getPhoneWithCountryCode();
        }

        return $this->getPhone();
    }

    public function getPhoneWithCountryCode(): string
    {
        return $this->prependCountryCode($this->getPhone(), $this->getPhoneNumberCountryCode());
    }

    private function prependCountryCode(string $phone, ?string $countryCode): string
    {
        if (empty($countryCode)) {
            return $phone;
        }

        if (is_rtl()) {
            return $countryCode . $phone . '+';
        }

        return '+' . $countryCode . $phone;
    }

    public function getPhoneNumberCountryCode(): int
    {
        $currentCode = $this->getPhoneCountryCode();
        if (is_numeric($currentCode)) {
            return (int)$currentCode;
        }

        foreach (tdf_app('phone_country_codes_with_flags') as $text => $code) {
            if ($text === $currentCode) {
                return (int)$code;
            }
        }

        return 0;
    }

    public function hasPhone(): bool
    {
        return !empty($this->getPhone());
    }

    public function getPhoneUrl(): string
    {
        return apply_filters(tdf_prefix() . '/phoneUrl', trim($this->getPhone()), $this);
    }

    public function getWhatsAppUrl(): string
    {
        return str_replace('+', '', $this->getPhoneUrl());
    }

    public function getPhonePlaceholder(): string
    {
        $phone = $this->getPhone();
        if (empty($phone)) {
            return '<span>* * * * * * * * *</span>';
        }

        $phone = str_replace(['(', ')', ' ', '+'], '', $phone);

        if (is_rtl()) {
            return '<span>* * * * * * * * *</span> ' . esc_html(substr($phone, 0, 3));
        }

        return esc_html(substr($phone, 0, 3)) . ' <span>* * * * * * * * *</span>';
    }

    public function setWhatsApp($enabled): void
    {
        $this->setMeta(UserSettingKey::WHATS_APP, (int)$enabled);
    }

    public function isWhatsAppEnabled(): bool
    {
        return !empty((int)$this->getMeta(UserSettingKey::WHATS_APP));
    }

    public function hasWhatsApp(): bool
    {
        return $this->hasPhone() && $this->isWhatsAppEnabled();
    }

    public function setViber($enabled): void
    {
        $this->setMeta(UserSettingKey::VIBER, (int)$enabled);
    }

    public function isViberEnabled(): bool
    {
        return !empty((int)$this->getMeta(UserSettingKey::VIBER));
    }

    public function hasViber(): bool
    {
        return $this->hasPhone() && $this->isViberEnabled();
    }

    public function setPhoneCountryCode($countryCode): void
    {
        $this->setMeta(UserSettingKey::PHONE_COUNTRY_CODE, $countryCode);
    }

    public function getPhoneCountryCode(): string
    {
        if (!tdf_settings()->isPhoneCountryCodeSelectEnabled()) {
            return tdf_app('phone_default_country_code');
        }

        $phoneCountryCode = (string)$this->getMeta(UserSettingKey::PHONE_COUNTRY_CODE);
        if (empty($phoneCountryCode)) {
            return tdf_app('phone_default_country_code');
        }

        return $phoneCountryCode;
    }

}