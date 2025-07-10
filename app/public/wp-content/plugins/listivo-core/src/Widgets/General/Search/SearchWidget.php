<?php

namespace Tangibledesign\Listivo\Widgets\General\Search;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Search\SearchField;
use Tangibledesign\Framework\Widgets\Helpers\HasUser;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\FieldStyleSection;

class SearchWidget extends BaseSearchWidget
{
    use FieldStyleSection;
    use ViewSelectorStyleSection;
    use SearchFiltersControls;

    public const PRIMARY_FIELDS = 'primary_fields';
    public const SECONDARY_FIELDS = 'secondary_fields';

    public function getKey(): string
    {
        return 'search';
    }

    public function getName(): string
    {
        return esc_html__('Search', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->addGeneralSection();

        $this->addSearchFieldsSection();

        $this->addSortBySection();

        $this->addGeneralStyleSection();

        $this->addHeadingStyleSection();

        $this->addViewSelectorStyleSection();

        $this->addFormStyleSection();

        $this->addFieldStyleSection('.listivo-main-search-form');
    }

    private function addSearchFieldsSection(): void
    {
        $this->startContentControlsSection('search_fields_section', esc_html__('Search Fields', 'listivo-core'));

        $this->addMainFieldsControl();

        $this->addSecondaryFields();

        $this->endControlsSection();
    }

    protected function addGeneralSection(): void
    {
        $this->startContentControlsSection();

        $this->addBasicSearchControls();

        $this->addShowSearchFiltersControl();

        $this->endControlsSection();
    }

    private function addMainFieldsControl(): void
    {
        $mainFields = new Repeater();

        $this->addSearchFieldsControls($mainFields);

        $this->add_control(
            self::PRIMARY_FIELDS,
            [
                'label' => esc_html__('Primary Fields', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $mainFields->get_controls(),
                'prevent_empty' => false,
                'title_field' => "<# "
                    ."let labels = ".json_encode($this->getFieldOptions())."; "
                    ."let label = labels[field]; "
                    ."#>"
                    ."{{{ label }}}",
            ]
        );
    }

    /**
     * @return Collection|SearchField[]
     */
    public function getPrimaryFields()
    {
        return $this->getSearchFields(self::PRIMARY_FIELDS);
    }

    private function addSecondaryFields(): void
    {
        $secondaryFields = new Repeater();

        $this->addSearchFieldsControls($secondaryFields);

        $this->add_control(
            self::SECONDARY_FIELDS,
            [
                'label' => esc_html__('Secondary Fields', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $secondaryFields->get_controls(),
                'prevent_empty' => false,
                'title_field' => "<# "
                    ."let labels = ".json_encode($this->getFieldOptions())."; "
                    ."let label = labels[field]; "
                    ."#>"
                    ."{{{ label }}}",
            ]
        );
    }

    /**
     * @return Collection|SearchField[]
     */
    public function getSecondaryFields()
    {
        return $this->getSearchFields(self::SECONDARY_FIELDS);
    }

    public function getMarkers(): array
    {
        return $this->markers;
    }

    protected function addFormStyleSection(): void
    {
        $this->startStyleControlsSection('form_style', esc_html__('Form', 'listivo-core'));

        $this->add_control(
            'form_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-main-search-form' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'form_padding',
            [
                'label' => esc_html__('Padding', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-main-search-form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->endControlsSection();
    }

    protected function render(): void
    {
        parent::render();

        $this->renderCustomFieldStyles();
    }

    private function addHeadingStyleSection(): void
    {
        $this->startStyleControlsSection('heading_style_section', esc_html__('Heading', 'listivo-core'));

        $this->add_control(
            'heading_heading',
            [
                'label' => esc_html__('Heading', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-search-results__title' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'heading_typography',
                'selector' => '{{WRAPPER}} .listivo-search-results__title',
            ]
        );

        $this->endControlsSection();
    }

    private function addGeneralStyleSection(): void
    {
        $this->startStyleControlsSection();

        $this->addPrimaryFieldsControls();

        $this->addSecondaryFieldsControls();

        $this->addResultsControls();

        $this->endControlsSection();
    }
}