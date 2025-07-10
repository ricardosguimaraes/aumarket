<?php

namespace Tangibledesign\Listivo\Traits\Widgets;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Interfaces\HasReviewsInterface;
use Tangibledesign\Framework\Widgets\Helpers\Controls\Control;

trait RatingContentControlsTrait
{
    use Control;

    /**
     * @return HasReviewsInterface|false
     */
    abstract public function getReviewSubject();

    protected function addRatingContentSection(): void
    {
        $this->startContentControlsSection('rating_content', esc_html__('Rating', 'listivo-core'));

        $this->addShowStarsControl();

        $this->addShowRatingControl();

        $this->addShowRatingCountControl();

        $this->endControlsSection();
    }

    protected function addShowStarsControl(): void
    {
        $this->add_control(
            'show_stars',
            [
                'label' => esc_html__('Display Stars', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '1',
                'return_value' => '1',
            ]
        );
    }

    protected function addShowRatingControl(): void
    {
        $this->add_control(
            'show_rating',
            [
                'label' => esc_html__('Display Rating', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '1',
                'return_value' => '1',
            ]
        );
    }

    protected function addShowRatingCountControl(): void
    {
        $this->add_control(
            'show_rating_count',
            [
                'label' => esc_html__('Display Rating Count', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '1',
                'return_value' => '1',
            ]
        );
    }

    public function showStars(): bool
    {
        return !empty($this->get_settings_for_display('show_stars'));
    }

    public function showRating(): bool
    {
        return !empty($this->get_settings_for_display('show_rating'));
    }

    public function showRatingCount(): bool
    {
        return !empty($this->get_settings_for_display('show_rating_count'));
    }
}