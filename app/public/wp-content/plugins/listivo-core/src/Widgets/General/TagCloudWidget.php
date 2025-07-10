<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\BlogWidgetStyleControls;

class TagCloudWidget extends BaseGeneralWidget
{
    use BlogWidgetStyleControls;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'tags_cloud';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return tdf_admin_string('tag_cloud');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->add_control(
            'label',
            [
                'label' => tdf_admin_string('label'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => tdf_string('tag_cloud'),
            ]
        );

        $this->add_control(
            'taxonomy',
            [
                'label' => tdf_admin_string('taxonomy'),
                'type' => Controls_Manager::SELECT,
                'default' => 'post_tag',
                'options' => $this->getTaxonomyControlOptions(),
            ]
        );

        $this->add_control(
            'number',
            [
                'label' => tdf_admin_string('number'),
                'type' => Controls_Manager::NUMBER,
                'default' => 45,
            ]
        );

        $this->add_control(
            'show_count',
            [
                'label' => tdf_admin_string('display_count'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );

        $this->endControlsSection();

        $this->addStyleSection();
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        $label = (string)$this->get_settings_for_display('label');
        if (empty($label)) {
            return tdf_string('tag_cloud');
        }

        return $label;
    }

    private function getTaxonomyControlOptions(): array
    {
        $options = [
            'post_tag' => tdf_admin_string('tag'),
            'category' => tdf_admin_string('category'),
        ];

        foreach (tdf_taxonomy_fields() as $taxonomyField) {
            $options[$taxonomyField->getKey()] = $taxonomyField->getName();
        }

        return $options;
    }

    /**
     * @return string
     */
    private function getTaxonomy(): string
    {
        $taxonomy = (string)$this->get_settings_for_display('taxonomy');
        if (empty($taxonomy)) {
            return 'post_tag';
        }

        return $taxonomy;
    }

    /**
     * @return int
     */
    private function getNumber(): int
    {
        $number = (int)$this->get_settings_for_display('number');
        if (empty($number)) {
            return 45;
        }

        return $number;
    }

    /**
     * @return bool
     */
    private function showCount(): bool
    {
        return !empty((int)$this->get_settings_for_display('show_count'));
    }

    /**
     * @return string[]
     */
    public function getArgs(): array
    {
        return [
            'taxonomy' => $this->getTaxonomy(),
            'number' => $this->getNumber(),
            'show_count' => $this->showCount(),
        ];
    }

    private function addStyleSection(): void
    {
        $this->startStyleControlsSection();

        $this->addBlogWidgetStyleControls();

        $this->add_control(
            'text_heading',
            [
                'label' => esc_html__('Tag', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        
        $this->add_control(
            'tag_border_radius',
            [
                'label' => esc_html__('Border radius (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .tag-cloud-link' => 'border-radius: {{VALUE}}px;',
                ]
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tag-cloud-link' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'text_hover_color',
            [
                'label' => esc_html__('Hover color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tag-cloud-link:hover' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'background_heading',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tag-cloud-link' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'background_hover_color',
            [
                'label' => esc_html__('Hover color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tag-cloud-link:hover' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->endControlsSection();
    }

}