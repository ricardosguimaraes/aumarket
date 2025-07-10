<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetKeywordSearchDescription
{
    use Setting;

    /**
     * @param int $value
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setKeywordSearchDescription($value): void
    {
        $this->setSetting(SettingKey::KEYWORD_SEARCH_DESCRIPTION, (int)$value);
    }

    /**
     * @return bool
     */
    public function keywordSearchDescription(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::KEYWORD_SEARCH_DESCRIPTION));
    }

}