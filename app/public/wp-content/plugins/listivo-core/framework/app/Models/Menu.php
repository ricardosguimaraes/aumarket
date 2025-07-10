<?php


namespace Tangibledesign\Framework\Models;


use Tangibledesign\Framework\Core\Menu\MenuWalker;
use Tangibledesign\Framework\Models\Term\Term;

/**
 * Class Menu
 * @package Tangibledesign\Framework\Models
 */
class Menu extends Term
{
    /**
     * @param string $id
     * @param array $args
     */
    public function display(string $id = '', array $args = []): void
    {
        if (empty($id)) {
            $id = tdf_prefix() . '-menu';
        }

        wp_nav_menu([
            'menu' => $this->getId(),
            'container' => 'div',
            'container_class' => $args['main_class'] ?? tdf_prefix() . '-menu',
            'container_id' => $id,
            'walker' => new MenuWalker($args),
            'items_wrap' => '%3$s',
            'depth' => 4,
        ]);
    }
}