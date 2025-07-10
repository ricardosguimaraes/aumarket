<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetMapDefaultRadius
{
    use Setting;

    public function setMapDefaultRadius($radius): void
    {
        $this->setSetting(SettingKey::MAP_DEFAULT_RADIUS, (int)$radius);
    }

    public function getMapDefaultRadius(): int
    {
        $radius = $this->getSetting(SettingKey::MAP_DEFAULT_RADIUS);
        if ($radius === '0' || $radius === 0) {
            return 0;
        }

        if (empty($radius)) {
            return 30;
        }

        return (int)$radius;
    }

    public function setMapRadiusUnit($unit): void
    {
        $this->setSetting(SettingKey::MAP_RADIUS_UNIT, $unit);
    }

    public function getMapRadiusUnit(): string
    {
        $unit = $this->getSetting(SettingKey::MAP_RADIUS_UNIT);
        if (empty($unit)) {
            return SettingKey::MAP_RADIUS_UNIT_MILES;
        }

        return $unit;
    }

    public function getDefaultMapRadiusValue(): int
    {
        $value = $this->getMapDefaultRadius();
        if ($this->getMapRadiusUnit() === SettingKey::MAP_RADIUS_UNIT_MILES) {
            return $value * 1609;
        }

        return $value * 1000;
    }

}