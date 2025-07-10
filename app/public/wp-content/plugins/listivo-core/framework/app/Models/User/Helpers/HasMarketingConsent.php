<?php

namespace Tangibledesign\Framework\Models\User\Helpers;

use MC4WP_MailChimp;
use Tangibledesign\Framework\Models\Helpers\HasMeta;

trait HasMarketingConsent
{
    use HasMeta;

    public function setMarketingConsent($marketingConsent): void
    {
        if (empty($marketingConsent) && $this->hasMarketingConsent()) {
            do_action(tdf_prefix() . '/user/marketingConsent/removed', $this);
        }

        if (!empty($marketingConsent) && !$this->hasMarketingConsent()) {
            do_action(tdf_prefix() . '/user/marketingConsent/added', $this);
        }

        $this->setMeta(UserSettingKey::MARKETING_CONSENT, (int)$marketingConsent);
    }

    public function hasMarketingConsent(): bool
    {
        return !empty((int)$this->getMeta(UserSettingKey::MARKETING_CONSENT));
    }
}