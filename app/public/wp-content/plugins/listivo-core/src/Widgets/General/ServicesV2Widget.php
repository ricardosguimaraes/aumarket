<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;

class ServicesV2Widget extends BaseGeneralWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'services_v2';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Services V2', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addServicesControl();

        $this->endControlsSection();
    }

    private function addServicesControl(): void
    {
        $services = new Repeater();

        $services->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'listivo-core'),
                'type' => Controls_Manager::ICONS,
            ]
        );

        $services->add_control(
            'name',
            [
                'label' => esc_html__('Name', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $services->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'listivo-core'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );

        $this->add_control(
            'services',
            [
                'label' => esc_html__('Services', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $services->get_controls(),
                'prevent_empty' => false,
            ]
        );
    }

    /**
     * @return array
     */
    public function getServices(): array
    {
        $services = $this->get_settings_for_display('services');
        if (!is_array($services)) {
            return [];
        }

        return tdf_collect($services)->map(static function ($service) {
            if ($service['icon']['library'] === 'svg') {
                $service['icon'] = [
                    'type' => 'svg',
                    'value' => $service['icon']['value']['url'] ?? '',
                ];

                return $service;
            }

            $service['icon'] = [
                'type' => 'regular',
                'value' => $service['icon']['value'] ?? '',
            ];

            return $service;
        })->values();
    }

}