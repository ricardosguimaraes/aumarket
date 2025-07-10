<?php


namespace Tangibledesign\Framework\Widgets\User;


use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseUserWidget;
use Tangibledesign\Framework\Widgets\Helpers\PostSingleWidget;

/**
 * Class UserHiddenPhone
 * @package Tangibledesign\Framework\Widgets\User
 */
class UserHiddenPhoneWidget extends BaseUserWidget implements PostSingleWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'user_hidden_phone';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return tdf_admin_string('user_hidden_phone');
    }

    protected function addShowAtStartControl(): void
    {
        $this->add_control(
            'show_at_start',
            [
                'label' => tdf_admin_string('show_at_start'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );
    }

    /**
     * @return bool
     */
    public function showAtStart(): bool
    {
        return !empty($this->get_settings_for_display('show_at_start'));
    }

}