<?php

namespace Tangibledesign\Listivo\Widgets\PrintModel;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Term\CustomTerm;
use Tangibledesign\Framework\Widgets\Helpers\Controls\MarginControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SimpleLabelControl;

class PrintListingFeaturesWidget extends BasePrintModelWidget
{
    use SimpleLabelControl;
    use MarginControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'print_listing_features';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Listing Features', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addLabelControl();

        $this->addTaxonomyControl();

        $this->addMarginControl('.listivo-print-features');

        $this->endControlsSection();
    }

    private function addTaxonomyControl(): void
    {
        $options = $this->getTaxonomyOptions();

        $this->add_control(
            'taxonomy',
            [
                'label' => esc_html__('Taxonomy', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => $options,
                'default' => !empty($options) ? key($options) : null,
            ]
        );
    }

    /**
     * @return array
     */
    private function getTaxonomyOptions(): array
    {
        $options = [];

        foreach (tdf_taxonomy_fields() as $taxonomy) {
            $options[$taxonomy->getKey()] = $taxonomy->getName();
        }

        return $options;
    }

    /**
     * @return Collection|CustomTerm[]
     */
    public function getTerms(): Collection
    {
        $listing = $this->getModel();
        $taxonomy = $this->getTaxonomy();
        if (!$listing || !$taxonomy) {
            return tdf_collect();
        }

        return $taxonomy->getValue($listing);
    }

    /**
     * @return TaxonomyField|false
     */
    private function getTaxonomy()
    {
        $taxonomyKey = $this->get_settings_for_display('taxonomy');
        if (empty($taxonomyKey)) {
            return false;
        }

        return tdf_taxonomy_fields()->find(static function ($taxonomy) use ($taxonomyKey) {
            /* @var TaxonomyField $taxonomy */
            return $taxonomy->getKey() === $taxonomyKey;
        });
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return (string)$this->get_settings_for_display('label');
    }

}