<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TypographyControl;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\FieldStyleSection;

class HeroSearchV10Widget extends HeroSearchWidget
{
    use TypographyControl;
    use FieldStyleSection;

    public function getKey(): string
    {
        return 'hero_search_v10';
    }

    public function getName(): string
    {
        return esc_html__('Hero Search V10', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addBackgroundImageControl();

        $this->addHeadingControl();

        $this->addTextControl();

        $this->addTermsControl();

        $this->addFormLabelControl();

        $fields = new Repeater();

        $this->addSearchFieldsControls($fields);

        $this->add_control(
            'fields',
            [
                'label' => esc_html__('Fields', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $fields->get_controls(),
                'prevent_empty' => false,
                'title_field' => "<# "
                    . "let labels = " . json_encode($this->getFieldOptions()) . "; "
                    . "let label = labels[field]; "
                    . "#>"
                    . "{{{ label }}}",
            ]
        );

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addPaddingControl();

        $this->addShowArrowControl();

        $this->endControlsSection();

        $this->addHeadingStyleSection();

        $this->addTextStyleSection();

        $this->addFormStyleSection();

        $this->addFieldStyleSection();

        $this->addButtonStyleSection();

        $this->addBackgroundMaskStyleSection();
    }

    private function addFormLabelControl(): void
    {
        $this->add_control(
            'form_label',
            [
                'label' => esc_html__('Form label', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );
    }

    /**
     * @return string
     */
    public function getFormLabel(): string
    {
        return (string)$this->get_settings_for_display('form_label');
    }

    private function addHeadingStyleSection(): void
    {
        $this->startStyleControlsSection('heading_style', esc_html__('Heading', 'listivo-core'));

        $this->addTypographyControl('.listivo-hero-search-v10__heading', 'heading');

        $this->add_control(
            'heading_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-hero-search-v10__heading' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'heading_span_color',
            [
                'label' => esc_html__('Span color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-hero-search-v10__heading span' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->endControlsSection();
    }

    private function addTextStyleSection(): void
    {
        $this->startStyleControlsSection('text_style', esc_html__('Text', 'listivo-core'));

        $this->addTypographyControl('.listivo-hero-search-v10__text', 'text');

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-hero-search-v10__text' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->endControlsSection();
    }

    private function addFormStyleSection(): void
    {
        $this->startStyleControlsSection('form', esc_html__('Form', 'listivo-core'));

        $this->add_control(
            'form_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-search-form-v3' => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'form_label_heading',
            [
                'label' => esc_html__('Label', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->addTypographyControl('.listivo-search-form-v3__label', 'form_label');

        $this->add_control(
            'form_label_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-search-form-v3__label' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->endControlsSection();
    }

    private function addButtonStyleSection(): void
    {
        $this->startStyleControlsSection('button', esc_html__('Button', 'listivo-core'));

        $this->add_control(
            'button_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
                '{{WRAPPER}} .listivo-search-form-v3__button' => 'color: {{VALUE}};'
            ]
        );

        $this->add_control(
            'button_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
                '{{WRAPPER}} .listivo-search-form-v3__button' => 'background: {{VALUE}};'
            ]
        );

        $this->endControlsSection();
    }

    private function addBackgroundImageControl(): void
    {
        $this->add_control(
            'background_image',
            [
                'label' => esc_html__('Background image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );
    }

    public function getBackgroundImage(): string
    {
        $image = $this->get_settings_for_display('background_image');

        return $image['url'] ?? '';
    }

    private function addShowArrowControl(): void
    {
        $this->add_control(
            'show_arrow',
            [
                'label' => esc_html__('Display arrow', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );
    }

    public function showArrow(): bool
    {
        return !empty((int)$this->get_settings_for_display('show_arrow'));
    }

    private function addPaddingControl(): void
    {
        $this->add_responsive_control(
            'padding',
            [
                'label' => esc_html__('Padding', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .listivo-hero-search-v10' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                ]
            ]
        );
    }

    protected function render(): void
    {
        parent::render();

        $this->renderCustomFieldStyles();
    }

    private function addBackgroundMaskStyleSection(): void
    {
        $this->startStyleControlsSection('background_mask', esc_html__('Background mask', 'listivo-core'));

        $this->add_control(
            'background_mask_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-hero-search-v10__background:before' => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'background_mask_opacity',
            [
                'label' => esc_html__('Opacity', 'listivo-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1,
                        'step' => 0.1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .listivo-hero-search-v10__background:before' => 'opacity: {{SIZE}};'
                ]
            ]
        );

        $this->endControlsSection();
    }
}