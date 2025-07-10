<?php

namespace Tangibledesign\Listivo\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\Controls\Control;

trait ListingGridControls
{
    use Control;

    protected function addGridControls(): void
    {
        $this->add_responsive_control(
            'grid_columns',
            [
                'label' => esc_html__('Columns', 'listivo-core'),
                'type' => Controls_Manager::SELECT2,
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                ],
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr))',
                ]
            ]
        );

        $this->add_responsive_control(
            'gap_columns',
            [
                'label' => esc_html__('Columns Gap (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-grid' => 'grid-column-gap: {{VALUE}}px'
                ]
            ]
        );

        $this->add_responsive_control(
            'gap_rows',
            [
                'label' => esc_html__('Rows Gap (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-grid' => 'grid-row-gap: {{VALUE}}px'
                ]
            ]
        );
    }

}