<?php


namespace Tangibledesign\Framework\Providers;


use Tangibledesign\Framework\Core\ServiceProvider;

/**
 * Class RegisterPostTypeServiceProvider
 * @package Tangibledesign\Framework\Providers
 */
class RegisterPostTypeServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('init', function () {
            foreach (apply_filters('tdf/posttypes', []) as $postTypeData) {
                $this->register($postTypeData);
            }
        });
    }

    /**
     * @param array $postTypeData
     */
    public function register(array $postTypeData): void
    {
        register_post_type(
            $postTypeData['key'],
            $postTypeData['settings'] + [
                'labels' => $this->getLabels($postTypeData['name'], $postTypeData['singular_name'])
            ]
        );
    }

    /**
     * @param string $name
     * @param string $singularName
     * @return array
     */
    private function getLabels(string $name, string $singularName): array
    {
        return [
            'name' => $name,
            'singular_name' => $singularName,
            'menu_name' => $name,
            'name_admin_bar' => $singularName,
            'add_new' => sprintf(tdf_admin_string('add_new'), $singularName),
            'add_new_item' => sprintf(tdf_admin_string('add_new_item'), $singularName),
            'new_item' => sprintf(tdf_admin_string('new_item'), $singularName),
            'edit_item' => sprintf(tdf_admin_string('edit_item'), $singularName),
            'view_item' => sprintf(tdf_admin_string('view_item'), $singularName),
            'all_items' => $name,
            'search_items' => sprintf(tdf_admin_string('search_items'), $name),
            'parent_item_colon' => sprintf(tdf_admin_string('parent_item_colon'), $name),
            'not_found' => sprintf(tdf_admin_string('not_found'), $name),
            'not_found_in_trash' => sprintf(tdf_admin_string('not_found_in_trash'), $name)
        ];
    }

}