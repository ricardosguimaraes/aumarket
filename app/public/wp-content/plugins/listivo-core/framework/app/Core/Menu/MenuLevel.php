<?php

namespace Tangibledesign\Framework\Core\Menu;


/**
 * Class MenuLevel
 * @package Tangibledesign\Framework\Core\Menu
 */
class MenuLevel
{
    /**
     * @var int
     */
    protected $depth;

    /**
     * @var array
     */
    private $args;

    /**
     * @param int $depth
     * @param array $args
     */
    public function __construct(int $depth, array $args = [])
    {
        $this->depth = $depth;

        $this->args = $args;
    }

    /**
     * @return int
     */
    public function getDepth(): int
    {
        return $this->depth;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        $classes = [];

        if (isset($this->args['menu_level_class'])) {
            $classes[] = $this->args['menu_level_class'];
        }

        if (isset($this->args['menu_level_depth_classes']) && is_array($this->args['menu_level_depth_classes'])) {
            foreach ($this->args['menu_level_depth_classes'] as $class) {
                $classes[] = $class . $this->getDepth();
            }
        }

        return implode(' ', $classes);
    }

}