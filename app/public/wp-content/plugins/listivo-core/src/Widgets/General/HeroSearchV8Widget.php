<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Tangibledesign\Framework\Models\Term\CustomTerm;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\FieldStyleSection;

class HeroSearchV8Widget extends HeroSearchWidget
{
    use FieldStyleSection;

    public function getKey(): string
    {
        return 'hero_search_v8';
    }

    public function getName(): string
    {
        return esc_html__('Hero Search V8', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addHeadingControl();

        $this->addFirstImageControl();

        $this->addSecondImageControl();

        $this->addShowArrowControl();

        $this->endControlsSection();

        $this->addFieldsSection();

        $this->addWhatsPopularSection();

        $this->startStyleControlsSection();

        $this->addHeadingStyleControls();

        $this->endControlsSection();

        $this->addFieldStyleSection();
    }

    private function addHeadingStyleControls(): void
    {
        $this->add_control(
            'heading_heading',
            [
                'label' => esc_html__('Heading', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-hero-search-v8__heading' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'heading_typo',
                'selector' => '{{WRAPPER}} .listivo-hero-search-v8__heading',
            ]
        );
    }

    private function addFieldsSection(): void
    {
        $this->startContentControlsSection('search_fields', esc_html__('Fields', 'listivo-core'));

        $this->addMainFieldControls(true);

        $this->addFieldsControl();

        $this->endControlsSection();

    }

    private function addFieldsControl(): void
    {
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
    }

    private function addFirstImageControl(): void
    {
        $this->add_control(
            'first_image',
            [
                'label' => esc_html__('First image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );
    }

    public function getFirstImage(): string
    {
        $image = $this->get_settings_for_display('first_image');

        return $image['url'] ?? '';
    }

    private function addSecondImageControl(): void
    {
        $this->add_control(
            'second_image',
            [
                'label' => esc_html__('Second image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );
    }

    public function getSecondImage(): string
    {
        $image = $this->get_settings_for_display('second_image');

        return $image['url'] ?? '';
    }

    public function getInitialFilters(CustomTerm $term): array
    {
        return [
            [
                'key' => $term->getTaxonomyKey(),
                'values' => [$term->getId()],
                'type' => 'taxonomy',
            ]
        ];
    }

    protected function render(): void
    {
        parent::render();

        $this->renderCustomFieldStyles();
    }

    private function addShowArrowControl(): void
    {
        $this->add_control(
            'show_arrow',
            [
                'label' => esc_html__('Show arrow', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );
    }

    public function showArrow(): bool
    {
        return (int)$this->get_settings_for_display('show_arrow') === 1;
    }
}