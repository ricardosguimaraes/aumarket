<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Image;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;

class HeroSearchV2Widget extends SearchFormWidget
{
    public const HEADING = 'heading';
    public const BACKGROUND_IMAGE = 'background_image';

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'hero_search_v2';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Hero Search V2', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addHeadingControl();

        $this->addBackgroundImageControl();

        $this->addFieldsControl();

        $this->addCategoriesHeading();

        $this->addSelectTaxonomyControl();

        $this->addTermListControl();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addHeightControl();

        $this->addWidthControl();

        $this->addSearchFormMarginControl();

        $this->addHeadingStyleControls();

        $this->endControlsSection();

        $this->startStyleControlsSection('image_mask_style', esc_html__('Image Mask', 'listivo-core'));

        $this->addMaskControls();

        $this->endControlsSection();
    }

    private function addHeadingStyleControls(): void
    {
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_type',
                'label' => esc_html__('Heading Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-hero-search-v2__heading',
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label' => esc_html__('Heading Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-hero-search-v2__heading' => 'color: {{VALUE}};'
                ]
            ]
        );
    }

    private function addSearchFormMarginControl(): void
    {
        $this->add_responsive_control(
            'content_margin',
            [
                'label' => esc_html__('Content Margin (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .listivo-hero-search-v2__content' => 'margin-top: {{VALUE}}px;'
                ]
            ]
        );
    }

    private function addMaskControls(): void
    {
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'mask_background',
                'label' => esc_html__('Mask', 'listivo-core'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .listivo-hero-search-v2__mask',
            ]
        );
    }

    private function addCategoriesHeading(): void
    {
        $this->add_control(
            'categories_heading',
            [
                'label' => esc_html__('Categories', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );
    }

    private function addHeadingControl(): void
    {
        $this->add_control(
            self::HEADING,
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
        return (string)$this->get_settings_for_display(self::HEADING);
    }

    public function addBackgroundImageControl(): void
    {
        $this->add_control(
            self::BACKGROUND_IMAGE,
            [
                'label' => esc_html__('Background Image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );
    }

    /**
     * @return Image|false
     */
    public function getBackgroundImage()
    {
        $image = $this->get_settings_for_display(self::BACKGROUND_IMAGE);
        if (empty($image['id'])) {
            return false;
        }

        return tdf_image_factory()->create((int)$image['id']);
    }

    private function addWidthControl(): void
    {
        $this->add_control(
            'width',
            [
                'label' => esc_html__('Search Form Width', 'listivo-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-search' => 'max-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .listivo-hero-search-v2__search-form' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
                'default' => [
                    'size' => 895,
                    'unit' => 'px'
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000,
                    ],
                ],
            ]
        );
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
                'label' => esc_html__('SVG Icon Code', 'listivo-core'),
                'type' => Controls_Manager::TEXTAREA,
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

                return $item;
            })
            ->filter(static function ($item) {
                return !empty($item['term']);
            })
            ->values();
    }

    public function addHeightControl(): void
    {
        $this->add_responsive_control(
            'height',
            [
                'label' => esc_html__('Section Height', 'listivo-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 800,
                ],
                'tablet_default' => [
                    'unit' => 'px',
                    'size' => 1000,
                ],
                'mobile_default' => [
                    'unit' => 'px',
                    'size' => 1000,
                ],
                'selectors' => [
                    '{{WRAPPER}} .listivo-hero-search-v2' => 'height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
    }

}