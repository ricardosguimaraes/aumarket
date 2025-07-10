<?php

namespace Tangibledesign\Listivo\Widgets\Listing;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Widgets\Helpers\BaseModelSingleWidget;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\ListingMainValueControl;

class ListingTopWidget extends BaseModelSingleWidget
{
    use ListingMainValueControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'listing_top';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Ad Top', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addCurrencyFieldsControl();

        $this->addSeeMapTypeControl();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addHeadingStyleControls();

        $this->addPriceStyleControls();

        $this->addAddressStyleControls();

        $this->addAddressIconControls();

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    private function addAddressIconControls(): void
    {
        $this->add_control(
            'address_icon_label',
            [
                'label' => esc_html__('Location icon', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'address_icon_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-top__address-icon path' => 'fill: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'address_icon_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-top__address-icon' => 'background: {{VALUE}};',
                ]
            ]
        );
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        $listing = $this->getModel();
        if (!$listing) {
            return '';
        }

        return $listing->getAddress();
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
                    'scroll' => esc_html__('Scroll to Map', 'listivo-core'),
                    'open_new_window' => esc_html__('Open New Window', 'listivo-core'),
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

    private function addHeadingStyleControls(): void
    {
        $this->add_control(
            'heading_heading',
            [
                'label' => esc_html__('Heading', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-top__name' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-listing-top__name',
            ]
        );
    }

    private function addPriceStyleControls(): void
    {
        $this->add_control(
            'price_heading',
            [
                'label' => esc_html__('Price', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-top__price' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'price_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-listing-top__price',
            ]
        );
    }

    private function addAddressStyleControls(): void
    {
        $this->add_control(
            'address_heading',
            [
                'label' => esc_html__('Address', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'address_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-top__address' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'address_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-listing-top__address',
            ]
        );
    }

}