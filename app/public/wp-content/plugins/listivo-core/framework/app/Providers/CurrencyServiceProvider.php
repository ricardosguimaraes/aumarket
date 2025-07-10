<?php


namespace Tangibledesign\Framework\Providers;


use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Currency;
use Tangibledesign\Framework\Queries\QueryCurrencies;

/**
 * Class CurrencyServiceProvider
 * @package Tangibledesign\Framework\Providers
 */
class CurrencyServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function initiation(): void
    {
        $this->container['query_currencies'] = $this->container->factory(static function () {
            return new QueryCurrencies();
        });

        $this->container['currencies'] = static function ($c) {
            $queryCurrencies = $c['query_currencies'];
            /** @var QueryCurrencies $query */
            return $queryCurrencies->get();
        };

        $this->container['current_currency'] = static function ($c) {
            $currencyId = (int)($_COOKIE[tdf_prefix().'/currency'] ?? 0);
            if (empty($currencyId)) {
                return $c['currencies']->first();
            }

            $currency = $c['currencies']->find(static function ($currency) use ($currencyId) {
                /* @var Currency $currency */
                return $currency->getId() === $currencyId;
            });

            if (!$currency) {
                return $c['currencies']->first();
            }

            return $currency;
        };
    }

    /**
     * @return void
     */
    public function afterInitiation(): void
    {
        add_action('admin_post_'.tdf_prefix().'/currency/switch', [$this, 'switch']);

        add_action('admin_post_nopriv_'.tdf_prefix().'/currency/switch', [$this, 'switch']);
    }

    /**
     * @return void
     */
    public function switch(): void
    {
        $currencyId = (int)($_POST['currency'] ?? 0);
        if (empty($currencyId)) {
            return;
        }

        setcookie(tdf_prefix().'/currency', $currencyId, time() + (86400 * 30), '/');
    }

}