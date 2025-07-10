<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\HasBreadcrumbs;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\TitleWithBreadcrumbsStyleControls;

class TitleWithBreadcrumbsWidget extends BaseGeneralWidget
{
    use HasBreadcrumbs;
    use TitleWithBreadcrumbsStyleControls;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'title_with_breadcrumbs';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Title With Breadcrumbs', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addTitleControl();

        $this->addBackgroundImageControl();

        $this->endControlsSection();

        $this->addTitleWithBreadcrumbsStyleSection();
    }

    private function addTitleControl(): void
    {
        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return (string)$this->get_settings_for_display('title');
    }

    private function addBackgroundImageControl(): void
    {
        $this->add_control(
            'background_image',
            [
                'label' => esc_html__('Background Image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );
    }

    /**
     * @return string
     */
    public function getBackgroundImage(): string
    {
        $image = $this->get_settings_for_display('background_image');

        return $image['url'] ?? '';
    }

}