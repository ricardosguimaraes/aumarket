<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Term\CustomTerm;
use WP_Post;
use WP_Query;

class TermRelationServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('admin_post_' . tdf_prefix() . '/term/relations/connect', [$this, 'init']);

        add_action(tdf_prefix() . '/term/relations/connect', [$this, 'check']);

        add_action('save_post', [$this, 'saveModel'], 10, 2);
    }

    public function saveModel(int $postId, WP_Post $post): void
    {
        if ($post->post_type !== tdf_model_post_type()) {
            return;
        }

        $this->check();
    }

    public function init(): void
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        $this->check();

        wp_redirect(admin_url('admin.php?page=' . tdf_prefix() . '_advanced&tab=tools'));
        exit;
    }

    public function check(): void
    {
        foreach ($this->getModelIds() as $modelId) {
            /** @noinspection NullPointerExceptionInspection */
            tdf_app('child_taxonomies')->each(function ($childTaxonomy) use ($modelId) {
                $this->connect($modelId, $childTaxonomy);
            });
        }
    }

    private function connect(int $modelId, TaxonomyField $childTaxonomy): void
    {
        $parentTaxonomies = $childTaxonomy->getParentTaxonomyFields();
        foreach ($parentTaxonomies as $parentTaxonomy) {
            if (!$parentTaxonomy) {
                continue;
            }

            $parentTerms = $this->getTerms($modelId, $parentTaxonomy->getKey());

            $this->getTerms($modelId, $childTaxonomy->getKey())->each(static function ($childTerm) use ($parentTerms) {
                /* @var CustomTerm $childTerm */
                if ($childTerm->getParentTerms()->isNotEmpty()) {
                    return;
                }

                $childTerm->setParentTerms($parentTerms->map(static function ($parentTerm) {
                    /* @var CustomTerm $parentTerm */
                    return $parentTerm->getId();
                })->values());
            });
        }
    }

    private function getModelIds(): array
    {
        return (new WP_Query([
            'post_type' => tdf_model_post_type(),
            'posts_per_page' => -1,
            'post_status' => 'any',
            'fields' => 'ids'
        ]))->posts;
    }

    private function getTerms(int $modelId, string $taxonomy): Collection
    {
        $terms = wp_get_object_terms($modelId, $taxonomy);
        if (is_wp_error($terms)) {
            return tdf_collect();
        }

        return tdf_collect($terms)->map(static function ($term) {
            return tdf_term_factory()->create($term);
        });
    }
}