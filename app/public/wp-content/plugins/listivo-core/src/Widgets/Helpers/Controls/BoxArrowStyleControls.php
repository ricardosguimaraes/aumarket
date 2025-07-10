<?php

namespace Tangibledesign\Listivo\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\Controls\Control;

trait BoxArrowStyleControls
{
    use Control;

    private function addBoxArrowStyleControls():void
    {
        $this->add_control(
            'arrows_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-box-arrow path' => 'fill: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'arrows_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-box-arrow' => 'background-color: {{VALUE}};'
                ]
            ]
        );
    }

    protected function addBoxArrowStyleSection(): void
    {
        $this->startStyleControlsSection('box_arrow_style', esc_html__('Navigation', 'listivo-core'));

        $this->addBoxArrowStyleControls();

        $this->endControlsSection();
    }

}