<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\PopularTermsControls;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SimpleLabelControl;

class PopularTermsV2Widget extends BaseGeneralWidget
{
    use PopularTermsControls;
    use SimpleLabelControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'popular_terms_v2';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Popular terms V2', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addTaxonomyControl();

        $this->addLabelControl();

        $this->addLimitControl();

        $this->addRandomizeControls();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addAlignControl();

        $this->addColorControls();

        $this->endControlsSection();
    }

    private function addAlignControl(): void
    {
        $this->add_responsive_control(
            'align',
            [
                'label' => esc_html__('Align', 'listivo-core'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => tdf_admin_string('left'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => tdf_admin_string('center'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => tdf_admin_string('right'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .listivo-popular-terms-v2' => 'justify-content: {{VALUE}};'
                ]
            ]
        );
    }

    private function addColorControls(): void
    {
        $this->add_responsive_control(
            'color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-popular-terms-v2' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'hover_color',
            [
                'label' => esc_html__('Hover color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-popular-terms-v2__term:hover' => 'color: {{VALUE}};'
                ]
            ]
        );
    }

}