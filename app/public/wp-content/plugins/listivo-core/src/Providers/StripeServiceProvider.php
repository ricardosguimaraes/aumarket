<?php

namespace Tangibledesign\Listivo\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;

class StripeServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_filter('wc_stripe_elements_styling', static function () {
            return [
                'base' => [
                    'iconColor' => '#222222',
                    'color' => '#222222',
                    'fontSize' => '24px',
                    'lineHeight' => '85px',
                    'fontFamily' => tdf_settings()->getTextFont(),
                    'fontWeight' => '700',
                    '::placeholder' => [
                        'color' => '#222222',
                    ],
                ],
            ];
        });
    }
}