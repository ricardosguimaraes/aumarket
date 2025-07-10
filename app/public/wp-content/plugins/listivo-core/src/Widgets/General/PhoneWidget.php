<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextAlignControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextColorControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TypographyControl;
use Tangibledesign\Framework\Widgets\Helpers\HasPhone;

class PhoneWidget extends BaseGeneralWidget
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
        return 'phone';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Phone', 'listivo-core');
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
                    'block' => esc_html__('No', 'listivo-core'),
                    'none' => esc_html__('Yes', 'listivo-core'),
                ],
                'default' => 'block',
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-small-data__icon' => 'display: {{VALUE}};'
                ]
            ]
        );

        $this->addTypographyControl($this->getSelector());

        $this->addTextAlignControl('.' . tdf_prefix() . '-phone-wrapper');

        $this->addTextColorControl($this->getSelector());

        $this->addTextColorControl(
            $this->getSelector() . ':hover',
            'color_hover',
            esc_html__('Color Hover', 'listivo-core')
        );

        $this->endControlsSection();
    }

    /**
     * @return string
     */
    protected function getSelector(): string
    {
        return '.' . tdf_prefix() . '-phone';
    }

}