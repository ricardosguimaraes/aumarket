<?php

namespace Tangibledesign\Listivo\Widgets\General\Search;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Exception;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Core\Settings\SettingKey;
use Tangibledesign\Framework\Models\Field\LocationField;
use WP_Post;

class SearchMapWidget extends SearchWidget
{
    /**
     * @var bool
     */
    protected $map = true;

    /**
     * SearchMapWidget constructor.
     * @param array $data
     * @param null $args
     * @throws Exception
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);

        $this->registerMapDeps();

        if (tdf_settings()->getMapProvider() === SettingKey::MAP_PROVIDER_GOOGLE_MAPS && !empty(tdf_settings()->getGoogleMapsApiKey())) {
            wp_register_script('infobox', tdf_app('url') . '/assets/js/infobox.min.js', ['google-maps'], false, true);

            wp_register_script('marker-with-label', tdf_app('url') . '/assets/js/markerWithLabel.min.js', ['google-maps'], false, true);

            wp_register_script('spiderfier', tdf_app('url') . '/assets/js/spiderfier.min.js', ['google-maps'], false, true);
        }
    }

    public function getKey(): string
    {
        return 'search_map';
    }

    public function getName(): string
    {
        return esc_html__('Search Map', 'listivo-core');
    }

    public function get_script_depends(): array
    {
        if (
            tdf_settings()->getMapProvider() === SettingKey::MAP_PROVIDER_GOOGLE_MAPS
            && !empty(tdf_settings()->getGoogleMapsApiKey())
        ) {
            return array_merge($this->getMapScriptDeps(), ['infobox', 'marker-with-label', 'spiderfier']);
        }

        return $this->getMapScriptDeps();
    }

    public function get_style_depends(): array
    {
        return $this->getMapStyleDeps();
    }

    protected function addSearchFieldsControls(Repeater $fields): void
    {
        $options = $this->getFieldOptions();

        $fields->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'listivo-core'),
                'type' => Controls_Manager::ICONS,
            ]
        );

        $fields->add_control(
            'field',
            [
                'label' => tdf_admin_string('field'),
                'type' => Controls_Manager::SELECT,
                'options' => $options,
            ]
        );

        $this->addTaxonomyFieldSettings($fields);

        $this->addNumberFieldSettings($fields);

        $this->addPriceFieldSettings($fields);

        $this->addTextFieldSettings($fields);

        $this->addLocationFieldSettings($fields, false);

        $this->addKeywordFieldSettings($fields);
    }

    public function getBaseUrl(): string
    {
        if (!is_page()) {
            return get_post_type_archive_link(tdf_model_post_type());
        }

        global $post;
        if (!$post instanceof WP_Post || $post->post_type !== 'page') {
            return get_post_type_archive_link(tdf_model_post_type());
        }

        return get_permalink($post);
    }

    /**
     * @return LocationField|false
     */
    public function getLocationField()
    {
        $field = tdf_settings()->getCardLocationField();
        if (!$field instanceof LocationField) {
            $field = tdf_location_fields()->first(false);
        }

        if (!$field) {
            return false;
        }

        return $field->getSearchField();
    }

    public function getCardSelectors(): array
    {
        return [
            '.listivo-listing-card-row',
            '.listivo-listing-card',
        ];
    }

    public function getListings(array $filters = []): Collection
    {
        $locationField = tdf_settings()->getCardLocationField();
        if ($locationField instanceof LocationField) {
            $this->locationField = $locationField;
        } else {
            $this->locationField = tdf_location_fields()->first(false);
        }

        return parent::getListings($filters);
    }

    protected function register_controls(): void
    {
        parent::register_controls();

        $this->startContentControlsSection('search_map_settings', esc_html__('Advanced Map Settings', 'listivo-core'));

        $this->add_control(
            'clustering',
            [
                'label' => esc_html__('Marker Clustering', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );

        $this->add_control(
            'marker_type',
            [
                'label' => esc_html__('Marker Type', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'content' => esc_html__('Price/Salary', 'listivo-core'),
                    'icon' => esc_html__('Icon', 'listivo-core'),
                ],
                'default' => 'content',
            ]
        );

        $this->endControlsSection();
    }

    /**
     * @return string
     */
    public function getMarkerType(): string
    {
        $type = $this->get_settings_for_display('marker_type');
        if (empty($type)) {
            return 'content';
        }

        return $type;
    }

    public function isMarkerClusteringEnabled(): bool
    {
        return !empty($this->get_settings_for_display('clustering'));
    }
}