<?php

namespace Tangibledesign\Framework\Factories;

use Tangibledesign\Framework\Factories\Helpers\GetPostObject;
use Tangibledesign\Framework\Models\Notification\NotificationType;
use Tangibledesign\Framework\Models\Notification\Tasks\MailNotificationTask;
use Tangibledesign\Framework\Models\Notification\Tasks\NotificationTask;
use Tangibledesign\Framework\Models\Notification\Tasks\TwilioSmsNotificationTask;
use WP_Post;

class NotificationTaskFactory implements BasePostFactory
{
    use GetPostObject;

    /**
     * @param  WP_Post|int|null  $post
     * @return NotificationTask|false
     */
    public function create($post)
    {
        $object = $this->getPostObject($post);
        if (!$object) {
            return false;
        }

        $type = $this->getType($object);

        if ($type === NotificationType::MAIL) {
            return new MailNotificationTask($object);
        }

        if ($type === NotificationType::TWILIO_SMS) {
            return new TwilioSmsNotificationTask($object);
        }

        return false;
    }

    /**
     * @param  WP_Post  $post
     * @return string
     */
    private function getType(WP_Post $post): string
    {
        return (string)get_post_meta($post->ID, NotificationTask::TYPE, true);
    }

}