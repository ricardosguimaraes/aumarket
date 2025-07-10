<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;

class ServicesV3Widget extends BaseGeneralWidget
{
    public function getKey(): string
    {
        return 'services_v3';
    }

    public function getName(): string
    {
        return esc_html__('Services V3', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addAddServicesControl();

        $this->endControlsSection();
    }

    private function addAddServicesControl(): void
    {
        $services = new Repeater();

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

        $services->add_control(
            'button_text',
            [
                'label' => esc_html__('Button Text', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => tdf_string('read_more'),
            ]
        );

        $services->add_control(
            'custom_url_switch',
            [
                'label' => esc_html__('Use Custom URL', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '0',
                'return_value' => '1',
            ]
        );

        $services->add_control(
            'button_link',
            [
                'label' => esc_html__('Button Link', 'listivo-core'),
                'type' => SelectRemoteControl::TYPE,
                'source' => tdf_action_url(tdf_prefix() . '/button/destinations'),
                'condition' => [
                    'custom_url_switch!' => '1',
                ],
            ]
        );

        $services->add_control(
            'button_destination_custom',
            [
                'label' => esc_html__('Custom URL', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'custom_url_switch' => '1',
                ],
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

    public function getServices(): Collection
    {
        $services = $this->get_settings_for_display('services');
        if (empty($services) || !is_array($services)) {
            return tdf_collect();
        }

        return tdf_collect($services)
            ->map(static function ($service) {
                if (!empty($service['custom_url_switch'])) {
                    $service['button_url'] = $service['button_destination_custom'];

                    return $service;
                }

                $destination = $service['button_link'];
                if (is_array($destination)) {
                    $destination = '';
                }

                $service['button_url'] = apply_filters(
                    tdf_prefix() . '/button/destination',
                    false,
                    (string)$destination
                );

                return $service;
            });
    }
}