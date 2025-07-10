<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetKeywordSearchTerms
{
    use Setting;

    /**
     * @param int $enabled
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setKeywordSearchTerms($enabled): void
    {
        $this->setSetting(SettingKey::KEYWORD_SEARCH_TERMS, (int)$enabled);
    }

    /**
     * @return bool
     */
    public function isKeywordSearchTermsEnabled(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::KEYWORD_SEARCH_TERMS));
    }

}