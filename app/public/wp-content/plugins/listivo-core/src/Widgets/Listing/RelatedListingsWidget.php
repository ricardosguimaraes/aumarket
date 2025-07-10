<?php

namespace Tangibledesign\Listivo\Widgets\Listing;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\Term\Term;
use Tangibledesign\Framework\Widgets\Helpers\BaseModelSingleWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\LimitControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SearchFields\SortByControls;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\ButtonTypeControl;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\CardTypeControls;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\HighlightFeaturedListingsControl;
use Tangibledesign\Listivo\Widgets\Helpers\ListingCarousel;

class RelatedListingsWidget extends BaseModelSingleWidget
{
    use LimitControl;
    use ListingCarousel;
    use ButtonTypeControl;
    use HighlightFeaturedListingsControl;
    use CardTypeControls;
    use SortByControls;

    public function getKey(): string
    {
        return 'related_listings';
    }

    public function getName(): string
    {
        return esc_html__('Related Ads', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addHeadingControl();

        $this->addRelatedByControl();

        $this->addLimitControl();

        $this->addSortByControls(false);

        $this->addSlidesPerViewControl(4, 3, 1);

        $this->addCardTypeControls();

        $this->addShowFeaturedLabelControl();

        $this->addHighlightFeaturedListingsControl();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addHeadingStyleControls();

        $this->addNavigationControls();

        $this->addButtonStyleControls();

        $this->addButtonTypeControl('primary_2');

        $this->addMarginControl();

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    private function addRelatedByControl(): void
    {
        $options = $this->getRelatedByOptions();

        $this->add_control(
            'related_by',
            [
                'label' => esc_html__('Related by', 'listivo-core'),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $options,
            ]
        );
    }

    private function getRelatedByOptions(): array
    {
        $options = [];

        foreach (tdf_taxonomy_fields() as $taxonomyField) {
            $options[$taxonomyField->getId()] = $taxonomyField->getName();
        }

        return $options;
    }

    /**
     * @return Collection|Model[]
     */
    public function getListings(): Collection
    {
        $listing = $this->getModel();

        $query = tdf_query_models()
            ->take($this->getLimit())
            ->setTaxQuery($this->getTaxQuery())
            ->orderBy($this->getInitialSortBy());

        if ($listing) {
            $query->notIn($listing->getId());
        }

        return $query->get();
    }

    /**
     * @return Collection|TaxonomyField[]
     */
    private function getRelatedByFields(): Collection
    {
        $fields = $this->get_settings_for_display('related_by');

        if (!is_array($fields) || empty($fields)) {
            return tdf_collect();
        }

        return tdf_collect($fields)->map(static function ($fieldId) {
            $fieldId = (int) $fieldId;

            return tdf_taxonomy_fields()->find(static function ($taxonomyField) use ($fieldId) {
                /* @var TaxonomyField $taxonomyField */
                return $taxonomyField->getId() === $fieldId;
            });
        })->filter(static function ($taxonomyField) {
            return $taxonomyField !== false && $taxonomyField !== null;
        });
    }

    private function getTaxQuery(): array
    {
        $listing = $this->getModel();
        if (!$listing) {
            return [];
        }

        $taxQuery = [];

        foreach ($this->getRelatedByFields() as $taxonomyField) {
            $taxQuery[] = [
                'taxonomy' => $taxonomyField->getKey(),
                'field' => 'term_id',
                'operator' => 'IN',
                'terms' => $taxonomyField->getValue($listing)->map(static function ($term) {
                    /* @var Term $term */
                    return $term->getId();
                })->values()
            ];
        }

        return $taxQuery;
    }

    private function addMarginControl(): void
    {
        $this->add_responsive_control(
            'widget_margin',
            [
                'label' => esc_html__('Margin', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-carousel' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
    }

    private function addButtonStyleControls(): void
    {
        $this->add_control(
            'button_heading',
            [
                'label' => esc_html__('Button', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-simple-button' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'button_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-simple-button' => 'background-color: {{VALUE}};',
                ]
            ]
        );
    }

    private function addHeadingStyleControls(): void
    {
        $this->add_control(
            'label_heading',
            [
                'label' => esc_html__('Label', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-carousel__label' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'label_typography',
                'selector' => '{{WRAPPER}} .listivo-listing-carousel__label',
            ]
        );
    }

    private function addNavigationControls(): void
    {
        $this->add_control(
            'navigation_heading',
            [
                'label' => esc_html__('Navigation', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'navigation_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-box-arrow path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'navigation_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-box-arrow' => 'background-color: {{VALUE}};',
                ]
            ]
        );
    }

}