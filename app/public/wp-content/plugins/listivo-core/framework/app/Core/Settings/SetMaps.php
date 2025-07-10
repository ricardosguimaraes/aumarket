<?php


namespace Tangibledesign\Framework\Core\Settings;


/**
 * Trait SetMaps
 * @package Tangibledesign\Framework\Core\Settings
 */
trait SetMaps
{
    use Setting;

    /**
     * @param int $zoomLevel
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setMapZoomLevel($zoomLevel): void
    {
        $this->setSetting(SettingKey::MAP_ZOOM_LEVEL, (int)$zoomLevel);
    }

    /**
     * @return int
     */
    public function getMapZoomLevel(): int
    {
        $zoomLevel = (int)$this->getSetting(SettingKey::MAP_ZOOM_LEVEL);

        if (empty($zoomLevel)) {
            return 6;
        }

        return $zoomLevel;
    }

    /**
     * @param string $language
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setMapLanguage($language): void
    {
        $this->setSetting(SettingKey::MAP_LANGUAGE, (string)$language);
    }

    /**
     * @return string
     */
    public function getMapLanguage(): string
    {
        $lang = (string)$this->getSetting(SettingKey::MAP_LANGUAGE);

        if (empty($lang)) {
            return 'en';
        }

        return $lang;
    }

    /**
     * @param string $apiKey
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setGoogleMapsApiKey($apiKey): void
    {
        $this->setSetting(SettingKey::GOOGLE_MAPS_API_KEY, (string)$apiKey);
    }

    /**
     * @return string
     */
    public function getGoogleMapsApiKey(): string
    {
        return (string)$this->getSetting(SettingKey::GOOGLE_MAPS_API_KEY);
    }

    /**
     * @param string $snazzyCode
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setMapSnazzy($snazzyCode): void
    {
        $this->setSetting(SettingKey::MAP_SNAZZY, $snazzyCode);
    }

    /**
     * @return string
     */
    public function getMapSnazzy(): string
    {
        return (string)$this->getSetting(SettingKey::MAP_SNAZZY);
    }

    /**
     * @param array $location
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setMapInitialLocation($location): void
    {
        $this->setSetting(SettingKey::MAP_INITIAL_LOCATION, $location);
    }

    /**
     * @return array
     */
    public function getMapInitialLocation(): array
    {
        $location = $this->getSetting(SettingKey::MAP_INITIAL_LOCATION);

        if (!is_array($location) || !isset($location['lat'], $location['lng'])) {
            return [
                'lng' => -74.0060,
                'lat' => 40.7128,
            ];
        }

        return [
            'lat' => (double)$location['lat'],
            'lng' => (double)$location['lng'],
        ];
    }

    /**
     * @param string $provider
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setMapProvider($provider): void
    {
        $this->setSetting(SettingKey::MAP_PROVIDER, $provider);
    }

    /**
     * @return string
     */
    public function getMapProvider(): string
    {
        $provider = $this->getSetting(SettingKey::MAP_PROVIDER);
        if (empty($provider)) {
            return SettingKey::MAP_PROVIDER_GOOGLE_MAPS;
        }

        return $provider;
    }

}