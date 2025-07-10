<?php

namespace Tangibledesign\Listivo\Widgets\Listing;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Widgets\Helpers\BaseModelSingleWidget;

class ListingReportAbuseWidget extends BaseModelSingleWidget
{
    public function getKey(): string
    {
        return 'listing_report_abuse';
    }

    public function getName(): string
    {
        return esc_html__('Report Abuse Button', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->add_control(
            'color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-report-abuse-button' => 'color: {{VALUE}};',
                    '{{WRAPPER}} path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'typo',
                'selector' => '{{WRAPPER}} .listivo-report-abuse-button',
            ]
        );

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

}