<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Exception;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Term\CustomTerm;
use Tangibledesign\Framework\Search\SearchField;
use Tangibledesign\Framework\Search\SearchModels;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\PopularTermsControls;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SearchFields\SearchFieldsControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SimpleLabelControl;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\FieldStyleSection;

class HeroSearchV4Widget extends BaseGeneralWidget
{
    use SearchFieldsControl;
    use PopularTermsControls;
    use SimpleLabelControl;
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
        return 'hero_search_v4';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Hero Search V4', 'listivo-core');
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

        $this->addImagesControls();

        $this->addHideDecorationsControls();

        $this->addHideArrowControl();

        $this->endControlsSection();

        $this->startContentControlsSection(
            'listivo_hero_v4_search_form',
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

        $this->startContentControlsSection('popular_terms', esc_html__('Popular Terms', 'listivo-core'));

        $this->addLabelControl(esc_html__("What's popular:", 'listivo-core'));

        $this->addTaxonomyControl();

        $this->addLimitControl('', 4);

        $this->addRandomizeControls();

        $this->endControlsSection();

        $this->addStyleSections();

        $this->addWhatsPopularStyleSection();
    }

    private function addStyleSections(): void
    {
        $this->startStyleControlsSection(
            'listivo_hero_v4_heading',
            esc_html__('Heading', 'listivo-core')
        );

        $this->add_control(
            'heading_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-hero-search-v4__heading h1' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-hero-search-v4__heading h1',
            ]
        );

        $this->endControlsSection();

        $this->addFieldStyleSection();
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
        $heading = $this->get_settings_for_display('heading');
        if (empty($heading)) {
            return '';
        }

        return $heading;
    }

    private function addImagesControls(): void
    {
        $this->add_control(
            'main_image',
            [
                'label' => esc_html__('Main Image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'top_image',
            [
                'label' => esc_html__('Top Image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'bottom_image',
            [
                'label' => esc_html__('Bottom Image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );
    }

    /**
     * @return string
     */
    public function getMainImage(): string
    {
        $data = $this->get_settings_for_display('main_image');

        return $data['url'] ?? '';
    }

    /**
     * @return string
     */
    public function getTopImage(): string
    {
        $data = $this->get_settings_for_display('top_image');

        return $data['url'] ?? '';
    }

    /**
     * @return string
     */
    public function getBottomImage(): string
    {
        $data = $this->get_settings_for_display('bottom_image');

        return $data['url'] ?? '';
    }

    /**
     * @return array
     */
    public function getTermCount(): array
    {
        return (new SearchModels())->getTermsCount();
    }

    /**
     * @return Collection|SearchField[]
     */
    public function getFields(): Collection
    {
        return $this->getSearchFields('fields');
    }

    /**
     * @param  CustomTerm  $term
     * @return array[]
     */
    public function getInitialFilters(CustomTerm $term): array
    {
        return [
            [
                'key' => $term->getTaxonomyKey(),
                'values' => [$term->getId()],
                'type' => 'taxonomy',
            ]
        ];
    }

    private function addHideDecorationsControls(): void
    {
        $this->add_control(
            'hide_decorations',
            [
                'label' => esc_html__('Hide Decorations', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listivo-core'),
                'label_off' => esc_html__('No', 'listivo-core'),
                'return_value' => '1',
                'default' => '0',
            ]
        );
    }

    private function addHideArrowControl(): void
    {
        $this->add_control(
            'hide_arrow',
            [
                'label' => esc_html__('Hide Arrow', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listivo-core'),
                'label_off' => esc_html__('No', 'listivo-core'),
                'return_value' => '1',
                'default' => '0',
            ]
        );
    }

    public function hideArrow(): bool
    {
        return !empty((int)$this->get_settings_for_display('hide_arrow'));
    }

    public function hideDecorations(): bool
    {
        return !empty((int)$this->get_settings_for_display('hide_decorations'));
    }

    private function addWhatsPopularStyleSection(): void
    {
        $this->startStyleControlsSection(
            'listivo_hero_v4_whats_popular',
            esc_html__('What\'s Popular', 'listivo-core')
        );

        $this->add_control(
            'popular_terms_label',
            [
                'label' => esc_html__('Label', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'popular_terms_label_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-hero-search-v4__popular-terms span' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'popular_terms_label_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-hero-search-v4__popular-terms span',
            ]
        );

        $this->add_control(
            'popular_terms_heading',
            [
                'label' => esc_html__('Terms', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'popular_terms_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-hero-search-v4__popular-terms a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'popular_terms_hover_color',
            [
                'label' => esc_html__('Hover Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-hero-search-v4__popular-terms a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'popular_terms_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-hero-search-v4__popular-terms a',
            ]
        );

        $this->endControlsSection();
    }

}