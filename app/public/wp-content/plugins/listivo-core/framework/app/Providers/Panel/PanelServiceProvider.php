<?php

namespace Tangibledesign\Framework\Providers\Panel;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Field\LocationField;
use Tangibledesign\Framework\Models\PanelFields\CustomPanelField;
use Tangibledesign\Framework\Models\PanelFields\DescriptionPanelField;
use Tangibledesign\Framework\Models\PanelFields\NamePanelField;
use Tangibledesign\Framework\Widgets\General\PanelWidget;

class PanelServiceProvider extends ServiceProvider
{

    public function initiation(): void
    {
        $this->container['after_login_redirect_url'] = function () {
            return $this->getRedirectUrl(tdf_settings()->getLoginRedirect());
        };

        $this->container['after_register_redirect_url'] = function () {
            return $this->getRedirectUrl(tdf_settings()->getRegisterRedirect());
        };

        $this->container['after_social_login_redirect_url'] = function () {
            return $this->getRedirectUrl(tdf_settings()->getSocialLoginRedirect());
        };

        $this->container['after_social_register_redirect_url'] = function () {
            return $this->getRedirectUrl(tdf_settings()->getSocialRegisterRedirect());
        };

        $this->container['panel_fields'] = static function () {
            $fields = tdf_collect([
                new NamePanelField(),
                new DescriptionPanelField(),
            ]);

            foreach (tdf_fields() as $field) {
                if ($field instanceof LocationField && empty(tdf_settings()->getGoogleMapsApiKey())) {
                    continue;
                }

                $fields[] = CustomPanelField::create($field);
            }

            return $fields;
        };
    }

    private function getRedirectUrl(string $type): string
    {
        if ($this->isAction($type)) {
            return PanelWidget::getUrl($type);
        }

        $page = tdf_post_factory()->create((int)$type);
        if (!$page) {
            return tdf_settings()->getPanelPageUrl();
        }

        return $page->getUrl();
    }

    private function isAction(string $type): bool
    {
        return in_array($type, [
            PanelWidget::ACTION_CREATE,
            PanelWidget::ACTION_LIST,
            PanelWidget::ACTION_SETTINGS,
            PanelWidget::ACTION_BUY_PACKAGE,
        ], true);
    }

    public function afterInitiation(): void
    {
        add_action('init', static function () {
            add_rewrite_rule(
                '^'.tdf_slug('panel').'/([^/]*)/?$',
                'index.php?page_id='.tdf_settings()->getPanelPageId().'&action=$matches[1]',
                'top'
            );
        });

        add_filter('query_vars', static function ($vars) {
            $vars[] = 'action';

            return $vars;
        });

        add_action('wp_head', static function () {
            if (!is_page() || !is_user_logged_in()) {
                return;
            }

            global $post;
            if (!$post) {
                return;
            }

            if ($post->ID !== tdf_settings()->getPanelPageId()) {
                return;
            }

            do_action(tdf_prefix().'/panel/load');
        });
    }

}