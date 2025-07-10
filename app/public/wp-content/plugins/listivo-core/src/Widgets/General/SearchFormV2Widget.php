<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Exception;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SearchFields\SearchFieldsControl;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\ButtonTypeControl;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\FieldStyleSection;

class SearchFormV2Widget extends BaseGeneralWidget
{
    use SearchFieldsControl;
    use ButtonTypeControl;
    use FieldStyleSection;

    /**
     * @param $data
     * @param $args
     * @throws Exception
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);

        $this->registerMapDeps();
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'search_form_v2';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Search form V2', 'listivo-core');
    }

    /**
     * @return array
     */
    public function get_script_depends(): array
    {
        return ['google-maps'];
    }

    protected function register_controls(): void
    {
        $this->addSearchFormControls();

        $this->addStyleSection();

        $this->addFieldStyleSection('.listivo-search-form-v2');
    }

    private function addStyleSection(): void
    {
        $this->startStyleControlsSection();

        $this->addFormBorderRadiusControl();

        $this->add_responsive_control(
            'align',
            [
                'label' => esc_html__('Align', 'listivo-core'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => tdf_admin_string('left'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => tdf_admin_string('center'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => tdf_admin_string('right'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .listivo-search-form-v2--wrapper' => 'justify-content: {{VALUE}};'
                ]
            ]
        );

        $this->addButtonStyleControl();

        $this->endControlsSection();
    }

    private function addSearchFormControls(): void
    {
        $this->startContentControlsSection(
            'search_form',
            esc_html__('Search Form', 'listivo-core')
        );

        $this->addMainFieldControls();

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
                    ."let labels = ".json_encode($this->getFieldOptions())."; "
                    ."let label = labels[field]; "
                    ."#>"
                    ."{{{ label }}}",
            ]
        );

        $this->endControlsSection();
    }

    private function addButtonStyleControl(): void
    {
        $this->add_control(
            'button_heading',
            [
                'label' => esc_html__('Button', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->addButtonTypeControl('primary_1', esc_html__('Type', 'listivo-core'));

        $this->add_control(
            'button_style',
            [
                'label' => esc_html__('Style', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'icon' => esc_html__('Icon', 'listivo-core'),
                    'text' => esc_html__('Regular', 'listivo-core'),
                ],
                'default' => 'icon',
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => esc_html__('Border radius', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-search-form-v2__text-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'button_style' => 'text',
                ]
            ]
        );

        $this->add_control(
            'button_icon_border_radius',
            [
                'label' => esc_html__('Border radius', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-search-form-v2__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'button_style' => 'icon',
                ]
            ]
        );

        $this->add_control(
            'button_width',
            [
                'label' => esc_html__('Width (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .listivo-search-form-v2__button' => 'width: {{VALUE}}px;'
                ],
                'condition' => [
                    'button_style' => 'icon',
                ]
            ]
        );

        $this->add_control(
            'button_height',
            [
                'label' => esc_html__('Height (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .listivo-search-form-v2__button' => 'height: {{VALUE}}px;'
                ],
                'condition' => [
                    'button_style' => 'icon',
                ]
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => tdf_string('search'),
            ]
        );
    }

    private function getButtonStyle(): string
    {
        $style = $this->get_settings_for_display('button_style');
        if (empty($style)) {
            return 'icon';
        }

        return $style;
    }

    /**
     * @return bool
     */
    public function isButtonIconStyle(): bool
    {
        return $this->getButtonStyle() === 'icon';
    }

    /**
     * @return string
     */
    public function getButtonText(): string
    {
        $text = (string)$this->get_settings_for_display('button_text');
        if (empty($text)) {
            return tdf_string('search');
        }

        return $text;
    }

    private function addFormBorderRadiusControl(): void
    {
        $this->add_control(
            'form_border_radius',
            [
                'label' => esc_html__('Form border radius', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-search-form-v2__inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
    }

    protected function render(): void
    {
        parent::render();

        $this->renderCustomFieldStyles();
    }

}