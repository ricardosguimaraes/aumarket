<?php


namespace Tangibledesign\Listivo\Widgets\General;


use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;

class MainCategoriesV2Widget extends BaseGeneralWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'main_categories_v2';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Main Categories V2', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addSelectTaxonomyControl();

        $this->addTermListControl();

        $this->endControlsSection();
    }

    private function addSelectTaxonomyControl(): void
    {
        $taxonomyOptions = $this->getTaxonomyOptions();

        $this->add_control(
            'taxonomy',
            [
                'label' => esc_html__('Taxonomy', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => $taxonomyOptions,
            ]
        );
    }

    /**
     * @return array
     */
    private function getTaxonomyOptions(): array
    {
        $taxonomies = [];

        foreach (tdf_taxonomy_fields() as $taxonomyField) {
            $taxonomies[$taxonomyField->getKey()] = $taxonomyField->getName();
        }

        return $taxonomies;
    }

    private function addTermListControl(): void
    {
        foreach (tdf_taxonomy_fields() as $taxonomyField) {
            $this->addTermsListControl($taxonomyField);
        }
    }

    /**
     * @param TaxonomyField $taxonomyField
     */
    protected function addTermsListControl(TaxonomyField $taxonomyField): void
    {
        $terms = new Repeater();

        $terms->add_control(
            'term',
            [
                'label' => esc_html__('Term', 'listivo-core'),
                'type' => SelectRemoteControl::TYPE,
                'source' => $taxonomyField->getApiEndpoint(),
            ]
        );

        $terms->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'listivo-core'),
                'type' => Controls_Manager::ICONS,
            ]
        );

        $terms->add_control(
            'background_color',
            [
                'label' => esc_html__('Background Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
            ]
        );

        $terms->add_control(
            'pattern_location',
            [
                'label' => esc_html__('Pattern Location', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'left_top' => esc_html__('Left-Top', 'listivo-core'),
                    'right_top' => esc_html__('Right-Top', 'listivo-core'),
                    'right_bottom' => esc_html__('Right-Bottom', 'listivo-core'),
                    'left_bottom' => esc_html__('Left-Bottom', 'listivo-core'),
                    'none' => esc_html__('None', 'listivo-core'),
                ],
                'default' => 'left_top',
            ]
        );

        $this->add_control(
            'list_' . $taxonomyField->getKey(),
            [
                'label' => esc_html__('Terms', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $terms->get_controls(),
                'condition' => [
                    'taxonomy' => $taxonomyField->getKey(),
                ]
            ]
        );
    }

    /**
     * @return array
     */
    public function getCategories(): array
    {
        $taxonomyKey = $this->get_settings_for_display('taxonomy');
        if (empty($taxonomyKey)) {
            return [];
        }

        $terms = $this->get_settings_for_display('list_' . $taxonomyKey);
        if (empty($terms) || !is_array($terms)) {
            return [];
        }

        return tdf_collect($terms)
            ->map(function ($item) {
                $item['term'] = tdf_term_factory()->create((int)$item['term']);
                $item['icon_class'] = $this->getPatternLocationClass($item['pattern_location'] ?? '');

                return $item;
            })
            ->filter(static function ($item) {
                return !empty($item['term']);
            })
            ->values();
    }

    /**
     * @param string $option
     * @return string
     */
    private function getPatternLocationClass(string $option): string
    {
        if ($option === 'left_top') {
            return 'listivo-main-category__icon-m--left-top';
        }

        if ($option === 'right_top') {
            return 'listivo-main-category__icon-m--right-top';
        }

        if ($option === 'right_bottom') {
            return 'listivo-main-category__icon-m--right-bottom';
        }

        if ($option === 'left_bottom') {
            return 'listivo-main-category__icon-m--left-bottom';
        }

        return '';
    }

}