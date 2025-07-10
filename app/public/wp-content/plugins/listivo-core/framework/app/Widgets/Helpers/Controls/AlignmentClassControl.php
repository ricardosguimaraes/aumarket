<?php


namespace Tangibledesign\Framework\Widgets\Helpers\Controls;


use Elementor\Controls_Manager;

/**
 * Trait AlignmentClassControl
 * @package Tangibledesign\Framework\Widgets\Helpers\Controls
 */
trait AlignmentClassControl
{
    use Control;

    protected function addAlignmentClassControl(): void
    {
        $this->add_responsive_control(
            'alignment_class',
            [
                'label' => tdf_admin_string('alignment'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => tdf_admin_string('left'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => tdf_admin_string('center'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => tdf_admin_string('right'),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => tdf_admin_string('justify'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'default' => '',
            ]
        );
    }

    /**
     * @return string
     */
    public function getAlignmentClass(): string
    {
        $classes = [];

        if (!empty($this->get_settings_for_display('alignment_class'))) {
            $classes[] = tdf_prefix() . '-alignment-' . $this->get_settings_for_display('alignment_class');
        }

        if (!empty($this->get_settings_for_display('alignment_class_tablet'))) {
            $classes[] = tdf_prefix() . '-alignment-tablet-' . $this->get_settings_for_display('alignment_class_tablet');
        }

        if (!empty($this->get_settings_for_display('alignment_class_mobile'))) {
            $classes[] = tdf_prefix() . '-alignment-mobile-' . $this->get_settings_for_display('alignment_class_mobile');
        }

        return implode(' ', $classes);
    }

}