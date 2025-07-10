<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetDesign
{
    use Setting;

    /**
     * @param int $radius
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setBorderRadius($radius): void
    {
        $this->setSetting(SettingKey::BORDER_RADIUS, $radius);
    }

    /**
     * @return int
     */
    public function getBorderRadius(): int
    {
        $radius = $this->getSetting(SettingKey::BORDER_RADIUS);
        if ($radius === null) {
            return 8;
        }

        return (int)$radius;
    }

    /**
     * @param string $style
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setHeadingStyle($style): void
    {
        $this->setSetting(SettingKey::HEADING_STYLE, $style);
    }

    /**
     * @return string
     */
    public function getHeadingStyle(): string
    {
        $style = $this->getSetting(SettingKey::HEADING_STYLE);
        if (empty($style)) {
            return 'style_1';
        }

        return $style;
    }

}