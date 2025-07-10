<?php

namespace Tangibledesign\Listivo\Widgets\Listing;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseModelSingleWidget;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\ContactButtonStyleControls;

class ListingDirectionWidget extends BaseModelSingleWidget
{
    use ContactButtonStyleControls;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'listing_direction';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Listing Direction', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->addContactButtonStyleControls();

        $this->addMarginControl();

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    private function addMarginControl(): void
    {
        $this->add_responsive_control(
            'direction_margin',
            [
                'label' => esc_html__('Margin', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-contact-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
    }

}