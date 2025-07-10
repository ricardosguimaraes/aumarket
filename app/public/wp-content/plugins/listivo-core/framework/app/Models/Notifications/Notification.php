<?php

namespace Tangibledesign\Framework\Models\Notification;

use Tangibledesign\Framework\Actions\Notifications\CreateNotificationTaskAction;
use Tangibledesign\Framework\Actions\Notifications\GetTagValueAction;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Notification\Tasks\NotificationTask;
use Tangibledesign\Framework\Models\Post\PostModel;
use Tangibledesign\Framework\Models\User\User;

abstract class Notification extends PostModel
{
    public const NAME = 'name';
    public const TYPES = 'types';
    public const TRIGGER = 'trigger';
    public const MAIL_TITLE = 'mail_title';
    public const MAIL_TEXT = 'mail_text';
    public const SMS_TEXT = 'sms_text';
    public const SEND_TO_GROUPS = 'send_to_groups';

    abstract public function getAllowedTags(): array;

    abstract public function getHint(): string;

    public function parseTags(string $text, NotificationTask $notificationTask): string
    {
        return str_replace(
            $this->getAllowedTagsWithBracers(),
            $this->getTagValues($this->getAllowedTagsWithBracers(), $notificationTask),
            $text
        );
    }

    protected function getTagValues(array $tags, NotificationTask $notificationTask): array
    {
        $values = [];

        foreach ($tags as $tag) {
            $values[] = $this->getTagValue($tag, $notificationTask);
        }

        return $values;
    }

    private function getTagValue(string $tag, NotificationTask $notificationTask): string
    {
        return (new GetTagValueAction())->execute(
            $tag,
            $notificationTask->getAdditional(),
            $notificationTask->getModel(),
            $notificationTask->getUser(),
            $notificationTask->getMessage(),
            $notificationTask->getReview()
        );
    }

    public function createTasks(array $args): void
    {
        if ($this->sendToUser()) {
            $this->createTask($args['user'], $args);
        }

        if ($this->sendToGroup()) {
            $this->createGroupTasks($args);
        }
    }

    private function createGroupTasks(array $args): void
    {
        foreach ($this->getGroupUsers() as $groupUser) {
            $this->createTask($groupUser->getId(), $args);
        }
    }

    private function createTask(int $userToId, array $args): void
    {
        if ($this->isMailTypeEnabled()) {
            (new CreateNotificationTaskAction())
                ->execute(NotificationType::MAIL, $userToId, $this->getId(), $this->getTaskMeta($args));
        }

        if ($this->isTwilioSmsEnabled()) {
            (new CreateNotificationTaskAction())
                ->execute(NotificationType::TWILIO_SMS, $userToId, $this->getId(), $this->getTaskMeta($args));
        }
    }

    protected function getTaskMeta(array $args): array
    {
        return [
            NotificationTask::MESSAGE => $args[NotificationTask::MESSAGE] ?? 0,
            NotificationTask::MODEL => $args[NotificationTask::MODEL] ?? 0,
            NotificationTask::USER => $args[NotificationTask::USER] ?? 0,
            NotificationTask::ADDITIONAL => $args[NotificationTask::ADDITIONAL] ?? [],
        ];
    }

    public function sendToUser(): bool
    {
        return in_array($this->getTrigger(), [
            Trigger::USER_WELCOME,
            Trigger::USER_NEW_MESSAGE,
            Trigger::USER_MODEL_PENDING,
            Trigger::MODEL_EXPIRE,
            Trigger::MODEL_EXPIRED,
            Trigger::MODEL_BUMPED,
            Trigger::MODEL_APPROVED,
            Trigger::MODEL_DECLINED,
            Trigger::MODEL_FEATURED_EXPIRED,
            Trigger::USER_SUBSCRIPTION_STARTED,
            Trigger::USER_SUBSCRIPTION_EXPIRED,
            Trigger::USER_SUBSCRIPTION_RENEWED,
            Trigger::USER_SUBSCRIPTION_PAYMENT_FAILED,
            Trigger::USER_SUBSCRIPTION_CANCELLED,
            Trigger::REVIEW_APPROVED,
            Trigger::REVIEW_DECLINED,
        ], true);
    }

    public function sendToGroup(): bool
    {
        return in_array($this->getTrigger(), [
            Trigger::MODERATION_MODEL_PENDING,
            Trigger::MODERATION_REVIEW_PENDING,
            Trigger::USER_REGISTERED,
        ], true);
    }

    public function setSmsText(string $smsText): void
    {
        $this->setMeta(self::SMS_TEXT, $smsText);
    }

    public function getSmsText(): string
    {
        return (string)$this->getMeta(self::SMS_TEXT);
    }

    public function setMailText(string $mailText): void
    {
        $this->setMeta(self::MAIL_TEXT, $mailText);
    }

    public function getMailText(): string
    {
        return (string)$this->getMeta(self::MAIL_TEXT);
    }

    public function setMailTitle(string $mailTitle): void
    {
        $this->setMeta(self::MAIL_TITLE, $mailTitle);
    }

    public function getMailTitle(): string
    {
        return (string)$this->getMeta(self::MAIL_TITLE);
    }

    public function getTrigger(): string
    {
        return (string)$this->getMeta(self::TRIGGER);
    }

    public function getFormattedTrigger(): string
    {
        $list = Trigger::getListWithNames();

        return $list[$this->getTrigger()] ?? '';
    }

    public function setTypes(array $types): void
    {
        $this->setMeta(self::TYPES, $types);
    }

    public function getTypes(): array
    {
        $types = $this->getMeta(self::TYPES);
        if (empty($types) || !is_array($types)) {
            return [NotificationType::MAIL];
        }

        return $types;
    }

    public function isMailTypeEnabled(): bool
    {
        return in_array(NotificationType::MAIL, $this->getTypes(), true);
    }

    public function isTwilioSmsEnabled(): bool
    {
        return in_array(NotificationType::TWILIO_SMS, $this->getTypes(), true);
    }

    public function getFormattedTypes(): array
    {
        $listWithNames = NotificationType::getListWithNames();
        $formattedTypes = [];

        foreach ($this->getTypes() as $type) {
            $formattedTypes[] = $listWithNames[$type] ?? '';
        }

        return $formattedTypes;
    }

    public function getEditUrl(): string
    {
        return admin_url('admin.php?page=' . tdf_prefix() . '-edit-notification&notificationId=' . $this->getId());
    }

    public function setSendToGroups(array $groups): void
    {
        $this->setMeta(self::SEND_TO_GROUPS, $groups);
    }

    public function getSendToGroups(): array
    {
        $groups = $this->getMeta(self::SEND_TO_GROUPS);
        if (!is_array($groups)) {
            return [];
        }

        return $groups;
    }

    /**
     * @return Collection|User[]
     */
    public function getGroupUsers(): Collection
    {
        $ids = [];

        if (in_array(SendToGroups::MODERATORS, $this->getSendToGroups(), true)) {
            $ids = array_merge($ids, tdf_settings()->getModeratorIds());
        }

        if (in_array(SendToGroups::ADMINS, $this->getSendToGroups(), true)) {
            $ids = array_merge($ids, tdf_app('admin_ids'));
        }

        $ids = array_unique($ids);

        if (empty($ids)) {
            return tdf_collect();
        }

        return tdf_query_users()->in($ids)->get();
    }

    public function getAllowedTagsWithBracers(): array
    {
        return tdf_collect($this->getAllowedTags())
            ->map(static function ($tag) {
                return '{' . $tag . '}';
            })
            ->values();
    }

    public function getAllowedTagsFormatted(): string
    {
        return tdf_collect($this->getAllowedTagsWithBracers())->implode();
    }
}