<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TermListWithImagesControl;

class TermListV3Widget extends BaseGeneralWidget
{
    use TermListWithImagesControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'term_list_v3';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Term list V3', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addGridControl();

        $this->addTermsControl();

        $this->endControlsSection();
    }

    private function addGridControl(): void
    {
        $this->add_responsive_control(
            'card_per_row',
            [
                'label' => esc_html__('Columns', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'repeat(1, minmax(0, 1fr))' => '1',
                    'repeat(2, minmax(0, 1fr))' => '2',
                    'repeat(3, minmax(0, 1fr))' => '3',
                    'repeat(4, minmax(0, 1fr))' => '4',
                    'repeat(5, minmax(0, 1fr))' => '5',
                    'repeat(6, minmax(0, 1fr))' => '6',
                ],
                'default' => 'repeat(3, minmax(0, 1fr))',
                'selectors' => [
                    '{{WRAPPER}} .listivo-term-list-v3' => 'grid-template-columns: {{VALUE}};',
                ]
            ]
        );
    }

}