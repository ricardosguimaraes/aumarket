<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Helpers\CurrentUserCan;
use Tangibledesign\Framework\Helpers\VerifyNonce;
use Tangibledesign\Framework\Models\Currency;

class ManageCurrenciesServiceProvider extends ServiceProvider
{
    use CurrentUserCan;
    use VerifyNonce;

    public function afterInitiation(): void
    {
        add_action('admin_post_' . tdf_prefix() . '/currency/create', [$this, 'create']);

        add_action('admin_post_' . tdf_prefix() . '/currency/update', [$this, 'update']);

        add_action('admin_post_' . tdf_prefix() . '/currency/delete', [$this, 'delete']);
    }

    public function delete(): void
    {
        if (!$this->currentUserCanManageOptions()) {
            return;
        }

        if (!$this->verifyNonce($_POST['nonce'] ?? '', tdf_prefix() . '/currency/delete')) {
            return;
        }

        $currencyId = (int)($_POST['currencyId'] ?? 0);
        if (empty($currencyId)) {
            return;
        }

        wp_delete_term($currencyId, tdf_prefix() . '_currency');
    }

    public function create(): void
    {
        if (!$this->currentUserCanManageOptions()) {
            return;
        }

        if (!$this->verifyNonce($_POST['nonce'] ?? '', tdf_prefix() . '/currency/create')) {
            return;
        }

        $currencyData = wp_insert_term(
            tdf_prefix() . '_currency_' . time(),
            tdf_prefix() . '_currency'
        );

        if (!isset($currencyData['term_id'])) {
            return;
        }

        $this->updateCurrencySettings($currencyData['term_id'], $_POST);

        wp_safe_redirect(admin_url('admin.php?page=' . tdf_prefix() . '_basic_setup&tab=currency'));
        exit;
    }

    public function update(): void
    {
        if (!$this->currentUserCanManageOptions()) {
            return;
        }

        if (!$this->verifyNonce($_POST['nonce'] ?? '', tdf_prefix() . '/currency/update')) {
            return;
        }

        $currencyId = (int)($_POST['currencyId'] ?? 0);
        if (empty($currencyId)) {
            return;
        }

        $this->updateCurrencySettings($currencyId, $_POST);

        wp_safe_redirect(admin_url('admin.php?page=' . tdf_prefix() . '_basic_setup&tab=currency'));
        exit;
    }

    private function updateCurrencySettings(int $currencyId, array $settings): void
    {
        update_term_meta(
            $currencyId,
            Currency::NAME,
            $settings[Currency::NAME] ?? ''
        );

        update_term_meta(
            $currencyId,
            Currency::SIGN,
            $settings[Currency::SIGN] ?? ''
        );

        update_term_meta(
            $currencyId,
            Currency::SIGN_POSITION,
            $settings[Currency::SIGN_POSITION] ?? Currency::SIGN_POSITION_BEFORE
        );

        update_term_meta(
            $currencyId,
            Currency::FORMAT,
            $settings[Currency::FORMAT] ?? Currency::FORMAT_1
        );

        update_term_meta(
            $currencyId,
            Currency::DYNAMIC_DECIMAL,
            $settings[Currency::DYNAMIC_DECIMAL] ?? Currency::DYNAMIC_DECIMAL
        );
    }
}