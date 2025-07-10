<?php

namespace Tangibledesign\Framework\Providers\Panel;

use JsonException;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\Payments\BumpUserPaymentPackage;

class ManuallyBumpModelServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('admin_post_'.tdf_prefix().'/panel/model/bump', [$this, 'bump']);
    }

    /**
     * @return void
     * @throws JsonException
     */
    public function bump(): void
    {
        if (!$this->verifyNonce() || !tdf_settings()->bumpsEnabled()) {
            $this->errorJsonResponse();
            return;
        }

        $model = $this->getModel();
        if (!$model) {
            $this->errorJsonResponse();
            return;
        }

        $package = $this->getPaymentPackage($model);
        if (!$package) {
            $this->errorJsonResponse();
            return;
        }

        $model->bump();

        $package->decrease();

        $this->successJsonResponse();
    }

    /**
     * @return BumpUserPaymentPackage|false
     */
    private function getPaymentPackage(Model $model)
    {
        $package = tdf_user_payment_packages_repository()
            ->getBumpPaymentPackagesForModel(tdf_current_user(), $model)->first();
        if (!$package instanceof BumpUserPaymentPackage) {
            return false;
        }

        return $package;
    }

    /**
     * @return Model|false
     */
    private function getModel()
    {
        $modelId = (int) ($_POST['modelId'] ?? 0);
        $model = tdf_post_factory()->create($modelId);
        if (!$model instanceof Model) {
            return false;
        }

        return $model;
    }

    /**
     * @return bool
     */
    private function verifyNonce(): bool
    {
        return wp_verify_nonce($_POST['nonce'] ?? '', tdf_prefix().'_panel_bump_model');
    }

}