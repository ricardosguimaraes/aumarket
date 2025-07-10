<?php


namespace Tangibledesign\Framework\Core\Settings;


/**
 * Trait SetPrimaryColor
 * @package Tangibledesign\Framework\Core\Settings
 */
trait SetPrimaryColor
{
    use Setting;

    /**
     * @param string $color
     */
    public function setPrimary1Color(string $color): void
    {
        $this->setSetting(SettingKey::PRIMARY_1_COLOR, $color);
    }

    /**
     * @return string
     */
    public function getPrimary1Color(): string
    {
        $color = $this->getSetting(SettingKey::PRIMARY_1_COLOR);

        if (empty($color)) {
            return '#da1c2e';
        }

        return $color;
    }

    /**
     * @param string $color
     */
    public function setPrimary2Color(string $color): void
    {
        $this->setSetting(SettingKey::PRIMARY_2_COLOR, $color);
    }

    /**
     * @return string
     */
    public function getPrimary2Color(): string
    {
        $color = $this->getSetting(SettingKey::PRIMARY_2_COLOR);

        if (empty($color)) {
            return '#b81726';
        }

        return $color;
    }

    /**
     * @param string $color
     */
    public function setPrimary3Color(string $color): void
    {
        $this->setSetting(SettingKey::PRIMARY_3_COLOR, $color);
    }

    /**
     * @return string
     */
    public function getPrimary3Color(): string
    {
        $color = $this->getSetting(SettingKey::PRIMARY_3_COLOR);

        if (empty($color)) {
            return '#fff3f4';
        }

        return $color;
    }

    /**
     * @param string $color
     */
    public function setSecondary1Color(string $color): void
    {
        $this->setSetting(SettingKey::SECONDARY_1_COLOR, $color);
    }

    /**
     * @return string
     */
    public function getSecondary1Color(): string
    {
        $color = $this->getSetting(SettingKey::SECONDARY_1_COLOR);

        if (empty($color)) {
            return '#ffc14a';
        }

        return $color;
    }

    /**
     * @param string $color
     */
    public function setSecondary2Color(string $color): void
    {
        $this->setSetting(SettingKey::SECONDARY_2_COLOR, $color);
    }

    /**
     * @return string
     */
    public function getSecondary2Color(): string
    {
        $color = $this->getSetting(SettingKey::SECONDARY_2_COLOR);

        if (empty($color)) {
            return '#f2af2f';
        }

        return $color;
    }

    /**
     * @param string $color
     */
    public function setSupport1Color(string $color): void
    {
        $this->setSetting(SettingKey::SUPPORT_1_COLOR, $color);
    }

    /**
     * @return string
     */
    public function getSupport1Color(): string
    {
        $color = $this->getSetting(SettingKey::SUPPORT_1_COLOR);

        if (empty($color)) {
            return '#b15dff';
        }

        return $color;
    }

    /**
     * @param string $color
     */
    public function setCardLabelColor(string $color): void
    {
        $this->setSetting(SettingKey::CARD_LABEL_COLOR, $color);
    }

    /**
     * @return string
     */
    public function getCardLabelColor(): string
    {
        $color = $this->getSetting(SettingKey::CARD_LABEL_COLOR);

        if (empty($color)) {
            return '#ffa800';
        }

        return $color;
    }


}