<?php


namespace Tangibledesign\Framework\Widgets\Helpers\Controls;


use Elementor\Controls_Manager;
use Tangibledesign\Framework\Models\Menu;

/**
 * Trait MenuControl
 * @package Tangibledesign\Framework\Widgets\Helpers\Controls
 */
trait MenuControl
{
    use Control;

    /**
     * @var Menu|false
     */
    protected $menu;

    protected function addMenuControl(): void
    {
        $options = $this->getMenuOptions();

        $this->add_control(
            'menu',
            [
                'label' => tdf_admin_string('menu'),
                'type' => Controls_Manager::SELECT,
                'options' => $options,
            ]
        );
    }

    /**
     * @return array
     */
    private function getMenuOptions(): array
    {
        $options = [];

        foreach (tdf_app('menus') as $menu) {
            /* @var Menu $menu */
            $options[$menu->getKey()] = $menu->getName();
        }

        return $options;
    }

    /**
     * @return Menu|false
     */
    public function getMenu()
    {
        if ($this->menu !== null) {
            return $this->menu;
        }

        $menuKey = $this->get_settings_for_display('menu');
        if (empty($menuKey)) {
            return false;
        }

        /** @noinspection NullPointerExceptionInspection */
        $this->menu = tdf_app('menus')->find(static function ($menu) use ($menuKey) {
            /* @var Menu $menu */
            return $menu->getKey() === $menuKey;
        });

        return $this->menu;
    }

}