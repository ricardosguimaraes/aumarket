<?php

namespace Tangibledesign\Listivo\Widgets\User;

use Tangibledesign\Framework\Interfaces\HasReviewsInterface;
use Tangibledesign\Framework\Widgets\Helpers\BaseUserWidget;
use Tangibledesign\Framework\Widgets\Helpers\ModelSingleWidget;
use Tangibledesign\Listivo\Traits\Widgets\RatingContentControlsTrait;
use Tangibledesign\Listivo\Traits\Widgets\RatingStyleControlsTrait;

class RatingUserWidget extends BaseUserWidget implements ModelSingleWidget
{
    use RatingContentControlsTrait;
    use RatingStyleControlsTrait;

    public function getKey(): string
    {
        return 'user_rating';
    }

    public function getName(): string
    {
        return esc_html__('User Rating', 'listivo-core');
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
        return $this->getUser();
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