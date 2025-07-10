<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\User\User;

class UtilsServiceProvider extends ServiceProvider
{

    public function initiation(): void
    {
        $this->container['current_url'] = static function () {
            global $wp;
            return home_url($wp->request);
        };
    }

    public function afterInitiation(): void
    {
        add_filter(tdf_prefix().'/phoneUrl', static function ($phone, $user = null) {
            $phone = str_replace([' ', '-', '(', ')'], '', trim($phone));
            if (!$user instanceof User || !tdf_settings()->isPhoneCountryCodeSelectEnabled()) {
                return $phone;
            }

            return '+'.$user->getPhoneNumberCountryCode().$phone;
        }, 10, 2);
    }

}