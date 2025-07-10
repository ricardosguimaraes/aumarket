<?php

namespace Tangibledesign\Framework\Models\DirectMessage;


use JsonSerializable;
use Tangibledesign\Framework\Models\User\User;
use Tangibledesign\Framework\Providers\DirectMessagesServiceProvider;

/**
 * Class Message
 * @package Vehica\Chat
 */
class DirectMessage implements JsonSerializable
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var int
     */
    private int $userFrom;

    /**
     * @var int
     */
    private int $userTo;

    /**
     * @var string
     */
    private string $message;

    /**
     * @var int
     */
    private int $seen;

    /**
     * @var int
     */
    private int $notified;

    /**
     * @var string
     */
    private string $createdAt;

    /**
     * @var bool
     */
    private bool $showDate;

    /**
     * Message constructor.
     * @param  int  $id
     * @param  int  $userFrom
     * @param  int  $userTo
     * @param  string  $message
     * @param  int  $seen
     * @param  int  $notified
     * @param  string  $createdAt
     * @noinspection PhpMissingParamTypeInspection
     */
    public function __construct($id, $userFrom, $userTo, $message, $seen, $notified, $createdAt)
    {
        $this->id = (int) $id;
        $this->userFrom = (int) $userFrom;
        $this->userTo = (int) $userTo;
        $this->message = $message;
        $this->seen = $seen;
        $this->notified = $notified;
        $this->createdAt = $createdAt;
    }

    /**
     * @param  bool  $show
     */
    public function setShowDate(bool $show): void
    {
        $this->showDate = $show;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function seen(): bool
    {
        return !empty($this->seen);
    }

    /**
     * @return bool
     */
    public function notified(): bool
    {
        return !empty($this->notified);
    }

    /**
     * @return int
     */
    public function getUserFromId(): int
    {
        return $this->userFrom;
    }

    /**
     * @return User|null
     */
    public function getUserFrom(): ?User
    {
        return tdf_user_factory()->create($this->userFrom);
    }

    /**
     * @return int
     */
    public function getUserToId(): int
    {
        return $this->userTo;
    }



    /**
     * @return User|null
     */
    public function getUserTo(): ?User
    {
        return tdf_user_factory()->create($this->userTo);
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return stripslashes_deep($this->message);
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @param  array  $data
     * @return DirectMessage
     */
    public static function make(array $data): DirectMessage
    {
        return new self(
            $data['id'],
            $data['user_from'],
            $data['user_to'],
            $data['message'],
            $data['seen'],
            $data['notified'],
            $data['created_at']
        );
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'userFromId' => $this->getUserFromId(),
            'userToId' => $this->getUserToId(),
            'message' => $this->getMessage(),
            'seen' => $this->seen(),
            'createdAt' => $this->getCreatedAt(),
            'formattedDate' => $this->getFormattedDate(),
            'fullDate' => $this->getFullDate(),
            'intro' => $this->getIntro(),
            'showDate' => $this->showDate,
            'timeSinceLastMessage' => tdf_get_hum_date_diff($this->getCreatedAt()),
        ];
    }

    /**
     * @return string
     */
    private function getIntro(): string
    {
        return strip_tags($this->getMessage());
    }

    /**
     * @return string
     */
    public function getFormattedDate(): string
    {
        $timestamp = strtotime($this->getCreatedAt());

        if (date('Y-m-d') === date('Y-m-d', $timestamp)) {
            return date_i18n(get_option('time_format'), $timestamp);
        }

        return date_i18n(get_option('date_format'), $timestamp)
            .' - '.date_i18n(get_option('time_format'), $timestamp);
    }

    /**
     * @return string
     */
    public function getFullDate(): string
    {
        $timestamp = strtotime($this->getCreatedAt());

        return date_i18n(get_option('date_format'), $timestamp)
            .' '.date_i18n(get_option('time_format'), $timestamp);
    }

    /**
     * @param  int  $id
     * @return DirectMessage|null
     * @noinspection SqlNoDataSourceInspection
     */
    public static function getById(int $id): ?DirectMessage
    {
        $tableName = DirectMessagesServiceProvider::getTableName();

        global $wpdb;
        $results = $wpdb->get_results("
            SELECT * FROM $tableName 
                WHERE `id` = ".$id." 
            ",
            ARRAY_A
        );

        if (empty($results)) {
            return null;
        }

        return self::make($results[0]);
    }

}