<?php


namespace Tangibledesign\Framework\Queries;


use Tangibledesign\Framework\Core\Collection;

/**
 * Class QueryTerms
 * @package Tangibledesign\Framework\Queries
 */
class QueryTerms extends Query
{
    /** @var string|int */
    protected $parent = '';

    /** @var string */
    protected string $keyword = '';

    /** @var bool */
    protected bool $prefixTaxonomy = false;

    /** @var string */
    protected string $taxonomy;

    /** @var string */
    protected string $orderby = 'name';

    /** @var string s */
    protected string $order = 'ASC';

    /** @var int|bool */
    protected $number = false;

    /** @var array */
    protected array $metaQuery = [];

    public function parseArgs(): array
    {
        return [
            'orderby' => $this->orderby,
            'order' => $this->order,
            'hide_empty' => false,
            'include' => $this->in,
            'exclude' => $this->notIn,
            'name__like' => $this->keyword,
            'parent' => $this->parent,
            'number' => $this->number,
            'meta_query' => $this->metaQuery,
        ];
    }

    /**
     * @return Collection
     */
    public function get(): Collection
    {
        $terms = get_terms($this->getTaxonomy(), $this->parseArgs());
        if (!is_array($terms)) {
            return tdf_collect();
        }

        return tdf_collect($terms)->map(function ($term) {
            return tdf_term_factory()->create($term);
        });
    }

    /**
     * @return string
     */
    protected function getTaxonomy(): string
    {
        if ($this->prefixTaxonomy) {
            return tdf_prefix() . '_' . $this->taxonomy;
        }

        return $this->taxonomy;
    }

    /**
     * @return static
     * @noinspection PhpMissingReturnTypeInspection
     */
    public function orderById()
    {
        $this->orderby = 'id';
        $this->order = 'ASC';

        return $this;
    }

    /**
     * @return $this
     * @noinspection PhpMissingReturnTypeInspection
     * @noinspection ReturnTypeCanBeDeclaredInspection
     */
    public function orderBy3rdPartyPlugin()
    {
        $this->orderby = 'term_order';

        return $this;
    }

    /**
     * @param string $taxonomy
     * @return $this
     */
    public function setTaxonomy(string $taxonomy): QueryTerms
    {
        $this->taxonomy = $taxonomy;

        return $this;
    }

    /**
     * @param string $keyword
     * @return $this
     * @noinspection PhpMissingReturnTypeInspection
     * @noinspection ReturnTypeCanBeDeclaredInspection
     */
    public function setKeyword(string $keyword)
    {
        $this->keyword = $keyword;

        return $this;
    }

    /**
     * @param int $parent
     * @return $this
     * @noinspection PhpMissingReturnTypeInspection
     * @noinspection ReturnTypeCanBeDeclaredInspection
     */
    public function setParent(int $parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return $this
     * @noinspection PhpMissingReturnTypeInspection
     * @noinspection ReturnTypeCanBeDeclaredInspection
     */
    public function orderByIn()
    {
        $this->orderby = 'include';

        return $this;
    }

    /**
     * @return $this
     * @noinspection PhpMissingReturnTypeInspection
     * @noinspection ReturnTypeCanBeDeclaredInspection
     */
    public function orderByCount()
    {
        $this->orderby = 'count';
        $this->order = 'DESC';

        return $this;
    }

    /**
     * @return $this
     * @noinspection PhpMissingReturnTypeInspection
     * @noinspection ReturnTypeCanBeDeclaredInspection
     */
    public function orderByName()
    {
        $this->orderby = 'name';
        $this->order = 'ASC';

        return $this;
    }

    /**
     * @param int $value
     * @return Query
     */
    public function take(int $value): Query
    {
        $this->number = $value;

        return $this;
    }

    public function metaQuery(array $metaQuery): QueryTerms
    {
        $this->metaQuery = $metaQuery;

        return $this;
    }
}