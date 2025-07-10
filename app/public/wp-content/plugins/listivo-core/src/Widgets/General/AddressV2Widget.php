<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextControls;

class AddressV2Widget extends BaseGeneralWidget
{
    use TextControls;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'address_v2';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Address V2', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->add_responsive_control(
            'hide_icon',
            [
                'label' => 'Hide Icon',
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'block' => tdf_admin_string('no'),
                    'none' => tdf_admin_string('yes'),
                ],
                'default' => 'block',
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-small-data__icon' => 'display: {{VALUE}};'
                ]
            ]
        );

        $this->addTypographyControl('.listivo-small-data__value');

        $this->addTextAlignControl('.listivo-address');

        $this->addTextColorControl('.listivo-small-data__value');

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
                    '{{WRAPPER}} .listivo-small-icon path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'icon_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-small-icon' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->endControlsSection();
    }

}