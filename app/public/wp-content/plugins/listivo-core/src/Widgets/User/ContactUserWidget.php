<?php

namespace Tangibledesign\Listivo\Widgets\User;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Models\Template\UserTemplate;
use Tangibledesign\Framework\Widgets\Helpers\HasModel;
use Tangibledesign\Framework\Widgets\Helpers\ModelSingleWidget;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\ButtonTypeControl;

class ContactUserWidget extends \Tangibledesign\Framework\Widgets\User\ContactUserWidget implements ModelSingleWidget
{
    use HasModel;
    use ButtonTypeControl;

    protected function register_controls(): void
    {
        $this->start_controls_section(
            'general',
            [
                'label' => tdf_admin_string('general'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'type',
            [
                'label' => tdf_admin_string('type'),
                'type' => Controls_Manager::SELECT,
                'options' => $this->getOptions(),
                'default' => 'global'
            ]
        );

        $this->add_control(
            'show_label',
            [
                'label' => esc_html__('Display label', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );

        $this->addButtonTypeControl();

        $this->end_controls_section();

        $this->startStyleControlsSection();

        $this->addHeadingStyleControls();

        $this->addTextStyleControls();

        $this->addMarginControl();

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    private function addHeadingStyleControls(): void
    {
        $this->add_control(
            'label_heading',
            [
                'label' => esc_html__('Label', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-create-message-form__label' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'label_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '.listivo-create-message-form__label',
            ]
        );
    }

    private function addTextStyleControls(): void
    {
        $this->add_control(
            'text_heading',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} textarea' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'text_typography',
                'selector' => '{{WRAPPER}} textarea',
            ]
        );
    }

    private function addMarginControl(): void
    {
        $this->add_responsive_control(
            'contact_margin',
            [
                'label' => esc_html__('Margin', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-create-message-form' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .listivo-contact-form' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
    }

    /**
     * @return bool
     */
    public function isUserPage(): bool
    {
        if (is_author()) {
            return true;
        }

        $template = tdf_app('current_template');
        return $template instanceof UserTemplate;
    }

    public function showLabel(): bool
    {
        return !empty($this->get_settings_for_display('show_label'));
    }

}