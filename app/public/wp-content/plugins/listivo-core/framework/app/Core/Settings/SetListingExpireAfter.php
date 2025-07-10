<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetListingExpireAfter
{
    use Setting;
    
    public function getListingExpireAfter(): int
    {
        return (int)$this->getSetting(SettingKey::LISTING_EXPIRE_AFTER);
    }

    public function setListingExpireAfter($expireListingAfter): void
    {
        $this->setSetting(SettingKey::LISTING_EXPIRE_AFTER, (int)$expireListingAfter);
    }
}