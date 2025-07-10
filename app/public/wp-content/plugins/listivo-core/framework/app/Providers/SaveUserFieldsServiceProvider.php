<?php


namespace Tangibledesign\Framework\Providers;


use Tangibledesign\Framework\Core\ServiceProvider;
use WP_User;

/**
 * Class SaveUserFieldsServiceProvider
 * @package Tangibledesign\Framework\Providers
 */
class SaveUserFieldsServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('edit_user_profile', [$this, 'addFields'], 9);
        add_action('show_user_profile', [$this, 'addFields'], 9);

        add_action('edit_user_profile_update', [$this, 'saveFields']);
        add_action('personal_options_update', [$this, 'saveFields']);
    }

    public function addFields(WP_User $user): void
    {
        tdf_load_view('user/fields', [
            'user' => tdf_user_factory()->create($user)
        ]);
    }

    public function saveFields(int $userId): void
    {
        $user = tdf_user_factory()->create($userId);
        if (!$user) {
            return;
        }

        $user->updateSettings($_POST);
    }

}