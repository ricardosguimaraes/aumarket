<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetSearchDefaultTitle
{
    use Setting;

    public function setSearchDefaultTitle($title): void
    {
        $this->setSetting(SettingKey::SEARCH_DEFAULT_TITLE, $title);
    }

    public function getSearchDefaultTitle(): string
    {
        return (string)$this->getSetting(SettingKey::SEARCH_DEFAULT_TITLE);
    }

    public function setSearchDefaultDescription($description): void
    {
        $this->setSetting(SettingKey::SEARCH_DEFAULT_DESCRIPTION, $description);
    }

    public function getSearchDefaultDescription(): string
    {
        return (string)$this->getSetting(SettingKey::SEARCH_DEFAULT_DESCRIPTION);
    }
}