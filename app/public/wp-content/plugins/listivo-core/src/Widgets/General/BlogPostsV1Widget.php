<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\General\BlogPostsWidget;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\BlogPostCardControls;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\HeadingControls;

class BlogPostsV1Widget extends BlogPostsWidget
{
    use HeadingControls;
    use BlogPostCardControls;

    public function getKey(): string
    {
        return 'blog_posts_v1';
    }

    public function getName(): string
    {
        return esc_html__('Blog Posts V1', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addHeadingControls();

        $this->addLimitControl('', 3);

        $this->addOffsetControl();

        $this->addExcerptLengthControl();

        $this->addExcerptEndControl();

        $this->addCategoriesControl();

        $this->addTagsControl();

        $this->addAuthorsControl();

        $this->addButtonHeading();

        $this->addButtonTextControl();

        $this->addButtonDestinationControl();

        $this->endControlsSection();

        $this->startContentControlsSection('card_content', esc_html__('Card', 'listivo-core'));

        $this->addShowCategoriesControl();

        $this->addShowUserControl();

        $this->addShowPublishDateControl();

        $this->endControlsSection();
    }

    private function addButtonHeading(): void
    {
        $this->add_control(
            'button_heading',
            [
                'label' => esc_html__('Button', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );
    }

    protected function addButtonDestinationControl(): void
    {
        $this->add_control(
            'button_destination',
            [
                'label' => tdf_admin_string('destination'),
                'type' => SelectRemoteControl::TYPE,
                'source' => tdf_action_url(tdf_prefix() . '/button/destinations')
            ]
        );
    }

    protected function addButtonTextControl(): void
    {
        $this->add_control(
            'button_text',
            [
                'label' => tdf_admin_string('text'),
                'type' => Controls_Manager::TEXT,
                'default' => tdf_admin_string('button'),
            ]
        );
    }

    public function getButtonText(): string
    {
        return (string)$this->get_settings_for_display('button_text');
    }

    public function getButtonUrl(): string
    {
        return apply_filters(
            tdf_prefix() . '/button/destination',
            false,
            (string)$this->get_settings_for_display('button_destination')
        );
    }
}