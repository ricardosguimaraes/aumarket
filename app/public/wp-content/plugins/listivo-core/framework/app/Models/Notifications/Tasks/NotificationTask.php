<?php

namespace Tangibledesign\Framework\Models\Notification\Tasks;

use Tangibledesign\Framework\Models\DirectMessage\DirectMessage;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\Notification\Notification;
use Tangibledesign\Framework\Models\Notification\NotificationType;
use Tangibledesign\Framework\Models\Post\PostModel;
use Tangibledesign\Framework\Models\Review;
use Tangibledesign\Framework\Models\User\User;

abstract class NotificationTask extends PostModel
{
    public const STATUS = 'task_status';
    public const STATUS_WAITING = 'waiting';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_COMPLETED = 'completed';
    public const NOTIFICATION = 'notification';
    public const TYPE = 'type';
    public const USER_TO = 'user_to';
    public const USER = 'user';
    public const MODEL = 'model';
    public const REVIEW = 'review';
    public const MESSAGE = 'message';
    public const ADDITIONAL = 'additional';

    abstract public function execute(): void;

    public function getType(): string
    {
        return (string)$this->getMeta(self::TYPE);
    }

    public function getNotificationId(): int
    {
        return (int)$this->getMeta(self::NOTIFICATION);
    }

    public function getNotification(): ?Notification
    {
        $notificationId = $this->getNotificationId();
        if (empty($notificationId)) {
            return null;
        }

        return tdf_notification_factory()->create($notificationId);
    }

    public function setStatus($status): void
    {
        $this->setMeta(self::STATUS, $status);
    }

    public function getStatus(): string
    {
        $status = $this->getMeta(self::STATUS);
        if (empty($status)) {
            return self::STATUS_WAITING;
        }

        return $status;
    }

    public function getStatusFormatted(): string
    {
        $status = $this->getStatus();
        if ($status === self::STATUS_WAITING) {
            return tdf_admin_string('waiting');
        }

        if ($status === self::STATUS_IN_PROGRESS) {
            return tdf_admin_string('in_progress');
        }

        if ($status === self::STATUS_COMPLETED) {
            return tdf_admin_string('completed');
        }

        return tdf_admin_string('waiting');
    }

    public function getTypeFormatted(): string
    {
        return NotificationType::getDisplayName($this->getType());
    }

    public function isCompleted(): bool
    {
        return $this->getStatus() === self::STATUS_COMPLETED;
    }

    public function isInProgress(): bool
    {
        return $this->getStatus() === self::STATUS_IN_PROGRESS;
    }

    public function isWaiting(): bool
    {
        return $this->getStatus() === self::STATUS_WAITING;
    }

    public function getUser(): ?User
    {
        $userId = (int)$this->getMeta(self::USER);
        if (empty($userId)) {
            return null;
        }

        $user = tdf_user_factory()->create($userId);
        if (!$user) {
            return null;
        }

        return $user;
    }

    public function setUserTo(int $userId): void
    {
        $this->setMeta(self::USER_TO, $userId);
    }

    public function getUserTo(): ?User
    {
        $userId = (int)$this->getMeta(self::USER_TO);
        if (empty($userId)) {
            return null;
        }

        return tdf_user_factory()->create($userId);
    }

    public function getModel(): ?Model
    {
        $modelId = (int)$this->getMeta(self::MODEL);
        if (empty($modelId)) {
            return null;
        }

        $model = tdf_post_factory()->create($modelId);
        if (!$model instanceof Model) {
            return null;
        }

        return $model;
    }

    public function getReview(): ?Review
    {
        $reviewId = (int)$this->getMeta(self::REVIEW);
        if (empty($reviewId)) {
            return null;
        }

        $review = tdf_review_factory()->create($reviewId);
        if (!$review) {
            return null;
        }

        return $review;
    }

    public function getMessage(): ?DirectMessage
    {
        $messageId = (int)$this->getMeta(self::MESSAGE);
        if (empty($messageId)) {
            return null;
        }

        return DirectMessage::getById($messageId);
    }

    public function getAdditional(): array
    {
        $additional = $this->getMeta(self::ADDITIONAL);
        if (!is_array($additional)) {
            return [];
        }

        return $additional;
    }
}