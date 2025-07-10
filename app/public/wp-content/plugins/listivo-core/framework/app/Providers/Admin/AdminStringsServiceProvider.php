<?php

namespace Tangibledesign\Framework\Providers\Admin;

use Tangibledesign\Framework\Core\ServiceProvider;

/**
 * Class AdminStringsServiceProvider
 * @package Tangibledesign\Framework\Providers
 */
class AdminStringsServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function initiation(): void
    {
        foreach ($this->getDefinitions() as $key => $value) {
            $this->container[$key] = $value;
        }
    }

    /**
     * @return array
     */
    private function getDefinitions(): array
    {
        $strings = [];

        foreach (apply_filters('tdf/admin/strings', []) as $key => $value) {
            $strings[$key.'_admin_string'] = $value;
        }

        return $strings;
    }

}