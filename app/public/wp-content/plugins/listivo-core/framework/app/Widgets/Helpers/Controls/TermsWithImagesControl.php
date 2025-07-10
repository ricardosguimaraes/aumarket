<?php


namespace Tangibledesign\Framework\Widgets\Helpers\Controls;


use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;

/**
 * Trait TermsWithImagesControl
 * @package Tangibledesign\Framework\Widgets\Helpers\Controls
 */
trait TermsWithImagesControl
{
    use Control;

    protected function addTermsWithImagesControls(): void
    {
        $this->addSelectTaxonomyControl();

        $this->addTermListControl();

        $this->addImageSizeControl();
    }

    private function addSelectTaxonomyControl(): void
    {
        $taxonomyOptions = $this->getTaxonomyOptions();

        $this->add_control(
            'twi_taxonomy',
            [
                'label' => tdf_admin_string('taxonomy'),
                'type' => Controls_Manager::SELECT,
                'options' => $taxonomyOptions,
                'default' => !empty($taxonomyOptions) ? key($taxonomyOptions) : null,
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
                'label' => tdf_admin_string('term'),
                'type' => SelectRemoteControl::TYPE,
                'source' => $taxonomyField->getApiEndpoint(),
            ]
        );

        $terms->add_control(
            'image',
            [
                'label' => tdf_admin_string('image'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'twi_list_' . $taxonomyField->getKey(),
            [
                'label' => tdf_admin_string('terms'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $terms->get_controls(),
                'condition' => [
                    'twi_taxonomy' => $taxonomyField->getKey(),
                ]
            ]
        );
    }

    private function addImageSizeControl(): void
    {
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'twi_image_size',
                'exclude' => ['custom'],
                'label' => tdf_admin_string('image_size'),
                'default' => 'full',
            ]
        );
    }

    /**
     * @return Collection
     */
    public function getTermList(): Collection
    {
        $taxonomyKey = (string)$this->get_settings_for_display('twi_taxonomy');
        if (empty($taxonomyKey)) {
            return tdf_collect();
        }

        $list = $this->get_settings_for_display('twi_list_' . $taxonomyKey);
        if (empty($list) || !is_array($list)) {
            return tdf_collect();
        }

        return tdf_collect($list)->map(static function ($item) {
            return [
                'term' => tdf_term_factory()->create((int)$item['term']),
                'image' => tdf_image_factory()->create((int)$item['image']['id']),
            ];
        })->filter(static function ($item) {
            return !empty($item['term']) && !empty($item['image']);
        });
    }

    /**
     * @return string
     */
    public function getImageSize(): string
    {
        return (string)$this->get_settings_for_display('twi_image_size_size');
    }

}