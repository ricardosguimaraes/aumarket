<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;

class HeroV1Widget extends BaseGeneralWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'hero_v1';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Hero V1', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addSmallHeadingControl();

        $this->addHeadingControl();

        $this->addImageControl();

        $this->addMobileImageControl();

        $this->addFirstButtonControls();

        $this->addSecondButtonControls();

        $this->endControlsSection();
    }

    private function addImageControl(): void
    {
        $this->add_control(
            'image',
            [
                'label' => esc_html__('Background image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        $image = $this->get_settings_for_display('image');

        return $image['url'] ?? '';
    }

    private function addMobileImageControl(): void
    {
        $this->add_control(
            'mobile_image',
            [
                'label' => esc_html__('Mobile background image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );
    }

    /**
     * @return string
     */
    public function getMobileImage(): string
    {
        $image = $this->get_settings_for_display('mobile_image');

        return $image['url'] ?? '';
    }

    private function addSmallHeadingControl(): void
    {
        $this->add_control(
            'small_heading',
            [
                'label' => esc_html__('Small heading', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );
    }

    /**
     * @return string
     */
    public function getSmallHeading(): string
    {
        return (string)$this->get_settings_for_display('small_heading');
    }

    private function addHeadingControl(): void
    {
        $this->add_control(
            'heading',
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
        return (string)$this->get_settings_for_display('heading');
    }

    private function addFirstButtonControls(): void
    {
        $this->addFirstButtonHeading();

        $this->addFirstButtonTextControl();

        $this->addFirstButtonDestinationControl();
    }

    protected function addFirstButtonHeading(): void
    {
        $this->add_control(
            'first_button_heading',
            [
                'label' => esc_html__('First Button', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );
    }

    protected function addFirstButtonDestinationControl(): void
    {
        $this->add_control(
            'first_button_destination',
            [
                'label' => tdf_admin_string('destination'),
                'type' => SelectRemoteControl::TYPE,
                'source' => tdf_action_url(tdf_prefix() . '/button/destinations')
            ]
        );
    }

    protected function addFirstButtonTextControl(): void
    {
        $this->add_control(
            'first_button_text',
            [
                'label' => tdf_admin_string('text'),
                'type' => Controls_Manager::TEXT,
                'default' => tdf_admin_string('button'),
            ]
        );
    }

    /**
     * @return string
     */
    public function getFirstButtonText(): string
    {
        return (string)$this->get_settings_for_display('first_button_text');
    }

    /**
     * @return string
     */
    public function getFirstButtonUrl(): string
    {
        return apply_filters(
            tdf_prefix() . '/button/destination',
            false,
            (string)$this->get_settings_for_display('first_button_destination')
        );
    }

    private function addSecondButtonControls(): void
    {
        $this->addSecondButtonHeading();

        $this->addSecondButtonTextControl();

        $this->addSecondButtonDestinationControl();
    }

    protected function addSecondButtonHeading(): void
    {
        $this->add_control(
            'second_button_heading',
            [
                'label' => esc_html__('Second Button', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );
    }

    protected function addSecondButtonDestinationControl(): void
    {
        $this->add_control(
            'second_button_destination',
            [
                'label' => tdf_admin_string('destination'),
                'type' => SelectRemoteControl::TYPE,
                'source' => tdf_action_url(tdf_prefix() . '/button/destinations')
            ]
        );
    }

    protected function addSecondButtonTextControl(): void
    {
        $this->add_control(
            'second_button_text',
            [
                'label' => tdf_admin_string('text'),
                'type' => Controls_Manager::TEXT,
                'default' => tdf_admin_string('button'),
            ]
        );
    }

    /**
     * @return string
     */
    public function getSecondButtonText(): string
    {
        return (string)$this->get_settings_for_display('second_button_text');
    }

    /**
     * @return string
     */
    public function getSecondButtonUrl(): string
    {
        return apply_filters(
            tdf_prefix() . '/button/destination',
            false,
            (string)$this->get_settings_for_display('second_button_destination')
        );
    }

}