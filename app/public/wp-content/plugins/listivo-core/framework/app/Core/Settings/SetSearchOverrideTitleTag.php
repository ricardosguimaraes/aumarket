<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetSearchOverrideTitleTag
{
    use Setting;

    /**
     * @param int $override
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setSearchOverrideTitleTag($override): void
    {
        $this->setSetting(SettingKey::SEARCH_OVERRIDE_TITLE_TAG, (int)$override);
    }

    /**
     * @return bool
     */
    public function searchOverrideTitleTag(): bool
    {
        return apply_filters(tdf_prefix() . '/search/dynamicTitle', !empty((int)$this->getSetting(SettingKey::SEARCH_OVERRIDE_TITLE_TAG)));
    }

}