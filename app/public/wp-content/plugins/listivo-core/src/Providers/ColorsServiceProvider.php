<?php

namespace Tangibledesign\Listivo\Providers;

use Elementor\Plugin;
use Tangibledesign\Framework\Core\ServiceProvider;

class ColorsServiceProvider extends ServiceProvider
{

    public function initiation(): void
    {
        $this->container['colors'] = static function () {
            $kit = Plugin::instance()->kits_manager->get_active_kit();
            if (!$kit) {
                return [];
            }

            $settings = $kit->get_settings_for_display('system_colors');

            if (!is_array($settings)) {
                return [];
            }

            $colors = [];

            foreach ($settings as $setting) {
                $colors[$setting['_id']] = ($setting['color'] ?? '');
            }

            return $colors;
        };

        $this->container['lprimary1'] = static function () {
            $colors = tdf_app('colors');

            return $colors['lprimary1'] ?? '#537CD9';
        };

        $this->container['lprimary2'] = static function () {
            $colors = tdf_app('colors');

            return $colors['lprimary2'] ?? '#F09965';
        };

        $this->container['lcolor1'] = static function () {
            $colors = tdf_app('colors');

            return $colors['lcolor1'] ?? '#2A3946';
        };

        $this->container['lcolor2'] = static function () {
            $colors = tdf_app('colors');

            return $colors['lcolor2'] ?? '#455867';
        };

        $this->container['lcolor3'] = static function () {
            $colors = tdf_app('colors');

            return $colors['lcolor3'] ?? '#D5E3EE';
        };


        $this->container['lcolor4'] = static function () {
            $colors = tdf_app('colors');

            return $colors['lcolor4'] ?? '#E6F0FA';
        };

        $this->container['lcolor5'] = static function () {
            $colors = tdf_app('colors');

            return $colors['lcolor5'] ?? '#FDFDFE';
        };

        $this->container['lsectionbg'] = static function () {
            $colors = tdf_app('colors');

            return $colors['lsectionbg'] ?? '#F8FAFD';
        };
    }

    public function afterInitiation(): void
    {
        add_action(tdf_prefix() . '/demoImporter/finished', [$this, 'updateColorsSettings']);

        add_action(tdf_prefix() . '/dynamicCss', [$this, 'createVariables']);

        add_action('admin_init', [$this, 'checkColors']);
    }

    public function createVariables(): void
    {
        ?>
        :root {
        --e-global-color-lprimary1: <?php echo esc_html(tdf_app('lprimary1')); ?>;
        --e-global-color-lprimary2: <?php echo esc_html(tdf_app('lprimary2')); ?>;
        --e-global-color-lcolor1: <?php echo esc_html(tdf_app('lcolor1')); ?>;
        --e-global-color-lcolor2: <?php echo esc_html(tdf_app('lcolor2')); ?>;
        --e-global-color-lcolor3: <?php echo esc_html(tdf_app('lcolor3')); ?>;
        --e-global-color-lcolor4: <?php echo esc_html(tdf_app('lcolor4')); ?>;
        --e-global-color-lcolor5: <?php echo esc_html(tdf_app('lcolor5')); ?>;
        --e-global-color-lcolor5-op-1: <?php echo esc_html($this->hex2rgba(tdf_app('lcolor5'), 0.95)); ?>;
        --e-global-color-lcolor5-op-2: <?php echo esc_html($this->hex2rgba(tdf_app('lcolor5'), 0.15)); ?>;
        }
        <?php
    }

    public function checkColors(): void
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        $kit = Plugin::instance()->kits_manager->get_active_kit();
        if (!$kit || $kit->get_id() === 0) {
            return;
        }

        $settings = $kit->get_settings_for_display('system_colors');
        if (!is_array($settings)) {
            $settings = [];
        }

        $change = false;

        foreach ($settings as $key => $setting) {
            if (in_array($setting['_id'], [
                'primary',
                'secondary',
                'text',
                'accent',
            ])) {
                unset($settings[$key]);

                $change = true;
            } else {
                $settings[$key]['title'] = str_replace('Listivo ', '', $setting['title']);
            }
        }

        if (!$change) {
            return;
        }

        $kit->set_settings('system_colors', tdf_collect($settings)->values());
        $kit->save(['settings' => $kit->get_settings()]);
    }

    public function updateColorsSettings(): void
    {
        $kit = Plugin::instance()->kits_manager->get_active_kit();
        if (!$kit) {
            return;
        }

        $settings = $kit->get_settings_for_display('system_colors');
        if (!is_array($settings)) {
            $settings = [];
        }

        $change = false;

        foreach ($this->getColors() as $colorSettings) {
            if (!$this->exists($colorSettings, $settings)) {
                $settings[] = $colorSettings;

                $change = true;
            }
        }

        if (!$change) {
            return;
        }

        $kit->set_settings('system_colors', $settings);
        $kit->save(['settings' => $kit->get_settings()]);
    }

    private function getColors(): array
    {
        return [
            [
                '_id' => 'lprimary1',
                'title' => esc_html__('Primary 1', 'listivo-core'),
                'color' => '#537CD9',
            ],
            [
                '_id' => 'lprimary2',
                'title' => esc_html__('Primary 2', 'listivo-core'),
                'color' => '#F09965',
            ],
            [
                '_id' => 'lcolor1',
                'title' => esc_html__('Color 1', 'listivo-core'),
                'color' => '#2A3946',
            ],
            [
                '_id' => 'lcolor2',
                'title' => esc_html__('Color 2', 'listivo-core'),
                'color' => '#455867',
            ],
            [
                '_id' => 'lcolor3',
                'title' => esc_html__('Color 3', 'listivo-core'),
                'color' => '#D5E3EE',
            ],
            [
                '_id' => 'lcolor4',
                'title' => esc_html__('Color 4', 'listivo-core'),
                'color' => '#E6F0FA',
            ],
            [
                '_id' => 'lcolor5',
                'title' => esc_html__('Color 5', 'listivo-core'),
                'color' => '#FDFDFE',
            ],
            [
                '_id' => 'lsectionbg',
                'title' => esc_html__('Section Background', 'listivo-core'),
                'color' => '#F8FAFD',
            ],
        ];
    }

    private function exists(array $colorSettings, array $settings): bool
    {
        foreach ($settings as $setting) {
            if ($setting['_id'] === $colorSettings['_id']) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $color
     * @param float|int $opacity
     * @return string
     */
    private function hex2rgba(string $color, float $opacity = 0): string
    {
        $data = str_split(str_replace('#', '', $color), 2);

        $output = [];

        foreach ($data as $d) {
            $output[] = hexdec($d);
        }

        return 'rgba(' . implode(',', $output) . ', ' . $opacity . ')';
    }

}