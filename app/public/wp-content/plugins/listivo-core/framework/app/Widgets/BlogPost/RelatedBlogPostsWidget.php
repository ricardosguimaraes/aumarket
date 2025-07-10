<?php

namespace Tangibledesign\Framework\Widgets\BlogPost;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\BlogPost;
use Tangibledesign\Framework\Models\Category;
use Tangibledesign\Framework\Models\Tag;
use Tangibledesign\Framework\Widgets\Helpers\BasePostSingleWidget;

class RelatedBlogPostsWidget extends BasePostSingleWidget
{
    public function getKey(): string
    {
        return 'related_blog_posts';
    }

    public function getName(): string
    {
        return tdf_admin_string('related_blog_posts');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addLimitControl();

        $this->endControlsSection();
    }

    protected function addLimitControl(int $default = 2): void
    {
        $this->add_control(
            'limit',
            [
                'label' => tdf_admin_string('limit'),
                'default' => $default,
            ]
        );
    }

    public function getLimit(): int
    {
        return (int)$this->get_settings_for_display('limit');
    }

    public function getRelatedBlogPosts(): Collection
    {
        $blogPost = $this->getBlogPost();
        if (!$blogPost) {
            return tdf_collect();
        }

        $relatedBlogPosts = $this->getByCategories($blogPost);
        if ($relatedBlogPosts->isNotEmpty()) {
            return $relatedBlogPosts;
        }

        $relatedBlogPosts = $this->getByTags($blogPost);
        if ($relatedBlogPosts->isNotEmpty()) {
            return $relatedBlogPosts;
        }

        return $this->getGeneral($blogPost);
    }

    private function getByCategories(BlogPost $blogPost): Collection
    {
        return tdf_query_blog_posts()
            ->categoryIn($blogPost->getCategories()->map(static function ($category) {
                /* @var Category $category */
                return $category->getId();
            })->values())
            ->notIn($blogPost->getId())
            ->take($this->getLimit())
            ->get();
    }

    private function getByTags(BlogPost $blogPost): Collection
    {
        return tdf_query_blog_posts()
            ->tagIn($blogPost->getTags()->map(static function ($tag) {
                /* @var Tag $tag */
                return $tag->getId();
            })->values())
            ->notIn($blogPost->getId())
            ->take($this->getLimit())
            ->get();
    }

    private function getGeneral(BlogPost $blogPost): Collection
    {
        return tdf_query_blog_posts()
            ->notIn($blogPost->getId())
            ->take($this->getLimit())
            ->get();
    }

}