<?php

namespace Tangibledesign\Framework\Models\Notification;

class Trigger
{
    public const USER_WELCOME = 'user_welcome';
    public const USER_REGISTERED = 'new_registered';
    public const USER_NEW_MESSAGE = 'user_new_message';
    public const USER_MODEL_PENDING = 'user_model_pending';
    public const MODERATION_MODEL_PENDING = 'moderation_model_pending';
    public const MODEL_APPROVED = 'model_approved';
    public const MODEL_DECLINED = 'model_declined';
    public const MODEL_EXPIRE = 'model_expire';
    public const MODEL_EXPIRED = 'model_expired';
    public const MODEL_FEATURED_EXPIRED = 'model_featured_expired';
    public const MODEL_BUMPED = 'model_bumped';
    public const USER_SUBSCRIPTION_STARTED = 'user_subscription_started';
    public const USER_SUBSCRIPTION_RENEWED = 'user_subscription_renewed';
    public const USER_SUBSCRIPTION_CANCELLED = 'user_subscription_cancelled';
    public const USER_SUBSCRIPTION_PAYMENT_FAILED = 'user_subscription_payment_failed';
    public const USER_SUBSCRIPTION_EXPIRED = 'user_subscription_expired';
    public const MODERATION_REVIEW_PENDING = 'moderation_review_pending';
    public const REVIEW_APPROVED = 'review_approved';
    public const REVIEW_DECLINED = 'review_declined';

    public static function getListWithNames(): array
    {
        return [
            self::USER_WELCOME => tdf_admin_string('user_welcome'),
            self::USER_REGISTERED => tdf_admin_string('user_registered'),
            self::USER_NEW_MESSAGE => tdf_admin_string('user_new_message'),
            self::USER_MODEL_PENDING => tdf_admin_string('user_model_pending'),
            self::MODERATION_MODEL_PENDING => tdf_admin_string('moderation_model_pending'),
            self::MODEL_EXPIRE => tdf_admin_string('model_expire'),
            self::MODEL_EXPIRED => tdf_admin_string('model_expired'),
            self::MODEL_APPROVED => tdf_admin_string('model_approved'),
            self::MODEL_DECLINED => tdf_admin_string('model_declined'),
            self::MODEL_FEATURED_EXPIRED => tdf_admin_string('model_featured_expired'),
            self::MODEL_BUMPED => tdf_admin_string('model_bumped'),
            self::USER_SUBSCRIPTION_STARTED => tdf_admin_string('user_subscription_started'),
            self::USER_SUBSCRIPTION_RENEWED => tdf_admin_string('user_subscription_renewed'),
            self::USER_SUBSCRIPTION_CANCELLED => tdf_admin_string('user_subscription_cancelled'),
            self::USER_SUBSCRIPTION_PAYMENT_FAILED => tdf_admin_string('user_subscription_payment_failed'),
            self::USER_SUBSCRIPTION_EXPIRED => tdf_admin_string('user_subscription_expired'),
            self::MODERATION_REVIEW_PENDING => tdf_admin_string('moderation_review_pending'),
            self::REVIEW_APPROVED => tdf_admin_string('moderation_review_approved'),
            self::REVIEW_DECLINED => tdf_admin_string('moderation_review_declined'),
        ];
    }
}