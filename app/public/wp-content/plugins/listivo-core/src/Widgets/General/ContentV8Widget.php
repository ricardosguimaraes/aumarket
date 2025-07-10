<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\ImageControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextareaControl;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\ButtonControls;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\HeadingV2Controls;

class ContentV8Widget extends BaseGeneralWidget
{
    use ImageControl;
    use HeadingV2Controls;
    use TextareaControl;
    use ButtonControls;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'content_v8';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Content section V8', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addImageControl();

        $this->addHeadingControls();

        $this->addTextControl();

        $this->addFeaturesControl();

        $this->addButtonControls();

        $this->addAwardControls();

        $this->endControlsSection();

        $this->addHeadingStyleSection();

        $this->addTextStyleSection();

        $this->addFeaturesStyleSection();

        $this->addAwardBoxStyleSection();
    }

    private function addFeaturesControl(): void
    {
        $features = new Repeater();

        $features->add_control(
            'feature',
            [
                'label' => esc_html__('Feature', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'features',
            [
                'label' => esc_html__('Features', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $features->get_controls(),
                'prevent_empty' => false,
            ]
        );
    }

    /**
     * @return Collection|string[]
     */
    public function getFeatures(): Collection
    {
        $features = $this->get_settings_for_display('features');
        if (empty($features) || !is_array($features)) {
            return tdf_collect();
        }

        return tdf_collect($features)->map(static function ($feature) {
            return $feature['feature'];
        });
    }

    private function addAwardControls(): void
    {
        $this->add_control(
            'award_heading',
            [
                'label' => esc_html__('Info box', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'award_image',
            [
                'label' => esc_html__('Image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'award_value',
            [
                'label' => esc_html__('Value', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'award_text',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );
    }

    /**
     * @return string
     */
    public function getAwardImage(): string
    {
        $image = $this->get_settings_for_display('award_image');

        return $image['url'] ?? '';
    }

    /**
     * @return string
     */
    public function getAwardValue(): string
    {
        return (string)$this->get_settings_for_display('award_value');
    }

    /**
     * @return string
     */
    public function getAwardText(): string
    {
        return (string)$this->get_settings_for_display('award_text');
    }

    private function addTextStyleSection(): void
    {
        $this->startStyleControlsSection('text_style', esc_html__('Text', 'listivo-core'));

        $this->addTextControls('.listivo-content-v8__text');




        $this->endControlsSection();
    }

    private function addFeaturesStyleSection(): void
    {
        $this->startStyleControlsSection('features_style', esc_html__('Features', 'listivo-core'));

        $this->addTypographyControl('.listivo-content-v8__feature', 'feature');

        $this->addTextColorControl('.listivo-content-v8__feature', 'feature');

        $this->add_control(
            'check_heading',
            [
                'label' => esc_html__('Icon', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'check_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-content-v8__check path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'check_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-content-v8__check' => 'background: {{VALUE}};',
                ]
            ]
        );

        $this->endControlsSection();
    }

    private function addAwardBoxStyleSection(): void
    {
        $this->startStyleControlsSection('award_box_style', esc_html__('Info box', 'listivo-core'));

        $this->add_control(
            'award_box_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-award-box-v4 path' => 'fill: {{VALUE}}; stroke: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'award_box_value_heading',
            [
                'label' => esc_html__('Value', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->addTypographyControl('.listivo-award-box-v4__main', 'award_box_value');

        $this->add_control(
            'award_box_value_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-award-box-v4__main' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'award_box_text_heading',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->addTypographyControl('.listivo-award-box-v4__text', 'award_box_text');

        $this->add_control(
            'award_box_text_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-award-box-v4__text' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->endControlsSection();
    }

}