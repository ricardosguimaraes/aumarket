<?php

namespace Tangibledesign\Listivo\Widgets\Listing;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Widgets\Helpers\BaseModelSingleWidget;

class ListingStatsWidget extends BaseModelSingleWidget
{
    public function getKey(): string
    {
        return 'listing_stats';
    }

    public function getName(): string
    {
        return esc_html__('Ad Info', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->addContentSection();

        $this->addStyleSection();

        $this->addVisibilitySection();
    }

    private function addStyleSection(): void
    {
        $this->startStyleControlsSection();

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
                    '{{WRAPPER}} .listivo-listing-stat__icon path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'icon_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-stat__icon' => 'background-color: {{VALUE}};',
                ]
            ]
        );

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
                    '{{WRAPPER}} .listivo-listing-stat' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'text_typo',
                'selector' => '{{WRAPPER}} .listivo-listing-stat',
            ]
        );

        $this->endControlsSection();
    }

    private function addContentSection(): void
    {
        $this->startContentControlsSection();

        $this->addShowAccountTypeControl();

        $this->addShowPublishDateControl();

        $this->addShowViewsCountControl();

        $this->endControlsSection();
    }

    private function addShowAccountTypeControl(): void
    {
        $this->add_control(
            'show_account_type',
            [
                'label' => esc_html__('Show Account Type', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '1',
                'return_value' => '1',
            ]
        );
    }

    public function showAccountType(): bool
    {
        return tdf_settings()->isAccountTypeEnabled() && !empty((int)$this->get_settings_for_display('show_account_type'));
    }

    private function addShowPublishDateControl(): void
    {
        $this->add_control(
            'show_publish_date',
            [
                'label' => esc_html__('Show Publish Date', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '1',
                'return_value' => '1',
            ]
        );
    }

    public function showPublishDate(): bool
    {
        return !empty((int)$this->get_settings_for_display('show_publish_date'));
    }

    private function addShowViewsCountControl(): void
    {
        $this->add_control(
            'show_views_count',
            [
                'label' => esc_html__('Show Views Count', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '1',
                'return_value' => '1',
            ]
        );
    }

    public function showViewsCount(): bool
    {
        return !empty((int)$this->get_settings_for_display('show_views_count'));
    }
}