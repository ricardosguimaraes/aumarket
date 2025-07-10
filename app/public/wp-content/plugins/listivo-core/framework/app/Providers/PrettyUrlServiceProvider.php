<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Page;
use Tangibledesign\Framework\Models\Term\CustomTerm;

class PrettyUrlServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('init', [$this, 'rewriteRules']);
        add_action('init', [$this, 'userRewriteRules']);
        add_filter(tdf_prefix().'/term/url', [$this, 'url'], 20, 3);
    }

    public function userRewriteRules(): void
    {
        $counter = 2;
        $regex = tdf_slug('user').'/([^/]+)/';
        $query = 'index.php?author_name=$matches[1]';

        foreach (tdf_app('breadcrumbs_taxonomies') as $taxonomy) {
            $regex .= '([^/]+)/';
            $query .= '&'.$taxonomy->getKey().'=$matches['.$counter.']';

            add_rewrite_rule(
                $regex.'?$',
                $query,
                'top'
            );

            $counter++;
        }
    }

    public function rewriteRules(): void
    {
        if (!tdf_settings()->prettyUrls()) {
            return;
        }

        $data = [
            [
                'regex' => tdf_model_archive_slug().'/',
                'query' => 'index.php?post_type='.tdf_model_post_type(),
            ],
        ];

        foreach ($this->getSearchPages() as $page) {
            /* @var Page $page */
            $data[] = [
                'regex' => $page->getSlug().'/',
                'query' => 'index.php?pagename='.$page->getSlug()
            ];
        }

        foreach ($data as $d) {
            $regex = $d['regex'];
            $query = $d['query'];
            $counter = 1;

            foreach (tdf_app('breadcrumbs_taxonomies') as $taxonomy) {
                /* @var TaxonomyField $taxonomy */
                $regex .= '([^/]+)/';
                $query .= '&'.$taxonomy->getKey().'=$matches['.$counter.']';

                add_rewrite_rule(
                    $regex.'?$',
                    $query,
                    'top'
                );

                $counter++;
            }
        }
    }

    private function getSearchPages(): Collection
    {
        $pageIds = tdf_settings()->getAdditionalSearchPagesIds();
        if (empty($pageIds)) {
            return tdf_collect();
        }

        return tdf_query_pages()->in($pageIds)->get();
    }

    /**
     * @param  string  $url
     * @param  CustomTerm|false  $term
     * @param  bool  $baseUrl
     * @return string
     */
    public function url(string $url, $term = false, bool $baseUrl = true): string
    {
        if (!tdf_settings()->prettyUrls()) {
            return $url;
        }

        $urlPartials = $this->getUrlPartials($url);
        if (empty($urlPartials)) {
            return $url;
        }

        $termUrl = $baseUrl ? get_post_type_archive_link(tdf_model_post_type()) : '';

        foreach (tdf_app('breadcrumbs_taxonomies') as $taxonomy) {
            /* @var TaxonomyField $taxonomy */
            if (!isset($urlPartials[$taxonomy->getSlug()])) {
                break;
            }

            $termUrl .= $urlPartials[$taxonomy->getSlug()].'/';


            unset($urlPartials[$taxonomy->getSlug()]);
        }

        if (!empty($urlPartials)) {
            $termUrl .= '?';
        }

        $index = 0;

        foreach ($urlPartials as $slug => $value) {
            if ($index) {
                $termUrl .= '&';
            }

            $termUrl .= $slug.'='.$value;

            $index++;
        }

        return $termUrl;
    }

    private function getUrlPartials(string $url): array
    {
        if (strpos($url, '?') !== false) {
            $temp = explode('?', $url);
            if (count($temp) < 2) {
                return [];
            }

            $url = $temp[1];
        }

        $elements = [];

        foreach (explode('&', $url) as $element) {
            $data = explode('=', $element);
            if (isset($data[1])) {
                $elements[$data[0]] = $data[1];
            }
        }

        return $elements;
    }

}