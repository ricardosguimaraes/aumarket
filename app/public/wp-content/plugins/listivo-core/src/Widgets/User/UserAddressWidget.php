<?php

namespace Tangibledesign\Listivo\Widgets\User;


use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseUserWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\FlexAlignmentControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextControls;
use Tangibledesign\Framework\Widgets\Helpers\ModelSingleWidget;

class UserAddressWidget extends BaseUserWidget implements ModelSingleWidget
{
    use FlexAlignmentControl;
    use TextControls;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'user_address';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return tdf_admin_string('user_address');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->addFlexAlignmentControl($this->getSelector());

        $this->add_control(
            'text_heading',
            [
                'label' => esc_html__('Text', 'listivo'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->addTextColorControl('.listivo-user-address__text');

        $this->addTypographyControl('.listivo-user-address__text');

        $this->add_control(
            'icon_heading',
            [
                'label' => esc_html__('Icon', 'listivo'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon Color', 'listivo'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-user-address__icon path' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'listivo'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-user-address__icon svg' => 'height: {{SIZE}}px;',
                ],
            ]
        );

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    /**
     * @return string
     */
    protected function getSelector(): string
    {
        return '.' . tdf_prefix() . '-user-address-wrapper';
    }
}