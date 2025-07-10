<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\DirectMessage\Conversation;
use Tangibledesign\Framework\Models\Notification\Trigger;

class DirectMessageNotificationsServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action(tdf_prefix().'/directMessages/notifications', [$this, 'notifications']);

        add_action('admin_init', [$this, 'scheduleCheck']);
    }

    public function scheduleCheck(): void
    {
        if (!wp_next_scheduled(tdf_prefix().'/directMessages/notifications')) {
            wp_schedule_event(time(), 'every_five_minutes', tdf_prefix().'/directMessages/notifications');
        }
    }

    public function notifications(): void
    {
        if (!tdf_settings()->messageSystem()) {
            return;
        }

        foreach (tdf_query_users()->lastActive(5)->get() as $user) {
            foreach ($user->getConversations() as $conversation) {
                if (!$conversation->notified($user->getId())) {
                    /** @noinspection LoopWhichDoesNotLoopInspection */
                    foreach ($conversation->getMessages(200, 0, $user->getId())->reverse() as $message) {
                        do_action(tdf_prefix().'/notifications/trigger', Trigger::USER_NEW_MESSAGE, [
                            'user' => $message->getUserToId(),
                            'message' => $message->getId(),
                        ]);

                        Conversation::setNotified($message->getUserFromId(), $message->getUserToId());
                        break;
                    }
                }
            }
        }
    }

}