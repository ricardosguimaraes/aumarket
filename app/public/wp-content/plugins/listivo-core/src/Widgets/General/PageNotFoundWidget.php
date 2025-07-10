<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;

class PageNotFoundWidget extends BaseGeneralWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'page_not_found';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Page Not Found', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->add_control(
            'image',
            [
                'label' => esc_html__('Image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->endControlsSection();
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        $image = $this->get_settings_for_display('image');

        return $image['url'] ?? '';
    }

}