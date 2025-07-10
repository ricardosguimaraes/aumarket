<?php

namespace Tangibledesign\Framework\Core\Menu;


class Menu
{
    /**
     * @var int
     */
    protected $menuId;

    /**
     * Menu constructor.
     * @param int $menuId
     */
    public function __construct($menuId)
    {
        $this->menuId = $menuId;
    }

    /**
     * @param string $id
     */
    public function display($id = '')
    {
        if (empty($id)) {
            $id = tdf_prefix() . '-menu';
        }

        wp_nav_menu([
            'menu' => $this->menuId,
            'container' => 'div',
            'container_class' => tdf_prefix() . '-menu',
            'container_id' => $id,
            'walker' => new MenuWalker(),
            'items_wrap' => '%3$s',
            'depth' => 4,
        ]);
    }

}