<?php

namespace Tangibledesign\Listivo\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Models\BlogPost;
use Tangibledesign\Framework\Widgets\Helpers\Controls\Control;

trait BlogPostCardControls
{
    use Control;

    protected function addShowUserControl(): void
    {
        $this->add_control(
            'show_user',
            [
                'label' => esc_html__('Display User', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );
    }

    public function showUser(): bool
    {
        return !empty($this->get_settings_for_display('show_user'));
    }

    protected function addShowPublishDateControl(): void
    {
        $this->add_control(
            'show_publish_date',
            [
                'label' => esc_html__('Display Publish Date', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );
    }

    public function showPublishDate(): bool
    {
        return !empty($this->get_settings_for_display('show_publish_date'));
    }

    protected function addShowCategoriesControl(): void
    {
        $this->add_control(
            'show_categories',
            [
                'label' => esc_html__('Display Categories', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );
    }

    public function showCategories(): bool
    {
        return !empty($this->get_settings_for_display('show_categories'));
    }

    public function addShowExcerptControl(): void
    {
        $this->add_control(
            'show_excerpt',
            [
                'label' => esc_html__('Show Excerpt', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );
    }

    public function showExcerpt(): bool
    {
        return !empty($this->get_settings_for_display('show_excerpt'));
    }

    protected function addExcerptLengthControl(): void
    {
        $this->add_control(
            'excerpt_length',
            [
                'label' => tdf_admin_string('excerpt_length'),
                'type' => Controls_Manager::NUMBER,
                'default' => 18,
            ]
        );
    }

    public function getExcerptLength(): int
    {
        $length = $this->get_settings_for_display('excerpt_length');

        if (empty($length)) {
            return 18;
        }

        return $length;
    }

    protected function addExcerptEndControl(): void
    {
        $this->add_control(
            'excerpt_end',
            [
                'label' => tdf_admin_string('excerpt_end'),
                'type' => Controls_Manager::TEXT,
                'default' => '...',
            ]
        );
    }

    public function getExcerptEnd(): string
    {
        return (string)$this->get_settings_for_display('excerpt_end');
    }

    public function addShowReadMoreButtonControl(): void
    {
        $this->add_control(
            'show_read_more',
            [
                'label' => esc_html__('Show "Read More" Button', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );
    }

    public function showReadMoreButton(): bool
    {
        return !empty($this->get_settings_for_display('show_read_more'));
    }

    public function displayExcerpt(BlogPost $blogPost): void
    {
        add_filter('excerpt_length', [$this, 'getExcerptLength'], 999);
        add_filter('excerpt_more', [$this, 'getExcerptEnd'], 999);
        echo get_the_excerpt($blogPost->getPost());
        remove_filter('excerpt_length', [$this, 'getExcerptLength']);
        remove_filter('excerpt_more', [$this, 'getExcerptEnd']);
    }
}