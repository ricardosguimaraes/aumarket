<?php

namespace Tangibledesign\Framework\Providers\Admin;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Core\Settings\SettingKey;
use Tangibledesign\Framework\Models\Field\Field;

class AdminScriptsServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('admin_enqueue_scripts', [$this, 'load']);

        add_action('elementor/editor/before_enqueue_scripts', [$this, 'load']);
    }

    public function load(): void
    {
        $this->loadSweetAlert2();

        $this->loadMainJs();

        $this->loadMainCss();

        $this->loadSelectize();

        $this->loadTreeSelect();

        $this->loadGoogleMaps();

        $this->loadOpenStreetMap();

        $this->loadElementor();

        $this->loadFontAwesome();

        $this->loadVueSelect();

        wp_enqueue_media();
    }

    private function loadVueSelect(): void
    {
        wp_enqueue_style('vue-select', tdf_app('url').'assets/css/vue-select.min.css');
    }

    private function loadFontAwesome(): void
    {
        wp_enqueue_style('font-awesome', tdf_app('url').'framework/assets/css/all.min.css');
    }

    private function loadMainCss(): void
    {
        wp_enqueue_style(tdf_prefix().'-core', tdf_app('url').'assets/css/main.css', ['selectize'],
            tdf_app('version'));

        wp_enqueue_style('google-font-roboto',
            'https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');
    }

    private function loadElementor(): void
    {
        wp_enqueue_script(tdf_prefix().'-elementor', tdf_app('url').'/framework/assets/js/elementor.js', ['jquery'],
            '1.0.0', true);

        wp_localize_script(tdf_prefix().'-elementor', 'tdfElementor', [
            'fields' => tdf_fields()->map(static function ($field) {
                /* @var Field $field */
                return [
                    'key' => $field->getKey(),
                    'name' => $field->getName(),
                ];
            })->values()
        ]);
    }

    private function loadMainJs(): void
    {
        wp_enqueue_media();

        wp_enqueue_script(tdf_prefix().'-admin', tdf_app('url').'assets/js/backend.min.js', ['jquery'],
            tdf_app('version'), true);

        ob_start();
        ?>
        jQuery(document).ready(function() {
        jQuery('body').attr('data-prefix', '<?php echo esc_attr(tdf_prefix()); ?>');
        });
        <?php

        wp_add_inline_script(tdf_prefix().'-admin', ob_get_clean(), 'before');
    }

    private function loadSelectize(): void
    {
        wp_enqueue_script('selectize', tdf_app('url').'/framework/assets/js/selectize.min.js', ['jquery'], '0.13.0',
            true);

        ob_start();
        ?>
        jQuery(document).ready(function() {
        if (jQuery('.tdf-selectize-init').length > 0) {
        jQuery('.tdf-selectize-init').selectize();
        }
        });
        <?php
        wp_add_inline_script('selectize', ob_get_clean());

        wp_enqueue_style('selectize', tdf_app('url').'/framework/assets/css/selectize.min.css');
    }

    private function loadTreeSelect(): void
    {
        wp_enqueue_style('tree-select', tdf_app('url').'/framework/assets/css/treeselect.min.css');
    }

    private function loadOpenStreetMap(): void
    {
        if (tdf_settings()->getMapProvider() !== SettingKey::MAP_PROVIDER_OPEN_STREET_MAP) {
            return;
        }

        wp_enqueue_style('leaflet', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.css');

        wp_enqueue_script('leaflet', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.js', [], false, true);
    }

    /** @noinspection DuplicatedCode */
    private function loadGoogleMaps(): void
    {
        if (empty(tdf_settings()->getGoogleMapsApiKey())) {
            return;
        }

        $url = '//maps.googleapis.com/maps/api/js?key='.tdf_settings()->getGoogleMapsApiKey().'&libraries=places&callback=mapLoaded&v=3.59';
        if (!empty(tdf_settings()->getMapLanguage())) {
            $url .= '&language='.tdf_settings()->getMapLanguage();
        }

        wp_enqueue_script('google-maps', $url, [], false, true);

        $snazzyCode = trim(tdf_settings()->getMapSnazzy());
        if (empty($snazzyCode)) {
            return;
        }
        ob_start();
        ?>
        var mapSnazzy = <?php echo tdf_settings()->getMapSnazzy(); ?>;
        <?php

        wp_add_inline_script('google-maps', ob_get_clean());
    }

    private function loadSweetAlert2(): void
    {
        wp_enqueue_script('sweetalert2', tdf_app('url').'/assets/js/sweetalert2.min.js', ['jquery'], '11.0.12', true);

        wp_enqueue_style('sweetalert2', tdf_app('url').'/assets/css/sweetalert2.min.css', [], '11.0.12');
    }

}