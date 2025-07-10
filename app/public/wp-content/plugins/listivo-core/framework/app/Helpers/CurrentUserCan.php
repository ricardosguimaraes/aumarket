<?php


namespace Tangibledesign\Framework\Helpers;


/**
 * Trait CurrentUserCan
 * @package Tangibledesign\Framework\Helpers
 */
trait CurrentUserCan
{
    /**
     * @return bool
     */
    public function currentUserCanManageOptions(): bool
    {
        return current_user_can('manage_options');
    }

}