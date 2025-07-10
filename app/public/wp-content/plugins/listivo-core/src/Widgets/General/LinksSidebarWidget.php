<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SimpleLabelControl;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;

class LinksSidebarWidget extends BaseGeneralWidget
{
    use SimpleLabelControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'links_sidebar';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Links Sidebar', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addLabelControl();

        $this->addLinksControl();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addLinksStyleControls();

        $this->endControlsSection();
    }

    private function addLinksControl(): void
    {
        $links = new Repeater();

        $links->add_control(
            'label',
            [
                'label' => esc_html__('Label', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $links->add_control(
            'destination',
            [
                'label' => tdf_admin_string('destination'),
                'type' => SelectRemoteControl::TYPE,
                'source' => tdf_action_url(tdf_prefix() . '/button/destinations')
            ]
        );

        $this->add_control(
            'links',
            [
                'label' => esc_html__('Links', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $links->get_controls(),
                'prevent_empty' => false,
            ]
        );
    }

    /**
     * @return Collection
     */
    public function getLinks(): Collection
    {
        $links = $this->get_settings_for_display('links');
        if (empty($links) || !is_array($links)) {
            return tdf_collect();
        }

        return tdf_collect($links)->map(static function ($link) {
            $link['url'] = apply_filters(
                tdf_prefix() . '/button/destination',
                false,
                $link['destination']
            );

            return $link;
        });
    }

    private function addLinksStyleControls(): void
    {
        $this->add_control(
            'link_heading',
            [
                'label' => esc_html__('Link', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'link_typography',
                'selector' => '{{WRAPPER}} .listivo-sidebar-list__label',
            ]
        );

        $this->add_control(
            'link_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-sidebar-list__label' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'link_hover_color',
            [
                'label' => esc_html__('Hover color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-sidebar-list__label:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-sidebar-list__label:hover:before' => 'background-color: {{VALUE}};',
                ]
            ]
        );
    }

}