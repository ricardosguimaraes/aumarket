<?php


namespace Tangibledesign\Framework\Widgets;


use JasonGrimes\Paginator;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\BlogPost;
use Tangibledesign\Framework\Queries\QueryBlogPosts;
use Tangibledesign\Framework\Widgets\Helpers\Controls\ExcerptControls;
use Tangibledesign\Framework\Widgets\Helpers\Controls\LimitControl;
use Tangibledesign\Framework\Widgets\Helpers\PostArchiveWidget;
use WP_Term;

/**
 * Class BlogArchiveWidget
 * @package Tangibledesign\Framework\Widgets
 */
abstract class BlogArchiveWidget extends Widget implements PostArchiveWidget
{
    use ExcerptControls;
    use LimitControl;

    /**
     * @var Collection|false
     */
    private $posts = false;

    /**
     * @var int|false
     */
    private $resultsNumber = false;

    protected function getTemplateDirectory(): string
    {
        return 'blog/';
    }

    protected function addBlogArchiveControls(): void
    {
        $this->addLimitControl();

        $this->addExcerptLengthControl();

        $this->addExcerptEndControl();
    }

    /**
     * @return Collection|BlogPost[]
     */
    public function getPosts(): Collection
    {
        if (!$this->posts) {
            $this->preparePosts();
        }

        return $this->posts;
    }

    /**
     * @return int
     */
    private function getResultsNumber(): int
    {
        if ($this->resultsNumber === false) {
            $this->preparePosts();
        }

        return $this->resultsNumber;
    }

    private function preparePosts(): void
    {
        $queryBlogPosts = tdf_query_blog_posts()
            ->take($this->getLimit());

        $this->setPage($queryBlogPosts);

        $this->setSearch($queryBlogPosts);

        $this->setCategory($queryBlogPosts);

        $this->setTag($queryBlogPosts);

        $this->posts = $queryBlogPosts->get();

        $this->resultsNumber = $queryBlogPosts->getResultsNumber();
    }

    /**
     * @param  QueryBlogPosts  $queryBlogPosts
     */
    private function setPage(QueryBlogPosts $queryBlogPosts): void
    {
        if (empty($_GET[tdf_slug('pagination')])) {
            return;
        }

        $queryBlogPosts->setPage((int) $_GET[tdf_slug('pagination')]);
    }

    /**
     * @param  QueryBlogPosts  $queryBlogPosts
     */
    private function setSearch(QueryBlogPosts $queryBlogPosts): void
    {
        $search = get_query_var('s');

        if (!empty($search)) {
            $queryBlogPosts->search(get_query_var('s'));
        }
    }

    /**
     * @param  QueryBlogPosts  $queryBlogPosts
     */
    private function setCategory(QueryBlogPosts $queryBlogPosts): void
    {
        if (!is_category()) {
            return;
        }

        $category = get_category(get_query_var('cat'), false);
        if ($category instanceof WP_Term) {
            $queryBlogPosts->categoryIn($category->term_id);
        }
    }

    /**
     * @param  QueryBlogPosts  $queryBlogPosts
     */
    private function setTag(QueryBlogPosts $queryBlogPosts): void
    {
        if (!is_tag()) {
            return;
        }

        $tag = get_term_by('slug', get_query_var('tag'), 'post_tag');
        if ($tag instanceof WP_Term) {
            $queryBlogPosts->tagIn($tag->term_id);
        }
    }

    /**
     * @param  int  $maxPagesToShow
     * @return false|Paginator
     */
    public function getPaginator(int $maxPagesToShow = 5)
    {
        if (!$this->resultsNumber) {
            return false;
        }

        $paginator = new Paginator(
            $this->getResultsNumber(),
            $this->getLimit(),
            $this->getCurrentPage(),
            $this->getUrlPattern()
        );

        $paginator->setMaxPagesToShow($maxPagesToShow);

        return $paginator;
    }

    /**
     * @return int
     */
    private function getCurrentPage(): int
    {
        if (empty($_GET[tdf_slug('pagination')])) {
            return 1;
        }

        $page = (int) $_GET[tdf_slug('pagination')];
        if ($page < 1) {
            return 1;
        }

        return $page;
    }

    /**
     * @return string
     */
    private function getUrlPattern(): string
    {
        return $this->getBaseUrl().'?'.tdf_slug('pagination').'=(:num)';
    }

    /**
     * @return string
     */
    private function getBaseUrl(): string
    {
        if (is_category()) {
            return get_category_link(get_query_var('cat'));
        }

        if (is_tag()) {
            return get_tag_link(get_query_var('tag'));
        }

        return get_post_type_archive_link('post');
    }

}