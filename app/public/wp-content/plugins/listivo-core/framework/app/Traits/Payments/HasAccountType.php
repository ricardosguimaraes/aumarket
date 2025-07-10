<?php

namespace Tangibledesign\Framework\Traits\Payments;

use Tangibledesign\Framework\Models\Helpers\HasMeta;
use Tangibledesign\Framework\Models\User\Helpers\UserSettingKey;
use Tangibledesign\Framework\Models\User\User;

trait HasAccountType
{
    use HasMeta;

    public function setUserAccountType($accountType): void
    {
        $this->setMeta('user_account_type', (string)$accountType);
    }

    public function getUserAccountType(): string
    {
        $accountType = $this->getMeta('user_account_type');
        if (empty($accountType)) {
            return 'any';
        }

        return $accountType;
    }

    public function getUserAccountTypeLabel(): string
    {
        $accountType = $this->getUserAccountType();
        if ($accountType === UserSettingKey::ACCOUNT_TYPE_PRIVATE) {
            return tdf_string('private_account_type');
        }

        if ($accountType === UserSettingKey::ACCOUNT_TYPE_BUSINESS) {
            return tdf_string('business');
        }

        return tdf_string('any');
    }

    public function isUserValid(User $user): bool
    {
        if (!tdf_settings()->isAccountTypeEnabled()) {
            return true;
        }

        if ($this->getUserAccountType() === 'any') {
            return true;
        }

        return $this->getUserAccountType() === $user->getAccountType();
    }

}