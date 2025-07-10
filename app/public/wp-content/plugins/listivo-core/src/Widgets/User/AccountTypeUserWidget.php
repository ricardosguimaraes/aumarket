<?php

namespace Tangibledesign\Listivo\Widgets\User;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Widgets\Helpers\BaseUserWidget;
use Tangibledesign\Framework\Widgets\Helpers\HasModel;
use Tangibledesign\Framework\Widgets\Helpers\ModelSingleWidget;

class AccountTypeUserWidget extends BaseUserWidget implements ModelSingleWidget
{
    use HasModel;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'user_account_type';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('User Account Type', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->add_control(
            'label',
            [
                'label' => esc_html__('Label', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->endControlsSection();

        $this->startStyleControlsSection();

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
                    '{{WRAPPER}} .listivo-user-account-type__label' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'label_typo',
                'selector' => '{{WRAPPER}} .listivo-user-account-type__label',
            ]
        );

        $this->add_control(
            'account_type_heading',
            [
                'label' => esc_html__('Account Type', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'account_type_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-user-account-type__value' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'account_type_typo',
                'selector' => '{{WRAPPER}} .listivo-user-account-type__value',
            ]
        );

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return (string)$this->get_settings_for_display('label');
    }

    /**
     * @return string
     */
    public function getAccountType(): string
    {
        $user = $this->getUser();
        if (!$user) {
            return '';
        }

        return $user->getDisplayAccountType();
    }

}