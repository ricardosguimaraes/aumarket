<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;

class PagesCarouselWidget extends BaseGeneralWidget
{
    public function getKey(): string
    {
        return 'pages_carousel';
    }

    public function getName(): string
    {
        return esc_html__('Pages Carousel', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addPagesControl();

        $this->endControlsSection();
    }

    private function addPagesControl(): void
    {
        $fields = new Repeater();

        $fields->add_control(
            'pageId',
            [
                'label' => esc_html__('Page', 'listivo-core'),
                'type' => SelectRemoteControl::TYPE,
                'source' => tdf_action_url(tdf_prefix() . '/button/destinations'),
            ]
        );

        $fields->add_control(
            'image',
            [
                'label' => esc_html__('Image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'pages',
            [
                'label' => esc_html__('Pages', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $fields->get_controls(),
                'prevent_empty' => false,
            ]
        );
    }

    public function getPages(): Collection
    {
        $pagesData = $this->get_settings('pages');
        if (!is_array($pagesData) || empty($pagesData)) {
            return tdf_collect();
        }

        return tdf_collect($pagesData)->map(function ($pageData) {
            $page = tdf_post_factory()->create((int)$pageData['pageId']);
            if (!$page) {
                return null;
            }

            return [
                'page' => $page,
                'image' => $pageData['image'],
            ];
        })->filter();
    }
}
