<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;

class AccordionWidget extends BaseGeneralWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'accordion';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return tdf_admin_string('accordion');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addOpenFirstControl();

        $this->addItemsControl();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addArrowStyleControls();

        $this->endControlsSection();
    }

    private function addOpenFirstControl(): void
    {
        $this->add_control(
            'open_first',
            [
                'label' => tdf_admin_string('open_first'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );
    }

    /**
     * @return bool
     */
    public function openFirst(): bool
    {
        return !empty((int)$this->get_settings_for_display('open_first'));
    }

    protected function addItemsControl(): void
    {
        $items = new Repeater();

        $items->add_control(
            'label',
            [
                'label' => tdf_admin_string('label'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $items->add_control(
            'text',
            [
                'label' => tdf_admin_string('text'),
                'type' => Controls_Manager::TEXTAREA
            ]
        );

        $this->add_control(
            'items',
            [
                'label' => tdf_admin_string('items'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $items->get_controls(),
                'default' => [
                    [
                        'label' => tdf_admin_string('accordion') . ' #1',
                        'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.'
                    ],
                    [
                        'label' => tdf_admin_string('accordion') . ' #2',
                        'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.'
                    ],
                ]
            ]
        );
    }

    /**
     * @return Collection
     */
    public function getItems(): Collection
    {
        $items = $this->get_settings_for_display('items');

        if (empty($items) || !is_array($items)) {
            return tdf_collect();
        }

        return tdf_collect($items);
    }

    private function addArrowStyleControls(): void
    {
        $this->add_control(
            'arrow_heading',
            [
                'label' => esc_html__('Arrow', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'arrow_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-accordion__arrow path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'arrow_hover_color',
            [
                'label' => esc_html__('Hover color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-accordion:hover .listivo-accordion__arrow path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'arrow_open_color',
            [
                'label' => esc_html__('Open color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-accordion--open.listivo-accordion--open .listivo-accordion__arrow path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .listivo-accordion--open.listivo-accordion--open:hover .listivo-accordion__arrow path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'arrow_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-accordion__arrow' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'arrow_hover_background',
            [
                'label' => esc_html__('Hover background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-accordion:hover .listivo-accordion__arrow' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'arrow_open_background',
            [
                'label' => esc_html__('Open background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-accordion.listivo-accordion--open .listivo-accordion__arrow' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-accordion.listivo-accordion--open:hover .listivo-accordion__arrow' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'arrow_border_color',
            [
                'label' => esc_html__('Border color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-accordion__arrow' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'arrow_border_hover_color',
            [
                'label' => esc_html__('Hover border color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-accordion:hover .listivo-accordion__arrow' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'arrow_border_open_color',
            [
                'label' => esc_html__('Open border color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-accordion.listivo-accordion--open .listivo-accordion__arrow' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-accordion.listivo-accordion--open:hover .listivo-accordion__arrow' => 'border-color: {{VALUE}};',
                ]
            ]
        );
    }

}