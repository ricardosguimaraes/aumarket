<?php

namespace Tangibledesign\Framework\Models\DirectMessage;

use DateTime;
use Exception;
use JsonSerializable;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Providers\DirectMessagesServiceProvider;

class Conversation implements JsonSerializable
{
    /**
     * @var int
     */
    private $userId;

    /**
     * Conversation constructor.
     * @param int $userId
     * @noinspection PhpMissingParamTypeInspection
     */
    public function __construct($userId)
    {
        $this->userId = (int)$userId;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param int|false $currentUserId
     * @return Collection|DirectMessage[]
     * @noinspection SqlNoDataSourceInspection
     * @noinspection PhpMissingParamTypeInspection
     */
    public function getMessages($limit = 200, $offset = 0, $currentUserId = false): Collection
    {
        global $wpdb;

        $tableName = DirectMessagesServiceProvider::getTableName();
        $currentUserId = $currentUserId ?: get_current_user_id();

        $results = $wpdb->get_results("
            SELECT * FROM {$tableName} 
                WHERE `user_from` = {$this->userId} AND `user_to` = {$currentUserId}
                    OR `user_from` = {$currentUserId} AND `user_to` = {$this->userId}
                ORDER BY `id` DESC
                LIMIT {$limit}
                OFFSET {$offset}
            ",
            ARRAY_A
        );

        if (!is_array($results)) {
            tdf_collect();
        }

        $messages = tdf_collect($results)->map(static function ($message) {
            return DirectMessage::make($message);
        })->reverse();

        try {
            $date = new DateTime(date('Y-m-d H:i:s'));
            $showFlag = true;
            foreach ($messages as $message) {
                /* @var DirectMessage $message */
                $date2 = new DateTime($message->getCreatedAt());
                if ($showFlag) {
                    $showFlag = false;

                    $message->setShowDate(true);
                    $date = $date2;
                } elseif ($messages->count() === 1) {
                    $message->setShowDate(true);
                    $date = $date2;
                } elseif ($date->diff($date2)->i > 15) {
                    $date = $date2;
                    $message->setShowDate(true);
                } else {
                    $message->setShowDate(false);
                }
            }
        } catch (Exception $e) {
            return $messages;
        }

        return $messages;
    }

    /**
     * @return int
     * @noinspection SqlNoDataSourceInspection
     * @noinspection SqlDialectInspection
     */
    public function getCount(): int
    {
        global $wpdb;

        $tableName = DirectMessagesServiceProvider::getTableName();
        $currentUserId = get_current_user_id();

        $results = $wpdb->get_results("
            SELECT COUNT(*) as count FROM {$tableName} 
                WHERE `user_from` = {$this->userId} AND `user_to` = {$currentUserId}
                    OR `user_from` = {$currentUserId} AND `user_to` = {$this->userId}
            ",
            ARRAY_A
        );

        if (empty($results)) {
            return 0;
        }

        return (int)$results[0]['count'];
    }

    /**
     * @param int $userId
     * @return Conversation
     * @noinspection PhpMissingParamTypeInspection
     */
    public static function make($userId): Conversation
    {
        return new self($userId);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $messages = $this->getMessages();
        $user = tdf_user_factory()->create($this->userId);

        if (!$user) {
            return [];
        }

        return [
            'user' => [
                'id' => $user->getId(),
                'name' => $user->getDisplayName(),
                'image' => $user->getImageUrl(tdf_prefix() . '_100_100'),
                'url' => $user->getUrl(),
            ],
            'count' => $this->getCount(),
            'seen' => $this->seen(),
            'intro' => $messages->isNotEmpty() ? $messages->last() : false,
        ];
    }

    /**
     * @return bool
     */
    public function seen(): bool
    {
        return !$this->getMessages()->find(function ($message) {
            /* @var DirectMessage $message */
            return !$message->seen() && $message->getUserFromId() === $this->userId;
        });
    }

    /**
     * @param int $userId
     * @return bool
     */
    public function notified(int $userId): bool
    {
        return !$this->getMessages(200, 0, $userId)->find(function ($message) use ($userId) {
            /* @var DirectMessage $message */
            return !$message->notified() && $message->getUserToId() === $userId;
        });
    }

    /**
     * @param int $userId
     * @return Collection
     * @noinspection SqlDialectInspection
     * @noinspection SqlNoDataSourceInspection
     * @noinspection PhpMissingParamTypeInspection
     */
    public static function getUserIds($userId): Collection
    {
        global $wpdb;

        $tableName = DirectMessagesServiceProvider::getTableName();

        $results = $wpdb->get_results("
            SELECT `user_from`, `user_to` FROM {$tableName} 
                WHERE `user_from` = {$userId} OR `user_to` = {$userId}
                ORDER BY `id` DESC
            ",
            ARRAY_A
        );

        $userIds = tdf_collect();

        if (!empty($_GET[tdf_slug('user')])) {
            $userIds[] = (int)$_GET[tdf_slug('user')];
        }

        if (!empty($_POST['user'])) {
            $userIds[] = (int)$_POST['user'];
        }

        $userIds = $userIds->merge(tdf_collect($results)
            ->map(static function ($results) use ($userId) {
                return (int)$results['user_from'] === $userId ? (int)$results['user_to'] : (int)$results['user_from'];
            }))
            ->unique()
            ->filter(static function ($userId) {
                return !empty($userId);
            });

        $users = get_users([
            'include' => $userIds->values(),
        ]);

        return $userIds->filter(static function ($userId) use ($users) {
            return tdf_collect($users)->find(static function ($user) use ($userId) {
                    return (int)$user->ID === $userId;
                }) !== false;
        });
    }

    /**
     * @param int $userFrom
     * @param int $userTo
     * @noinspection PhpMissingParamTypeInspection
     */
    public static function setSeen($userFrom, $userTo): void
    {
        global $wpdb;

        $tableName = DirectMessagesServiceProvider::getTableName();

        $wpdb->update($tableName, ['seen' => 1], ['user_from' => $userFrom, 'user_to' => $userTo]);

        self::setNotified($userFrom, $userTo);
    }

    /**
     * @param int $userFrom
     * @param int $userTo
     * @noinspection PhpMissingParamTypeInspection
     */
    public static function setNotified($userFrom, $userTo): void
    {
        global $wpdb;

        $tableName = DirectMessagesServiceProvider::getTableName();

        $wpdb->update($tableName, ['notified' => 1], ['user_from' => $userFrom, 'user_to' => $userTo]);
    }

}