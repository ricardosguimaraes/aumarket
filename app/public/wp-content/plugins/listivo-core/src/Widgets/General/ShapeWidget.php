<?php


namespace Tangibledesign\Listivo\Widgets\General;


use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextAlignControl;

/**
 * Class ShapeWidget
 * @package Tangibledesign\Listivo\Widgets\General
 */
class ShapeWidget extends BaseGeneralWidget
{
    use TextAlignControl;

    public const TYPE = 'type';
    public const TYPE_UNDERLINE = 'underline';
    public const TYPE_LINE_SEPARATOR = 'line_separator';
    public const TYPE_WAVE_SEPARATOR = 'wave_separator';
    public const TYPE_TRIANGLE = 'triangle';
    public const TYPE_CLOUD = 'cloud';
    public const TYPE_WAVE = 'wave';
    public const TYPE_DOTS = 'dots';
    public const TYPE_OX = 'ox';
    public const TYPE_ARROW_1 = 'arrow_1';

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'shape';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Shape', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->addTypeControl();

        $this->addWidthControl();

        $this->addTextAlignControl('.listivo-shape');

        $this->addColorControl();

        $this->endControlsSection();
    }

    private function addWidthControl(): void
    {
        $this->add_responsive_control(
            'width',
            [
                'label' => esc_html__('Width', 'listivo-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} svg' => 'width: {{SIZE}}{{UNIT}} !important;'
                ]
            ]
        );
    }

    private function addColorControl(): void
    {
        $this->add_control(
            'color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} svg' => 'fill: {{VALUE}} !important;'
                ]
            ]
        );
    }

    private function addTypeControl(): void
    {
        $this->add_control(
            self::TYPE,
            [
                'label' => esc_html__('Type', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    self::TYPE_UNDERLINE => esc_html__('Underline', 'listivo-core'), //
                    self::TYPE_LINE_SEPARATOR => esc_html__('Line Separator', 'listivo-core'), //
                    self::TYPE_WAVE_SEPARATOR => esc_html__('Wave Separator', 'listivo-core'),
                    self::TYPE_TRIANGLE => esc_html__('Triangle', 'listivo-core'), //
                    self::TYPE_CLOUD => esc_html__('Cloud', 'listivo-core'),
                    self::TYPE_WAVE => esc_html__('Wave', 'listivo-core'),
                    self::TYPE_DOTS => esc_html__('Dots', 'listivo-core'),
                    self::TYPE_OX => esc_html__('OX', 'listivo-core'), //
                    self::TYPE_ARROW_1 => esc_html__('Arrow', 'listivo-core'), //
                ],
                'default' => self::TYPE_LINE_SEPARATOR,
            ]
        );
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        $type = $this->get_settings_for_display(self::TYPE);

        if (empty($type)) {
            return self::TYPE_LINE_SEPARATOR;
        }

        return $type;
    }

}