<?php

namespace Tangibledesign\Listivo\Widgets\BlogPost;

use Elementor\Controls_Manager;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\BoxArrowStyleControls;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\HeadingV2Controls;

class RelatedBlogPostsCarouselWidget extends \Tangibledesign\Framework\Widgets\BlogPost\RelatedBlogPostsWidget
{
    use HeadingV2Controls;
    use BoxArrowStyleControls;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'related_blog_posts_carousel';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Related Blog Posts Carousel', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addHeadingControls();

        $this->addLimitControl(6);

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->add_control(
            'navigation_heading',
            [
                'label' => esc_html__('Navigation', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->addBoxArrowStyleControls();

        $this->add_control(
            'heading_heading',
            [
                'label' => esc_html__('Heading', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->addHeadingStyleControls();

        $this->endControlsSection();
    }


}