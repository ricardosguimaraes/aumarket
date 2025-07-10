<?php

use Tangibledesign\Framework\Core\Notification;

add_filter('listivo/notifications', static function () {
    return [
        [
            'key' => Notification::MAIL_CONFIRMATION,
            'label' => esc_html__('Confirmation Email', 'listivo-core'),
            'description' => esc_html__('Require new users to verify account via email.', 'listivo-core'),
            'title' => esc_html__('Confirm your e-mail', 'listivo-core'),
            'message' => esc_html__('Hello {userDisplayName},

Thank you for registration! Please confirm your email by clicking this link: {confirmationLink}

Best wishes,
CEO', 'listivo-core'),
            'vars' => ['userDisplayName'],
            'optional' => false,
            'enabled' => true,
        ],
        [
            'key' => Notification::RESET_PASSWORD,
            'label' => esc_html__('Reset Password', 'listivo-core'),
            'description' => esc_html__('Email that your users will receive if they use Forgotten password function',
                'listivo-core'),
            'title' => esc_html__('Reset your password', 'listivo-core'),
            'message' => esc_html__('Hello {userDisplayName},

You can reset your password here: {resetPasswordLink}

Best wishes,
CEO', 'listivo-core'),
            'vars' => ['userDisplayName'],
            'optional' => false,
            'enabled' => true,
        ],
        [
            'key' => Notification::CHANGE_EMAIL,
            'label' => esc_html__('Change E-Mail', 'listivo-core'),
            'description' => esc_html__('Email that your users will receive when they change email', 'listivo-core'),
            'title' => esc_html__('Change Your E-Mail', 'listivo-core'),
            'message' => esc_html__('Hello {userDisplayName},

PIN: {changeEmailToken}

Best wishes,
CEO', 'listivo-core'),
            'vars' => ['changeEmailToken', 'userDisplayName'],
            'optional' => false,
            'enabled' => true,
        ],
    ];
});