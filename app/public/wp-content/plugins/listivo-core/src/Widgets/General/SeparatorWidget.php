<?php


namespace Tangibledesign\Listivo\Widgets\General;


use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;

/**
 * Class SeparatorWidget
 * @package Tangibledesign\Listivo\Widgets\General
 */
class SeparatorWidget extends BaseGeneralWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'separator';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Separator', 'listivo-core');
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
                    '{{WRAPPER}} svg' => 'fill:{{VALUE}};'
                ]
            ]
        );

        $this->endControlsSection();
    }

}