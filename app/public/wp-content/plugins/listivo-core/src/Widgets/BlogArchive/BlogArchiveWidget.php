<?php


namespace Tangibledesign\Listivo\Widgets\BlogArchive;


use Elementor\Controls_Manager;

/**
 * Class BlogArchiveWidget
 * @package Tangibledesign\Listivo\Widgets
 */
class BlogArchiveWidget extends \Tangibledesign\Framework\Widgets\BlogArchiveWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'blog_archive';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Blog Archive', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addGridControls();

        $this->addBlogArchiveControls();

        $this->addShowExcerptControl();

        $this->addShowUserControl();

        $this->addShowPublishDateControl();

        $this->addShowReadMoreControl();

        $this->endControlsSection();
    }

    private function addGridControls(): void
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
                    '{{WRAPPER}} .listivo-posts' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr))',
                ]
            ]
        );

        $this->add_responsive_control(
            'gap_columns',
            [
                'label' => esc_html__('Columns Gap (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .listivo-posts' => 'grid-column-gap: {{VALUE}}px'
                ]
            ]
        );

        $this->add_responsive_control(
            'gap_rows',
            [
                'label' => esc_html__('Rows Gap (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .listivo-posts' => 'grid-row-gap: {{VALUE}}px'
                ]
            ]
        );
    }

    private function addShowUserControl(): void
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

    /**
     * @return bool
     */
    public function showUser(): bool
    {
        return !empty($this->get_settings_for_display('show_user'));
    }

    private function addShowPublishDateControl(): void
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

    /**
     * @return bool
     */
    public function showPublishDate(): bool
    {
        return !empty($this->get_settings_for_display('show_publish_date'));
    }

    private function addShowReadMoreControl(): void
    {
        $this->add_control(
            'show_read_more',
            [
                'label' => esc_html__('Display Read More Button', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );
    }

    /**
     * @return bool
     */
    public function showReadMore(): bool
    {
        return !empty($this->get_settings_for_display('show_read_more'));
    }

    private function addShowExcerptControl(): void
    {
        $this->add_control(
            'show_excerpt',
            [
                'label' => esc_html__('Display Excerpt', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );
    }

    /**
     * @return bool
     */
    public function showExcerpt(): bool
    {
        return !empty($this->get_settings_for_display('show_excerpt'));
    }

}