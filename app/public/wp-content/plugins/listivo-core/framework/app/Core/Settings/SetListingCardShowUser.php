<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetListingCardShowUser
{
    use Setting;

    /**
     * @param int $show
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setListingCardShowUser($show): void
    {
        $this->setSetting(SettingKey::LISTING_CARD_SHOW_USER, (int)$show);
    }

    /**
     * @return bool
     */
    public function showUserOnCard(): bool
    {
        return tdf_app('card_show_user');
    }

}