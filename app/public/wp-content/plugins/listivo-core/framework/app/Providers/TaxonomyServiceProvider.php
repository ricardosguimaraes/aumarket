<?php


namespace Tangibledesign\Framework\Providers;


use JsonException;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Helpers\CurrentUserCan;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Term\Term;

/**
 * Class TaxonomyServiceProvider
 * @package Tangibledesign\Framework\Providers
 */
class TaxonomyServiceProvider extends ServiceProvider
{
    use CurrentUserCan;

    /**
     * @return void
     */
    public function initiation(): void
    {
        $this->container['taxonomy_list'] = static function () {
            $list = [];

            foreach (tdf_taxonomy_fields() as $taxonomyField) {
                $list[$taxonomyField->getKey()] = $taxonomyField->getName();
            }

            return $list;
        };

        $this->container['taxonomy_keys'] = static function () {
            return tdf_taxonomy_fields()->map(static function ($field) {
                /* @var TaxonomyField $field */
                return $field->getKey();
            })->values();
        };

        $this->container['child_taxonomies'] = static function () {
            return tdf_taxonomy_fields()->filter(static function ($taxonomy) {
                /* @var TaxonomyField $taxonomy */
                return $taxonomy->getParentTaxonomyFields()->isNotEmpty();
            });
        };
    }

    public function afterInitiation(): void
    {
        add_action('init', function () {
            add_action('admin_post_'.tdf_prefix().'/terms', [$this, 'terms']);
        });
    }

    /**
     * @throws JsonException
     */
    public function terms(): void
    {
        if (!isset($_GET['taxonomy']) || !$this->currentUserCanManageOptions()) {
            return;
        }

        $taxonomyId = (int)$_GET['taxonomy'];
        if (empty($taxonomyId)) {
            return;
        }

        $taxonomyField = tdf_post_factory()->create($taxonomyId);
        if (!$taxonomyField instanceof TaxonomyField) {
            return;
        }

        $query = tdf_query_terms($taxonomyField->getKey());

        if (isset($_REQUEST['include'])) {
            $query->in($this->getTermIds());
        }

        echo json_encode($query->get()->map(static function ($term) {
            /* @var Term $term */

            return [
                'id' => $term->getKey(),
                'name' => $term->getName(),
            ];
        }), JSON_THROW_ON_ERROR);
    }

    /**
     * @return array
     */
    private function getTermIds(): array
    {
        $include = is_array($_REQUEST['include']) ? $_REQUEST['include'] : explode(',', $_REQUEST['include']);

        return tdf_collect($include)->map(static function ($key) {
            return (int)str_replace(tdf_prefix().'_', '', $key);
        })->values();
    }

}