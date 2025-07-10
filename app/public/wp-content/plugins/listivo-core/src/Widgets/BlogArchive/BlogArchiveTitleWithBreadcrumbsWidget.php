<?php

namespace Tangibledesign\Listivo\Widgets\BlogArchive;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BasePostArchiveWidget;
use Tangibledesign\Framework\Widgets\Helpers\HasBreadcrumbs;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\TitleWithBreadcrumbsStyleControls;

class BlogArchiveTitleWithBreadcrumbsWidget extends BasePostArchiveWidget
{
    use HasBreadcrumbs;
    use TitleWithBreadcrumbsStyleControls;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'blog_archive_title_with_breadcrumbs';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Blog Archive Title With Breadcrumbs', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addBackgroundImageControl();

        $this->endControlsSection();

        $this->addTitleWithBreadcrumbsStyleSection();
    }

    private function addBackgroundImageControl(): void
    {
        $this->add_control(
            'image',
            [
                'label' => esc_html__('Background Image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        if (is_search()) {
            return tdf_string('search') . ': ' . get_query_var('s');
        }

        return get_the_archive_title();
    }

    /**
     * @return string
     */
    public function getBackgroundImage(): string
    {
        $image = $this->get_settings_for_display('image');

        return $image['url'] ?? '';
    }

}