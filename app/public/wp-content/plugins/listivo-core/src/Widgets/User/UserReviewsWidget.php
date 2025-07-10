<?php

namespace Tangibledesign\Listivo\Widgets\User;

use Tangibledesign\Framework\Interfaces\HasReviewsInterface;
use Tangibledesign\Framework\Models\Review;
use Tangibledesign\Framework\Widgets\Helpers\BaseUserWidget;
use Tangibledesign\Listivo\Traits\Widgets\ReviewsContentControlsTrait;
use Tangibledesign\Listivo\Traits\Widgets\ReviewsStyleControlsTrait;

class UserReviewsWidget extends BaseUserWidget
{
    use ReviewsContentControlsTrait;
    use ReviewsStyleControlsTrait;

    public function getKey(): string
    {
        return 'user_reviews';
    }

    public function getName(): string
    {
        return esc_html__('User Reviews', 'listivo-core');
    }

    protected function loadTemplate(): void
    {
        get_template_part('templates/widgets/shared/reviews/reviews');
    }

    public function get_style_depends(): array
    {
        return ['photo-swipe'];
    }

    protected function register_controls(): void
    {
        $this->addContentSection();

        $this->addReviewsBaseListStyleSection();

        $this->addReviewStyleSection();

        $this->addReviewFormStyleSection();

        $this->addReviewsModalStyleSection();

        $this->addUserAvatarPlaceholderStyleSection();

        $this->addVisibilitySection();
    }

    private function addContentSection(): void
    {
        $this->startContentControlsSection();

        $this->addInitialReviewsNumberControl();

        $this->addReviewsLimitControl();

        $this->addInitialRatingControl();

        $this->endControlsSection();
    }

    public function getReviewType(): string
    {
        return Review::TYPE_USER;
    }

    public function getReviewSubjectId(): int
    {
        $user = $this->getUser();
        if (!$user) {
            return 0;
        }

        return $user->getId();
    }

    /**
     * @return HasReviewsInterface|false
     */
    public function getReviewSubject()
    {
        return $this->getUser();
    }
}