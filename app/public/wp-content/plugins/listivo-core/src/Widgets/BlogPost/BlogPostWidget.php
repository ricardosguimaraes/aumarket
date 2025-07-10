<?php

namespace Tangibledesign\Listivo\Widgets\BlogPost;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BasePostSingleWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SocialShareControls;

class BlogPostWidget extends BasePostSingleWidget
{
    use SocialShareControls;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'blog_post';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Blog Post', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addSocialShareControls();

        $this->endControlsSection();
    }

}