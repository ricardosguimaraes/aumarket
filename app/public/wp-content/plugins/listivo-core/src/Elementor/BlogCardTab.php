<?php

namespace Tangibledesign\Listivo\Elementor;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Tab_Base;
use Elementor\Group_Control_Typography;

class BlogCardTab extends Tab_Base
{

    public function get_id(): string
    {
        return 'listivo-blog-card';
    }

    public function get_title(): string
    {
        return esc_html__('Blog Card', 'listivo-core');
    }

    public function get_group(): string
    {
        return 'theme-style';
    }

    public function get_icon(): string
    {
        return 'fas fa-paint-brush';
    }

    protected function register_tab_controls(): void
    {
        $this->start_controls_section(
            'listivo_blog_card',
            [
                'label' => esc_html__('Listivo Blog Card', 'listivo-core'),
                'tab' => $this->get_id(),
            ]
        );

        $this->addHideUserControl();

        $this->addHidePublishDateControl();

        $this->addImageSizeControl();

        $this->addLabelStyleControls();

        $this->addTextStyleControls();

        $this->addMetaDataStyleControls();

        $this->addDateIconControls();

        $this->end_controls_section();
    }

    private function addImageSizeControl(): void
    {
        $this->add_control(
            'listivo_blog_card_image_size',
            [
                'label' => esc_html__('Image Size', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => tdf_app('image_size_options'),
                'default' => tdf_prefix().'_360_240',
            ]
        );
    }

    private function addDateIconControls(): void
    {
        $this->add_control(
            'listivo_blog_card_date_icon_label',
            [
                'label' => esc_html__('Date icon', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listivo_blog_card_date_icon_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper().' .listivo-blog-post-card-v4__icon path' => 'fill: {{VALUE}};',
                    $this->getWrapper().' .listivo-blog-post-card-v5__icon path' => 'fill: {{VALUE}};',
                    $this->getWrapper().' .listivo-blog-post-mini-card__icon path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listivo_blog_card_date_icon_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper().' .listivo-blog-post-card-v4__icon' => 'background: {{VALUE}};',
                    $this->getWrapper().' .listivo-blog-post-card-v5__icon' => 'background: {{VALUE}};',
                    $this->getWrapper().' .listivo-blog-post-mini-card__icon' => 'background: {{VALUE}};',
                ]
            ]
        );
    }

    private function addLabelStyleControls(): void
    {
        $this->add_control(
            'blog_card_label_heading',
            [
                'label' => esc_html__('Heading', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'blog_card_label_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper().' .listivo-blog-post-card-v4__heading' => 'color: {{VALUE}};',
                    $this->getWrapper().' .listivo-blog-post-card-v5__heading' => 'color: {{VALUE}};',
                    $this->getWrapper().' .listivo-blog-post-mini-card__heading' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'blog_card_label_typography',
                'selector' => $this->getWrapper().' .listivo-blog-post-card-heading-selector',
            ]
        );
    }

    private function addTextStyleControls(): void
    {
        $this->add_control(
            'blog_card_text_heading',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'blog_card_text_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper().' .listivo-blog-post-card-v4__text' => 'color: {{VALUE}};',
                    $this->getWrapper().' .listivo-blog-post-card-v5__text' => 'color: {{VALUE}};',
                    $this->getWrapper().' .listivo-blog-post-mini-card__text' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'blog_card_text_typography',
                'selector' => $this->getWrapper().' .listivo-blog-post-card-text-selector',
            ]
        );
    }

    private function addMetaDataStyleControls(): void
    {
        $this->add_control(
            'blog_card_meta_data_heading',
            [
                'label' => esc_html__('Meta data', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'blog_card_meta_data_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper().' .listivo-blog-post-card-v4__meta-value' => 'color: {{VALUE}};',
                    $this->getWrapper().' .listivo-blog-post-card-v5__meta-value' => 'color: {{VALUE}};',
                    $this->getWrapper().' .listivo-blog-post-mini-card__meta-value' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'blog_card_meta_data_typography',
                'selector' => $this->getWrapper().' .listivo-blog-post-card-meta-selector',
            ]
        );
    }

    private function addHidePublishDateControl(): void
    {
        $this->add_control(
            'blog_card_hide_publish_date',
            [
                'label' => esc_html__('Hide publish date', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );
    }

    private function addHideUserControl(): void
    {

        $this->add_control(
            'blog_card_hide_user',
            [
                'label' => esc_html__('Hide user', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );
    }

    private function getWrapper(): string
    {
        if (is_rtl()) {
            return '[dir] {{WRAPPER}}';
        }

        return '{{WRAPPER}}';
    }

}