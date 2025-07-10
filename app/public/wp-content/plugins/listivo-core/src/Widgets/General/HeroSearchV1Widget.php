<?php


namespace Tangibledesign\Listivo\Widgets\General;


use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Models\Image;
use Tangibledesign\Framework\Widgets\Helpers\Controls\JustifyContentControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\PopularTermsControls;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SimpleLabelControl;

/**
 * Class HeroSearchV1Widget
 * @package Tangibledesign\Listivo\Widgets\General
 */
class HeroSearchV1Widget extends SearchFormWidget
{
    use PopularTermsControls;
    use SimpleLabelControl;
    use JustifyContentControl;

    public const HEADING = 'heading';
    public const SUBHEADING = 'subheading';
    public const FIRST_IMAGE = 'first_image';
    public const SECOND_IMAGE = 'second_image';

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'hero_search_v1';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Hero Search V1', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addWidthControl();

        $this->addHeadingControl();

        $this->addSubheadingControl();

        $this->addFirstImageControl();

        $this->addSecondImageControl();

        $this->addFieldsControl();

        $this->endControlsSection();

        $this->startContentControlsSection('popular_terms', esc_html__('Popular Terms', 'listivo-core'));

        $this->addLabelControl(esc_html__("Check Popular:", 'listivo-core'));

        $this->addTaxonomyControl();

        $this->addLimitControl('', 4);

        $this->addRandomizeControls();

        $this->addJustifyContentControl('.listivo-popular');

        $this->endControlsSection();
    }

    private function addHeadingControl(): void
    {
        $this->add_control(
            self::HEADING,
            [
                'label' => esc_html__('Heading', 'listivo-core'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );
    }

    /**
     * @return string
     */
    public function getHeading(): string
    {
        return (string)$this->get_settings_for_display(self::HEADING);
    }

    public function addSubheadingControl(): void
    {
        $this->add_control(
            self::SUBHEADING,
            [
                'label' => esc_html__('Subheading', 'listivo-core'),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'small_text_typography',
                'label' => esc_html__('Subheading Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-pretty-heading',
                'fields_options' => [
                    'typography' => [
                        'default' => 'yes'
                    ],
                    'font_family' => [
                        'default' => 'Alex Brush',
                    ],
                ]
            ]
        );
    }

    /**
     * @return string
     */
    public function getSubheading(): string
    {
        return (string)$this->get_settings_for_display(self::SUBHEADING);
    }

    public function addFirstImageControl(): void
    {
        $this->add_control(
            self::FIRST_IMAGE,
            [
                'label' => esc_html__('Main Image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );
    }

    /**
     * @return Image|false
     */
    public function getFirstImage()
    {
        $image = $this->get_settings_for_display(self::FIRST_IMAGE);
        if (empty($image['id'])) {
            return false;
        }

        return tdf_image_factory()->create((int)$image['id']);
    }

    public function addSecondImageControl(): void
    {
        $this->add_control(
            self::SECOND_IMAGE,
            [
                'label' => esc_html__('Additional Image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );
    }

    /**
     * @return Image|false
     */
    public function getSecondImage()
    {
        $image = $this->get_settings_for_display(self::SECOND_IMAGE);
        if (empty($image['id'])) {
            return false;
        }

        return tdf_image_factory()->create((int)$image['id']);
    }

    private function addWidthControl(): void
    {
        $this->add_control(
            'width',
            [
                'label' => tdf_admin_string('width'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-search' => 'max-width: {{SIZE}}{{UNIT}};'
                ],
                'default' => [
                    'size' => 895,
                    'unit' => 'px'
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000,
                    ],
                ],
            ]
        );
    }

}