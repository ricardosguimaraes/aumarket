<?php


namespace Tangibledesign\Listivo\Widgets\Listing;


use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Widgets\Helpers\BaseModelSingleWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SimpleLabelControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextControls;

/**
 * Class ListingDescriptionWidget
 * @package Tangibledesign\Listivo\Widgets\Listing
 */
class ListingDescriptionWidget extends BaseModelSingleWidget
{
    use TextControls;
    use SimpleLabelControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'listing_description';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Ad Description', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->add_control(
            'label_heading',
            [
                'label' => esc_html__('Label', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->addLabelControl();

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

        $this->add_control(
            'text_heading',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->addTextControls('.listivo-listing-section__text');

        $this->add_responsive_control(
            'description_margin',
            [
                'label' => esc_html__('Margin', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-section' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'description_padding',
            [
                'label' => esc_html__('Padding', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

}