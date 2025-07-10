<?php


namespace Tangibledesign\Framework\Models\User\Helpers;


/**
 * Class UserSettingKey
 * @package Tangibledesign\Framework\Models\User\Helpers
 */
class UserSettingKey
{
    /* Reset Password */
    public const RESET_PASSWORD_TOKEN = 'reset_password_token';
    public const RESET_PASSWORD_EXPIRES = 'reset_password_expires';
    public const RESET_PASSWORD_SELECTOR = 'reset_password_selector';
    /* Confirmation */
    public const CONFIRMATION_TOKEN = 'confirmation_token';
    public const CONFIRMATION_SELECTOR = 'confirmation_selector';
    public const CONFIRMATION_EXPIRES = 'confirmation_expires';
    public const CONFIRMED = 'confirmed';
    /* General */
    public const IMAGE = 'image';
    public const SOCIAL_IMAGE = 'social_image';
    public const ADDRESS = 'address';
    public const JOB_TITLE = 'job_title';
    public const PHONE = 'phone';
    public const PHONE_COUNTRY_CODE = 'phone_country_code';
    public const WHATS_APP = 'whats_app';
    public const VIBER = 'viber';
    /* SocialProfiles */
    public const YOU_TUBE_PROFILE = 'you_tube_profile';
    public const FACEBOOK_PROFILE = 'facebook_profile';
    public const LINKED_IN_PROFILE = 'linked_in_profile';
    public const TWITTER_PROFILE = 'twitter_profile';
    public const INSTAGRAM_PROFILE = 'instagram_profile';
    public const TIKTOK_PROFILE = 'tiktok_profile';
    public const TELEGRAM_PROFILE = 'telegram_profile';
    public const EBAY_PROFILE = 'ebay_profile';
    /* Change Email */
    public const CHANGE_EMAIL_TOKEN = 'change_email_token';
    public const CHANGE_EMAIL_EXPIRE = 'change_email_expire';
    public const CHANGE_EMAIL_TEMP = 'change_email_temp';
    /* AUTH */
    public const SOCIAL_SOURCE = 'social_source';

    public const MODEL_IN_PROGRESS = 'model_in_progress';
    public const PACKAGES = 'packages';

    public const REDIRECT_URL = 'redirect_url';
    public const LAST_ACTIVITY = 'last_activity';

    public const ACCOUNT_TYPE = 'account_type';
    public const ACCOUNT_TYPE_BUSINESS = 'business';
    public const ACCOUNT_TYPE_PRIVATE = 'regular';
    public const COMPANY_INFORMATION = 'company_information';
    public const VERIFIED = 'verified';

    public const STRIPE_CUSTOMER_ID = 'stripe_customer_id';
    public const USER_SUBSCRIPTION = 'user_subscription';

    public const MARKETING_CONSENT = 'marketing_consent';

    public const COVER_IMAGE = 'cover_image';
}