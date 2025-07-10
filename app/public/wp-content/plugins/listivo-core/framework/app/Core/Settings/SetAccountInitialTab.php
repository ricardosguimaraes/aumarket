<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetAccountInitialTab
{
    use Setting;

    /**
     * @param string $tab
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setAccountInitialTab($tab): void
    {
        $this->setSetting(SettingKey::ACCOUNT_INITIAL_TAB, $tab);
    }

    /**
     * @return string
     */
    public function getInitialTab(): string
    {
        if (!tdf_settings()->userRegistrationOpen()) {
            return SettingKey::ACCOUNT_TAB_LOGIN;
        }

        $tab = $this->getTabFromUrl();

        if (empty($tab)) {
            $tab = $this->getSetting(SettingKey::ACCOUNT_INITIAL_TAB);
        }

        if (empty($tab)) {
            return SettingKey::ACCOUNT_TAB_LOGIN;
        }

        return $tab;
    }

    /**
     * @return string
     */
    protected function getTabFromUrl(): string
    {
        $tab = $_GET[tdf_slug('tab')] ?? '';

        if ($tab === tdf_slug('login')) {
            return SettingKey::ACCOUNT_TAB_LOGIN;
        }

        if ($tab === tdf_slug('register')) {
            return SettingKey::ACCOUNT_TAB_REGISTER;
        }

        return '';
    }

}