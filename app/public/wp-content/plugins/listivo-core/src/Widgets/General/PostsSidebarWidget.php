<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\BlogPost;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\BlogWidgetStyleControls;

class PostsSidebarWidget extends BaseGeneralWidget
{
    use BlogWidgetStyleControls;

    public function getKey(): string
    {
        return 'posts_sidebar';
    }

    public function getName(): string
    {
        return tdf_admin_string('posts_sidebar');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addLabelControl();

        $this->addPostsControl();

        $this->addHidePublishDateControl();

        $this->addLimitControl();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addBlogWidgetStyleControls();

        $this->addTitleStyleControls();

        $this->addIconStyleControls();

        $this->addDateStyleControls();

        $this->endControlsSection();
    }

    private function addLimitControl(): void
    {
        $this->add_control(
            'limit',
            [
                'label' => tdf_admin_string('limit'),
                'type' => Controls_Manager::NUMBER,
                'default' => 3,
            ]
        );
    }

    private function getLimit(): int
    {
        $limit = (int)$this->get_settings_for_display('limit');
        if (empty($limit)) {
            return 3;
        }

        return $limit;
    }

    private function addPostsControl(): void
    {
        $posts = new Repeater();
        $posts->add_control(
            'post_id',
            [
                'label' => tdf_admin_string('post'),
                'type' => SelectRemoteControl::TYPE,
                'source' => get_rest_url() . 'wp/v2/posts',
            ]
        );

        $this->add_control(
            'posts',
            [
                'label' => tdf_admin_string('posts'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $posts->get_controls(),
                'prevent_empty' => false,
            ]
        );
    }

    /**
     * @return Collection|BlogPost[]
     */
    public function getPosts(): Collection
    {
        $posts = $this->getStaticPosts();
        if ($posts->isNotEmpty()) {
            return $posts;
        }

        return $this->getDynamicPosts();
    }

    private function getDynamicPosts(): Collection
    {
        return tdf_query_blog_posts()->take($this->getLimit())->get();
    }

    /**
     * @return Collection|BlogPost[]
     */
    private function getStaticPosts(): Collection
    {
        $posts = $this->get_settings_for_display('posts');
        if (empty($posts) || !is_array($posts)) {
            return tdf_collect();
        }

        $postIds = tdf_collect($posts)->map(static function ($post) {
            return (int)($post['post_id'] ?? 0);
        })->filter(static function ($postId) {
            return !empty($postId);
        })->values();

        if (empty($postIds)) {
            return tdf_collect();
        }

        return tdf_query_blog_posts()->in($postIds)->get();
    }

    private function addLabelControl(): void
    {
        $this->add_control(
            'label',
            [
                'label' => tdf_admin_string('label'),
                'type' => Controls_Manager::TEXT,
            ]
        );
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        $label = $this->get_settings_for_display('label');
        if (empty($label)) {
            return tdf_string('popular_posts');
        }

        return $label;
    }

    private function addIconStyleControls(): void
    {
        $this->add_control(
            'icon_heading',
            [
                'label' => esc_html__('Icon', 'listivo-core'),
                'type' => Controls_Manager::HEADING
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-small-icon path' => 'fill: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'icon_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-small-icon' => 'background-color: {{VALUE}};'
                ]
            ]
        );
    }

    private function addTitleStyleControls(): void
    {
        $this->add_control(
            'title_heading',
            [
                'label' => esc_html__('Title', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .listivo-sidebar-posts__label',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-sidebar-posts__label' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label' => esc_html__('Hover color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-sidebar-posts__label:hover' => 'color: {{VALUE}};',
                ]
            ]
        );
    }

    private function addDateStyleControls(): void
    {
        $this->add_control(
            'date_heading',
            [
                'label' => esc_html__('Date', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'date_typography',
                'selector' => '{{WRAPPER}} .listivo-sidebar-posts__date',
            ]
        );

        $this->add_control(
            'date_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-sidebar-posts__date' => 'color: {{VALUE}};',
                ]
            ]
        );
    }

    private function addHidePublishDateControl(): void
    {
        $this->add_control(
            'hide_publish_date',
            [
                'label' => esc_html__('Hide publish date', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );
    }

    public function hidePublishDate(): bool
    {
        return !empty((int)$this->get_settings_for_display('hide_publish_date'));
    }
}