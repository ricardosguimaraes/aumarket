<?php

namespace Tangibledesign\Framework\Models\Notification;

class ModelExpireNotification extends Notification
{
    public const HOURS = 'hours';

    /**
     * @param  int  $hours
     * @return void
     */
    public function setHours(int $hours): void
    {
        $this->setMeta(self::HOURS, $hours);
    }

    /**
     * @return int
     */
    public function getHours(): int
    {
        return (int) $this->getMeta(self::HOURS);
    }

    /**
     * @return array
     */
    public function getAllowedTags(): array
    {
        return [
            'userDisplayName',
            'userFirstName',
            'userLastName',
            'userUrl',
            'userMail',
            'userPhone',
            'userCompanyInformation',
            'adName',
            'adUrl',
        ];
    }

    /**
     * @return string
     */
    public function getHint(): string
    {
        return tdf_admin_string('model_expire_notification_hint');
    }

}