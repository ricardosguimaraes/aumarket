<?php

namespace Tangibledesign\Listivo\Widgets\User;

use Tangibledesign\Framework\Widgets\Helpers\ModelSingleWidget;

class UserNameWidget extends \Tangibledesign\Framework\Widgets\User\UserNameWidget implements ModelSingleWidget
{
    public function getName(): string
    {
        return esc_html__('User Display Name', 'listivo-core');
    }
}