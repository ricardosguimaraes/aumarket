<?php

namespace Tangibledesign\Framework\Widgets\General;

use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\MenuControl;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;

abstract class BaseSimpleMenuWidget extends BaseGeneralWidget
{
    use MenuControl;

    public function getKey(): string
    {
        return 'simple_menu';
    }

    public function getName(): string
    {
        return tdf_admin_string('simple_menu');
    }

    protected function addMenuControl(): void
    {
        $this->add_control(
            'menu',
            [
                'label' => tdf_admin_string('menu'),
                'type' => SelectRemoteControl::TYPE,
                'source' => tdf_action_url(tdf_prefix() . '/api/menus'),
                'prevent_empty' => false,
                'default' => ['global'],
            ]
        );
    }

    private function getMenuId(): int
    {
        return (int)$this->get_settings_for_display('menu');
    }

    public function displayMenu(): void
    {
        wp_nav_menu([
            'menu' => $this->getMenuId(),
            'container' => 'div',
            'container_id' => tdf_prefix() . '-simple-menu-container-' . $this->get_id(),
            'items_wrap' => '<ul class="' . tdf_prefix() . '-simple-menu">%3$s</ul>',
            'depth' => 1,
        ]);
    }
}