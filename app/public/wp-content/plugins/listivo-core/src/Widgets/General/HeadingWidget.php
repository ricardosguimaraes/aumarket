<?php


namespace Tangibledesign\Listivo\Widgets\General;


use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\AlignmentModifierControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextColorControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TypographyControl;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\HeadingControls;

/**
 * Class HeadingWidget
 * @package Tangibledesign\Listivo\Widgets\General
 */
class HeadingWidget extends BaseGeneralWidget
{
    use HeadingControls;
    use TextColorControl;
    use TypographyControl;
    use AlignmentModifierControl;

    public const DECORATION_STYLE = 'decoration_style';
    public const DECORATION_STYLE_NONE = 'none';
    public const DECORATION_STYLE_ARROW_LEFT_BOTTOM = 'arrow_left_bottom';
    public const DECORATION_STYLE_ARROW_RIGHT_BOTTOM = 'arrow_right_bottom';
    public const DECORATION_STYLE_TRIANGLE = 'triangle';
    public const DECORATION_STYLE_TRIANGLE_LEFT = 'triangle_left';

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'heading';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Section Heading', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addHeadingControls();

        $this->addAlignControl();

        $this->addDecorationStyleControl();

        $this->endControlsSection();

        $this->startStyleControlsSection('small_text_style_section', esc_html__('Small Text', 'listivo-core'));

        $this->addTypographyControl('.listivo-heading__small-text', 'small_text');

        $this->addTextColorControl('.listivo-heading__small-text', 'small_text');

        $this->endControlsSection();

        $this->startStyleControlsSection('text_style_section', esc_html__('Text', 'listivo-core'));

        $this->addTypographyControl('.listivo-heading__text', 'text');

        $this->addTextColorControl('.listivo-heading__text', 'text');

        $this->endControlsSection();
    }

    private function addDecorationStyleControl(): void
    {
        $this->add_control(
            self::DECORATION_STYLE,
            [
                'label' => esc_html__('Decoration Style (Tablet / Desktop)', 'listivo-core'),
                'label_block' => true,
                'type' => Controls_Manager::SELECT,
                'options' => [
                    self::DECORATION_STYLE_NONE => esc_html__('None', 'listivo-core'),
                    self::DECORATION_STYLE_ARROW_LEFT_BOTTOM => esc_html__('Arrow Left Bottom', 'listivo-core'),
                    self::DECORATION_STYLE_ARROW_RIGHT_BOTTOM => esc_html__('Arrow Right Bottom', 'listivo-core'),
                    self::DECORATION_STYLE_TRIANGLE_LEFT => esc_html__('Triangle Left', 'listivo-core'),
                    self::DECORATION_STYLE_TRIANGLE => esc_html__('Triangle Right', 'listivo-core'),
                ],
                'default' => self::DECORATION_STYLE_NONE,
            ]
        );

        $this->add_control(
            'decoration_color',
            [
                'label' => esc_html__('Decoration Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} svg' => 'fill: {{VALUE}};'
                ],
                'condition' => [
                    self::DECORATION_STYLE . '!' => self::DECORATION_STYLE_NONE,
                ]
            ]
        );
    }

    /**
     * @return string
     */
    public function getDecorationStyle(): string
    {
        $decorationStyle = $this->get_settings_for_display(self::DECORATION_STYLE);

        if (empty($decorationStyle)) {
            return self::DECORATION_STYLE_NONE;
        }

        return $decorationStyle;
    }

    /**
     * @return bool
     */
    public function isArrowLeftBottomDecorationStyle(): bool
    {
        return $this->getDecorationStyle() === self::DECORATION_STYLE_ARROW_LEFT_BOTTOM;
    }

    /**
     * @return bool
     */
    public function isArrowRightBottomDecorationStyle(): bool
    {
        return $this->getDecorationStyle() === self::DECORATION_STYLE_ARROW_RIGHT_BOTTOM;
    }

    /**
     * @return bool
     */
    public function isTriangleRightDecorationStyle(): bool
    {
        return $this->getDecorationStyle() === self::DECORATION_STYLE_TRIANGLE;
    }

    /**
     * @return bool
     */
    public function isTriangleLeftDecorationStyle(): bool
    {
        return $this->getDecorationStyle() === self::DECORATION_STYLE_TRIANGLE_LEFT;
    }

}