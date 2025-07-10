<?php

namespace Tangibledesign\Framework\Providers;

use JsonException;
use Tangibledesign\Framework\Actions\Search\FetchTermsByParentTaxonomyTermsAction;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Field\TaxonomyField;

class TermsOptionsServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('admin_post_' . tdf_prefix() . '/terms/options', [$this, 'options']);
        add_action('admin_post_' . tdf_prefix() . '/search/terms/fetch', [$this, 'searchTermsByParentTaxonomyTerms']);
        add_action('admin_post_nopriv_' . tdf_prefix() . '/search/terms/fetch',
            [$this, 'searchTermsByParentTaxonomyTerms']);
    }

    public function searchTermsByParentTaxonomyTerms(): void
    {
        $taxonomyKey = $_POST['taxonomyKey'] ?? '';
        $parentTermIds = $_POST['parentTermIds'] ?? [];

        if (empty($taxonomyKey) || empty($parentTermIds)) {
            try {
                echo json_encode(['terms' => []], JSON_THROW_ON_ERROR);
            } catch (JsonException $e) {
            }
            return;
        }

        if (!is_array($parentTermIds)) {
            $parentTermIds = [$parentTermIds];
        }

        try {
            echo json_encode([
                'terms' => (new FetchTermsByParentTaxonomyTermsAction())->execute($taxonomyKey, $parentTermIds)
            ], JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
        }
    }

    public function options(): void
    {
        if (!is_user_logged_in()) {
            return;
        }

        $taxonomyKey = $_POST['taxonomyKey'] ?? '';

        $taxonomy = tdf_taxonomy_fields()->find(static function ($taxonomy) use ($taxonomyKey) {
            /* @var TaxonomyField $taxonomy */
            return $taxonomy->getKey() === $taxonomyKey;
        });

        if (!$taxonomy instanceof TaxonomyField) {
            try {
                echo json_encode(['options' => []], JSON_THROW_ON_ERROR);
            } catch (JsonException $e) {
            }
            return;
        }

        try {
            echo json_encode(['options' => $taxonomy->getMultilevelTermsTree(true)], JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
        }
    }
}