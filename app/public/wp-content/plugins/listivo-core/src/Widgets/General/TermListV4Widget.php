<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;

class TermListV4Widget extends BaseGeneralWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'term_list_v4';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Term list V4', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addTermsControl();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addHoverBackgroundControl();

        $this->addInvertIconColorControl();

        $this->addTextControls();

        $this->endControlsSection();
    }

    private function addTermsControl(): void
    {
        $terms = new Repeater();

        $terms->add_control(
            'image',
            [
                'label' => esc_html__('Icon', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $terms->add_control(
            'taxonomy',
            [
                'label' => esc_html__('Taxonomy', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => tdf_app('taxonomy_list'),
            ]
        );

        foreach (tdf_taxonomy_fields() as $taxonomyField) {
            $terms->add_control(
                'term_'.$taxonomyField->getKey(),
                [
                    'label' => esc_html__('Term', 'listivo-core'),
                    'type' => SelectRemoteControl::TYPE,
                    'source' => $taxonomyField->getApiEndpoint(),
                    'multiple' => false,
                    'condition' => [
                        'taxonomy' => $taxonomyField->getKey(),
                    ]
                ]
            );
        }

        $this->add_control(
            'terms',
            [
                'label' => esc_html__('Terms', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $terms->get_controls(),
                'prevent_empty' => false,
            ]
        );
    }

    /**
     * @return Collection
     */
    public function getTerms(): Collection
    {
        $tabs = $this->get_settings_for_display('terms');

        if (empty($tabs) || !is_array($tabs)) {
            return tdf_collect();
        }

        return tdf_collect($tabs)
            ->map(static function ($tab) {
                $taxonomyKey = $tab['taxonomy'];
                if (empty($taxonomyKey)) {
                    return false;
                }

                $termId = (int)$tab['term_'.$taxonomyKey];
                if (empty($termId)) {
                    return false;
                }

                $term = tdf_term_factory()->create($termId);
                if (!$term) {
                    return false;
                }

                return [
                    'image' => $tab['image']['url'] ?? '',
                    'label' => $term->getName(),
                    'url' => $term->getUrl(),
                ];
            })
            ->filter(static function ($term) {
                return $term !== false && $term !== null;
            });
    }

    private function addHoverBackgroundControl(): void
    {
        $this->add_control(
            'hover_background',
            [
                'label' => esc_html__('Hover background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-terms-v2__term:hover' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
                ]
            ]
        );
    }

    private function addInvertIconColorControl(): void
    {
        $this->add_control(
            'invert_icon_color',
            [
                'label' => esc_html__('Invert image color', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );
    }

    /**
     * @return bool
     */
    public function invertIconColor(): bool
    {
        return !empty((int)$this->get_settings_for_display('invert_icon_color'));
    }

    private function addTextControls(): void
    {
        $this->add_control(
            'text_heading',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-terms-v2__term' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'text_hover_color',
            [
                'label' => esc_html__('Hover color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-terms-v2__term:hover' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-terms-v2__term',
            ]
        );
    }

}