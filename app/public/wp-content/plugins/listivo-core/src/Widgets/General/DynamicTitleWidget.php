<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;

class DynamicTitleWidget extends BaseGeneralWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'dynamic_title';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Dynamic title', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->add_control(
            'color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-dynamic-title' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'typography',
                'selector' => '{{WRAPPER}} .listivo-dynamic-title',
            ]
        );

        $this->endControlsSection();
    }

}