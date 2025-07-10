<?php


namespace Tangibledesign\Listivo\Widgets\Listing;


use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Widgets\Helpers\BaseModelSingleWidget;

/**
 * Class ListingAddressWidget
 * @package Tangibledesign\Listivo\Widgets\Listing
 */
class ListingAddressWidget extends BaseModelSingleWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'listing_address';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Ad Address', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->addSeeMapTypeControl();

        $this->addIconStyleControls();

        $this->addTextStyleControls();

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    private function addTextStyleControls(): void
    {
        $this->add_control(
            'text_heading',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-address' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'text_typo',
                'selector' => '{{WRAPPER}} .listivo-listing-address',
            ]
        );
    }

    private function addIconStyleControls(): void
    {
        $this->add_control(
            'icon_heading',
            [
                'label' => esc_html__('Icon', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-address__icon path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'icon_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-address__icon' => 'background-color: {{VALUE}};',
                ]
            ]
        );
    }


    private function addSeeMapTypeControl(): void
    {
        $this->add_control(
            'see_map_type',
            [
                'label' => esc_html__('See Map Type', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'scroll',
                'options' => [
                    'scroll' => esc_html__('Scroll to the map', 'listivo-core'),
                    'open_new_window' => esc_html__('open the map in a new window', 'listivo-core'),
                ]
            ]
        );
    }

    /**
     * @return string
     */
    public function getSeeMapType(): string
    {
        $type = $this->get_settings_for_display('see_map_type');
        if (empty($type)) {
            return 'scroll';
        }

        return $type;
    }

}