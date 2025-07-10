<?php


namespace Tangibledesign\Listivo\Widgets\Listing;


use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Exception;
use Tangibledesign\Framework\Widgets\Helpers\BaseModelSingleWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\LocationFieldControl;

/**
 * Class ListingMapWidget
 * @package Tangibledesign\Listivo\Widgets\Listing
 */
class ListingMapWidget extends BaseModelSingleWidget
{
    use LocationFieldControl;

    /**
     * @param array $data
     * @param null $args
     * @throws Exception
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);

        $this->registerMapDeps();
    }

    public function getKey(): string
    {
        return 'listing_map';
    }

    public function getName(): string
    {
        return esc_html__('Ad Map', 'listivo-core');
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
        $this->startContentControlsSection();

        $this->addLocationFieldControl();

        $this->addLabelControls();

        $this->addMarginControl();

        $this->addPaddingControl();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->add_control(
            'label_heading',
            [
                'label' => esc_html__('Label', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-section__label' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'label_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-listing-section__label',
            ]
        );

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    private function addMarginControl(): void
    {
        $this->add_responsive_control(
            'map_margin',
            [
                'label' => esc_html__('Margin', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-section' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
    }

    private function addPaddingControl(): void
    {
        $this->add_responsive_control(
            'map_padding',
            [
                'label' => esc_html__('Padding', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
    }

    /**
     * @return false|float[]
     */
    public function getLocation()
    {
        $listing = $this->getModel();
        $locationField = $this->getLocationField();

        if (!$listing || !$locationField) {
            return false;
        }

        return $locationField->getLocation($listing);
    }

    protected function addLabelControls(): void
    {
        $this->add_control(
            'show_label',
            [
                'label' => tdf_admin_string('show_label'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );

        $this->add_control(
            'label',
            [
                'label' => tdf_admin_string('label'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => tdf_string('location'),
                'condition' => [
                    'show_label' => '1',
                ]
            ]
        );
    }

    public function showLabel(): bool
    {
        return !empty((int)$this->get_settings_for_display('show_label'));
    }

    public function getLabel(): string
    {
        $label = (string)$this->get_settings_for_display('label');

        if (empty($label)) {
            return tdf_string('location');
        }

        return $label;
    }
}