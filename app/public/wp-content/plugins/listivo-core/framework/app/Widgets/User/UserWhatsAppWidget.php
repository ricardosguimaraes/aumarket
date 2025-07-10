<?php


namespace Tangibledesign\Framework\Widgets\User;


use Tangibledesign\Framework\Widgets\Helpers\BaseUserWidget;

/**
 * Class UserWhatsAppWidget
 * @package Tangibledesign\Framework\Widgets\User
 */
class UserWhatsAppWidget extends BaseUserWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'user_whats_app';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return tdf_admin_string('user_whats_app');
    }

}