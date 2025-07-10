<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Models\Image;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\ButtonControls;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\HeadingV2Controls;

class ContentV2Widget extends BaseGeneralWidget
{
    use HeadingV2Controls;
    use ButtonControls;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'content_v2';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Content Section V2', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addImageControl();

        $this->addHeadingControls();

        $this->addTextControl();

        $this->addButtonControls('primary_2');

        $this->endControlsSection();
    }

    private function addImageControl(): void
    {
        $this->add_control(
            'image',
            [
                'label' => esc_html__('Image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );
    }

    private function addTextControl(): void
    {
        $this->add_control(
            'text',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );
    }

    /**
     * @return Image|false
     */
    public function getImage()
    {
        $image = $this->get_settings_for_display('image');
        if (!isset($image['id'])) {
            return false;
        }

        return tdf_image_factory()->create((int)$image['id']);
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return (string)$this->get_settings_for_display('text');
    }

}