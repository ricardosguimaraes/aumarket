<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextAlignControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextColorControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TypographyControl;
use Tangibledesign\Framework\Widgets\Helpers\HasPhone;

class PhoneV3Widget extends BaseGeneralWidget
{
    use TextColorControl;
    use TextAlignControl;
    use TypographyControl;
    use HasPhone;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'phone_v3';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Phone V3', 'listivo-core');
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

        $this->addTypographyControl($this->getSelector());

        $this->addTextAlignControl('.' . tdf_prefix() . '-phone-v3-wrapper');

        $this->addTextColorControl($this->getSelector());

        $this->addTextColorControl(
            $this->getSelector() . ':hover',
            'color_hover',
            tdf_admin_string('color_hover')
        );

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

    /**
     * @return string
     */
    protected function getSelector(): string
    {
        return '.' . tdf_prefix() . '-phone-v3';
    }

}