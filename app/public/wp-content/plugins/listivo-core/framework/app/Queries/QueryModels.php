<?php

namespace Tangibledesign\Framework\Queries;

use Tangibledesign\Framework\Factories\BasePostFactory;
use Tangibledesign\Framework\Models\Field\NumberField;
use Tangibledesign\Framework\Models\Field\PriceField;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\Term\CustomTerm;

class QueryModels extends QueryPosts
{
    public function getPostType(): string
    {
        return tdf_model_post_type();
    }

    public function featured(): QueryModels
    {
        $this->metaQuery = [
            [
                'key' => 'featured',
                'value' => '1',
            ]
        ];

        return $this;
    }

    public function byTerm(CustomTerm $term): QueryModels
    {
        $this->taxQuery = [
            [
                'taxonomy' => $term->getTaxonomyKey(),
                'field' => 'term_id',
                'terms' => $term->getId(),
            ]
        ];

        return $this;
    }

    public function orderBy(string $orderBy): QueryModels
    {
        if ($orderBy === tdf_slug('name_asc')) {
            return $this->orderByName();
        }

        if ($orderBy === tdf_slug('newest')) {
            return $this->orderByNewest();
        }

        if ($orderBy === tdf_slug('oldest')) {
            return $this->orderByOldest();
        }

        if ($orderBy === tdf_slug('most_relevant')) {
            return $this->orderByFeatured();
        }

        if ($orderBy === 'random') {
            return $this->orderByRandom();
        }

        foreach (tdf_price_fields() as $priceField) {
            if ($orderBy === $priceField->getSlug() . '-' . tdf_slug('high_to_low')) {
                return $this->orderByPrice($priceField, 'DESC');
            }

            if ($orderBy === $priceField->getSlug() . '-' . tdf_slug('low_to_high')) {
                return $this->orderByPrice($priceField);
            }
        }

        foreach (tdf_number_fields() as $numberField) {
            if ($orderBy === $numberField->getSlug() . '-' . tdf_slug('high_to_low')) {
                return $this->orderByNumberField($numberField, 'DESC');
            }

            if ($orderBy === $numberField->getSlug() . '-' . tdf_slug('low_to_high')) {
                return $this->orderByNumberField($numberField);
            }
        }

        return $this;
    }

    protected function orderByFeatured(): QueryModels
    {
        $this->metaQuery = [
            'relation' => 'OR',
            [
                'key' => 'featured',
                'compare' => 'NOT EXISTS',
            ],
            [
                'relation' => 'OR',
                [
                    'key' => 'featured',
                    'value' => '1',
                ],
                [
                    'key' => 'featured',
                    'value' => '1',
                    'compare' => '!=',
                ],
            ],
        ];

        $this->orderBy = ['meta_value' => 'DESC', 'date' => 'DESC', 'ID' => 'DESC'];

        $this->args['meta_value_num'] = 'featured';

        return $this;
    }

    private function orderByPrice(PriceField $priceField, string $order = 'ASC'): QueryModels
    {
        if (!tdf_current_currency()) {
            return $this;
        }

        /** @noinspection NullPointerExceptionInspection */
        $priceKey = $priceField->getKey() . '_' . tdf_current_currency()->getKey();

        $this->orderBy = 'meta_value_num';
        $this->order = $order;

        $this->metaQuery = [
            'relation' => 'OR',
            [
                'key' => $priceKey,
                'compare' => 'EXISTS'
            ],
            [
                'key' => $priceKey,
                'compare' => 'NOT EXISTS',
                'value' => ''
            ]
        ];

        $this->args['meta_type'] = 'NUMERIC';
        $this->args['meta_key'] = $priceKey;

        return $this;
    }

    private function orderByNumberField(NumberField $numberField, string $order = 'ASC'): QueryModels
    {
        $this->orderBy = [
            'meta_value_num' => $order
        ];

        $this->metaQuery = [
            'relation' => 'OR',
            [
                'key' => $numberField->getKey(),
                'compare' => 'EXISTS'
            ],
            [
                'key' => $numberField->getKey(),
                'compare' => 'NOT EXISTS',
                'value' => ''
            ]
        ];

        $this->args['meta_key'] = $numberField->getKey();

        return $this;
    }

    public function expiresLessThan(int $hours): QueryModels
    {
        $dateTime = date("Y-m-d H:i:s", time() + ($hours * HOUR_IN_SECONDS));

        $this->metaQuery[] = [
            'key' => Model::EXPIRE,
            'compare' => '<',
            'value' => $dateTime,
        ];

        return $this;
    }

    protected function getFactory(): BasePostFactory
    {
        return tdf_model_factory();
    }

    public function expired(): QueryModels
    {
        $this->metaQuery[] = [
            'relation' => 'AND',
            [
                'key' => Model::EXPIRE,
                'compare' => '<',
                'value' => date("Y-m-d H:i:s"),
            ],
            [
                'key' => Model::EXPIRE,
                'compare' => '!=',
                'value' => '',
            ],
            [
                'key' => Model::EXPIRE,
                'compare' => '!=',
                'value' => null,
            ]
        ];

        return $this;
    }

    public function featuredExpired(): QueryModels
    {
        $this->metaQuery[] = [
            'relation' => 'AND',
            [
                'key' => Model::FEATURED_EXPIRE,
                'compare' => 'EXISTS'
            ],
            [
                'key' => Model::FEATURED_EXPIRE,
                'compare' => '!=',
                'value' => '',
            ],
            [
                'key' => Model::FEATURED_EXPIRE,
                'compare' => '<',
                'value' => date("Y-m-d H:i:s"),
                'type' => 'DATETIME'
            ]
        ];

        return $this;
    }
}