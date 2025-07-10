<?php

namespace Tangibledesign\Framework\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\User\User;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;

trait UsersControl
{
    use Control;

    protected function addUsersControl(): void
    {
        $users = new Repeater();

        $users->add_control(
            'id',
            [
                'label' => tdf_admin_string('user'),
                'type' => SelectRemoteControl::TYPE,
                'source' => get_rest_url() . 'wp/v2/users',
            ]
        );

        $this->add_control(
            'users',
            [
                'label' => tdf_admin_string('users'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $users->get_controls(),
            ]
        );
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        $users = $this->get_settings_for_display('users');

        if (!is_array($users) || empty($users)) {
            return tdf_collect();
        }

        return tdf_collect($users)->map(static function ($user) {
            return tdf_user_factory()->create((int)$user['id']);
        })->filter(static function ($user) {
            return $user !== null;
        });
    }

}