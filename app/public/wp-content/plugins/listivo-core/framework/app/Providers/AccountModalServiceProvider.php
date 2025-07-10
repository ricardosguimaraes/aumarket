<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;

class AccountModalServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('wp_footer', [$this, 'load']);
    }

    public function load(): void
    {
        if (is_user_logged_in()) {
            return;
        }

        get_template_part('templates/partials/account_modal');
    }

}