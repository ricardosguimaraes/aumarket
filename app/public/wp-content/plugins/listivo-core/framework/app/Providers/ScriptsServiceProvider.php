<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Core\Settings\SettingKey;
use Tangibledesign\Framework\Models\Field\LocationField;

class ScriptsServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('wp_enqueue_scripts', [$this, 'scripts']);

        add_action('wp_footer', static function () {
            $portals = apply_filters('tdf/portals', []);
            ?>
            <div id="footer" class="<?php echo esc_attr(tdf_prefix()); ?>-app">
                <portal-target name="footer"></portal-target>

                <?php foreach ($portals as $portal) : ?>
                    <portal-target name="<?php echo esc_attr($portal); ?>"></portal-target>
                <?php endforeach; ?>
            </div>
            <?php
        });
    }

    public function scripts(): void
    {
        $this->loadLazySizes();

        $this->swiper();

        $this->photoSwipe();

        $this->mainJs();

        $this->loadMaps();

        $this->fontAwesome();

        $this->loadReCaptcha();

        $this->loadSweetAlert2();

        $this->loadDropZone();
    }

    public function loadLazySizes(): void
    {
        wp_enqueue_script('lazysizes', tdf_app('url') . 'framework/assets/js/lazysizes.min.js', [], '5.3.2');

        ob_start();
        ?>
        window.lazySizesConfig = window.lazySizesConfig || {};
        window.lazySizesConfig.loadMode = 1
        window.lazySizesConfig.init = 0
        <?php
        wp_add_inline_script('lazysizes', ob_get_clean(), 'before');
    }

    private function loadDropzone(): void
    {
        $dependency = is_rtl() ? tdf_prefix() . '-rtl' : tdf_prefix();

        wp_register_style('dropzone', tdf_app('url') . 'framework/assets/css/dropzone.min.css', [$dependency]);

        wp_enqueue_style('dropzone');
    }

    private function loadSweetAlert2(): void
    {
        wp_enqueue_script('sweetalert2', tdf_app('url') . 'assets/js/sweetalert2.min.js', ['jquery'], '11.0.12', true);

        wp_enqueue_style('sweetalert2', tdf_app('url') . 'assets/css/sweetalert2.min.css', [], '11.0.12');
    }

    private function loadReCaptcha(): void
    {
        if (!tdf_settings()->reCaptchaEnabled()) {
            return;
        }

        wp_enqueue_script(
            'recaptcha',
            'https://www.google.com/recaptcha/api.js?render=' . tdf_settings()->getReCaptchaSiteKey(),
            [],
            null
        );
    }

    private function photoSwipe(): void
    {
        if (!is_singular(tdf_app('model_post_types')) && !is_singular(tdf_prefix() . '_template')) {
            wp_register_style('photo-swipe', tdf_app('url') . 'assets/css/photoswipe.css', [], '5.3.4');
            return;
        }

        wp_enqueue_style('photo-swipe', tdf_app('url') . 'assets/css/photoswipe.css', [], '5.3.4');
    }

    private function fontAwesome(): void
    {
        wp_enqueue_style('elementor-icons-fa-regular');

        wp_enqueue_style('elementor-icons-fa-solid');

        wp_enqueue_style('elementor-icons-fa-brands');
    }

    private function swiper(): void
    {
        wp_enqueue_script('swiper', tdf_app('url') . 'assets/js/swiper.min.js', ['jquery'], null, true);
    }

    private function mainJs(): void
    {
        wp_enqueue_script(
            tdf_prefix(),
            tdf_app('url') . 'assets/js/frontend.min.js',
            ['jquery', 'swiper'],
            tdf_app('version'),
            true
        );
    }

    private function getMapsRegion(): string
    {
        $field = tdf_location_fields()->first();
        if (!$field instanceof LocationField) {
            return '';
        }

        return implode(',', $field->getRestrictedCountries());
    }

    private function googleMaps(): void
    {
        if (empty(tdf_settings()->getGoogleMapsApiKey())) {
            return;
        }

        $url = '//maps.googleapis.com/maps/api/js?key=' . tdf_settings()->getGoogleMapsApiKey() . '&libraries=places&callback=mapLoaded&region=' . $this->getMapsRegion() . '&v=3.59';
        if (!empty(tdf_settings()->getMapLanguage())) {
            $url .= '&language=' . tdf_settings()->getMapLanguage();
        }

        wp_register_script('google-maps', $url, [], false, true);

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

    private function openStreetMap(): void
    {
        wp_register_style('leaflet', tdf_app('url') . 'assets/css/leaflet/leaflet.css');

        wp_register_script('leaflet', tdf_app('url') . 'assets/js/leaflet/leaflet.js', [], false, true);

        wp_register_script('leaflet-oms', tdf_app('url') . 'assets/js/leaflet/leaflet.oms.js', ['leaflet'], false, true);

        wp_register_script('leaflet-cluster', tdf_app('url') . 'assets/js/leaflet/leaflet.markercluster.js', ['leaflet'], false, true);

        wp_register_style('leaflet-cluster-default', tdf_app('url') . 'assets/css/leaflet/MarkerCluster.Default.css');

        wp_register_style('leaflet-cluster', tdf_app('url') . 'assets/css/leaflet/MarkerCluster.css');

        wp_register_style('leaflet-gesture',tdf_app('url') . 'assets/css/leaflet/leaflet-gesture-handling.min.css');

        wp_register_script('leaflet-gesture', tdf_app('url') . 'assets/js/leaflet/leaflet-gesture-handling.min.js');
    }

    private function loadMaps(): void
    {
        $mapProvider = tdf_settings()->getMapProvider();

        if ($mapProvider === SettingKey::MAP_PROVIDER_GOOGLE_MAPS) {
            $this->googleMaps();
        } elseif ($mapProvider === SettingKey::MAP_PROVIDER_OPEN_STREET_MAP) {
            $this->openStreetMap();
        }
    }
}