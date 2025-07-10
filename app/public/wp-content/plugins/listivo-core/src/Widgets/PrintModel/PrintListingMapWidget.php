<?php

namespace Tangibledesign\Listivo\Widgets\PrintModel;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Models\Field\LocationField;

class PrintListingMapWidget extends BasePrintModelWidget
{
    public function getKey(): string
    {
        return 'print_listing_map';
    }

    public function getName(): string
    {
        return esc_html__('Listing Map', 'listivo-core');
    }

    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);

        $this->registerMapDeps();
    }

    public function get_style_depends(): array
    {
        return $this->getMapStyleDeps();
    }

    public function get_script_depends(): array
    {
        return $this->getMapScriptDeps();
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->add_responsive_control(
            'height',
            [
                'label' => esc_html__('Height', 'listivo-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-map' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->endControlsSection();
    }

    public function getLocationField(): ?LocationField
    {
        /** @noinspection NullPointerExceptionInspection */
        $locationField = tdf_app('card_location_field')->first();
        if (!$locationField instanceof LocationField) {
            return null;
        }

        return $locationField;
    }
}