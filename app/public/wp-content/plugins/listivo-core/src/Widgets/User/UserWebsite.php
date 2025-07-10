<?php

namespace Tangibledesign\Listivo\Widgets\User;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Widgets\Helpers\BaseUserWidget;
use Tangibledesign\Framework\Widgets\Helpers\ModelSingleWidget;

class UserWebsite extends BaseUserWidget implements ModelSingleWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'user_website';
    }

    /**
     * @return string
     */
    public function getWebsite(): string
    {
        $user = $this->getUser();
        if (!$user) {
            return '';
        }

        $website = $user->getWebsite();
        if (empty($website)) {
            return '';
        }

        return $website;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('User Website', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addTextControl();

        $this->addOpenInNewWindowControl();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addStyleControls();

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    public function addTextControl(): void
    {
        $this->add_control(
            'text',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
                'default' => 'User website',
            ]
        );
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        $text = $this->get_settings_for_display('text');
        if (empty($text)) {
            /** @noinspection HttpUrlsUsage */
            return str_replace(['https://', 'http://'], '', $this->getWebsite());
        }

        return $text;
    }

    private function addOpenInNewWindowControl(): void
    {
        $this->add_control(
            'open_in_new_window',
            [
                'label' => esc_html__('Open in new window', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );
    }

    /**
     * @return bool
     */
    public function openInNewWindow(): bool
    {
        return !empty((int)$this->get_settings_for_display('open_in_new_window'));
    }

    private function addStyleControls(): void
    {
        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-user-website' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_typo',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-user-website',
            ]
        );
    }

}