<?php

namespace Tangibledesign\Listivo\Widgets\BlogPost;

use Elementor\Controls_Manager;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\BlogPostCard;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\BlogPostCardControls;

class RelatedBlogPostsWidget extends \Tangibledesign\Framework\Widgets\BlogPost\RelatedBlogPostsWidget implements BlogPostCard
{
    use BlogPostCardControls;

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addLimitControl();

        $this->addShowPublishDateControl();

        $this->addShowUserControl();

        $this->addShowExcerptControl();

        $this->addExcerptLengthControl();

        $this->addExcerptEndControl();

        $this->addShowReadMoreButtonControl();

        $this->addGridColumnsControl();

        $this->addGapControls();

        $this->endControlsSection();
    }

    private function addGridColumnsControl(): void
    {
        $this->add_control(
            'grid_columns',
            [
                'label' => esc_html__('Columns', 'listivo-core'),
                'type' => Controls_Manager::SELECT2,
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                ],
                'selectors' => [
                    '{{WRAPPER}} .listivo-related-blog-posts__list' => 'grid-template-columns: repeat({{VALUE}}, 1fr)',
                ]
            ]
        );
    }

    private function addGapControls(): void
    {
        $this->add_responsive_control(
            'gap_columns',
            [
                'label' => esc_html__('Columns Gap (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .listivo-related-blog-posts__list' => 'grid-column-gap: {{VALUE}}px'
                ]
            ]
        );

        $this->add_responsive_control(
            'gap_rows',
            [
                'label' => esc_html__('Rows Gap (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .listivo-related-blog-posts__list' => 'grid-row-gap: {{VALUE}}px'
                ]
            ]
        );
    }

}