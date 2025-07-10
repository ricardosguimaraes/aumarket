<?php

namespace Tangibledesign\Listivo\Widgets\Listing;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Widgets\Helpers\BaseModelSingleWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SimpleLabelControl;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\ListingAttributesControl;

class ListingFeaturesWidget extends BaseModelSingleWidget
{
    use ListingAttributesControl;
    use SimpleLabelControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'listing_features';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Ad Features', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addLabelControl();

        $this->addFieldsControl();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addLabelStyleControls('.listivo-listing-simple-label');

        $this->addGridStyleControls();

        $this->addIconStyleControls();

        $this->addFeatureStyleControls();

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    private function addGridStyleControls(): void
    {
        $this->add_control(
            'grid_label',
            [
                'label' => esc_html__('Grid', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_responsive_control(
            'grid_cols',
            [
                'label' => esc_html__('Columns', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'repeat(1, minmax(0, 1fr))' => 1,
                    'repeat(2, minmax(0, 1fr))' => 2,
                    'repeat(3, minmax(0, 1fr))' => 3,
                    'repeat(4, minmax(0, 1fr))' => 4,
                ],
                'default' => 'repeat(2, minmax(0, 1fr))',
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-features' => 'grid-template-columns: {{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'grid_col_gap',
            [
                'label' => esc_html__('Columns gap (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-features' => 'grid-column-gap: {{VALUE}}px;',
                ]
            ]
        );

        $this->add_responsive_control(
            'grid_row_gap',
            [
                'label' => esc_html__('Rows gap (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-features' => 'grid-row-gap: {{VALUE}}px;',
                ]
            ]
        );
    }

    private function addIconStyleControls(): void
    {
        $this->add_control(
            'icon_label',
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
                    '{{WRAPPER}} .listivo-listing-feature__icon path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .listivo-listing-feature__icon i' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'icon_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-feature__icon' => 'background-color: {{VALUE}};',
                ]
            ]
        );
    }

    private function addFeatureStyleControls(): void
    {
        $this->add_control(
            'feature_label',
            [
                'label' => esc_html__('Feature', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'feature_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-feature__text' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'feature_typo',
                'selector' => '{{WRAPPER}} .listivo-listing-feature__text',
            ]
        );
    }

}