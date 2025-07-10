<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Repeater;

class ServicesWidget extends \Tangibledesign\Framework\Widgets\General\ServicesWidget
{

    protected function addServicesControl(): void
    {
        $services = new Repeater();

        $services->add_control(
            'image',
            [
                'label' => tdf_admin_string('image'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $services->add_control(
            'title',
            [
                'label' => tdf_admin_string('title'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $services->add_control(
            'text',
            [
                'label' => tdf_admin_string('text'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );

        $services->add_control(
            'background_color',
            [
                'label' => esc_html__('Background Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-service{{CURRENT_ITEM}}' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $services->add_control(
            'enable_border',
            [
                'label' => esc_html__('Enable Border', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );

        $this->add_control(
            'services',
            [
                'label' => tdf_admin_string('services'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $services->get_controls(),
            ]
        );
    }

}