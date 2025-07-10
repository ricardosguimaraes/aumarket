<?php

namespace Tangibledesign\Framework\Providers\Users;

use Tangibledesign\Framework\Actions\Users\DeleteUserAction;
use Tangibledesign\Framework\Core\ServiceProvider;

class DeleteUserServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('admin_post_'.tdf_prefix().'/users/delete', [$this, 'delete']);
    }

    /**
     * @return void
     */
    public function delete(): void
    {
        if ($this->currentUserCanManageOptions()) {
            return;
        }

        $userId = $this->getUserId();
        if (empty($userId)) {
            return;
        }

        (new DeleteUserAction())->execute($userId);

        wp_logout();
    }

    /**
     * @return int
     */
    private function getUserId(): int
    {
        return get_current_user_id();
    }

}