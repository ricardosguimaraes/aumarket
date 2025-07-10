<?php

namespace Tangibledesign\Listivo\Widgets\General\Search;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Models\Field\LocationField;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\CardTypeControls;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\RowCardTypeControls;

abstract class BaseSearchWidget extends \Tangibledesign\Framework\Widgets\General\SearchWidget implements HasResults
{
    use CardTypeControls;
    use RowCardTypeControls;

    protected ?LocationField $locationField = null;

    /**
     * @var bool
     */
    protected $map = false;

    protected function addBasicSearchControls(): void
    {
        $this->addLimitControl(esc_html__('Listings Per Page', 'listivo-core'));

        $this->addHideSearchResultsBarControl();

        $this->addInitialViewControl();

        $this->addCardTypeControls();

        $this->addRowCardTypeControls();

        $this->addShowViewSelectorControl();

        $this->addGridControls();
    }

    protected function addHideSearchResultsBarControl(): void
    {
        $this->add_control(
            'hide_search_results_bar',
            [
                'label' => esc_html__('Hide Search Results Bar', 'listivo-core'),
                'label_block' => true,
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );
    }

    /**
     * @return bool
     */
    public function hideSearchResultsBar(): bool
    {
        return !empty($this->get_settings_for_display('hide_search_results_bar'));
    }

    protected function addInitialViewControl(): void
    {
        $this->add_control(
            'initial_view',
            [
                'label' => esc_html__('Initial View', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'card' => esc_html__('Card', 'listivo-core'),
                    'row' => esc_html__('Row', 'listivo-core'),
                ],
                'default' => 'row',
            ]
        );
    }

    protected function addShowViewSelectorControl(): void
    {
        $this->add_control(
            'show_view_selector',
            [
                'label' => esc_html__('Display View Selector (grid /list)', 'listivo-core'),
                'label_block' => true,
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );
    }

    /**
     * @return bool
     */
    public function showViewSelector(): bool
    {
        return !empty((int)$this->get_settings_for_display('show_view_selector'));
    }

    protected function addGridControls(): void
    {
        $this->add_responsive_control(
            'columns',
            [
                'label' => esc_html__('Columns (Cards)', 'listivo-core'),
                'type' => Controls_Manager::SELECT2,
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                ],
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-grid--cards' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
                ]
            ]
        );

        $this->add_responsive_control(
            'column_gap',
            [
                'label' => esc_html__('Column Gap (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-grid--cards' => 'grid-column-gap: {{VALUE}}px;'
                ]
            ]
        );

        $this->add_responsive_control(
            'row_gap',
            [
                'label' => esc_html__('Row Gap (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-grid--rows' => 'grid-row-gap: {{VALUE}}px;',
                    '{{WRAPPER}} .listivo-listing-grid--rows-v2' => 'grid-row-gap: {{VALUE}}px;',
                    '{{WRAPPER}} .listivo-listing-grid--cards' => 'grid-row-gap: {{VALUE}}px;',
                ]
            ]
        );
    }

    /**
     * @return string
     */
    protected function getTemplateFromUrl(): string
    {
        $view = $_GET[tdf_slug('view')] ?? '';

        if ($view === tdf_slug('row')) {
            return 'row';
        }

        if ($view === tdf_slug('card')) {
            return 'card';
        }

        return '';
    }

    /**
     * @return string
     */
    protected function getViewFromSettings(): string
    {
        $view = $this->get_settings_for_display('initial_view');
        if ($view === 'row') {
            return $view;
        }

        return 'card';
    }

    /**
     * @return string
     */
    public function getInitialTemplate(): string
    {
        $view = $this->getTemplateFromUrl();
        if (empty($view)) {
            $view = $this->getViewFromSettings();
        }

        if ($view === 'card') {
            return 'templates/partials/search_results_' . $this->getCardType();
        }

        return 'templates/partials/search_results_' . $this->getRowCardType();
    }

    /**
     * @return string
     */
    public function getCardTemplatePath(): string
    {
        return 'templates/partials/search_results_' . $this->getCardType();
    }

    /**
     * @return string
     */
    public function getRowCardTemplatePath(): string
    {
        return 'templates/partials/search_results_' . $this->getRowCardType();
    }


    protected function addPrimaryFieldsControls(): void
    {
        $this->add_control(
            'primary_fields_heading',
            [
                'label' => esc_html__('Primary fields', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_responsive_control(
            'primary_fields_padding',
            [
                'label' => esc_html__('Padding', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-main-search-form__primary-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_control(
            'primary_fields_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-main-search-form__primary-wrapper' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'primary_fields_col_gap',
            [
                'label' => esc_html__('Columns gap (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .listivo-main-search-form__primary' => 'grid-column-gap: {{VALUE}}px;',
                ]
            ]
        );

        $this->add_responsive_control(
            'primary_fields_row_gap',
            [
                'label' => esc_html__('Rows gap (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .listivo-main-search-form__primary' => 'grid-row-gap: {{VALUE}}px;',
                ]
            ]
        );
    }

    protected function addSecondaryFieldsControls(): void
    {
        $this->add_control(
            'secondary_fields_heading',
            [
                'label' => esc_html__('Secondary fields', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_responsive_control(
            'secondary_fields_padding',
            [
                'label' => esc_html__('Padding', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-main-search-form__secondary-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_control(
            'secondary_fields_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-main-search-form__secondary-wrapper' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'secondary_fields_col_gap',
            [
                'label' => esc_html__('Columns gap (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .listivo-main-search-form__secondary' => 'grid-column-gap: {{VALUE}}px;',
                ]
            ]
        );

        $this->add_responsive_control(
            'secondary_fields_row_gap',
            [
                'label' => esc_html__('Rows gap (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .listivo-main-search-form__secondary' => 'grid-row-gap: {{VALUE}}px;',
                ]
            ]
        );
    }

    protected function addResultsControls(): void
    {
        $this->add_control(
            'results_heading',
            [
                'label' => esc_html__('Results', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_responsive_control(
            'results_padding',
            [
                'label' => esc_html__('Padding', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-search-results' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_control(
            'results_number_color',
            [
                'label' => esc_html__('Results number', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-search-results__results-number' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'results_title_color',
            [
                'label' => esc_html__('Results title', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-search-results__title' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'results_description_heading',
            [
                'label' => esc_html__('Results Description', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'results_description_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-search-results__description' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'results_description_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-search-results__description',
            ]
        );
    }

}