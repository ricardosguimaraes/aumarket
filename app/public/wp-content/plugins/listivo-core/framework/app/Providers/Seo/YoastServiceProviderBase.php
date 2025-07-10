<?php

namespace TangibleDesign\Framework\Providers\Seo;

use Tangibledesign\Framework\Models\Model;
use WPSEO_Options;
use Yoast\WP\SEO\Models\Indexable;
use Yoast\WP\SEO\Repositories\Indexable_Repository;
use Yoast\WP\SEO\Presenters\Open_Graph\Image_Presenter;

class YoastServiceProviderBase extends BaseSeoServiceProvider
{
    public function afterInitiation(): void
    {
        parent::afterInitiation();

        add_filter('wpseo_remove_reply_to_com', '__return_false');

        add_filter('wpseo_title', [$this, 'title']);
//        add_filter('wpseo_metadesc', [$this, 'termDescription']);

        add_filter('wpseo_frontend_presentation', [$this, 'presentation']);

        add_action('wp_head', function () {
            if (!class_exists(WPSEO_Options::class) || !is_tax()) {
                return;
            }

            $term = $this->getCurrentTitleTerm();
            if (!$term) {
                return;
            }

            global $wp_query;
            $wp_query->is_tax = true;
            $wp_query->is_post_type_archive = false;
            $wp_query->queried_object_id = $term->getId();
            $wp_query->queried_object = $term->getWpTerm();
        }, 1);

        add_action('wpseo_head', static function () {
            if (!is_tax()) {
                return;
            }

            global $wp_query;
            $wp_query->is_post_type_archive = true;
        });

        add_filter('wpseo_canonical', [$this, 'canonicalUrl'], 9999);

        add_filter('wpseo_frontend_presenter_classes', static function ($filter) {
            if (!is_singular(tdf_model_post_type())) {
                return $filter;
            }

            if (($key = array_search(Image_Presenter::class, $filter, true)) !== false) {
                unset($filter[$key]);
            }

            return $filter;
        });
    }

    public function canonicalUrl(?string $canonical)
    {
        if (is_single()) {
            return $canonical;
        }

        global $wp_query;
        if (isset($wp_query->query_vars['post_type']) && $wp_query->query_vars['post_type'] === tdf_model_post_type()) {
            return false;
        }

        return $canonical;
    }

    public function presentation($presentation)
    {
        remove_filter('wpseo_frontend_presentation', [$this, 'presentation']);

        if (!is_tax()) {
            return $presentation;
        }

        $term = $this->getCurrentTitleTerm();
        if (!$term) {
            return $presentation;
        }

        $meta = YoastSEO()->meta->for_term($term->getId());

        return $meta->context->presentation;
    }

    /**
     * @return Indexable|false
     */
    private function getIndexable()
    {
        $term = $this->getCurrentBreadcrumbTerm();
        if (!$term) {
            return false;
        }

        return (YoastSEO()->classes->get(Indexable_Repository::class))->find_by_id_and_type($term->term_id, 'term');
    }

    public function title($title): string
    {
        if (is_singular(tdf_model_post_type()) && tdf_settings()->getAutoGenerateModelTitleFields()->isNotEmpty()) {
            global $post;
            if (!$post) {
                return $title;
            }

            $override = apply_filters(tdf_prefix() . '/seo/model/title/override', true, $post);
            if (!$override) {
                return $title;
            }

            return (new Model($post))->getName();
        }

        if (!is_tax()) {
            return $title;
        }

        if (!tdf_settings()->searchOverrideTitleTag()) {
            return $title;
        }

        return $this->getFullTitle();
    }

    public function termDescription($description): string
    {
        if (!is_tax()) {
            return $description;
        }

        $indexable = $this->getIndexable();

        return $indexable->description ?? $description;
    }
}