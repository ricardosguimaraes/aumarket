<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;

class ServicesV4Widget extends BaseGeneralWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'services_v4';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Services V4', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addAddServicesControl();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->add_control(
            'icon_circle',
            [
                'label' => esc_html__('Icon circle', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );

        $this->add_control(
            'circle_background',
            [
                'label' => esc_html__('Circle background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-service-v4__circle' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'icon_circle' => '1',
                ]
            ]
        );

        $this->endControlsSection();
    }
    
    /**
     * @return bool
     */
    public function iconCirclesEnabled(): bool
    {
        return !empty((int)$this->get_settings_for_display('icon_circle'));
    }

    private function addAddServicesControl(): void
    {
        $services = new Repeater();

        $services->add_control(
            'type',
            [
                'label' => esc_html__('Type', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'text' => esc_html__('Text', 'listivo-core'),
                    'mail' => esc_html__('Mail', 'listivo-core'),
                    'phone' => esc_html__('Phone', 'listivo-core'),
                    'address' => esc_html__('Address', 'listivo-core'),
                ],
                'default' => 'text',
            ]
        );

        $services->add_control(
            'image',
            [
                'label' => esc_html__('Image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $services->add_control(
            'title',
            [
                'label' => esc_html__('title', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $services->add_control(
            'text',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );

        $this->add_control(
            'services',
            [
                'label' => esc_html__('Services', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $services->get_controls(),
            ]
        );
    }

    /**
     * @return Collection
     */
    public function getServices(): Collection
    {
        $services = $this->get_settings_for_display('services');
        if (empty($services) || !is_array($services)) {
            return tdf_collect();
        }

        return tdf_collect($services)->map(static function ($service) {
            if (!empty($service['text']) || $service['type'] === 'text') {
                return $service;
            }

            if ($service['type'] === 'address') {
                $service['text'] = tdf_settings()->getAddress();
                return $service;
            }

            if ($service['type'] === 'mail') {
                $service['text'] = tdf_settings()->getMail();
                return $service;
            }

            if ($service['type'] === 'phone') {
                $service['text'] = tdf_settings()->getPhone();
                return $service;
            }

            return $service;
        });
    }

}