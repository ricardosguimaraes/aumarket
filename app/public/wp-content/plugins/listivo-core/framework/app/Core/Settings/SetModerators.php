<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetModerators
{
    use Setting;

    /**
     * @param array $userIds
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setModerators($userIds): void
    {
        $this->setSetting(SettingKey::MODERATORS, $userIds);
    }

    public function getModeratorIds(): array
    {
        $userIds = $this->getSetting(SettingKey::MODERATORS);

        if (empty($userIds) || !is_array($userIds)) {
            return [];
        }

        return tdf_collect($userIds)->map(static function ($userId) {
            return (int)$userId;
        })->values();
    }
}