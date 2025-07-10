<?php

namespace Tangibledesign\Listivo\Providers;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Core\ServiceProvider;

use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\Term\CustomTerm;
use TextAnalysis\Tokenizers\GeneralTokenizer;

class KeywordServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_filter('listivo/keyword/options', [$this, 'options'], 10, 4);
    }

    /**
     * @param Collection $options
     * @param string $keyword
     * @param array $taxonomyKeys
     * @param int $limit
     * @return Collection
     */
    public function options(Collection $options, string $keyword, array $taxonomyKeys, int $limit): Collection
    {
        $listings = tdf_query_models()->search($keyword)->get();
        if ($listings->isEmpty()) {
            return $options;
        }

        foreach ($this->getKeywords($keyword, $listings) as $index => $newKeyword) {
            $listings = tdf_query_models()->search($newKeyword)->get();

            $options[] = [
                'keyword' => $newKeyword,
                'term' => '',
                'value' => [$newKeyword],
                'type' => 'keyword'
            ];

            if (empty($index)) {
                $options = $options->merge($this->getKeywordAndTermsOptions($newKeyword, $listings, $taxonomyKeys));
            }

            if ($options->count() > $limit) {
                break;
            }
        }

        return $options->slice(0, $limit);
    }

    /**
     * @param string $keyword
     * @param Collection $listings
     * @param array $taxonomyKeys
     * @return Collection
     */
    private function getKeywordAndTermsOptions(string $keyword, Collection $listings, array $taxonomyKeys): Collection
    {
        $options = tdf_collect();

        foreach (tdf_taxonomy_fields() as $taxonomyField) {
            if (!in_array($taxonomyField->getKey(), $taxonomyKeys, true)) {
                continue;
            }

            $termIds = [];
            $terms = [];

            foreach ($listings as $listing) {
                foreach ($taxonomyField->getValue($listing) as $term) {
                    $termId = $term->getId();

                    $termIds[$termId] = $termId;
                    $terms[$termId] = $term;
                }
            }

            if ($taxonomyField->isMultilevel()) {
                foreach ($terms as $term) {
                    foreach ($term->getMultilevelParentIds() as $parentId) {
                        if (isset($termIds[$parentId])) {
                            unset($terms[$parentId]);
                        }
                    }
                }
            }

            foreach ($terms as $term) {
                $options[] = [
                    'id' => $taxonomyField->getKey() . '_' . $term->getId() . '_' . $keyword,
                    'keyword' => $keyword,
                    'term' => $term->getName(),
                    'termId' => $term->getId(),
                    'type' => 'keyword_taxonomy',
                    'value' => $term->getMultilevelIds(),
                    'taxonomy' => $taxonomyField->getKey(),
                    'terms' => tdf_query_terms($taxonomyField->getKey())->in($term->getMultilevelIds())->get()->map(static function ($term) {
                        /* @var CustomTerm $term */
                        return [
                            'id' => $term->getId(),
                            'name' => $term->getName(),
                        ];
                    })->values()
                ];
            }
        }

        return $options->slice(0, 3);
    }

    /**
     * @param string $keyword
     * @param Collection $listings
     * @return Collection
     */
    private function getKeywords(string $keyword, Collection $listings): Collection
    {
        $keywords = tdf_collect();
        $grams = [];
        $nGram = count(preg_split('/\s+/', $keyword));
        $nGrams = [$nGram, $nGram + 1];
        $tokenizer = new GeneralTokenizer(" \n\t\r,!?");

        foreach ($nGrams as $number) {
            foreach ($listings as $listing) {
                /* @var Model $listing */
                /** @noinspection SlowArrayOperationsInLoopInspection */
                $grams = array_merge($grams, ngrams(normalize_tokens($tokenizer->tokenize($listing->getName())), $number));
            }
        }

        foreach (array_count_values($grams) as $gram => $count) {
            if (strpos($gram, $keyword) !== false) {
                $keywords[] = $gram;
            }
        }

        return $keywords;
    }
}