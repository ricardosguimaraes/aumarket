<?php

namespace Tangibledesign\Framework\Actions\Message;


use Tangibledesign\Framework\Core\Notification;
use Tangibledesign\Framework\Models\DirectMessage\DirectMessage;
use Tangibledesign\Framework\Models\Notification\Trigger;
use Tangibledesign\Framework\Providers\DirectMessagesServiceProvider;

class CreateDirectMessageAction
{
    /**
     * @param int $userFrom
     * @param int $userTo
     * @param string $message
     * @param string $createdAt
     * @param int $seen
     * @return bool
     */
    public static function create(
        int    $userFrom,
        int    $userTo,
        string $message,
        string $createdAt = '',
        int    $seen = 0
    ): bool
    {
        if (empty($message) || empty($userFrom) || empty($userTo)) {
            return false;
        }

        global $wpdb;

        if (empty($createdAt)) {
            $createdAt = date('Y-m-d H:i:s');
        }

        return $wpdb->insert(DirectMessagesServiceProvider::getTableName(), [
                'user_from' => $userFrom,
                'user_to' => $userTo,
                'message' => nl2br($message),
                'seen' => $seen,
                'created_at' => $createdAt,
            ]) !== false;
    }

}