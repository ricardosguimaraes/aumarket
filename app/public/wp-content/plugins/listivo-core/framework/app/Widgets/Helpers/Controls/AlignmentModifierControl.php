<?php


namespace Tangibledesign\Framework\Widgets\Helpers\Controls;


use Elementor\Controls_Manager;

/**
 * Trait AlignmentModifierControl
 * @package Tangibledesign\Framework\Widgets\Helpers\Controls
 */
trait AlignmentModifierControl
{
    use Control;

    /**
     * @param string $default
     */
    protected function addAlignControl(string $default = 'center'): void
    {
        $this->add_control(
            'text_align',
            [
                'label' => tdf_admin_string('text_align'),
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
                ],
                'default' => $default,
            ]
        );
    }

    /**
     * @return string
     */
    public function getAlignModifier(): string
    {
        $modifier = $this->get_settings_for_display('text_align');
        if (empty($modifier)) {
            return 'left';
        }

        return $modifier;
    }

}