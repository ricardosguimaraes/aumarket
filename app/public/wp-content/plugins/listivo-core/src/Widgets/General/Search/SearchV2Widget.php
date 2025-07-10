<?php

namespace Tangibledesign\Listivo\Widgets\General\Search;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Search\SearchField;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\FieldStyleSection;

class SearchV2Widget extends BaseSearchWidget implements HasSidebarFields, HasPrimaryFields
{
    use ViewSelectorStyleSection;
    use SearchFiltersControls;
    use FieldStyleSection;

    public function getKey(): string
    {
        return 'search_v2';
    }

    public function getName(): string
    {
        return esc_html__('Search V2', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addStickySidebarControl();

        $this->addBasicSearchControls();

        $this->addShowSearchFiltersControl();

        $this->endControlsSection();

        $this->addPrimaryFieldsSection();

        $this->addSidebarFieldsSection();

        $this->addSortBySection();

        $this->addGeneralStyleSection();

        $this->addSidebarStyleSection();

        $this->addViewSelectorStyleSection();

        $this->addSearchFilterStyleSection();

        $this->addFieldStyleSection();
    }

    private function addPrimaryFieldsSection(): void
    {
        $this->startContentControlsSection('primary_fields_section', esc_html__('Primary fields', 'listivo-core'));

        $fields = new Repeater();

        $this->addSearchFieldsControls($fields);

        $this->add_control(
            'primary_fields',
            [
                'label' => esc_html__('Fields', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $fields->get_controls(),
                'prevent_empty' => false,
                'title_field' => "<# "
                    . "let labels = " . json_encode($this->getFieldOptions()) . "; "
                    . "let label = labels[field]; "
                    . "#>"
                    . "{{{ label }}}",
            ]
        );

        $this->endControlsSection();
    }

    private function addSidebarFieldsSection(): void
    {
        $this->startContentControlsSection('sidebar_fields_section', esc_html__('Sidebar fields', 'listivo-core'));

        $fields = new Repeater();

        $fields->add_control(
            'field',
            [
                'label' => tdf_admin_string('field'),
                'type' => Controls_Manager::SELECT,
                'options' => $this->getFieldOptions(),
            ]
        );

        $this->addTaxonomyFieldSettings($fields, true);

        $this->addNumberFieldSettings($fields, true);

        $this->addPriceFieldSettings($fields, true);

        $this->addTextFieldSettings($fields);

        $this->addLocationFieldSettings($fields);

        $this->addKeywordFieldSettings($fields);

        $this->add_control(
            'sidebar_fields',
            [
                'label' => esc_html__('Fields', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $fields->get_controls(),
                'prevent_empty' => false,
                'title_field' => "<# "
                    . "let labels = " . json_encode($this->getFieldOptions()) . "; "
                    . "let label = labels[field]; "
                    . "#>"
                    . "{{{ label }}}",
            ]
        );

        $this->endControlsSection();
    }

    /**
     * @return Collection|SearchField[]
     */
    public function getSidebarFields(): Collection
    {
        return $this->getSearchFields('sidebar_fields');
    }

    /**
     * @return Collection|SearchField[]
     */
    public function getPrimaryFields(): Collection
    {
        return $this->getSearchFields('primary_fields');
    }

    private function addSidebarStyleSection(): void
    {
        $this->startStyleControlsSection('search_sidebar_style', esc_html__('Sidebar', 'listivo-core'));

        $this->add_control(
            'sidebar_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-search-sidebar' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'sidebar_border_color',
            [
                'label' => esc_html__('Border color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-search-sidebar' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'sidebar_active_option_color',
            [
                'label' => esc_html__('Active option', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-search-sidebar .listivo-checkbox--checked' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-search-sidebar .listivo-radio--active' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-search-sidebar .listivo-radio--active:before' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-search-sidebar .listivo-search-panel__item:hover .listivo-radio' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-search-sidebar .listivo-search-panel__item:hover .listivo-search-panel__item-label' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-search-sidebar .listivo-search-panel__item--active .listivo-search-panel__item-label' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-search-sidebar .listivo-search-panel__term-item-icon path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .listivo-search-sidebar .listivo-search-panel__term-item span' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-search-sidebar .listivo-search-panel__term-item span:before' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'sidebar_field_label_heading',
            [
                'label' => esc_html__('Field label', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'sidebar_field_label_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-search-panel__label' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'sidebar_field_label_typo',
                'selector' => '{{WRAPPER}} .listivo-search-panel__label',
            ]
        );

        $this->add_control(
            'sidebar_field_dot_heading',
            [
                'label' => esc_html__('Label dot', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'sidebar_field_dot_color',
            [
                'label' => esc_html__('Inactive', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-search-panel__circle:not(.listivo-search-panel__circle--active)' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'sidebar_field_dot_active_color',
            [
                'label' => esc_html__('Active', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-search-panel__circle--active' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'sidebar_field_count_heading',
            [
                'label' => esc_html__('Field count', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'sidebar_field_count_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-search-panel__item-count' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'sidebar_field_count_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-search-panel__item-count' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->endControlsSection();
    }

    private function addGeneralStyleSection(): void
    {
        $this->startStyleControlsSection();

        $this->addPrimaryFieldsControls();

        $this->addResultsControls();

        $this->endControlsSection();
    }

    protected function render(): void
    {
        parent::render();

        $this->renderCustomFieldStyles();
    }

    private function addStickySidebarControl(): void
    {
        $this->add_control(
            'sticky_sidebar',
            [
                'label' => esc_html__('Sticky Sidebar', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );
    }

    public function isStickySidebar(): bool
    {
        return !empty((int)$this->get_settings_for_display('sticky_sidebar'));
    }
}