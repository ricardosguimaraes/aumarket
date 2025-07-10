<?php

namespace Tangibledesign\Framework\Queries;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Factories\BasePostFactory;
use Tangibledesign\Framework\Models\Post\PostStatus;
use WP_Query;

class QueryPosts extends Query
{
    protected bool $prefixPostType = false;

    protected string $postType = 'post';

    protected string $title = '';

    protected array $metaQuery = [];

    protected array $taxQuery = [];

    protected array $userIn = [];

    protected string $search = '';

    protected int $page = 1;

    /** @var bool|int */
    protected $resultsNumber = false;

    protected string $order = 'DESC';

    /** @var string|array */
    protected $orderBy = 'date';

    protected string $status = 'publish';

    public function get(): Collection
    {
        $query = new WP_Query($this->parseArgs());

        $this->resultsNumber = $query->found_posts;

        return tdf_collect($query->posts)->map(function ($post) {
            return $this->getFactory()->create($post);
        })->filter(static function ($post) {
            return $post !== false;
        });
    }

    protected function getFactory(): BasePostFactory
    {
        return tdf_post_factory();
    }

    public function getResultsNumber(): int
    {
        if ($this->resultsNumber === false) {
            $this->get();
        }

        if ($this->resultsNumber === false) {
            return 0;
        }

        return $this->resultsNumber;
    }

    protected function parseArgs(): array
    {
        return $this->args + [
                'post_type' => $this->getPostType(),
                'posts_per_page' => $this->limit,
                'offset' => $this->offset,
                'paged' => $this->page,
                'meta_query' => $this->metaQuery,
                'tax_query' => $this->taxQuery,
                'title' => $this->title,
                'author__in' => $this->userIn,
                'search_title' => $this->search,
                'post__in' => $this->in,
                'post__not_in' => apply_filters(tdf_prefix() . '/search/excluded', $this->notIn),
                'order' => $this->order,
                'orderby' => $this->orderBy,
                'post_status' => $this->status,
            ];
    }

    protected function getPostType(): string
    {
        if ($this->prefixPostType) {
            return tdf_prefix() . '_' . $this->postType;
        }

        return $this->postType;
    }

    /**
     * @param string $title
     * @return static
     * @noinspection PhpMissingReturnTypeInspection
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param array|int $ids
     * @return static
     * @noinspection PhpMissingReturnTypeInspection
     */
    public function userIn($ids)
    {
        $this->userIn = is_array($ids) ? $ids : [$ids];

        return $this;
    }

    /**
     * @param string $keyword
     * @return static
     * @noinspection PhpMissingReturnTypeInspection
     */
    public function search(string $keyword)
    {
        $this->search = $keyword;

        return $this;
    }

    /**
     * @param int $page
     * @return static
     * @noinspection PhpMissingReturnTypeInspection
     */
    public function setPage(int $page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @param array $taxQuery
     * @return static
     * @noinspection PhpMissingReturnTypeInspection
     */
    public function setTaxQuery(array $taxQuery)
    {
        $this->taxQuery = $taxQuery;

        return $this;
    }

    /**
     * @param string $status
     * @return $this
     * @noinspection PhpMissingReturnTypeInspection
     * @noinspection ReturnTypeCanBeDeclaredInspection
     */
    public function setStatus(string $status)
    {
        $this->status = $status;

        return $this;
    }

    /** @noinspection PhpMissingReturnTypeInspection
     * @noinspection ReturnTypeCanBeDeclaredInspection
     */
    public function orderByName()
    {
        $this->orderBy = 'title';
        $this->order = 'ASC';

        return $this;
    }

    /**
     * @return $this
     * @noinspection PhpMissingReturnTypeInspection
     * @noinspection ReturnTypeCanBeDeclaredInspection
     */
    public function orderByNewest()
    {
        $this->orderBy = 'date';
        $this->order = 'DESC';

        return $this;
    }

    /**
     * @return $this
     * @noinspection PhpMissingReturnTypeInspection
     * @noinspection ReturnTypeCanBeDeclaredInspection
     */
    public function orderByOldest()
    {
        $this->orderBy = 'date';
        $this->order = 'ASC';

        return $this;
    }

    /**
     * @return $this
     * @noinspection PhpMissingReturnTypeInspection
     * @noinspection ReturnTypeCanBeDeclaredInspection
     */
    public function orderByRandom()
    {
        $this->orderBy = 'rand';

        return $this;
    }

    /**
     * @return $this
     * @noinspection PhpMissingReturnTypeInspection
     * @noinspection ReturnTypeCanBeDeclaredInspection
     */
    public function orderByIn()
    {
        $this->orderBy = 'post__in';

        return $this;
    }

    /**
     * @return $this
     * @noinspection PhpMissingReturnTypeInspection
     * @noinspection ReturnTypeCanBeDeclaredInspection
     */
    public function anyStatus()
    {
        $this->status = PostStatus::ANY;

        return $this;
    }

    public function where(string $metaKey, string $metaValue, string $compare = '='): self
    {
        $this->metaQuery[] = [
            'key' => $metaKey,
            'value' => $metaValue,
            'compare' => $compare
        ];

        return $this;
    }

    public function first()
    {
        return $this->get()->first();
    }

    public function orderByMeta(string $key, string $order = 'DESC'): self
    {
        $this->metaQuery[] = [
            'key' => $key,
            'compare' => 'EXISTS',
        ];

        $this->args['meta_key'] = $key;

        $this->orderBy = [
            'meta_value_num' => $order,
            'date' => 'DESC',
            'ID' => 'DESC'
        ];

        return $this;
    }

    public function status(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}