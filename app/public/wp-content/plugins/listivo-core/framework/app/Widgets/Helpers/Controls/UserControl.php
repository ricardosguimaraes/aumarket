<?php


namespace Tangibledesign\Framework\Widgets\Helpers\Controls;


use Tangibledesign\Framework\Models\User\User;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;

/**
 * Trait UserControl
 * @package Tangibledesign\Framework\Widgets\Helpers\Controls
 */
trait UserControl
{
    use Control;

    protected function addUserControl(): void
    {
        $this->add_control(
            'user',
            [
                'label' => tdf_admin_string('user'),
                'type' => SelectRemoteControl::TYPE,
                'source' => get_rest_url() . 'wp/v2/users',
            ]
        );
    }

    /**
     * @return User|false
     */
    public function getUser()
    {
        $userId = (int)$this->get_settings_for_display('user');

        if (empty($userId)) {
            return false;
        }

        return tdf_user_factory()->create($userId);
    }

}