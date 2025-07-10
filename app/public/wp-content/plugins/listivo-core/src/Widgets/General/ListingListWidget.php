<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\QueryModelsControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SearchFields\SortByControls;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;
use Tangibledesign\Listivo\Traits\Widgets\AdCardConfigTrait;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\CardTypeControls;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\HighlightFeaturedListingsControl;

class ListingListWidget extends BaseGeneralWidget
{
    use CardTypeControls;
    use QueryModelsControl;
    use HighlightFeaturedListingsControl;
    use SortByControls;
    use AdCardConfigTrait;

    public function getKey(): string
    {
        return 'listing_list';
    }

    public function getName(): string
    {
        return esc_html__('Listing List', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addCardTypeControls();

        $this->addLimitControl();

        $this->addSortByControls(false);

        $this->addGridControls();

        $this->addTermsControl();

        $this->addFeaturedOnlyControl();

        $this->addButtonHeading();

        $this->addButtonTextControl();

        $this->addButtonDestinationControl();

        $this->addShowDecorationControl();

        $this->addShowFeaturedLabelControl();

        $this->addHighlightFeaturedListingsControl();

        $this->addIncludeExcludedControl();

        $this->endControlsSection();
    }

    protected function addGridControls(string $selector = '.listivo-listing-list__grid'): void
    {
        $this->add_responsive_control(
            'grid_columns',
            [
                'label' => esc_html__('Columns', 'listivo-core'),
                'type' => Controls_Manager::SELECT2,
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr))',
                ]
            ]
        );

        $this->add_responsive_control(
            'gap_columns',
            [
                'label' => esc_html__('Columns Gap (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'grid-column-gap: {{VALUE}}px'
                ]
            ]
        );

        $this->add_responsive_control(
            'gap_rows',
            [
                'label' => esc_html__('Rows Gap (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'grid-row-gap: {{VALUE}}px'
                ]
            ]
        );
    }

    protected function addButtonDestinationControl(): void
    {
        $this->add_control(
            'button_custom_destination',
            [
                'label' => esc_html__('Custom Destination', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );

        $this->add_control(
            'button_destination',
            [
                'label' => tdf_admin_string('destination'),
                'type' => SelectRemoteControl::TYPE,
                'source' => tdf_action_url(tdf_prefix() . '/button/destinations'),
                'condition' => [
                    'button_custom_destination!' => '1',
                ],
            ]
        );

        $this->add_control(
            'button_custom_destination_url',
            [
                'label' => tdf_admin_string('destination'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => 'https://example.com',
                'condition' => [
                    'button_custom_destination' => '1',
                ],
            ]
        );
    }

    protected function addButtonTextControl(): void
    {
        $this->add_control(
            'button_text',
            [
                'label' => tdf_admin_string('text'),
                'type' => Controls_Manager::TEXT,
                'default' => tdf_admin_string('button'),
            ]
        );
    }

    public function getText(): string
    {
        return (string)$this->get_settings_for_display('button_text');
    }

    public function getUrl(): string
    {
        if ($this->isCustomDestination()) {
            return $this->getCustomDestinationUrl();
        }

        return apply_filters(
            tdf_prefix() . '/button/destination',
            false,
            $this->get_settings_for_display('button_destination')
        );
    }

    public function isCustomDestination(): bool
    {
        return !empty($this->get_settings_for_display('button_custom_destination'));
    }

    public function getCustomDestinationUrl(): string
    {
        return (string)$this->get_settings_for_display('button_custom_destination_url');
    }

    protected function addButtonHeading(): void
    {
        $this->add_control(
            'button_heading',
            [
                'label' => esc_html__('Button', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );
    }

    protected function addShowDecorationControl(): void
    {
        $this->add_control(
            'show_decoration',
            [
                'label' => esc_html__('Display Section Background Shape', 'listivo-core'),
                'label_block' => true,
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );
    }

    public function showDecoration(): bool
    {
        return !empty($this->get_settings_for_display('show_decoration'));
    }

}