<?php

namespace Tangibledesign\Framework\Models\User;

use Tangibledesign\Framework\Actions\Order\CountOrdersByStatusAction;
use Tangibledesign\Framework\Helpers\HasSettings;
use Tangibledesign\Framework\Interfaces\HasReviewsInterface;
use Tangibledesign\Framework\Models\DirectMessage\Conversation;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\Payments\UserSubscription;
use Tangibledesign\Framework\Models\Post\PostStatus;
use Tangibledesign\Framework\Models\Review;
use Tangibledesign\Framework\Models\User\Helpers\HasAccountType;
use Tangibledesign\Framework\Models\User\Helpers\HasAddress;
use Tangibledesign\Framework\Models\User\Helpers\HasAddressInterface;
use Tangibledesign\Framework\Models\User\Helpers\HasBusinessInformation;
use Tangibledesign\Framework\Models\User\Helpers\HasConversations;
use Tangibledesign\Framework\Models\User\Helpers\HasFavorite;
use Tangibledesign\Framework\Models\User\Helpers\HasImage;
use Tangibledesign\Framework\Models\User\Helpers\HasImageInterface;
use Tangibledesign\Framework\Models\User\Helpers\HasJobTitle;
use Tangibledesign\Framework\Models\User\Helpers\HasJobTitleInterface;
use Tangibledesign\Framework\Models\User\Helpers\HasMarketingConsent;
use Tangibledesign\Framework\Models\User\Helpers\HasPaymentPackages;
use Tangibledesign\Framework\Models\User\Helpers\HasPhone;
use Tangibledesign\Framework\Models\User\Helpers\HasPhoneInterface;
use Tangibledesign\Framework\Models\User\Helpers\HasSocialProfiles;
use Tangibledesign\Framework\Models\User\Helpers\HasSocialProfilesInterface;
use Tangibledesign\Framework\Models\User\Helpers\HasSocialSource;
use Tangibledesign\Framework\Models\User\Helpers\UserSettingKey;
use Tangibledesign\Framework\Traits\HasReviewsTrait;
use WP_Query;
use WP_User;

class User extends BaseUser implements HasImageInterface, HasSocialProfilesInterface, HasPhoneInterface, HasJobTitleInterface, HasAddressInterface, HasReviewsInterface
{
    use HasSettings;
    use HasImage;
    use HasSocialProfiles;
    use HasJobTitle;
    use HasAddress;
    use HasPhone;
    use HasFavorite;
    use HasConversations;
    use HasSocialSource;
    use HasPaymentPackages;
    use HasAccountType;
    use HasBusinessInformation;
    use HasMarketingConsent;
    use HasReviewsTrait;

    /**
     * @var WP_User
     */
    protected $user;

    public function getSettingKeys(): array
    {
        return array_merge([
            UserSettingKey::IMAGE,
            UserSettingKey::JOB_TITLE,
            UserSettingKey::ADDRESS,
            UserSettingKey::PHONE,
            UserSettingKey::WHATS_APP,
            UserSettingKey::VERIFIED,
            UserSettingKey::PHONE_COUNTRY_CODE,
            UserSettingKey::VIBER,
            UserSettingKey::CONFIRMED,
            UserSettingKey::ACCOUNT_TYPE,
            UserSettingKey::COMPANY_INFORMATION,
            UserSettingKey::MARKETING_CONSENT,
            UserSettingKey::STRIPE_CUSTOMER_ID,
        ], $this->getSocialProfilesSettingKeys());
    }

    public function setModelInProgress($modelId): void
    {
        $this->setMeta(UserSettingKey::MODEL_IN_PROGRESS, (int)$modelId);
    }

    public function hasModelInProgress(): bool
    {
        return $this->getModelInProgress() !== false;
    }

    /**
     * @return Model |false
     */
    public function getModelInProgress()
    {
        $modelId = (int)$this->getMeta(UserSettingKey::MODEL_IN_PROGRESS);
        if (empty($modelId)) {
            return false;
        }

        $model = tdf_post_factory()->create($modelId);
        if (!$model instanceof Model) {
            return false;
        }

        return $model;
    }

    public function removeModelInProgress(): void
    {
        $this->setMeta(UserSettingKey::MODEL_IN_PROGRESS, '0');
    }

    public function getPublishedModelNumber(): int
    {
        return (new WP_Query([
            'post_type' => tdf_model_post_type(),
            'posts_per_page' => -1,
            'fields' => 'ids',
            'post_status' => [PostStatus::PUBLISH],
            'author__in' => [$this->getId()],
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
        ]))->found_posts;
    }

    public function getCurrentUserAllModelNumber(): int
    {
        return (new WP_Query([
            'post_type' => tdf_model_post_type(),
            'posts_per_page' => -1,
            'fields' => 'ids',
            'post_status' => [PostStatus::PUBLISH, PostStatus::PENDING, PostStatus::DRAFT],
            'author__in' => [get_current_user_id()],
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
        ]))->found_posts;
    }

    public function getCurrentUserPublishModelNumber(): int
    {
        return (new WP_Query([
            'post_type' => tdf_model_post_type(),
            'posts_per_page' => -1,
            'fields' => 'ids',
            'post_status' => PostStatus::PUBLISH,
            'author__in' => [get_current_user_id()],
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
        ]))->found_posts;
    }

    public function getCurrentUserPendingModelNumber(): int
    {
        return (new WP_Query([
            'post_type' => tdf_model_post_type(),
            'posts_per_page' => -1,
            'fields' => 'ids',
            'post_status' => PostStatus::PENDING,
            'author__in' => [get_current_user_id()],
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
        ]))->found_posts;
    }

    public function getCurrentUserDraftModelNumber(): int
    {
        return (new WP_Query([
            'post_type' => tdf_model_post_type(),
            'posts_per_page' => -1,
            'fields' => 'ids',
            'post_status' => PostStatus::DRAFT,
            'author__in' => [get_current_user_id()],
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
        ]))->found_posts;
    }

    public function isModerator(): bool
    {
        return $this->isAdministrator() || in_array($this->getId(), tdf_settings()->getModeratorIds(), true);
    }

    public function canSeeOrders(): bool
    {
        return current_user_can('manage_options') || in_array($this->getId(), tdf_settings()->getModeratorIds(), true);
    }

    public function getNotSeenConversationNumber(): int
    {
        return $this->getConversations()
            ->filter(static function ($conversation) {
                /* @var Conversation $conversation */
                return !$conversation->seen();
            })
            ->count();
    }

    public function setRedirectUrl(string $url): void
    {
        $this->setMeta(UserSettingKey::REDIRECT_URL, $url);
    }

    public function getRedirectUrl(): string
    {
        return (string)$this->getMeta(UserSettingKey::REDIRECT_URL);
    }

    public function hasRedirectUrl(): bool
    {
        return !empty($this->getRedirectUrl());
    }

    public function clearRedirectUrl(): void
    {
        $this->setMeta(UserSettingKey::REDIRECT_URL, 0);
    }

    public function updateLastActivity(): void
    {
        $this->setMeta(UserSettingKey::LAST_ACTIVITY, date("Y-m-d H:i:s"));
    }

    /**
     * @return string|false
     */
    public function getLastActive()
    {
        $lastActive = (string)$this->getMeta(UserSettingKey::LAST_ACTIVITY);
        if (empty($lastActive)) {
            return false;
        }

        return $lastActive;
    }

    public function wasActiveInLastMinutes(int $minutes): bool
    {
        $lastActive = $this->getLastActive();
        if (!$lastActive) {
            return false;
        }

        return $lastActive > date('Y-m-d H:i:s', strtotime('-' . $minutes . ' minutes'));
    }

    public function getOrdersNumber(string $status = 'any'): int
    {
        return (new CountOrdersByStatusAction())->execute($status, $this->getId());
    }

    public function hasOrders(): bool
    {
        return $this->getOrdersNumber() > 0;
    }

    public function getWebsite(): string
    {
        return $this->user->user_url;
    }

    public function setWebsite(string $url): void
    {
        wp_update_user([
            'ID' => $this->getId(),
            'user_url' => $url,
        ]);
    }

    public function getBackendEditUrl(): string
    {
        return get_edit_user_link($this->getId());
    }

    public function isVerified(): bool
    {
        return !empty((int)$this->getMeta(UserSettingKey::VERIFIED));
    }

    public function setVerified($verified = 1): void
    {
        $this->setMeta(UserSettingKey::VERIFIED, (int)$verified);
    }

    public function setStripeCustomerId(string $customerId): void
    {
        $this->setMeta(UserSettingKey::STRIPE_CUSTOMER_ID, $customerId);
    }

    public function getStripeCustomerId(): string
    {
        return (string)$this->getMeta(UserSettingKey::STRIPE_CUSTOMER_ID);
    }

    public function setUserSubscription(int $id): void
    {
        $this->setMeta(UserSettingKey::USER_SUBSCRIPTION, $id);
    }

    public function getUserSubscription(): ?UserSubscription
    {
        $id = (int)$this->getMeta(UserSettingKey::USER_SUBSCRIPTION);
        if (empty($id)) {
            return null;
        }

        return tdf_user_subscription_factory()->create($id);
    }

    public function hasUserSubscription(): bool
    {
        return $this->getUserSubscription() !== null;
    }

    public function getSubscriptionName(): string
    {
        $userSubscription = $this->getUserSubscription();
        if (!$userSubscription) {
            return '';
        }

        $subscription = $userSubscription->getSubscription();
        if (!$subscription) {
            return '';
        }

        return $subscription->getName();
    }

    public function canCreateModels(): bool
    {
        if ($this->isAdministrator()) {
            return apply_filters(tdf_prefix() . '/user/canCreateModels', true, $this);
        }

        if ($this->isPrivateAccount() && tdf_settings()->isPrivateRoleModelsDisabled()) {
            return apply_filters(tdf_prefix() . '/user/canCreateModels', false, $this);
        }

        if ($this->isBusinessAccount() && tdf_settings()->isBusinessRoleModelsDisabled()) {
            return apply_filters(tdf_prefix() . '/user/canCreateModels', false, $this);
        }

        return apply_filters(tdf_prefix() . '/user/canCreateModels', true, $this);
    }

    public function getReviewType(): string
    {
        return Review::TYPE_USER;
    }

    public function hasAlreadyReviewed(int $reviewSubject, string $reviewType): bool
    {
        return tdf_query_reviews()
            ->userIn($this->getId())
            ->model($reviewSubject, $reviewType)
            ->anyStatus()
            ->get()
            ->isNotEmpty();
    }
}