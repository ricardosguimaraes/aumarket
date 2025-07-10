<?php

namespace Tangibledesign\Listivo\Widgets\Listing;

use Tangibledesign\Framework\Interfaces\HasReviewsInterface;
use Tangibledesign\Framework\Widgets\Helpers\BaseModelSingleWidget;
use Tangibledesign\Listivo\Traits\Widgets\RatingContentControlsTrait;
use Tangibledesign\Listivo\Traits\Widgets\RatingStyleControlsTrait;

class ListingRatingWidget extends BaseModelSingleWidget
{
    use RatingContentControlsTrait;
    use RatingStyleControlsTrait;

    public function getKey(): string
    {
        return 'listing_rating';
    }

    public function getName(): string
    {
        return esc_html__('Ad Rating', 'listivo-core');
    }

    protected function loadTemplate(): void
    {
        get_template_part('templates/widgets/shared/rating');
    }

    /**
     * @return HasReviewsInterface|false
     */
    public function getReviewSubject()
    {
        return $this->getModel();
    }

    protected function register_controls(): void
    {
        $this->addRatingContentSection();

        $this->addRatingStyleSection();

        $this->addStarsStyleSection();

        $this->addRatingCountStyleSection();

        $this->addVisibilitySection();
    }
}