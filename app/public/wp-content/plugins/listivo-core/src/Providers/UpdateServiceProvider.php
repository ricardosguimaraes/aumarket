<?php

namespace Tangibledesign\Listivo\Providers;

use Elementor\Plugin;
use Tangibledesign\Framework\Actions\Notifications\CreateNotificationAction;
use Tangibledesign\Framework\Actions\Order\CreateOrderFromWooCommerceOrderAction;
use Tangibledesign\Framework\Actions\PaymentPackage\CreateRegularUserPaymentPackageAction;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Notification\Notification;
use Tangibledesign\Framework\Models\Notification\NotificationType;
use Tangibledesign\Framework\Models\Notification\Trigger;
use Tangibledesign\Framework\Models\Payments\DynamicPaymentPackageRegular;
use Tangibledesign\Framework\Models\User\Helpers\UserSettingKey;

class UpdateServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('admin_init', [$this, 'updateUserPackages']);

        add_action('admin_init', [$this, 'updateLegacyNotifications']);

        add_action('admin_init', [$this, 'updateCronSchedules']);

        add_action('admin_init', [$this, 'afterUpdate']);
    }

    public function afterUpdate(): void
    {
        $version = get_option('listivo_version');
        if ($version === LISTIVO_CORE_VERSION) {
            return;
        }

        Plugin::instance()->files_manager->clear_cache();

        update_option(tdf_prefix() . '_flush_urls', 1);

        update_option('listivo_version', LISTIVO_CORE_VERSION, true);

        wp_unschedule_hook(tdf_prefix() . '/directMessages/notifications');

        do_action(tdf_prefix() . '/settings/saved');

        $this->fixElementor();

        if ($version < '2.3.0') {
            $this->updateOrders();
        }
    }

    private function fixElementor(): void
    {
        /* @var \Elementor\Core\Kits\Documents\Kit $kit */
        $kit = Plugin::instance()->kits_manager->get_active_kit_for_frontend();
        if (!$kit) {
            return;
        }

        $kit->set_settings('space_between_widgets', [
            "column" => "0",
            "row" => "0",
            "isLinked" => true,
            "unit" => "px",
            "size" => 0,
            "sizes" => []
        ]);

        $kit->set_settings('site_favicon', [
            'url' => '',
            'id' => get_option('site_icon', '0'),
            'size' => '',
        ]);

        $kit->save(['settings' => $kit->get_settings()]);
    }

    public function updateCronSchedules(): void
    {
        $check = (int)get_option('listivo_update_cron_schedules');
        if (!empty($check)) {
            return;
        }

        wp_unschedule_hook(tdf_prefix() . '/notifications/modelExpire/check');
        wp_unschedule_hook(tdf_prefix() . '/models/checkExpired');
        wp_unschedule_hook(tdf_prefix() . '/models/checkBumps');
        wp_unschedule_hook(tdf_prefix() . '/directMessages/notifications');
        wp_unschedule_hook(tdf_prefix() . '/notifications/send');

        wp_schedule_event(time(), 'every_minute', tdf_prefix() . '/notifications/modelExpire/check');
        wp_schedule_event(time(), 'every_minute', tdf_prefix() . '/models/checkExpired');
        wp_schedule_event(time(), 'every_minute', tdf_prefix() . '/models/checkBumps');
        wp_schedule_event(time(), 'every_minute', tdf_prefix() . '/directMessages/notifications');
        wp_schedule_event(time(), 'every_minute', tdf_prefix() . '/notifications/send');

        update_option('listivo_update_cron_schedules', 1, false);
    }

    public function updateLegacyNotifications(): void
    {
        $check = (int)get_option('listivo_legacy_notifications');
        if (!empty($check)) {
            return;
        }

        $notifications = get_option(tdf_prefix() . '_notifications');

        $search = [
            '{listingName}',
            '{listingLink}',
            '{replyLink}',
            '{messageSenderName}',
            '{messageSenderNameWithLink}'
        ];

        $replace = [
            '{adName}',
            '{adUrl}',
            '{messageReplyUrl}',
            '{messageSenderDisplayName}',
            '{messageSenderDisplayNameWithUrl}'
        ];

        if (isset($notifications['model_approved']) && !empty($notifications['model_approved']['enabled'])) {
            $notificationId = (new CreateNotificationAction())->execute([
                Notification::NAME => 'Ad Approved',
                Notification::TYPES => [NotificationType::MAIL],
                Notification::TRIGGER => Trigger::MODEL_APPROVED,
            ]);

            update_post_meta(
                $notificationId,
                Notification::MAIL_TITLE,
                str_replace($search, $replace, $notifications['model_approved']['title'])
            );

            update_post_meta(
                $notificationId,
                Notification::MAIL_TEXT,
                str_replace($search, $replace, $notifications['model_approved']['message'])
            );
        }

        if (isset($notifications['model_declined']) && !empty($notifications['model_declined']['enabled'])) {
            $notificationId = (new CreateNotificationAction())->execute([
                Notification::NAME => 'Ad Declined',
                Notification::TYPES => [NotificationType::MAIL],
                Notification::TRIGGER => Trigger::MODEL_DECLINED,
            ]);

            update_post_meta(
                $notificationId,
                Notification::MAIL_TITLE,
                str_replace($search, $replace, $notifications['model_declined']['title'])
            );

            update_post_meta(
                $notificationId,
                Notification::MAIL_TEXT,
                str_replace($search, $replace, $notifications['model_declined']['message'])
            );
        }

        if (isset($notifications['model_pending']) && !empty($notifications['model_pending']['enabled'])) {
            $notificationId = (new CreateNotificationAction())->execute([
                Notification::NAME => 'Ad Pending',
                Notification::TYPES => [NotificationType::MAIL],
                Notification::TRIGGER => Trigger::USER_MODEL_PENDING,
            ]);

            update_post_meta(
                $notificationId,
                Notification::MAIL_TITLE,
                str_replace($search, $replace, $notifications['model_pending']['title'])
            );

            update_post_meta(
                $notificationId,
                Notification::MAIL_TEXT,
                str_replace($search, $replace, $notifications['model_pending']['message'])
            );
        }

        if (isset($notifications['model_expired']) && !empty($notifications['model_expired']['enabled'])) {
            $notificationId = (new CreateNotificationAction())->execute([
                Notification::NAME => 'Ad Expired',
                Notification::TYPES => [NotificationType::MAIL],
                Notification::TRIGGER => Trigger::MODEL_EXPIRED,
            ]);

            update_post_meta(
                $notificationId,
                Notification::MAIL_TITLE,
                str_replace($search, $replace, $notifications['model_expired']['title'])
            );

            update_post_meta(
                $notificationId,
                Notification::MAIL_TEXT,
                str_replace($search, $replace, $notifications['model_expired']['message'])
            );
        }

        if (isset($notifications['new_model_pending']) && !empty($notifications['new_model_pending']['enabled'])) {
            $notificationId = (new CreateNotificationAction())->execute([
                Notification::NAME => 'Ad Pending (Moderator)',
                Notification::TYPES => [NotificationType::MAIL],
                Notification::TRIGGER => Trigger::MODERATION_MODEL_PENDING,
            ]);

            update_post_meta(
                $notificationId,
                Notification::MAIL_TITLE,
                str_replace($search, $replace, $notifications['new_model_pending']['title'])
            );

            update_post_meta(
                $notificationId,
                Notification::MAIL_TEXT,
                str_replace($search, $replace, $notifications['new_model_pending']['message'])
            );
        }

        if (isset($notifications['welcome_user']) && !empty($notifications['welcome_user']['enabled'])) {
            $notificationId = (new CreateNotificationAction())->execute([
                Notification::NAME => 'Welcome user',
                Notification::TYPES => [NotificationType::MAIL],
                Notification::TRIGGER => Trigger::USER_WELCOME,
            ]);

            update_post_meta(
                $notificationId,
                Notification::MAIL_TITLE,
                str_replace($search, $replace, $notifications['welcome_user']['title'])
            );

            update_post_meta(
                $notificationId,
                Notification::MAIL_TEXT,
                str_replace($search, $replace, $notifications['welcome_user']['message'])
            );
        }

        if (isset($notifications['new_message']) && !empty($notifications['new_message']['enabled'])) {
            $notificationId = (new CreateNotificationAction())->execute([
                Notification::NAME => 'New message',
                Notification::TYPES => [NotificationType::MAIL],
                Notification::TRIGGER => Trigger::USER_NEW_MESSAGE,
            ]);

            update_post_meta(
                $notificationId,
                Notification::MAIL_TITLE,
                str_replace($search, $replace, $notifications['new_message']['title'])
            );

            update_post_meta(
                $notificationId,
                Notification::MAIL_TEXT,
                str_replace($search, $replace, $notifications['new_message']['message'])
            );
        }

        update_option('listivo_legacy_notifications', 1, false);
    }

    public function updateUserPackages(): void
    {
        $check = (int)get_option('listivo_user_packages_updated_check');
        if (!empty($check)) {
            return;
        }

        foreach (tdf_query_users()->get() as $user) {
            $packages = $user->getMeta(UserSettingKey::PACKAGES);
            if (empty($packages) || !is_array($packages)) {
                continue;
            }

            foreach ($packages as $package) {
                $data = array_values((array)$package);

                $p['key'] = $data[1];
                $p['name'] = $data[2];
                $p['number'] = $data[3];
                $p['expire'] = $data[4];
                $p['featuredExpire'] = $data[5];
                $p['price'] = $data[6];
                $p['displayPrice'] = $data[6];
                $p['categories'] = $data[7];

                $dynamicPackage = new DynamicPaymentPackageRegular($p);

                (new CreateRegularUserPaymentPackageAction())->execute($user, $dynamicPackage);
            }
        }

        update_option('listivo_user_packages_updated_check', '1');
    }

    private function updateOrders(): void
    {
        if (!function_exists('wc_get_orders')) {
            return;
        }

        $orders = wc_get_orders([
            'limit' => -1,
            'status' => wc_get_order_statuses(),
        ]);

        foreach ($orders as $order) {
            (new CreateOrderFromWooCommerceOrderAction())->execute($order);
        }
    }

}