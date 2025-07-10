<?php

namespace Tangibledesign\Listivo\Widgets\BlogPost;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Widgets\Helpers\BasePostSingleWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SocialShareControls;

class BlogPostV2Widget extends BasePostSingleWidget
{
    use SocialShareControls;

    public function getKey(): string
    {
        return 'blog_post_v2';
    }

    public function getName(): string
    {
        return esc_html__('Blog Post V2', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addHideMainImageControl();

        $this->addHidePublishDateControl();

        $this->addHideCommentsNumberControl();

        $this->addHideUserControl();

        $this->addHideCategoryControl();

        $this->addSocialShareControls();

        $this->endControlsSection();

        $this->addGeneralStyleSection();

        $this->addContentStyleSection();
    }

    private function addGeneralStyleSection(): void
    {
        $this->startStyleControlsSection();

        $this->addBackgroundColor();

        $this->addListCircleColor();

        $this->add_control(
            'icon_heading',
            [
                'label' => esc_html__('Icon', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-single-post__data-icon path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'icon_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-single-post__data-icon' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'tag_heading',
            [
                'label' => esc_html__('Tag', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'tag_border_radius',
            [
                'label' => esc_html__('Border radius (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .listivo-single-post__tag' => 'border-radius: {{VALUE}}px;',
                ]
            ]
        );

        $this->add_control(
            'tag_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-single-post__tag' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'tag_hover_color',
            [
                'label' => esc_html__('Hover color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-single-post__tag:hover' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'tag_background_color',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-single-post__tag' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'tag_hover_background_color',
            [
                'label' => esc_html__('Hover background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-single-post__tag:hover' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->endControlsSection();
    }

    private function addContentStyleSection(): void
    {
        $this->startStyleControlsSection('content_style_section', esc_html__('Content', 'listivo-core'));

        $this->add_control(
            'title_heading',
            [
                'label' => esc_html__('Title', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-single-post__title' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .listivo-single-post__title',
            ]
        );

        $this->add_control(
            'text_heading',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-single-post__content' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'selector' => '{{WRAPPER}} .listivo-single-post__content',
            ]
        );

        $this->add_control(
            'heading_1_heading',
            [
                'label' => esc_html__('H1', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'heading_1_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-single-post__content h1' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_1_typography',
                'selector' => '{{WRAPPER}} .listivo-single-post__content h1',
            ]
        );

        $this->add_control(
            'heading_2_heading',
            [
                'label' => esc_html__('H2', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'heading_2_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-single-post__content h2' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_2_typography',
                'selector' => '{{WRAPPER}} .listivo-single-post__content h2',
            ]
        );

        $this->add_control(
            'heading_3_heading',
            [
                'label' => esc_html__('H3', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'heading_3_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-single-post__content h3' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_3_typography',
                'selector' => '{{WRAPPER}} .listivo-single-post__content h3',
            ]
        );

        $this->add_control(
            'heading_4_heading',
            [
                'label' => esc_html__('H4', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'heading_4_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-single-post__content h4' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_4_typography',
                'selector' => '{{WRAPPER}} .listivo-single-post__content h4',
            ]
        );

        $this->add_control(
            'heading_5_heading',
            [
                'label' => esc_html__('H5', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'heading_5_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-single-post__content h5' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_5_typography',
                'selector' => '{{WRAPPER}} .listivo-single-post__content h5',
            ]
        );

        $this->endControlsSection();
    }

    private function addBackgroundColor(): void
    {
        $this->add_control(
            'background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-single-post__meta-wrapper' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-single-post__main' => 'background-color: {{VALUE}};',
                ]
            ]
        );
    }

    private function addListCircleColor(): void
    {
        $this->add_control(
            'list_circle_color',
            [
                'label' => esc_html__('List circle color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-styled-list li:before' => 'border-color: {{VALUE}};',
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

    private function addHideCommentsNumberControl(): void
    {
        $this->add_control(
            'hide_comments_number',
            [
                'label' => esc_html__('Hide comments number', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );
    }

    public function hideCommentsNumber(): bool
    {
        return !empty((int)$this->get_settings_for_display('hide_comments_number'));
    }

    private function addHideUserControl(): void
    {
        $this->add_control(
            'hide_user',
            [
                'label' => esc_html__('Hide user', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );
    }

    public function hideUser(): bool
    {
        return !empty((int)$this->get_settings_for_display('hide_user'));
    }

    private function addHideCategoryControl(): void
    {
        $this->add_control(
            'hide_category',
            [
                'label' => esc_html__('Hide category', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );
    }

    public function hideCategory(): bool
    {
        return !empty((int)$this->get_settings_for_display('hide_category'));
    }

    public function showPostFooter(): bool
    {
        return !$this->hideCategory()
            || !$this->hideUser()
            || $this->showTwitter()
            || $this->showFacebook()
            || $this->showMessenger()
            || $this->showWhatsApp();
    }

    private function addHideMainImageControl(): void
    {
        $this->add_control(
            'hide_main_image',
            [
                'label' => esc_html__('Hide Image', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => 0,
            ]
        );
    }

    public function hideMainImage(): bool
    {
        return !empty((int)$this->get_settings_for_display('hide_main_image'));
    }

}