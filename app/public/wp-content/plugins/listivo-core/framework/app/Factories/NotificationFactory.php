<?php

namespace Tangibledesign\Framework\Factories;

use Tangibledesign\Framework\Factories\Helpers\GetPostObject;
use Tangibledesign\Framework\Models\Notification\ModelApprovedNotification;
use Tangibledesign\Framework\Models\Notification\ModelBumpedNotification;
use Tangibledesign\Framework\Models\Notification\ModelDeclinedNotification;
use Tangibledesign\Framework\Models\Notification\ModelExpiredNotification;
use Tangibledesign\Framework\Models\Notification\ModelExpireNotification;
use Tangibledesign\Framework\Models\Notification\ModelFeaturedExpiredNotification;
use Tangibledesign\Framework\Models\Notification\ModerationModelPendingNotification;
use Tangibledesign\Framework\Models\Notification\ModerationReviewPendingNotification;
use Tangibledesign\Framework\Models\Notification\Notification;
use Tangibledesign\Framework\Models\Notification\ReviewApprovedNotification;
use Tangibledesign\Framework\Models\Notification\ReviewDeclinedNotification;
use Tangibledesign\Framework\Models\Notification\Trigger;
use Tangibledesign\Framework\Models\Notification\UserModelPendingNotification;
use Tangibledesign\Framework\Models\Notification\UserNewMessageNotification;
use Tangibledesign\Framework\Models\Notification\UserRegisteredNotification;
use Tangibledesign\Framework\Models\Notification\UserSubscriptionCancelledNotification;
use Tangibledesign\Framework\Models\Notification\UserSubscriptionExpiredNotification;
use Tangibledesign\Framework\Models\Notification\UserSubscriptionPaymentFailedNotification;
use Tangibledesign\Framework\Models\Notification\UserSubscriptionRenewedNotification;
use Tangibledesign\Framework\Models\Notification\UserSubscriptionStartedNotification;
use Tangibledesign\Framework\Models\Notification\UserWelcomeNotification;
use WP_Post;

class NotificationFactory implements BasePostFactory
{
    use GetPostObject;

    /**
     * @param WP_Post|int|null $post
     * @return Notification|null
     */
    public function create($post): ?Notification
    {
        $object = $this->getPostObject($post);
        if (!$object) {
            return null;
        }

        $trigger = $this->getTrigger($object);
        if (empty($trigger)) {
            return null;
        }

        if ($trigger === Trigger::USER_REGISTERED) {
            return new UserRegisteredNotification($object);
        }

        if ($trigger === Trigger::USER_WELCOME) {
            return new UserWelcomeNotification($object);
        }

        if ($trigger === Trigger::USER_MODEL_PENDING) {
            return new UserModelPendingNotification($object);
        }

        if ($trigger === Trigger::MODERATION_MODEL_PENDING) {
            return new ModerationModelPendingNotification($object);
        }

        if ($trigger === Trigger::MODEL_APPROVED) {
            return new ModelApprovedNotification($object);
        }

        if ($trigger === Trigger::MODEL_DECLINED) {
            return new ModelDeclinedNotification($object);
        }

        if ($trigger === Trigger::MODEL_EXPIRE) {
            return new ModelExpireNotification($object);
        }

        if ($trigger === Trigger::MODEL_EXPIRED) {
            return new ModelExpiredNotification($object);
        }

        if ($trigger === Trigger::MODEL_FEATURED_EXPIRED) {
            return new ModelFeaturedExpiredNotification($object);
        }

        if ($trigger === Trigger::MODEL_BUMPED) {
            return new ModelBumpedNotification($object);
        }

        if ($trigger === Trigger::USER_NEW_MESSAGE) {
            return new UserNewMessageNotification($object);
        }

        if ($trigger === Trigger::USER_SUBSCRIPTION_STARTED) {
            return new UserSubscriptionStartedNotification($object);
        }

        if ($trigger === Trigger::USER_SUBSCRIPTION_CANCELLED) {
            return new UserSubscriptionCancelledNotification($object);
        }

        if ($trigger = Trigger::USER_SUBSCRIPTION_PAYMENT_FAILED) {
            return new UserSubscriptionPaymentFailedNotification($object);
        }

        if ($trigger === Trigger::USER_SUBSCRIPTION_RENEWED) {
            return new UserSubscriptionRenewedNotification($object);
        }

        if ($trigger === Trigger::USER_SUBSCRIPTION_EXPIRED) {
            return new UserSubscriptionExpiredNotification($object);
        }

        if ($trigger === Trigger::MODERATION_REVIEW_PENDING) {
            return new ModerationReviewPendingNotification($object);
        }

        if ($trigger === Trigger::REVIEW_APPROVED) {
            return new ReviewApprovedNotification($object);
        }

        if ($trigger === Trigger::REVIEW_DECLINED) {
            return new ReviewDeclinedNotification($object);
        }

        return null;
    }

    private function getTrigger(WP_Post $object): string
    {
        return (string)get_post_meta($object->ID, Notification::TRIGGER, true);
    }
}