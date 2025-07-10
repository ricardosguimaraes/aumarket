<?php

namespace Tangibledesign\Listivo\Widgets\Listing;

use Tangibledesign\Framework\Interfaces\HasReviewsInterface;
use Tangibledesign\Framework\Widgets\Helpers\BaseModelSingleWidget;
use Tangibledesign\Listivo\Traits\Widgets\ReviewsContentControlsTrait;
use Tangibledesign\Listivo\Traits\Widgets\ReviewsStyleControlsTrait;

class ListingReviewsWidget extends BaseModelSingleWidget
{
    use ReviewsStyleControlsTrait;
    use ReviewsContentControlsTrait;

    public function getKey(): string
    {
        return 'listing_reviews';
    }

    public function getName(): string
    {
        return esc_html__('Ad Reviews', 'listivo-core');
    }

    protected function loadTemplate(): void
    {
        get_template_part('templates/widgets/shared/reviews/reviews');
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
        return tdf_model_post_type();
    }

    public function getReviewSubjectId(): int
    {
        $model = $this->getModel();
        if (!$model) {
            return 0;
        }

        return $model->getId();
    }

    /**
     * @return HasReviewsInterface|false
     */
    public function getReviewSubject()
    {
        return $this->getModel();
    }
}