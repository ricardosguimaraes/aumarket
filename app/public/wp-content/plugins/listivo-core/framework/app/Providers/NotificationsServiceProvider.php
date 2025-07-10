<?php

namespace Tangibledesign\Framework\Providers;

use Exception;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Core\Notification;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Core\Settings\Settings;
use Tangibledesign\Framework\Models\User\User;

class NotificationsServiceProvider extends ServiceProvider
{

    public function initiation(): void
    {
        $this->container['notifications'] = static function () {
            $notifications = get_option(tdf_prefix().'_notifications');
            return Collection::make(apply_filters(tdf_prefix().'/notifications', []))
                ->map(static function ($notification) use ($notifications) {
                    if (!isset($notifications[$notification['key']])) {
                        return Notification::create($notification);
                    }

                    $n = $notifications[$notification['key']];

                    if (!empty($n['title'])) {
                        $notification['title'] = $n['title'];
                    }

                    if (!empty($n['message'])) {
                        $notification['message'] = $n['message'];
                    }

                    if (isset($n['enabled'])) {
                        $notification['enabled'] = !empty($n['enabled']);
                    } else {
                        $notification['enabled'] = false;
                    }

                    return Notification::create($notification);
                })->filter(static function ($notification) {
                    return $notification !== false;
                });
        };
    }

    public function afterInitiation(): void
    {
        add_action('admin_post_'.tdf_prefix().'/notifications/save', [$this, 'save']);

        add_action(tdf_prefix().'/notification/'.Notification::MAIL_CONFIRMATION, [$this, 'mailConfirmation']);

        add_action(tdf_prefix().'/notification/'.Notification::RESET_PASSWORD, [$this, 'resetPassword'], 10, 2);

        add_action(tdf_prefix().'/notification/'.Notification::CHANGE_EMAIL, [$this, 'changeEmail']);

        add_filter('wp_mail_from', static function ($mail) {
            if (empty(tdf_settings()->getSenderEmail())) {
                return $mail;
            }

            return tdf_settings()->getSenderEmail();
        });

        add_filter('wp_mail_from_name', static function ($name) {
            if (empty(tdf_settings()->getSenderName())) {
                return $name;
            }

            return tdf_settings()->getSenderName();
        });
    }

    public function mailConfirmation(User $user): void
    {
        $notification = Notification::getByKey(Notification::MAIL_CONFIRMATION);
        if (!$notification) {
            return;
        }

        $isLegacyMessage = $this->isLegacyMessage($notification->message);

        $confirmationUrl = $user->getConfirmationUrl();

        $title = str_replace('{userDisplayName}', $user->getDisplayName(), $notification->title);

        $message = str_replace(
            ['{userDisplayName}', '{confirmationLink}'],
            [$user->getDisplayName(), '<a href="'.$confirmationUrl.'">'.$confirmationUrl.'</a>'],
            $notification->message
        );

        $message = apply_filters(tdf_prefix().'/notification/'.Notification::MAIL_CONFIRMATION.'/message', $message,
            $confirmationUrl, $notification->message, $user->getDisplayName());

        if ($isLegacyMessage) {
            $this->sendNotification($user->getMail(), $title, $message);
            return;
        }

        $this->sendNotification($user->getMail(), $title, $message, [
            'label' => tdf_string('confirm_email'),
            'url' => $confirmationUrl,
        ]);
    }

    /**
     * @param  User  $user
     * @throws Exception
     */
    public function changeEmail(User $user): void
    {
        $notification = Notification::getByKey(Notification::CHANGE_EMAIL);
        if (!$notification) {
            return;
        }

        $token = $user->createChangeEmailToken();

        $title = str_replace('{userDisplayName}', $user->getDisplayName(), $notification->title);

        $message = str_replace(
            ['{userDisplayName}', '{changeEmailToken}'],
            [$user->getDisplayName(), $token],
            $notification->message
        );

        $this->sendNotification($user->getMail(), $title, $message);
    }

    public function resetPassword(User $user, string $link): void
    {
        $notification = Notification::getByKey(Notification::RESET_PASSWORD);
        if (!$notification) {
            return;
        }

        $isLegacyMessage = $this->isLegacyMessage($notification->message);

        $title = str_replace('{userDisplayName}', $user->getDisplayName(), $notification->title);
        $message = str_replace(
            ['{userDisplayName}', '{resetPasswordLink}'],
            [$user->getDisplayName(), '<a href="'.$link.'">'.$link.'</a>']
            , $notification->message
        );

        if ($isLegacyMessage) {
            $this->sendNotification($user->getMail(), $title, $message);
            return;
        }

        $this->sendNotification($user->getMail(), $title, $message, [
            'label' => tdf_string('reset_password'),
            'url' => $link,
        ]);
    }

    private function sendNotification(string $mail, string $title, string $rawMessage, array $cta = null): void
    {
        ob_start();

        get_template_part('templates/mail/base', null, [
            'title' => $title,
            'message' => $rawMessage,
            'cta' => $cta,
        ]);

        wp_mail($mail, $title, ob_get_clean(), [
            'Content-Type: text/html; charset=UTF-8'
        ]);
    }

    public function save(): void
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        if (isset($_POST['notifications'])) {
            $this->saveNotifications($_POST['notifications']);
        }

        tdf_settings()->update(Settings::getNotificationSettings(), $_POST);

        wp_safe_redirect($_POST['redirect'] ?? site_url());
        exit;
    }

    private function saveNotifications($notifications): void
    {
        update_option(tdf_prefix().'_notifications', stripslashes_deep($notifications));
    }

    private function isLegacyMessage(string $message): bool
    {
        return strpos($message, '{confirmationLink}') !== false
            || strpos($message, '{resetPasswordLink}') !== false;
    }

}