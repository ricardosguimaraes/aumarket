<?php

use Tangibledesign\Framework\Models\Payments\SelectSubscriptionInterface;

$userSubscription = tdf_current_user()->getUserSubscription();
$currentSubscription = $userSubscription ? $userSubscription->getSubscription() : null;
?>
<div class="listivo-panel-head">
    <div class="listivo-container">
        <h1 class="listivo-panel-head__label">
            <?php echo esc_html(tdf_string('choose_a_subscription')); ?>
        </h1>
    </div>
</div>

<div class="listivo-panel-section">
    <div class="listivo-container">
        <div class="listivo-panel-section__content listivo-panel-section__content--no-margin-top">
            <lst-select-subscription
                    request-url="<?php echo esc_url(tdf_action_url('tdf/subscriptions/select')); ?>"
                    confirm-downgrade-title="<?php echo esc_attr(tdf_string('confirm_downgrade_title')); ?>"
                    confirm-downgrade-text="<?php echo esc_attr(tdf_string('confirm_downgrade_text')); ?>"
                    confirm-downgrade-button-text="<?php echo esc_attr(tdf_string('confirm_downgrade_button_text')); ?>"
                    confirm-downgrade-cancel-button-text="<?php echo esc_attr(tdf_string('cancel')); ?>"
                <?php if ($currentSubscription) : ?>
                    current-subscription-key="<?php echo esc_attr($currentSubscription->getKey()); ?>"
                <?php endif; ?>
            >
                <div slot-scope="props">
                    <div class="listivo-panel-packages-v2">
                        <?php
                        global $subscription;
                        foreach (tdf_app('current_user_subscription_list') as $subscription) :
                            /* @var SelectSubscriptionInterface $subscription */
                            get_template_part('templates/widgets/general/panel/subscription_card');
                        endforeach;
                        ?>
                    </div>
                </div>
            </lst-select-subscription>
        </div>
    </div>
</div>
