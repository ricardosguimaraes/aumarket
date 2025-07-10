<?php


namespace Tangibledesign\Framework\Providers;


use Tangibledesign\Framework\Core\ServiceProvider;

/**
 * Class UserRoleServiceProviders
 * @package Tangibledesign\Framework\Providers
 */
class UserRoleServiceProviders extends ServiceProvider
{
    /**
     * @return void
     */
    public function initiation(): void
    {
        $this->container['user_roles'] = static function () {
            global $wp_roles;

            $roles = [];

            foreach ($wp_roles->roles as $key => $role) {
                $roles[$key] = $role['name'];
            }

            return $roles;
        };

        $this->container['admin_ids'] = static function () {
            return tdf_collect(get_users([
                'role__in' => ['administrator'],
            ]))->map(static function ($user) {
                return $user->ID;
            })->values();
        };
    }

    /**
     * @return void
     */
    public function afterInitiation(): void
    {
        add_action('admin_init', [$this, 'create']);
    }

    /**
     * @return void
     */
    public function create(): void
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        global $wp_roles;

        if (!$wp_roles->is_role(tdf_prefix().'_user')) {
            add_role(tdf_prefix().'_user', tdf_app('name').' '.tdf_string('user'));
        }
    }

}