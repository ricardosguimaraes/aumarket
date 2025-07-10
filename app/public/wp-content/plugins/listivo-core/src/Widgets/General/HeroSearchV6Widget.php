<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Exception;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Search\SearchField;
use Tangibledesign\Framework\Search\SearchModels;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\PopularTermsControls;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SearchFields\SearchFieldsControl;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\FieldStyleSection;

class HeroSearchV6Widget extends BaseGeneralWidget
{
    use SearchFieldsControl;
    use PopularTermsControls;
    use FieldStyleSection;

    /**
     * @param $data
     * @param $args
     * @throws Exception
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);

        $this->registerMapDeps();
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'hero_search_v6';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Hero Search V6', 'listivo-core');
    }

    /**
     * @return array
     */
    public function get_script_depends(): array
    {
        return ['google-maps'];
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addHeadingControl();

        $this->addFirstImageControl();

        $this->addSecondImageControl();

        $this->addTaxonomyControl();

        $this->addLimitControl();

        $this->addRandomizeControls();

        $this->endControlsSection();

        $this->addSearchFormControls();

        $this->addStyleSection();

        $this->addFieldStyleSection();
    }

    private function addSearchFormControls(): void
    {
        $this->startContentControlsSection(
            'search_form',
            esc_html__('Search Form', 'listivo-core')
        );

        $this->addMainFieldControls();

        $fields = new Repeater();

        $this->addSearchFieldsControls($fields);

        $this->add_control(
            'fields',
            [
                'label' => esc_html__('Fields', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $fields->get_controls(),
                'prevent_empty' => false,
                'title_field' => "<# "
                    ."let labels = ".json_encode($this->getFieldOptions())."; "
                    ."let label = labels[field]; "
                    ."#>"
                    ."{{{ label }}}",
            ]
        );

        $this->endControlsSection();
    }

    /**
     * @return Collection|SearchField[]
     */
    public function getFields(): Collection
    {
        return $this->getSearchFields('fields');
    }

    private function addHeadingControl(): void
    {
        $this->add_control(
            'heading',
            [
                'label' => esc_html__('Heading', 'listivo-core'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );
    }

    /**
     * @return string
     */
    public function getHeading(): string
    {
        return (string)$this->get_settings_for_display('heading');
    }

    private function addFirstImageControl(): void
    {
        $this->add_control(
            'first_image',
            [
                'label' => esc_html__('First Image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );
    }

    /**
     * @return string
     */
    public function getFirstImage(): string
    {
        $image = $this->get_settings_for_display('first_image');
        return $image['url'] ?? '';
    }

    private function addSecondImageControl(): void
    {
        $this->add_control(
            'second_image',
            [
                'label' => esc_html__('Second Image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );
    }

    /**
     * @return string
     */
    public function getSecondImage(): string
    {
        $image = $this->get_settings_for_display('second_image');
        return $image['url'] ?? '';
    }

    /**
     * @return array
     */
    public function getTermCount(): array
    {
        return (new SearchModels())->getTermsCount();
    }

    private function addStyleSection(): void
    {
        $this->startStyleControlsSection();

        $this->add_control(
            'whats_popular_color',
            [
                'label' => esc_html__('Popular terms', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-hero-search-v6__popular-term' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-hero-search-v6__popular-terms' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'arrow_color',
            [
                'label' => esc_html__('Arrow color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-hero-search-v6__arrow path' => 'stroke: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'heading_heading',
            [
                'label' => esc_html__('Heading', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_responsive_control(
            'heading_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-hero-search-v6__heading' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-hero-search-v6__heading',
            ]
        );

        $this->endControlsSection();
    }

    protected function render(): void
    {
        parent::render();

        $this->renderCustomFieldStyles();
    }

}