<?php


namespace Tangibledesign\Framework\Widgets\Helpers\Controls;


use Elementor\Controls_Manager;

/**
 * Trait CarouselControls
 * @package Tangibledesign\Framework\Widgets\Helpers\Controls
 */
trait CarouselControls
{
    use Control;

    public function getSwiperConfig(): array
    {
        return [
            'loop' => true,
            'autoplay' => $this->isAutoplayEnabled(),
            'autoplayDelay' => $this->getAutoplayDelay(),
        ];
    }

    protected function addAutoPlayControl(): void
    {
        $this->add_control(
            'autoplay',
            [
                'label' => tdf_admin_string('autoplay'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );

        $this->add_control(
            'autoplay_delay',
            [
                'label' => tdf_admin_string('autoplay_delay'),
                'type' => Controls_Manager::NUMBER,
                'default' => 3000,
                'condition' => [
                    'autoplay' => '1',
                ]
            ]
        );
    }

    /**
     * @return bool
     */
    protected function isAutoplayEnabled(): bool
    {
        return !empty((int)$this->get_settings_for_display('autoplay'));
    }

    /**
     * @return int
     */
    protected function getAutoplayDelay(): int
    {
        $delay = (int)$this->get_settings_for_display('autoplay_delay');

        if (empty($delay)) {
            return 3000;
        }

        return $delay;
    }

}