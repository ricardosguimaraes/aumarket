<?php


namespace Tangibledesign\Framework\Admin;


use Tangibledesign\Framework\Core\ServiceProvider;

/**
 * Class RegisterTaxonomyServiceProvider
 * @package Tangibledesign\Framework\Admin
 */
class RegisterTaxonomyServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('init', function () {
            foreach (apply_filters('tdf/taxonomies', []) as $taxonomyData) {
                $this->register($taxonomyData);
            }
        });
    }

    /**
     * @param  array  $taxonomyData
     */
    public function register(array $taxonomyData): void
    {
        register_taxonomy(
            $taxonomyData['key'],
            $taxonomyData['object_type'],
            $taxonomyData['settings'] + [
                'labels' => $this->getLabels($taxonomyData['label']),
            ]
        );
    }

    /**
     * @param  string  $label
     * @return array
     */
    private function getLabels(string $label): array
    {
        return [
            'name' => $label,
            'singular_name' => $label,
            'search_items' => sprintf(tdf_admin_string('search_items'), $label),
            'all_items' => sprintf(tdf_admin_string('all'), $label),
            'parent_item' => sprintf(tdf_admin_string('parent_item'), $label),
            'parent_item_colon' => sprintf(tdf_admin_string('parent_item_colon'), $label),
            'edit_item' => sprintf(tdf_admin_string('edit_item'), $label),
            'update_item' => sprintf(tdf_admin_string('update_item'), $label),
            'add_new_item' => sprintf(tdf_admin_string('add_new_item'), $label),
            'new_item_name' => sprintf(tdf_admin_string('new_item_name'), $label),
            'menu_name' => $label,
        ];

    }

}