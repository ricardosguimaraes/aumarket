<?php


namespace Tangibledesign\Framework\Providers;


use Tangibledesign\Framework\Core\ServiceProvider;

/**
 * Class ConfigServiceProvider
 * @package Tangibledesign\Framework\Providers
 */
class ConfigServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function initiation(): void
    {
        foreach (apply_filters('tdf/config', []) as $key => $value) {
            $this->container[$key] = $value;
        }
    }

}