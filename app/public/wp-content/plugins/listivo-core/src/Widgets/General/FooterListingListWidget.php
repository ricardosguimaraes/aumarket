<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\GalleryFieldControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\IncludeExcludedControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\LimitControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\PriceFieldControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SearchFields\SortByControls;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextColorControl;

class FooterListingListWidget extends BaseGeneralWidget
{
    use PriceFieldControl;
    use GalleryFieldControl;
    use LimitControl;
    use TextColorControl;
    use IncludeExcludedControl;
    use SortByControls;

    public const TAXONOMY_FIELD = 'taxonomy_field';

    public function getKey(): string
    {
        return 'footer_listing_list';
    }

    public function getName(): string
    {
        return esc_html__('Mini Listings', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->addContentSection();

        $this->addStyleSection();
    }

    private function addContentSection(): void
    {
        $this->startContentControlsSection();

        $this->addLimitControl('', 4);

        $this->addSortByControls(false);

        $this->addPriceFieldControl();

        $this->addGalleryFieldControl();

        $this->addIncludeExcludedControl();

        $this->endControlsSection();
    }

    private function addStyleSection(): void
    {
        $this->startStyleControlsSection();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Title Typography', 'listivo-core'),
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .listivo-mini-listings__title',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-mini-listings__title' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Price Typography', 'listivo-core'),
                'name' => 'price_typography',
                'selector' => '{{WRAPPER}} .listivo-mini-listings__price',
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label' => esc_html__('Price Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-mini-listings__price' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('In Typography', 'listivo-core'),
                'name' => 'in_typography',
                'selector' => '{{WRAPPER}} .listivo-mini-listings__in',
            ]
        );

        $this->add_control(
            'in_color',
            [
                'label' => esc_html__('In Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-mini-listings__in' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Category Typography', 'listivo-core'),
                'name' => 'category_typography',
                'selector' => '{{WRAPPER}} .listivo-mini-listings__categories a',
            ]
        );

        $this->add_control(
            'category_color',
            [
                'label' => esc_html__('Category Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-mini-listings__categories a' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->endControlsSection();
    }

    public function getListings(): Collection
    {
        $query = tdf_query_models()
            ->take($this->getLimit());

        if (!$this->includeExcluded()) {
            $query->notIn(tdf_app('models_excluded_from_search'));
        }

        $query->orderBy($this->getSlug($this->getOrderBy()));

        return $query->get();
    }

    public function getOrderBy(): string
    {
        $orderBy = $this->get_settings_for_display('sort_by_initial');
        if (empty($orderBy)) {
            return 'newest';
        }

        return $orderBy;
    }

    /**
     * @return TaxonomyField|false
     */
    public function getTaxonomyField()
    {
        $taxonomyKey = (string)$this->get_settings_for_display(self::TAXONOMY_FIELD);
        if (empty($taxonomyKey)) {
            return false;
        }

        return tdf_taxonomy_fields()->find(static function ($taxonomy) use ($taxonomyKey) {
            /* @var TaxonomyField $taxonomy */
            return $taxonomy->getKey() === $taxonomyKey;
        });
    }

}