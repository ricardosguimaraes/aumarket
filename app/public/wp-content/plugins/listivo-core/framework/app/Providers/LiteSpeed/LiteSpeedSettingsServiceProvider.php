<?php

namespace Tangibledesign\Framework\Providers\LiteSpeed;

use Tangibledesign\Framework\Core\ServiceProvider;

class LiteSpeedSettingsServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('litespeed_init', [$this, 'applySettings']);
    }

    public function applySettings(): void
    {
        foreach ($this->getSettings() as $key => $value) {
            if (is_array($value)) {
                $value = array_unique(array_merge($value, $this->getCurrentSettings($key)));
            }

            do_action('litespeed_conf_force', $key, $value);
        }


        if (is_user_logged_in()) {
            do_action('litespeed_control_set_nocache', 'nocache due to logged in');
        }
    }

    private function getSettings(): array
    {
        return apply_filters(tdf_prefix() . '/litespeed/config', [
            'cache-priv' => 0,
            'cache-browser' => 0,
            'cache-exc' => [
                '/panel/',
                '/login-register/',
                '/' . tdf_slug('user') . '/',
                '/' . tdf_slug('listing') . '/',
            ],
            'cache-exc_roles' => [
                'administrator',
            ],
            'object-admin' => 0,
            'util-instant_click' => 1,
            'media-lazy' => 0,
            'optm-exc' => [
                '/panel/',
                '/login-register/',
            ],
            'optm-guest_only' => 1,
            'optm-exc_roles' => [
                'administrator',
            ],
            'optm-js_exc' => [
                'jquery.js',
                'jquery.min.js',
                'maps',
            ],
        ]);
    }

    private function getCurrentSettings(string $key): array
    {
        $val = apply_filters('litespeed_conf', $key);
        if (is_array($val)) {
            return $val;
        }

        return [];
    }
}