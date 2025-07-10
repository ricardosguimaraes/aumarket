<?php

namespace Tangibledesign\Framework\Providers;

use Exception;
use JsonException;
use Tangibledesign\Framework\Actions\PaymentPackage\ApplyPackageAction;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\Notification\Trigger;
use Tangibledesign\Framework\Models\Payments\BasePaymentPackage;
use Tangibledesign\Framework\Models\Payments\DynamicPaymentPackageRegular;
use Tangibledesign\Framework\Models\Payments\PaymentPackage;
use Tangibledesign\Framework\Models\Payments\RegularUserPaymentPackageInterface;
use Tangibledesign\Framework\Widgets\General\PanelWidget;
use WooCommerce;

class MonetizationServiceProvider extends ServiceProvider
{
    public function initiation(): void
    {
        $this->container['free_package'] = static function () {
            return new DynamicPaymentPackageRegular([
                'key' => 'free',
                'name' => tdf_string('free'),
                'label' => tdf_settings()->getFreeListingLabel(),
                'text' => tdf_settings()->getFreeListingText(),
                'price' => '',
                'displayPrice' => '',
                'number' => 1,
                'expire' => tdf_settings()->getFreeListingExpire(),
                'featuredExpire' => tdf_settings()->getFreeListingFeaturedExpire(),
                'bumpsNumber' => tdf_settings()->getFreeListingBumpsNumber(),
                'bumpsInterval' => tdf_settings()->getFreeListingBumpsInterval(),
            ]);
        };

        $this->container['register_package'] = static function () {
            return new DynamicPaymentPackageRegular([
                'key' => 'register',
                'name' => tdf_string('free'),
                'price' => '',
                'displayPrice' => '',
                'number' => tdf_settings()->getRegisterPackageNumber(),
                'expire' => tdf_settings()->getRegisterPackageExpire(),
                'featuredExpire' => tdf_settings()->getRegisterPackageFeaturedExpire(),
                'bumpsNumber' => tdf_settings()->getRegisterPackageBumpsNumber(),
                'bumpsInterval' => tdf_settings()->getRegisterPackageBumpsInterval(),
            ]);
        };
    }

    public function afterInitiation(): void
    {
        add_action('wp_ajax_' . tdf_prefix() . '/monetization/selectPackage', [$this, 'selectPackage']);

        add_action(tdf_prefix() . '/notifications/trigger', [$this, 'addRegisterPackage'], 10, 2);

        add_filter(tdf_prefix() . '/plugins', [$this, 'plugins']);

        add_action('admin_notices', [$this, 'woocommerceNotice']);
    }

    public function woocommerceNotice(): void
    {
        if (class_exists(WooCommerce::class) || !current_user_can('manage_options') || !tdf_settings()->paymentsEnabled()) {
            return;
        }
        ?>
        <div class="error">
            <p>
                <strong>
                    The monetization option requires installation of the WooCommerce plugin.
                    <a href="<?php echo esc_url(tdf_action_url(tdf_prefix() . '/woocommerce/install')); ?>">
                        Install Now
                    </a>
                </strong>
            </p>
        </div>
        <?php
    }

    public function plugins(array $plugins): array
    {
        if (!tdf_settings()->paymentsEnabled()) {
            return $plugins;
        }

        $plugins[] = [
            'name' => tdf_admin_string('woocommerce'),
            'slug' => 'woocommerce',
            'required' => true,
        ];

        return $plugins;
    }

    public function addRegisterPackage(string $trigger, array $data): void
    {
        if ($trigger !== Trigger::USER_WELCOME || !tdf_settings()->isRegisterPackageEnabled()) {
            return;
        }

        $user = tdf_user_factory()->create((int)$data['user']);
        if (!$user) {
            return;
        }

        $user->addPaymentPackage(tdf_app('register_package'));
    }

    /** @noinspection ForgottenDebugOutputInspection */
    public function selectPackage(): void
    {
        $type = $_POST['type'];
        $packageKey = $_POST['packageKey'];
        $modelId = (int)$_POST['modelId'];

        if (empty($packageKey)) {
            $this->errorJsonResponse([
                'message' => tdf_string('you_need_to_choose_a_package'),
            ]);
            wp_die();
        }

        if ($packageKey === 'free' && tdf_settings()->isFreeListingEnabled()) {
            $this->applyFreePackage($modelId);
            wp_die();
        }

        if ($type === 'buy') {
            $this->buyPackage($packageKey, $modelId);
            wp_die();
        }

        if ($type === 'my') {
            $this->applyPackage((int)$packageKey, $modelId);
            wp_die();
        }

        $this->errorJsonResponse();
        wp_die();
    }

    private function buyPackage(string $packageKey, int $modelId): void
    {
        if (!empty($modelId)) {
            /** @noinspection NullPointerExceptionInspection */
            tdf_current_user()->setModelInProgress($modelId);
        }

        $paymentPackage = tdf_query_payment_packages()
            ->get()
            ->find(static function ($pp) use ($packageKey) {
                /* @var PaymentPackage $pp */
                return $pp->getKey() === $packageKey;
            });

        if (!$paymentPackage instanceof BasePaymentPackage) {
            $this->errorJsonResponse();
            /** @noinspection ForgottenDebugOutputInspection */
            wp_die();
        }

        WC()->cart->empty_cart();

        try {
            WC()->cart->add_to_cart($paymentPackage->getProductId());
        } catch (Exception $e) {
            http_response_code(500);
            exit;
        }

        $this->successJsonResponse([
            'redirect' => wc_get_checkout_url(),
        ]);
        /** @noinspection ForgottenDebugOutputInspection */
        wp_die();
    }

    private function applyFreePackage(int $modelId): void
    {
        $model = tdf_post_factory()->create($modelId);
        if ($model->isPublished()) {
            $this->errorJsonResponse([
                'message' => tdf_string('you_cannot_apply_free_package_to_published_model'),
            ]);
            /** @noinspection ForgottenDebugOutputInspection */
            wp_die();
        }

        if ($model->isPending()) {
            $this->errorJsonResponse([
                'message' => tdf_string('you_cannot_apply_free_package_to_pending_model'),
            ]);
            /** @noinspection ForgottenDebugOutputInspection */
            wp_die();
        }

        if (!$model instanceof Model) {
            $this->errorJsonResponse();
            /** @noinspection ForgottenDebugOutputInspection */
            wp_die();
        }

        if ($this->requireModeration($model)) {
            $this->setPendingPackage($model, 'free');

            $this->successJsonResponse([
                'redirect' => PanelWidget::getUrl(PanelWidget::ACTION_LIST),
            ]);
            /** @noinspection ForgottenDebugOutputInspection */
            wp_die();
        }

        $this->handlePackage(tdf_app('free_package'), $model);
    }

    /**
     * @param Model $model
     * @return bool
     */
    private function requireModeration(Model $model): bool
    {
        return tdf_settings()->moderationEnabled()
            && (!$model->isApproved() || tdf_settings()->moderationRequiredReApprove())
            && !$model->isPublished();
    }

    private function applyPackage(int $userPaymentPackageId, int $modelId): void
    {
        $model = tdf_post_factory()->create($modelId);
        if (!$model instanceof Model) {
            $this->errorJsonResponse();
            /** @noinspection ForgottenDebugOutputInspection */
            wp_die();
        }

        /** @noinspection NullPointerExceptionInspection */
        $package = tdf_current_user()->getPaymentPackage($userPaymentPackageId);
        if (!$package) {
            $this->errorJsonResponse();
            /** @noinspection ForgottenDebugOutputInspection */
            wp_die();
        }

        if ($this->requireModeration($model)) {
            $this->setPendingPackage($model, $userPaymentPackageId);

            /** @noinspection NullPointerExceptionInspection */
            tdf_current_user()->decreasePackage($userPaymentPackageId);

            $this->successJsonResponse([
                'redirect' => PanelWidget::getUrl(PanelWidget::ACTION_LIST),
            ]);
            return;
        }

        $this->handlePackage($package, $model);
    }

    private function handlePackage(RegularUserPaymentPackageInterface $package, Model $model): void
    {
        $action = new ApplyPackageAction();
        if (!$action->apply($package, $model)) {
            $this->errorJsonResponse([]);
            /** @noinspection ForgottenDebugOutputInspection */
            wp_die();
        }

        if (!$model->isPublished()) {
            $model->setPublish();
        }

        $this->successJsonResponse([
            'redirect' => PanelWidget::getUrl(PanelWidget::ACTION_LIST),
        ]);
        /** @noinspection ForgottenDebugOutputInspection */
        wp_die();
    }

    /**
     * @param Model $model
     * @param int|string $userPaymentPackageId
     * @return void
     */
    private function setPendingPackage(Model $model, $userPaymentPackageId): void
    {
        $model->setPendingPackage($userPaymentPackageId);

        $model->setPending();

        do_action(tdf_prefix() . '/notifications/trigger', Trigger::USER_MODEL_PENDING, [
            'user' => $model->getUserId(),
            'model' => $model->getId(),
        ]);

        do_action(tdf_prefix() . '/notifications/trigger', Trigger::MODERATION_MODEL_PENDING, [
            'user' => $model->getUserId(),
            'model' => $model->getId(),
        ]);
    }
}