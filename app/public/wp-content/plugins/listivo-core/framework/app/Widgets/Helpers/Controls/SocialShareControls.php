<?php

namespace Tangibledesign\Framework\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;

trait SocialShareControls
{
    use Control;

    protected function addSocialShareControls(): void
    {
        $this->addShowFacebookControl();

        $this->addShowTwitterControl();

        $this->addShowWhatsAppControl();

        $this->addShowMessengerControl();
    }

    protected function addShowFacebookControl(): void
    {
        $this->add_control(
            'show_facebook',
            [
                'label' => tdf_admin_string('display_facebook'),
                'label_block' => true,
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );
    }

    public function showFacebook(): bool
    {
        return !empty((int)$this->get_settings_for_display('show_facebook'));
    }

    protected function addShowTwitterControl(): void
    {
        $this->add_control(
            'show_twitter',
            [
                'label' => tdf_admin_string('display_twitter'),
                'label_block' => true,
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );
    }

    public function showTwitter(): bool
    {
        return !empty((int)$this->get_settings_for_display('show_twitter'));
    }

    protected function addShowWhatsAppControl(): void
    {
        $this->add_control(
            'show_whats_app',
            [
                'label' => tdf_admin_string('display_whats_app'),
                'label_block' => true,
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );
    }

    public function showWhatsApp(): bool
    {
        return !empty((int)$this->get_settings_for_display('show_whats_app'));
    }

    protected function addShowMessengerControl(): void
    {
        $this->add_control(
            'show_messenger',
            [
                'label' => tdf_admin_string('display_messenger'),
                'label_block' => true,
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );
    }

    public function showMessenger(): bool
    {
        return !empty((int)$this->get_settings_for_display('show_messenger'));
    }
}