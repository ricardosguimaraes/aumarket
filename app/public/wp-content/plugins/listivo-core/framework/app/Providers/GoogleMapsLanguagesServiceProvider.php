<?php


namespace Tangibledesign\Framework\Providers;


use Tangibledesign\Framework\Core\ServiceProvider;

/**
 * Class GoogleMapsLanguagesServiceProvider
 * @package Tangibledesign\Framework\Providers
 */
class GoogleMapsLanguagesServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function initiation(): void
    {
        $this->container['google_map_languages'] = static function () {
            return apply_filters('tdf/googleMaps/languages', []);
        };
    }

}