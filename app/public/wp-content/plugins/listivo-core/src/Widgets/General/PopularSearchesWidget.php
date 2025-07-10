<?php


namespace Tangibledesign\Listivo\Widgets\General;


use Elementor\Controls_Manager;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Search\Helpers\Search;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;

/**
 * Class PopularSearchesWidget
 * @package Tangibledesign\Listivo\Widgets\General
 */
class PopularSearchesWidget extends BaseGeneralWidget
{
    public const DEFAULT_NUMBER = 11;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'popular_searches';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Popular Searches', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addNumberControl();

        $this->endControlsSection();
    }

    /**
     * @return Collection
     */
    public function getRecentSearches(): Collection
    {
        $searches = [];

        foreach (tdf_app('recent_searches') as $search) {
            $searches[] = Search::create($search);
        }

        return tdf_collect($searches)->take($this->getNumber());
    }

    /**
     * @return Collection|Search[]
     */
    public function getPopularSearches(): Collection
    {
        $searches = [];

        foreach (tdf_app('popular_searches') as $search) {
            $searches[] = Search::create($search);
        }

        return tdf_collect($searches)->take($this->getNumber());
    }

    private function addNumberControl(): void
    {
        $this->add_control(
            'number',
            [
                'label' => esc_html__('Number', 'listivo-core'),
                'default' => self::DEFAULT_NUMBER,
                'type' => Controls_Manager::NUMBER,
            ]
        );
    }

    /**
     * @return int
     */
    public function getNumber(): int
    {
        $number = (int)$this->get_settings_for_display('number');
        if (empty($number)) {
            return self::DEFAULT_NUMBER;
        }

        return $number;
    }

    /**
     * @return Collection
     */
    public function getTerms(): Collection
    {
        return tdf_query_terms(tdf_prefix() . '_' . tdf_settings()->getMainCategoryId())->get();
    }

}