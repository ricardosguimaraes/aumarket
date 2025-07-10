<?php

namespace Tangibledesign\Listivo\Traits\Widgets;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Interfaces\HasReviewsInterface;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\User\User;
use Tangibledesign\Framework\Widgets\Helpers\Controls\Control;

trait ReviewsContentControlsTrait
{
    use Control;

    abstract public function getReviewType(): string;

    abstract public function getReviewSubjectId(): int;

    public function hasUserAlreadyReviewed(): bool
    {
        if (!tdf_settings()->singleReviewPerModel()) {
            return false;
        }

        $currentUser = tdf_current_user();
        if ($currentUser) {
            return $currentUser->hasAlreadyReviewed($this->getReviewSubjectId(), $this->getReviewType());
        }

        if (!tdf_settings()->reviewsAllowGuests()) {
            return false;
        }

        $reviewIds = $_COOKIE[tdf_prefix() . '_reviews'] ?? '';
        if (empty($reviewIds)) {
            return false;
        }

        $reviewIds = explode(',', $reviewIds);
        if (!is_array($reviewIds)) {
            return false;
        }

        return tdf_query_reviews()
            ->model($this->getReviewSubjectId(), $this->getReviewType())
            ->in($reviewIds)
            ->get()
            ->isNotEmpty();
    }

    public function showCreateReviewForm(): bool
    {
        $currentUser = tdf_current_user();
        if (!$currentUser) {
            return false;
        }

        $reviewSubject = $this->getReviewSubject();
        if (!$reviewSubject) {
            return false;
        }

        if ($reviewSubject instanceof User) {
            if ($reviewSubject->isModerator()) {
                return true;
            }

            return $currentUser->getId() !== $reviewSubject->getId();
        }

        if ($reviewSubject instanceof Model) {
            return $currentUser->getId() !== $reviewSubject->getUserId();
        }

        return true;
    }

    /**
     * @return HasReviewsInterface|false
     */
    abstract public function getReviewSubject();

    public function getReviews(HasReviewsInterface $hasReviews): Collection
    {
        return $hasReviews->getReviews(1, $this->getInitialReviewsNumber());
    }

    private function addReviewsLimitControl(): void
    {
        $this->add_control(
            'reviews_limit',
            [
                'label' => esc_html__('Reviews Limit', 'listivo-core'),
                'description' => esc_html__('How many reviews to load on each load more click', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => 5,
            ]
        );
    }

    public function getReviewsLimit(): int
    {
        return (int)$this->get_settings_for_display('reviews_limit');
    }

    private function addInitialReviewsNumberControl(): void
    {
        $this->add_control(
            'initial_reviews_number',
            [
                'label' => esc_html__('Initial Reviews Number', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => 5,
            ]
        );
    }

    public function getInitialReviewsNumber(): int
    {
        return (int)$this->get_settings_for_display('initial_reviews_number');
    }

    private function addInitialRatingControl(): void
    {
        $this->add_control(
            'initial_rating',
            [
                'label' => esc_html__('Initial Rating', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    0 => esc_html__('Not Rated', 'listivo-core'),
                    1 => esc_html__('1 Star', 'listivo-core'),
                    2 => esc_html__('2 Stars', 'listivo-core'),
                    3 => esc_html__('3 Stars', 'listivo-core'),
                    4 => esc_html__('4 Stars', 'listivo-core'),
                    5 => esc_html__('5 Stars', 'listivo-core'),
                ],
                'default' => 5,
            ]
        );
    }

    public function getInitialRating(): int
    {
        return (int)$this->get_settings_for_display('initial_rating');
    }

    public function getDropzoneConfig(): array
    {
        return [
            'url' => tdf_action_url(tdf_prefix() . '/images/upload'),
            'thumbnailWidth' => 200,
            'addRemoveLinks' => true,
            'dictDefaultMessage' => '',
            'parallelUploads' => 1,
            'acceptedFiles' => 'image/jpeg,image/png,image/gif,image/webp',
            'maxFiles' => tdf_settings()->getReviewsImagesNumber(),
            'maxFilesize' => tdf_settings()->getReviewsImagesSize(),
            'timeout' => 180000,
            'maxThumbnailFilesize' => tdf_settings()->getReviewsImagesSize(),
            'dictFileTooBig' => str_replace(['[currentFilesize]', '[maxFilesize]'], ['{{filesize}}', '{{maxFilesize}}'], tdf_string('dropzone_too_big')),
        ];
    }

    public function getSortByOptions(): array
    {
        $options = [
            [
                'id' => 'newest',
                'name' => tdf_string('newest'),
                'value' => 'newest',
            ],
            [
                'id' => 'oldest',
                'name' => tdf_string('oldest'),
                'value' => 'oldest',
            ],
        ];

        if (tdf_settings()->reviewsThumbsEnabled()) {
            array_splice($options, 1, 0, [
                [
                    'id' => 'most_helpful',
                    'name' => tdf_string('most_helpful'),
                    'value' => 'thumb_up',
                ],
            ]);
        }

        return $options;
    }

    public function getFilterRatingOptions(HasReviewsInterface $hasReviews): array
    {
        return [
            [
                'id' => 'all',
                'name' => tdf_string('all_ratings'),
                'value' => 'all',
            ],
            [
                'id' => '5',
                'name' => sprintf('%s %s (%d)', '5', tdf_string('stars'), $hasReviews->getReviewCountByRating(5)),
                'value' => '5',
            ],
            [
                'id' => '4',
                'name' => sprintf('%s %s (%d)', '4', tdf_string('stars'), $hasReviews->getReviewCountByRating(4)),
                'value' => '4',
            ],
            [
                'id' => '3',
                'name' => sprintf('%s %s (%d)', '3', tdf_string('stars'), $hasReviews->getReviewCountByRating(3)),
                'value' => '3',
            ],
            [
                'id' => '2',
                'name' => sprintf('%s %s (%d)', '2', tdf_string('stars'), $hasReviews->getReviewCountByRating(2)),
                'value' => '2',
            ],
            [
                'id' => '1',
                'name' => sprintf('%s %s (%d)', '1', tdf_string('star'), $hasReviews->getReviewCountByRating(1)),
                'value' => '1',
            ],
        ];
    }
}