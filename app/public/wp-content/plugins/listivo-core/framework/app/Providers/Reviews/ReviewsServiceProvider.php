<?php

namespace Tangibledesign\Framework\Providers\Reviews;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Notification\Trigger;
use Tangibledesign\Framework\Models\Post\PostStatus;

class ReviewsServiceProvider extends ServiceProvider
{
    public function initiation(): void
    {
        $this->configureSwiper();

        $this->configurePostType();
    }

    public function afterInitiation(): void
    {
        $this->filterBlockEditorForPostType();

        $this->handlePostStatusTransition();

        $this->filterReviewPostType();
    }

    private function filterReviewPostType(): void
    {
        add_filter('tdf/posttypes', function ($postTypesData) {
            if (tdf_settings()->reviewsEnabled()) {
                return $postTypesData;
            }

            return array_filter($postTypesData, static function ($postType) {
                return $postType['key'] !== tdf_prefix() . '_review';
            });
        }, 10, 999);
    }

    private function configurePostType(): void
    {
        $this->container['review_post_type'] = static function () {
            return apply_filters(tdf_prefix() . '/reviews/postType', tdf_prefix() . '_review');
        };
    }

    private function configureSwiper(): void
    {
        $this->container['reviews_modal_swiper_config'] = static function () {
            return [
                'url' => tdf_action_url(tdf_prefix() . '/images/upload'),
                'containerModifierClass' => tdf_prefix() . '-swiper-container-',
                'slideClass' => tdf_prefix() . '-swiper-slide',
                'slideActiveClass' => tdf_prefix() . '-swiper-slide-active',
                'slideDuplicateActiveClass' => tdf_prefix() . '-swiper-slide-duplicate-active',
                'slideVisibleClass' => tdf_prefix() . '-swiper-slide-visible',
                'slideDuplicateClass' => tdf_prefix() . '-swiper-slide-duplicate',
                'slideNextClass' => tdf_prefix() . '-swiper-slide-next',
                'slideDuplicateNextClass' => tdf_prefix() . '-swiper-slide-duplicate-next',
                'slidePrevClass' => tdf_prefix() . '-swiper-slide-prev',
                'slideDuplicatePrevClass' => tdf_prefix() . '-swiper-slide-duplicate-prev',
                'wrapperClass' => tdf_prefix() . '-swiper-wrapper',
                'loop' => false,
                'spaceBetween' => 10,
                'breakpoints' => [
                    0 => [
                        'slidesPerView' => 3,
                        'spaceBetween' => 10
                    ],
                    499 => [
                        'slidesPerView' => 4,
                    ],
                    699 => [
                        'slidesPerView' => 5,
                        'spaceBetween' => 10
                    ],
                    1024 => [
                        'slidesPerView' => 4,
                        'spaceBetween' => 10
                    ],
                    1280 => [
                        'slidesPerView' => 5,
                        'spaceBetween' => 10
                    ],
                ],
            ];
        };

        $this->container['reviews_swiper_config'] = static function () {
            return [
                'url' => tdf_action_url(tdf_prefix() . '/images/upload'),
                'containerModifierClass' => tdf_prefix() . '-swiper-container-',
                'slideClass' => tdf_prefix() . '-swiper-slide',
                'slideActiveClass' => tdf_prefix() . '-swiper-slide-active',
                'slideDuplicateActiveClass' => tdf_prefix() . '-swiper-slide-duplicate-active',
                'slideVisibleClass' => tdf_prefix() . '-swiper-slide-visible',
                'slideDuplicateClass' => tdf_prefix() . '-swiper-slide-duplicate',
                'slideNextClass' => tdf_prefix() . '-swiper-slide-next',
                'slideDuplicateNextClass' => tdf_prefix() . '-swiper-slide-duplicate-next',
                'slidePrevClass' => tdf_prefix() . '-swiper-slide-prev',
                'slideDuplicatePrevClass' => tdf_prefix() . '-swiper-slide-duplicate-prev',
                'wrapperClass' => tdf_prefix() . '-swiper-wrapper',
                'loop' => false,
                'spaceBetween' => 10,
                'breakpoints' => [
                    0 => [
                        'slidesPerView' => 2.5,
                        'spaceBetween' => 10
                    ],
                    499 => [
                        'slidesPerView' => 3.5,
                        'spaceBetween' => 10
                    ],
                    1024 => [
                        'slidesPerView' => 4,
                        'spaceBetween' => 10
                    ],
                    1280 => [
                        'slidesPerView' => 5,
                        'spaceBetween' => 10
                    ],
                ],
            ];
        };
    }

    private function filterBlockEditorForPostType(): void
    {
        add_filter('use_block_editor_for_post_type', static function ($useBlockEditor, $postType) {
            if ($postType === tdf_prefix() . '_review') {
                return false;
            }

            return $useBlockEditor;
        }, 10, 2);
    }

    private function handlePostStatusTransition(): void
    {
        add_action('transition_post_status', static function ($newStatus, $oldStatus, $post) {
            if ($post->post_type !== tdf_prefix() . '_review') {
                return;
            }

            $review = tdf_review_factory()->create($post);
            if (!$review) {
                return;
            }

            $review->getType();

            delete_transient(tdf_prefix() . '/reviews/' . $review->getType() . '/number/' . $review->getModelId());
            delete_transient(tdf_prefix() . '/reviews/' . $review->getType() . '/rating/' . $review->getModelId());

            if ($newStatus === PostStatus::PUBLISH && $oldStatus === PostStatus::PENDING) {
                do_action(tdf_prefix() . '/notifications/trigger', Trigger::REVIEW_APPROVED, [
                    'review' => $review->getId(),
                    'model' => $review->getModelId(),
                    'user' => $review->getUserId(),
                ]);
            }

            if ($oldStatus === PostStatus::PENDING && $newStatus !== PostStatus::PUBLISH) {
                do_action(tdf_prefix() . '/notifications/trigger', Trigger::REVIEW_DECLINED, [
                    'review' => $review->getId(),
                    'model' => $review->getModelId(),
                    'user' => $review->getUserId(),
                ]);
            }

            if ($newStatus === PostStatus::PENDING) {
                do_action(tdf_prefix() . '/notifications/trigger', Trigger::MODERATION_REVIEW_PENDING, [
                    'review' => $review->getId(),
                    'model' => $review->getModelId(),
                    'user' => $review->getUserId(),
                ]);
            }
        }, 10, 3);
    }
}