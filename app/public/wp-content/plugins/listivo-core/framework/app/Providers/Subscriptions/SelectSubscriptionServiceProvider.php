<?php

namespace Tangibledesign\Framework\Providers\Subscriptions;

use Tangibledesign\Framework\Actions\UserSubscription\CreateFreeUserSubscriptionAction;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Payments\Subscription;
use Tangibledesign\Framework\Models\Payments\SubscriptionInterface;
use Tangibledesign\Framework\Models\Payments\UserSubscription;
use Tangibledesign\Framework\Models\User\User;
use Tangibledesign\Framework\Widgets\General\PanelWidget;

class SelectSubscriptionServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('admin_post_tdf/subscriptions/select', [$this, 'selectSubscription']);
        add_action('tdf/user/registered', [$this, 'selectFreeSubscription']);
        add_action('tdf/userSubscription/cancelled', [$this, 'onSubscriptionCancelled'], 10, 2);
    }

    public function onSubscriptionCancelled(User $user, UserSubscription $userSubscription): void
    {
        if (!tdf_settings()->isFreeSubscriptionEnabled()) {
            return;
        }

        if ($userSubscription->isFree()) {
            return;
        }

        (new CreateFreeUserSubscriptionAction())->execute($user, true);
    }

    public function selectSubscription(): void
    {
        $user = tdf_current_user();
        if (!$user instanceof User) {
            return;
        }

        $subscriptionKey = (string)($_POST['subscription'] ?? null);
        if (empty($subscriptionKey)) {
            return;
        }

        if ($subscriptionKey === 'free') {
            $this->handleFreeSubscription($user);
            return;
        }

        $subscription = tdf_subscriptions()->find(static function ($subscription) use ($subscriptionKey) {
            /* @var Subscription $subscription */
            return $subscription->getKey() === $subscriptionKey;
        });

        if (!$subscription instanceof Subscription) {
            return;
        }

        $this->checkModelInProgress($user);

        do_action('tdf/userSubscription/init', $subscription);
    }

    private function handleFreeSubscription(User $user): void
    {
        if ($this->selectFreeSubscription($user)) {
            $this->successResponse();
        }
    }

    public function selectFreeSubscription(User $user): bool
    {
        if (!tdf_settings()->subscriptionsEnabled()) {
            return false;
        }

        if (!tdf_settings()->isFreeSubscriptionEnabled()) {
            return false;
        }

        $hasSubscription = $user->hasUserSubscription();
        if ($hasSubscription && !$this->cancelCurrentSubscription($user, 'free')) {
            return false;
        }

        if ($hasSubscription) {
            return true;
        }

        $userSubscriptionId = (new CreateFreeUserSubscriptionAction())->execute($user);
        if (empty($userSubscriptionId)) {
            return false;
        }

        $this->checkModelInProgress($user);

        return true;
    }

    private function successResponse(): void
    {
        $this->successJsonResponse([
            'redirect' => PanelWidget::getUrl(PanelWidget::ACTION_SELECT_SUBSCRIPTION_SUCCESS),
        ]);
    }

    private function checkModelInProgress(User $user): void
    {
        $modelId = (int)($_POST['modelId'] ?? 0);
        if (empty($modelId)) {
            return;
        }

        $user->setModelInProgress($modelId);
    }

    private function cancelCurrentSubscription(User $user, string $newSubscriptionKey): bool
    {
        $userSubscription = $user->getUserSubscription();
        if (!$userSubscription instanceof UserSubscription) {
            return true;
        }

        $subscription = $userSubscription->getSubscription();
        if (!$subscription instanceof SubscriptionInterface) {
            return true;
        }

        if ($subscription->getKey() === $newSubscriptionKey) {
            return false;
        }

        do_action('tdf/userSubscription/cancel', $userSubscription);

        return true;
    }
}