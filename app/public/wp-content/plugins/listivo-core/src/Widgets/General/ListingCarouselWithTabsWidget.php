<?php


namespace Tangibledesign\Listivo\Widgets\General;


use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Term\Term;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\IncludeExcludedControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\LimitControl;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\CardTypeControl;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\HeadingControls;

/**
 * Class ListingCarouselWithTabsWidget
 * @package Tangibledesign\Listivo\Widgets\General
 */
class ListingCarouselWithTabsWidget extends BaseGeneralWidget
{
    use HeadingControls;
    use LimitControl;
    use IncludeExcludedControl;
    use CardTypeControl;

    public const TYPE = 'type';
    public const TYPE_ALL = 'all';
    public const TYPE_MOST_POPULAR = 'most_popular';
    public const TYPE_RECENTLY_VIEWED = 'recently_viewed';

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'listing_carousel_with_tabs';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Listing Carousel With Tabs', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addHeadingControls();

        $this->addLimitControl('', 12);

        $this->addCardTypeControl();

        $this->addCategoriesControl();

        $this->addIncludeExcludedControl();

        $this->endControlsSection();
    }

    private function addCategoriesControl(): void
    {
        $categories = new Repeater();

        $categories->add_control(
            self::TYPE,
            [
                'label' => esc_html__('Type', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => $this->getCategoryOptions(),
                'default' => self::TYPE_ALL,
            ]
        );

        foreach (tdf_taxonomy_fields() as $taxonomyField) {
            $categories->add_control(
                'terms_' . $taxonomyField->getKey(),
                [
                    'label' => esc_html__('Taxonomy', 'listivo-core'),
                    'type' => SelectRemoteControl::TYPE,
                    'source' => $taxonomyField->getApiEndpoint(),
                    'multiple' => true,
                    'condition' => [
                        'type' => $taxonomyField->getKey(),
                    ]
                ]
            );
        }

        $this->add_control(
            'categories',
            [
                'label' => esc_html__('Categories', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $categories->get_controls(),
            ]
        );
    }

    /**
     * @return array
     */
    private function getCategoryOptions(): array
    {
        $options = [
            self::TYPE_ALL => esc_html__('All', 'listivo-core'),
            self::TYPE_MOST_POPULAR => esc_html__('Most Popular', 'listivo core'),
            self::TYPE_RECENTLY_VIEWED => esc_html__('Recently Viewed', 'listivo-core'),
        ];

        foreach (tdf_taxonomy_fields() as $taxonomyField) {
            $options[$taxonomyField->getKey()] = $taxonomyField->getName();
        }

        return $options;
    }

    /**
     * @return array
     */
    public function getTabs(): array
    {
        $categories = $this->get_settings_for_display('categories');
        $tabs = [];

        if (!is_array($categories) || empty($categories)) {
            return [];
        }

        foreach ($categories as $category) {
            /** @noinspection SlowArrayOperationsInLoopInspection */
            $tabs = array_merge($tabs, $this->getTabsByCategory($category));
        }

        return $tabs;
    }

    /**
     * @param array $category
     * @return array
     */
    private function getTabsByCategory(array $category): array
    {
        if (in_array($category['type'], tdf_taxonomy_keys(), true)) {
            return $this->getTabsByTaxonomy($category);
        }

        if ($category['type'] === self::TYPE_ALL) {
            return [
                [
                    'name' => tdf_string('all'),
                    'key' => self::TYPE_ALL,
                    'type' => self::TYPE_ALL,
                ],
            ];
        }

        if ($category['type'] === self::TYPE_MOST_POPULAR) {
            return [
                [
                    'name' => tdf_string('most_popular'),
                    'key' => self::TYPE_MOST_POPULAR,
                    'type' => self::TYPE_MOST_POPULAR,
                ],
            ];
        }

        if ($category['type'] === self::TYPE_RECENTLY_VIEWED) {
            return [
                [
                    'name' => tdf_string('recently_viewed'),
                    'key' => self::TYPE_RECENTLY_VIEWED,
                    'type' => self::TYPE_RECENTLY_VIEWED,
                ],
            ];
        }

        return [];
    }

    /**
     * @param array $category
     * @return array
     */
    private function getTabsByTaxonomy(array $category): array
    {
        $taxonomyKey = $category['type'];
        $termIds = $category['terms_' . $taxonomyKey];

        if (!is_array($termIds) || empty($termIds)) {
            return [];
        }

        $tabs = [];

        foreach (tdf_query_terms($taxonomyKey)->in($termIds)->get() as $term) {
            /* @var Term $term */
            $tabs[] = [
                'name' => $term->getName(),
                'type' => 'term',
                'key' => $term->getId(),
            ];
        }

        return $tabs;
    }

    /**
     * @return array
     */
    public function getSwiperConfig(): array
    {
        return [
            'containerModifierClass' => 'listivo-swiper-container-',
            'slideClass' => 'listivo-swiper-slide',
            'slideActiveClass' => 'listivo-swiper-slide-active',
            'slideDuplicateActiveClass' => 'listivo-swiper-slide-duplicate-active',
            'slideVisibleClass' => 'listivo-swiper-slide-visible',
            'slideDuplicateClass' => 'listivo-swiper-slide-duplicate',
            'slideNextClass' => 'listivo-swiper-slide-next',
            'slideDuplicateNextClass' => 'listivo-swiper-slide-duplicate-next',
            'slidePrevClass' => 'listivo-swiper-slide-prev',
            'slideDuplicatePrevClass' => 'listivo-swiper-slide-duplicate-prev',
            'wrapperClass' => 'listivo-swiper-wrapper',
            'loop' => false,
            'spaceBetween' => 30,
            'breakpoints' => [
                0 => [
                    'slidesPerView' => 1,
                    'spaceBetween' => 15
                ],
                499 => [
                    'slidesPerView' => 2,
                    'spaceBetween' => 30
                ],
                1024 => [
                    'slidesPerView' => 3,
                    'spaceBetween' => 30
                ],
                1280 => [
                    'slidesPerView' => 4,
                    'spaceBetween' => 30
                ],
            ],
        ];
    }

    /**
     * @return Collection
     */
    public function getListings(): Collection
    {
        $tabs = $this->getTabs();
        if (empty($tabs)) {
            return tdf_collect();
        }

        return apply_filters('listivo/listingCarouselWithTabsWidget/listings', $tabs[0]['type'], $this->getLimit(), $this->includeExcluded());
    }

}