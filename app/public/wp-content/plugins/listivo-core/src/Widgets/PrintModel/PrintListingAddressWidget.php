<?php

namespace Tangibledesign\Listivo\Widgets\PrintModel;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextControls;

class PrintListingAddressWidget extends BasePrintModelWidget
{
    use TextControls;

    public function getKey(): string
    {
        return 'print_listing_address';
    }

    public function getName(): string
    {
        return esc_html__('Listing Address', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->addMarginControl();

        $this->addTextControls('.listivo-print-address-wrapper');

        $this->endControlsSection();
    }

    private function addMarginControl(): void
    {
        $this->add_control(
            'margin',
            [
                'label' => esc_html__('Margin', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .listivo-print-address' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
    }
}