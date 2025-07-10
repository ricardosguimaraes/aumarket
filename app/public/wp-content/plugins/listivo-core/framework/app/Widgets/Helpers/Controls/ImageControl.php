<?php

namespace Tangibledesign\Framework\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Models\Image;

trait ImageControl
{
    use Control;

    protected function addImageControl(): void
    {
        $this->add_control(
            'image',
            [
                'label' => tdf_admin_string('image'),
                'type' => Controls_Manager::MEDIA,
            ]
        );
    }

    /**
     * @return string
     */
    public function getImageUrl(): string
    {
        $image = $this->get_settings_for_display('image');

        return $image['url'] ?? '';
    }

    /**
     * @return Image|false
     */
    public function getImage()
    {
        $image = $this->get_settings_for_display('image');
        if (empty($image['id'])) {
            return false;
        }

        return tdf_image_factory()->create((int)$image['id']);
    }

}