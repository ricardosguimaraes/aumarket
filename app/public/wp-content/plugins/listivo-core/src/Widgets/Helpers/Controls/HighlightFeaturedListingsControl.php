<?php

namespace Tangibledesign\Listivo\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\Controls\Control;

trait HighlightFeaturedListingsControl
{
    use Control;

    protected function addHighlightFeaturedListingsControl(): void
    {
        $this->add_control(
            'highlight_featured_listings',
            [
                'label' => esc_html__('Highlight featured ads', 'listivo-core'),
                'description' => esc_html__('Apply styles from Site Settings -> Featured Ad Card', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );
    }

    /**
     * @return bool
     */
    public function highlightFeaturedListings(): bool
    {
        return !empty((int)$this->get_settings_for_display('highlight_featured_listings'));
    }

    protected function addShowFeaturedLabelControl(): void
    {
        $this->add_control(
            'show_featured_label',
            [
                'label' => esc_html__('Show featured label', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );
    }

    /**
     * @return bool
     */
    public function showFeaturedLabel(): bool
    {
        return !empty((int)$this->get_settings_for_display('show_featured_label'));
    }

    /**
     * @return string
     */
    public function getFeaturedLabelClasses(): string
    {
        $classes = [];

        if ($this->highlightFeaturedListings()) {
            $classes[] = 'listivo-highlight-featured-listings';
        }

        if (!$this->showFeaturedLabel()) {
            $classes[] = 'listivo-hide-listing-featured-label';
        }

        return implode(' ', $classes);
    }


}