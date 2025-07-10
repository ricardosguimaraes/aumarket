<?php


namespace Tangibledesign\Framework\Widgets\Helpers\Controls;


use Elementor\Controls_Manager;

/**
 * Trait ExcerptControls
 * @package Tangibledesign\Framework\Widgets\Helpers\Controls
 */
trait ExcerptControls
{
    use Control;

    protected function addExcerptLengthControl(): void
    {
        $this->add_control(
            'excerpt_length',
            [
                'label' => tdf_admin_string('excerpt_length'),
                'type' => Controls_Manager::NUMBER,
                'default' => 18,
            ]
        );
    }

    /**
     * @return int
     */
    public function getExcerptLength(): int
    {
        $length = $this->get_settings_for_display('excerpt_length');

        if (empty($length)) {
            return 18;
        }

        return $length;
    }

    protected function addExcerptEndControl(): void
    {
        $this->add_control(
            'excerpt_end',
            [
                'label' => tdf_admin_string('excerpt_end'),
                'type' => Controls_Manager::TEXT,
                'default' => '...',
            ]
        );
    }

    /**
     * @return string
     */
    public function getExcerptEnd(): string
    {
        return (string)$this->get_settings_for_display('excerpt_end');
    }

}