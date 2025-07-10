<?php


namespace Tangibledesign\Framework\Providers;


use JsonException;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Factories\TermFactory;
use Tangibledesign\Framework\Models\Menu;
use Tangibledesign\Framework\Queries\QueryMenus;

/**
 * Class MenuServiceProvider
 * @package Tangibledesign\Framework\Providers
 */
class MenuServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function initiation(): void
    {
        $this->container['menus'] = static function () {
            return (new QueryMenus())->get();
        };
    }

    /**
     * @return void
     * @throws JsonException
     */
    public function afterInitiation(): void
    {
        add_action('admin_post_'.tdf_prefix().'/api/menus', static function () {
            $options = [
                [
                    'id' => 'global',
                    'name' => tdf_admin_string('global'),
                ]
            ];

            foreach (tdf_app('menus') as $menu) {
                /* @var Menu $menu */
                $options[] = [
                    'id' => $menu->getId(),
                    'name' => $menu->getName(),
                ];
            }

            if (isset($_REQUEST['include'])) {
                $options = array_filter($options, static function ($option) {
                    return $option['id'] === (int)$_REQUEST['include'];
                });
            }

            echo json_encode($options, JSON_THROW_ON_ERROR);
        });

        add_filter('body_class', static function ($class) {
            if (tdf_settings()->isMainMenuSticky()) {
                $class[] = tdf_prefix().'-menu-sticky';
            }

            return $class;
        });
    }

}