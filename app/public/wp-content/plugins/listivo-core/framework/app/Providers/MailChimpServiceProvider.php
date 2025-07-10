<?php

namespace Tangibledesign\Framework\Providers;

use Exception;
use MC4WP_MailChimp;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\User\User;

class MailChimpServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action(tdf_prefix() . '/user/marketingConsent/added', [$this, 'subscribe']);
        add_action(tdf_prefix() . '/user/marketingConsent/removed', [$this, 'unsubscribe']);
    }

    public function subscribe(User $user): void
    {
        if (!class_exists('MC4WP_MailChimp')) {
            return;
        }

        $mailchimp = new MC4WP_MailChimp();
        foreach ($mailchimp->get_lists(true) as $list) {
            try {
                if (!$mailchimp->list_has_subscriber($list->id, $user->getMail())) {
                    $mailchimp->list_subscribe($list->id, $user->getMail());
                }
            } catch (Exception $e) {

            }
        }
    }

    public function unsubscribe(User $user): void
    {
        if (!class_exists('MC4WP_MailChimp')) {
            return;
        }

        $mailchimp = new MC4WP_MailChimp();
        foreach ($mailchimp->get_lists(true) as $list) {
            try {
                if ($mailchimp->list_has_subscriber($list->id, $user->getMail())) {
                    $mailchimp->list_unsubscribe($list->id, $user->getMail());
                }
            } catch (Exception $e) {

            }
        }
    }
}