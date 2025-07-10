<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;

class TemplatePostTypeServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('template_redirect', static function () {
            if (is_user_logged_in() && current_user_can('manage_options')) {
                return;
            }

            if (is_singular(tdf_prefix() . '_template') || is_post_type_archive(tdf_prefix() . '_template')) {
                global $wp_query;
                $wp_query->set_404();
                status_header(404);
                nocache_headers();
                include get_query_template('404');
                die();
            }
        });
    }
}