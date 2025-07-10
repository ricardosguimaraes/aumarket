<?php


namespace Tangibledesign\Framework\Queries;


/**
 * Class QueryBlogPosts
 * @package Tangibledesign\Framework\Queries
 */
class QueryBlogPosts extends QueryPosts
{
    /** @var array */
    protected array $tagIn = [];

    /** @var array */
    protected array $categoryIn = [];

    /**
     * @param  array|int  $ids
     * @return $this
     */
    public function tagIn($ids): QueryBlogPosts
    {
        $this->tagIn = is_array($ids) ? $ids : [$ids];

        return $this;
    }

    /**
     * @param  array|int  $ids
     * @return QueryBlogPosts
     */
    public function categoryIn($ids): QueryBlogPosts
    {
        $this->categoryIn = is_array($ids) ? $ids : [$ids];

        return $this;
    }

    /**
     * @return array
     */
    protected function parseArgs(): array
    {
        return parent::parseArgs() + [
                'tag__in' => $this->tagIn,
                'category__in' => $this->categoryIn,
            ];
    }

}