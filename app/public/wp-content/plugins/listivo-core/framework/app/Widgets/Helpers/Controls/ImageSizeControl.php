<?php


namespace Tangibledesign\Framework\Widgets\Helpers\Controls;


use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

/**
 * Trait ImageSizeControl
 * @package Tangibledesign\Framework\Widgets\Helpers\Controls
 */
trait ImageSizeControl
{
    use Control;

    /**
     * @param string $default
     * @param string $key
     * @param string $label
     */
    protected function addImageSizeControl(string $default = 'full', string $key = 'image_size', string $label = ''): void
    {
        if (!empty($label)) {
            $this->add_control(
                $key . '_heading',
                [
                    'label' => $label,
                    'type' => Controls_Manager::HEADING,
                ]
            );
        }

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => $key,
                'default' => $default,
                'exclude' => ['custom'],
            ]
        );
    }

    /**
     * @param string $key
     * @return string
     */
    public function getImageSize(string $key = 'image_size'): string
    {
        $imageSize = $this->get_settings_for_display($key . '_size');
        if (empty($imageSize)) {
            return 'full';
        }

        return $imageSize;
    }

}