<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Widgets\General\BlogPostsWidget;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\BlogPostCardControls;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\HeadingV2Controls;

class BlogPostsV2Widget extends BlogPostsWidget
{
    use HeadingV2Controls;
    use BlogPostCardControls;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'blog_posts_v2';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Blog Posts V2', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addHeadingControls();

        $this->add_control(
            'limit',
            [
                'type' => Controls_Manager::HIDDEN,
                'default' => 4,
            ]
        );

        $this->addOffsetControl();

        $this->addCategoriesControl();

        $this->addTagsControl();

        $this->addAuthorsControl();

        $this->endControlsSection();
    }

}