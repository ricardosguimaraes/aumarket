<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;

class SharedStateServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('wp_enqueue_scripts', function () {
            wp_localize_script(tdf_prefix(), tdf_prefix() . 'SharedState', apply_filters(tdf_prefix() . '/core/sharedState', [
                'requestUrl' => tdf_action_url(tdf_prefix() . '/'),
                'user' => $this->getUserData(),
                'loginPageUrl' => tdf_settings()->getLoginPageUrl(),
            ]));
        });
    }

    /**
     * @return array|false
     */
    private function getUserData()
    {
        $currentUser = tdf_current_user();

        if (!$currentUser) {
            return false;
        }

        $data = [
            'displayName' => $currentUser->getDisplayName(),
            'url' => $currentUser->getUrl(),
        ];

        if (tdf_settings()->isFavoriteEnabled()) {
            $data['favorite'] = $currentUser->getFavoriteIds();
        }

        return $data;
    }
}