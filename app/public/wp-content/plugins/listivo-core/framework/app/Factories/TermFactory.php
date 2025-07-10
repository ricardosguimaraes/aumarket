<?php

namespace Tangibledesign\Framework\Factories;

use Tangibledesign\Framework\Models\Term\Term;
use Tangibledesign\Framework\Models\Category;
use Tangibledesign\Framework\Models\Currency;
use Tangibledesign\Framework\Models\Term\CustomTerm;
use Tangibledesign\Framework\Models\Menu;
use Tangibledesign\Framework\Models\Tag;
use WP_Term;

class TermFactory
{
    /**
     * @param  WP_Term|int  $term
     * @return Term|null
     */
    public function create($term = null): ?Term
    {
        return $this->getTermObject($term);
    }

    public function createBySlug(string $slug, string $taxonomy = ''): ?Term
    {
        $term = get_term_by('slug', $slug, $taxonomy);
        if (!$term instanceof WP_Term) {
            return null;
        }

        return $this->create($term);
    }

    /**
     * @param  WP_Term|int|null  $term
     * @return Term|null
     */
    public function getTermObject($term): ?Term
    {
        $object = $this->getObject($term);
        if (!$object) {
            return null;
        }

        if ($object->taxonomy === 'tag') {
            return new Tag($object);
        }

        if ($object->taxonomy === 'category') {
            return new Category($object);
        }

        if ($object->taxonomy === 'nav_menu') {
            return new Menu($object);
        }

        if ($object->taxonomy === tdf_prefix().'_currency') {
            return new Currency($object);
        }

        return new CustomTerm($object);
    }

    /**
     * @param  WP_Term|int  $term
     * @return WP_Term|null
     */
    protected function getObject($term): ?WP_Term
    {
        if ($term instanceof WP_Term) {
            return $term;
        }

        if (!is_int($term)) {
            return null;
        }

        $termObject = get_term($term);
        return $termObject instanceof WP_Term ? $termObject : null;
    }

}