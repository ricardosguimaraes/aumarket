<?php

namespace Tangibledesign\Framework\Providers\Notifications;

use Tangibledesign\Framework\Actions\Notifications\CreateNotificationAction;
use Tangibledesign\Framework\Actions\Notifications\DeleteNotificationAction;
use Tangibledesign\Framework\Actions\Notifications\UpdateNotificationAction;
use Tangibledesign\Framework\Core\ServiceProvider;

class ManageNotificationsServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('admin_post_' . tdf_prefix() . '/notifications/create', [$this, 'create']);

        add_action('admin_post_' . tdf_prefix() . '/notifications/update', [$this, 'update']);

        add_action('admin_post_' . tdf_prefix() . '/notifications/delete', [$this, 'delete']);
    }

    public function create(): void
    {
        if (!wp_verify_nonce($_POST['nonce'] ?? '', tdf_prefix() . '/notifications/create')) {
            return;
        }

        if (!$this->currentUserCanManageOptions()) {
            return;
        }

        $notificationId = (new CreateNotificationAction())->execute($_POST);
        if (!$notificationId) {
            wp_safe_redirect(admin_url('admin.php?page=' . tdf_prefix() . '_notifications'));
            exit;
        }

        wp_safe_redirect(admin_url('admin.php?page=' . tdf_prefix() . '-edit-notification&notificationId=' . $notificationId));
        exit;
    }

    public function update(): void
    {
        if (!wp_verify_nonce($_POST['nonce'] ?? '', tdf_prefix() . '/notifications/update')) {
            return;
        }

        if (!$this->currentUserCanManageOptions()) {
            return;
        }

        $notificationId = (int)($_POST['notificationId'] ?? 0);
        if (empty($notificationId)) {
            return;
        }

        (new UpdateNotificationAction())->execute($notificationId, $_POST);

        wp_safe_redirect(admin_url('admin.php?page=' . tdf_prefix() . '_notifications'));
        exit;
    }

    public function delete(): void
    {
        if (!wp_verify_nonce($_POST['nonce'] ?? '', tdf_prefix() . '/notifications/delete')) {
            return;
        }

        if (!$this->currentUserCanManageOptions()) {
            return;
        }

        $notificationId = (int)$_POST['notificationId'];
        if (empty($notificationId)) {
            return;
        }

        (new DeleteNotificationAction())->execute($notificationId);
    }
}