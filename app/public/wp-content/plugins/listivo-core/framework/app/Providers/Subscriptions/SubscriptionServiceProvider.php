<?php

namespace Tangibledesign\Framework\Providers\Subscriptions;

use Tangibledesign\Framework\Actions\Subscriptions\CreateSubscriptionAction;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Payments\FreeSubscription;
use Tangibledesign\Framework\Models\Payments\Subscription;

class SubscriptionServiceProvider extends ServiceProvider
{

    public function initiation(): void
    {
        $this->container['free_subscription'] = static function () {
            return new FreeSubscription();
        };

        $this->container['subscriptions'] = static function () {
            $ids = tdf_settings()->getSubscriptionIds();
            if (empty($ids)) {
                return tdf_query_subscriptions()->get();
            }

            $subscriptions = tdf_query_subscriptions()
                ->in($ids)
                ->orderByIn()
                ->get()
                ->filter(static function ($subscription) {
                    return $subscription !== false;
                });

            if ($subscriptions->isEmpty()) {
                return tdf_query_subscriptions()->get();
            }

            return $subscriptions;
        };

        $this->container['subscription_list'] = static function () {
            $subscriptions = tdf_collect();

            if (tdf_settings()->isFreeSubscriptionEnabled()) {
                $subscriptions->add(tdf_app('free_subscription'));
            }

            return $subscriptions->merge(tdf_app('subscriptions'));
        };

        $this->container['current_user_subscription_list'] = static function () {
            if (!tdf_current_user()) {
                return tdf_collect();
            }

            $currentUserAccountType = tdf_current_user()->getAccountType();

            return tdf_app('subscription_list')->filter(static function ($subscription) use ($currentUserAccountType) {
                /* @var Subscription $subscription */
                $accountType = $subscription->getUserAccountType();
                if ($accountType === 'any') {
                    return true;
                }

                return $accountType === $currentUserAccountType;
            });
        };
    }

    public function afterInitiation(): void
    {
        add_filter('tdf/posttypes', static function ($postTypes) {
            if (!tdf_settings()->subscriptionsEnabled()) {
                return $postTypes;
            }

            $postTypes[] = [
                'key' => tdf_prefix() . '_subscription',
                'name' => tdf_admin_string('subscriptions'),
                'singular_name' => tdf_admin_string('subscription'),
                'settings' => [
                    'public' => false,
                    'publicly_queryable' => false,
                    'show_ui' => false,
                    'show_in_menu' => false,
                    'query_var' => false,
                    'has_archive' => false,
                    'hierarchical' => false,
                    'supports' => ['title'],
                ],
            ];

            $postTypes[] = [
                'key' => tdf_prefix() . '_user_subs',
                'name' => tdf_admin_string('user_subscriptions'),
                'singular_name' => tdf_admin_string('user_subscription'),
                'settings' => [
                    'public' => false,
                    'publicly_queryable' => false,
                    'show_ui' => false,
                    'show_in_menu' => false,
                    'query_var' => false,
                    'has_archive' => false,
                    'hierarchical' => false,
                    'supports' => ['title'],
                ],
            ];

            $postTypes[] = [
                'key' => tdf_prefix() . '_invoice',
                'name' => tdf_admin_string('invoice'),
                'singular_name' => tdf_admin_string('invoice'),
                'settings' => [
                    'public' => true,
                    'publicly_queryable' => false,
                    'show_ui' => false,
                    'show_in_menu' => false,
                    'query_var' => false,
                    'has_archive' => false,
                    'hierarchical' => false,
                    'supports' => ['title'],
                ],
            ];

            return $postTypes;
        });

        add_action('admin_post_' . tdf_prefix() . '/subscriptions/create', [$this, 'create']);

        add_action('admin_post_' . tdf_prefix() . '/subscriptions/update', [$this, 'update']);

        add_action('admin_post_' . tdf_prefix() . '/subscriptions/delete', [$this, 'delete']);

        add_action('admin_post_' . tdf_prefix() . '/subscriptions/updateOrder', [$this, 'updateOrder']);
    }

    public function updateOrder(): void
    {
        if (!$this->currentUserCanManageOptions()) {
            return;
        }

        $ids = $_POST['subscriptionIds'];
        if (!is_array($ids)) {
            return;
        }

        tdf_settings()->setSubscriptionIds($ids);

        tdf_settings()->save();
    }

    public function delete(): void
    {
        if (!$this->currentUserCanManageOptions()) {
            return;
        }

        $subscriptionId = (int)($_POST['subscriptionId'] ?? 0);
        if (empty($subscriptionId)) {
            return;
        }

        $subscription = tdf_subscription_factory()->create($subscriptionId);
        if (!$subscription) {
            return;
        }

        wp_delete_post($subscription->getId(), true);

        do_action('tdf/subscriptions/deleted', $subscription);
    }

    public function create(): void
    {
        if (!wp_verify_nonce($_POST['nonce'] ?? '', tdf_prefix() . '/subscriptions/create')) {
            return;
        }

        if (!$this->currentUserCanManageOptions()) {
            return;
        }

        $subscription = (new CreateSubscriptionAction())->execute($_POST);
        if (!$subscription) {
            wp_safe_redirect(admin_url('admin.php?page=' . tdf_prefix() . '_monetization&tab=subscriptions'));
            exit;
        }

        tdf_settings()->addSubscription($subscription->getId());

        do_action('tdf/subscriptions/created', $subscription);

        wp_safe_redirect(admin_url('admin.php?page=' . tdf_prefix() . '-edit-subscription&subscription_id=' . $subscription->getId()));
        exit;
    }

    public function update(): void
    {
        if (!wp_verify_nonce($_POST['nonce'] ?? '', tdf_prefix() . '/subscriptions/update')) {
            return;
        }

        if (!$this->currentUserCanManageOptions()) {
            return;
        }

        $subscription = tdf_subscription_factory()->create((int)$_POST['subscription_id']);
        if (!$subscription instanceof Subscription) {
            wp_safe_redirect(admin_url('admin.php?page=' . tdf_prefix() . '_monetization&tab=subscriptions'));
            exit;
        }

        $subscription->setData($_POST['subscription'] ?? []);

        do_action('tdf/subscriptions/updated', $subscription);

        wp_safe_redirect(admin_url('admin.php?page=' . tdf_prefix() . '_monetization&tab=subscriptions'));
        exit;
    }

}