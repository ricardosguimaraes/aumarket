<?php

namespace Tangibledesign\Listivo\Widgets\BlogArchive;

use Elementor\Controls_Manager;

class BlogArchiveV2Widget extends \Tangibledesign\Framework\Widgets\BlogArchiveWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'blog_archive_v2';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Blog Archive V2', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->add_control(
            'first_featured',
            [
                'label' => esc_html__('Feature first post', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );

        $this->addLimitControl('', 7);

        $this->endControlsSection();
    }

    /**
     * @return bool
     */
    public function isFirstPostFeatured(): bool
    {
        return !empty((int)$this->get_settings_for_display('first_featured'));
    }

}