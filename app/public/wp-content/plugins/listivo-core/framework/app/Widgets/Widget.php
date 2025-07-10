<?php

namespace Tangibledesign\Framework\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Tangibledesign\Framework\Core\Settings\SettingKey;
use Tangibledesign\Framework\Models\Field\LocationField;
use Tangibledesign\Framework\Models\Template\TemplateType\TemplateType;

abstract class Widget extends Widget_Base
{
    abstract public function getKey(): string;

    abstract public function getName(): string;

    public function get_categories(): array
    {
        return [tdf_prefix()];
    }

    public function get_name(): string
    {
        return tdf_short_prefix().'_'.$this->getKey();
    }

    public function get_title(): string
    {
        return $this->getName();
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->add_control(
            'no_settings',
            [
                'label' => tdf_admin_string('no_settings'),
                'type' => Controls_Manager::HEADING,
                'default' => tdf_admin_string('no_settings'),
            ]
        );

        $this->endControlsSection();
    }

    protected function render(): void
    {
        global ${tdf_short_prefix().'CurrentWidget'};
        ${tdf_short_prefix().'CurrentWidget'} = $this;

        $postType = get_post_type();

        if ($postType === 'elementor_library' || $postType === tdf_prefix().'_template') {
            $this->prepare();
        }

        $this->renderContent();

        $this->loadTemplate();
    }

    public function prepare(): void
    {
        $templateType = tdf_template_type_factory()->getCurrent();

        if (!$templateType instanceof TemplateType) {
            return;
        }

        $templateType->preparePreview();
    }

    protected function loadTemplate(): void
    {
        get_template_part('templates/widgets/'.$this->getTemplateDirectory().$this->getKey());
    }

    protected function getTemplateDirectory(): string
    {
        return '';
    }

    protected function renderContent(): void
    {

    }

    protected function startContentControlsSection(string $key = 'general_content', string $label = ''): void
    {
        if (empty($label)) {
            $label = tdf_admin_string('general');
        }

        $this->startControlsSection($key, $label, Controls_Manager::TAB_CONTENT);
    }

    protected function startStyleControlsSection(string $key = 'general_style', string $label = ''): void
    {
        if (empty($label)) {
            $label = tdf_admin_string('general');
        }

        $this->startControlsSection($key, $label, Controls_Manager::TAB_STYLE);
    }

    protected function startControlsSection(string $key, string $label, string $tab): void
    {
        $this->start_controls_section(
            $key,
            [
                'label' => $label,
                'tab' => $tab,
            ]
        );
    }

    protected function endControlsSection(): void
    {
        $this->end_controls_section();
    }

    public function getMapStyleDeps(): array
    {
        $provider = tdf_settings()->getMapProvider();
        if ($provider === SettingKey::MAP_PROVIDER_GOOGLE_MAPS) {
            return ['google-maps'];
        }

        if ($provider === SettingKey::MAP_PROVIDER_OPEN_STREET_MAP) {
            return ['leaflet', 'leaflet-cluster', 'leaflet-cluster-default', 'leaflet-gesture'];
        }

        return [];
    }

    public function getMapScriptDeps(): array
    {
        $provider = tdf_settings()->getMapProvider();
        if ($provider === SettingKey::MAP_PROVIDER_OPEN_STREET_MAP) {
            return ['leaflet', 'leaflet-oms', 'leaflet-cluster', 'leaflet-gesture', 'google-maps'];
        }

        if ($provider === SettingKey::MAP_PROVIDER_GOOGLE_MAPS && !empty(tdf_settings()->getGoogleMapsApiKey())) {
            return ['google-maps'];
        }

        return [];
    }

    public function registerMapDeps(): void
    {
        $provider = tdf_settings()->getMapProvider();
//        if ($provider === SettingKey::MAP_PROVIDER_GOOGLE_MAPS && !empty(tdf_settings()->getGoogleMapsApiKey())) {
        if (!empty(tdf_settings()->getGoogleMapsApiKey())) {
            $url = '//maps.googleapis.com/maps/api/js?key='.tdf_settings()->getGoogleMapsApiKey().'&libraries=places&callback=mapLoaded';
            $region = $this->getMapsRegion();

            if (!empty($region)) {
                $url .= $region;
            }

            wp_register_script(
                'google-maps',
                $url,
                [],
                false,
                true
            );
        } elseif ($provider === SettingKey::MAP_PROVIDER_OPEN_STREET_MAP) {
            wp_register_style('leaflet', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.css');

            wp_register_script('leaflet', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.js', [], false, true);

            wp_register_script('leaflet-oms',
                'https://cdnjs.cloudflare.com/ajax/libs/OverlappingMarkerSpiderfier-Leaflet/0.2.6/oms.min.js', [],
                false, true);

            wp_register_script('leaflet-cluster',
                'https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js', ['leaflet'], false,
                true);

            wp_register_style('leaflet-cluster-default',
                'https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css');

            wp_register_style('leaflet-cluster',
                'https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css');

            wp_register_style('leaflet-gesture',
                'https://unpkg.com/leaflet-gesture-handling/dist/leaflet-gesture-handling.min.css');

            wp_register_script('leaflet-gesture', 'https://unpkg.com/leaflet-gesture-handling');
        }
    }

    private function getMapsRegion(): string
    {
        $field = tdf_location_fields()->first();
        if (!$field instanceof LocationField) {
            return '';
        }

        return implode(',', $field->getRestrictedCountries());
    }
}