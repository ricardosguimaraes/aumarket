<?php

namespace Tangibledesign\Framework\Widgets\Helpers;

use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Page;
use Tangibledesign\Framework\Models\Template\TemplateType\PostArchiveTemplateType;
use Tangibledesign\Framework\Models\Template\TemplateType\PostSingleTemplateType;
use Tangibledesign\Framework\Models\Template\TemplateType\TemplateType;
use Tangibledesign\Framework\Models\Template\TemplateType\UserTemplateType;
use Tangibledesign\Framework\Models\Term\CustomTerm;
use WP_Term;

trait HasBreadcrumbs
{
    use HasBlogPost;
    use HasPage;
    use HasUser;

    public function getBreadcrumbs(): array
    {
        $templateType = $this->getTemplateType();

        if ($templateType instanceof PostSingleTemplateType || is_singular('post')) {
            return $this->getSinglePostBreadcrumbs();
        }

        if ($templateType instanceof PostArchiveTemplateType || is_home() || is_category() || is_tag(
            ) || is_post_type_archive('post')) {
            return $this->getPostArchiveBreadcrumbs();
        }

        if (is_singular('page')) {
            return $this->getPageBreadcrumbs();
        }

        if ($templateType instanceof UserTemplateType || is_author()) {
            return $this->getUserBreadcrumbs();
        }

        return $this->getCustomBreadcrumbs($templateType);
    }

    private function getTemplateType(): ?TemplateType
    {
        if ( ! is_singular(tdf_prefix().'_template')) {
            return null;
        }

        return tdf_template_type_factory()->getCurrent();
    }

    protected function getCustomBreadcrumbs(?TemplateType $templateType): array
    {
        return [];
    }

    private function getPageBreadcrumbs(): array
    {
        $breadcrumbs = $this->getBaseBreadcrumbs();
        $page        = $this->getPage();

        if ( ! $page) {
            return $breadcrumbs;
        }

        $this->addPageBreadcrumb($page, $breadcrumbs);

        return $breadcrumbs;
    }

    private function addPageBreadcrumb(Page $page, &$breadcrumbs): void
    {
        $parentPage = $page->getParent();
        if ($parentPage) {
            $this->addPageBreadcrumb($parentPage, $breadcrumbs);
        }

        $breadcrumbs[] = [
            'key'  => 'page',
            'name' => $page->getName(),
            'url'  => $page->getUrl(),
        ];
    }

    private function getPostArchiveBreadcrumbs(): array
    {
        $breadcrumbs = $this->getBaseBreadcrumbs();

        $breadcrumbs[] = [
            'key'  => 'blog',
            'name' => tdf_string('blog'),
            'url'  => get_post_type_archive_link('post'),
        ];

        if (is_category()) {
            $category = get_queried_object();
            if ($category instanceof WP_Term) {
                $breadcrumbs[] = [
                    'key'  => 'category',
                    'name' => $category->name,
                    'url'  => get_term_link($category),
                ];
            }
        }

        if (is_tag()) {
            $tag = get_queried_object();
            if ($tag instanceof WP_Term) {
                $breadcrumbs[] = [
                    'key'  => 'tag',
                    'name' => $tag->name,
                    'url'  => get_term_link($tag),
                ];
            }
        }

        if (is_search()) {
            $breadcrumbs[] = [
                'key'  => 'search',
                'name' => 'search',
                'url'  => '#',
            ];
        }

        return $breadcrumbs;
    }

    private function getSinglePostBreadcrumbs(): array
    {
        $breadcrumbs = $this->getBaseBreadcrumbs();

        $post = $this->getBlogPost();
        if ( ! $post) {
            return $breadcrumbs;
        }

        $breadcrumbs[] = [
            'key'  => 'blog',
            'name' => tdf_string('blog'),
            'url'  => get_post_type_archive_link('post'),
        ];

        /** @noinspection LoopWhichDoesNotLoopInspection */
        foreach ($post->getCategories() as $category) {
            $breadcrumbs[] = [
                'key'  => $category->getKey(),
                'name' => $category->getName(),
                'url'  => $category->getUrl(),
            ];

            break;
        }

        $breadcrumbs[] = [
            'key'  => 'blog-post',
            'name' => $post->getName(),
            'url ' => $post->getUrl(),
        ];

        return $breadcrumbs;
    }

    protected function getHomeBreadcrumb(): array
    {
        return [
            'key'  => 'home',
            'name' => tdf_string('home'),
            'url'  => site_url(),
        ];
    }

    protected function getBaseBreadcrumbs(): array
    {
        return [$this->getHomeBreadcrumb()];
    }

    protected function getTermUrl(string $baseUrl, TaxonomyField $taxonomyField, CustomTerm $term): string
    {
        $partial = $taxonomyField->getSlug().'='.$term->getSlug();

        if ( ! str_contains($baseUrl, '?')) {
            $baseUrl .= '?';
        } else {
            $baseUrl .= '&';
        }

        return $baseUrl.$partial;
    }

    public function getUserBreadcrumbs(): array
    {
        $breadcrumbs = $this->getBaseBreadcrumbs();

        $user = $this->getUser();
        if ( ! $user) {
            return $breadcrumbs;
        }

        $breadcrumbs[] = [
            'key'  => $user->getKey(),
            'name' => $user->getDisplayName(),
            'url'  => $user->getUrl(),
        ];

        return $breadcrumbs;
    }
}