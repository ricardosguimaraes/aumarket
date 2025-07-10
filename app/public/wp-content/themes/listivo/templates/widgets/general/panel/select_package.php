<?php

use Tangibledesign\Framework\Models\Payments\Subscription;
use Tangibledesign\Framework\Models\User\User;
use Tangibledesign\Framework\Widgets\General\PanelWidget;

/* @var PanelWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstCurrentUser = tdf_current_user();
if (!$lstCurrentUser instanceof User) {
    return;
}

$lstModel = $lstCurrentWidget->getSelectPackageModel();
$lstUserPackagesForModel = tdf_user_payment_packages_repository()
    ->getRegularPaymentPackagesForModel($lstCurrentUser, $lstModel);

$lstPackagesForModel = tdf_payment_packages_repository()
    ->getRegularPaymentPackagesForModel($lstCurrentUser, $lstModel);

$lstType = $lstUserPackagesForModel->isEmpty() && tdf_settings()->subscriptionsEnabled() && !$lstCurrentUser->hasUserSubscription()
    ? 'subscription'
    : 'package';
?>
<div class="listivo-panel-head">
    <div class="listivo-container">
        <h1 class="listivo-panel-head__label">
            <?php if ($lstType === 'subscription') : ?>
                <?php echo esc_html(tdf_string('select_subscription')); ?>
            <?php else : ?>
                <?php echo esc_html(tdf_string('select_package')); ?>
            <?php endif; ?>
        </h1>
    </div>
</div>

<div class="listivo-panel-section">
    <div class="listivo-container">
        <div class="listivo-panel-section__content listivo-panel-section__content--no-margin-top">
            <?php if ($lstType === 'subscription') : ?>
                <lst-select-subscription
                        request-url="<?php echo esc_url(admin_url('admin-post.php?action=tdf/subscriptions/select')); ?>"
                        :model-id="<?php echo esc_attr($lstModel->getId()); ?>"
                >
                    <div slot-scope="props">
                        <div class="listivo-panel-packages-v2">
                            <?php
                            global $subscription;
                            foreach (tdf_app('current_user_subscription_list') as $subscription) :
                                /* @var Subscription $subscription */
                                get_template_part('templates/widgets/general/panel/subscription_card');
                            endforeach;
                            ?>
                        </div>
                    </div>
                </lst-select-subscription>
            <?php else : ?>
                <template>
                    <lst-select-package
                            request-url="<?php echo esc_url(admin_url('admin-ajax.php?action=listivo/monetization/selectPackage')); ?>"
                            :model-id="<?php echo esc_attr($lstModel->getId()); ?>"
                            close-text="<?php echo esc_attr(tdf_string('close')); ?>"
                            error-title="<?php echo esc_attr(tdf_string('something_went_wrong')); ?>"
                            initial-tab="<?php echo esc_attr($lstUserPackagesForModel->isNotEmpty() ? 'my' : 'buy'); ?>"
                    >
                        <div slot-scope="props">
                            <?php if ($lstUserPackagesForModel->isNotEmpty()) : ?>
                                <div class="listivo-panel-packages">
                                    <?php

                                    global $lstPackage;
                                    foreach ($lstUserPackagesForModel as $lstPackage) :
                                        get_template_part('templates/widgets/general/panel/my_package');
                                    endforeach;

                                    if (tdf_settings()->isFreeListingEnabled()) :
                                        global $lstPaymentPackage;
                                        $lstPaymentPackage = tdf_app('free_package');
                                        get_template_part('templates/widgets/general/panel/package');
                                    endif;
                                    ?>
                                </div>
                            <?php else : ?>
                                <div class="listivo-panel-packages-v2">
                                    <?php
                                    global $lstPaymentPackage;

                                    if (tdf_settings()->isFreeListingEnabled()) :
                                        $lstPaymentPackage = tdf_app('free_package');
                                        get_template_part('templates/widgets/general/panel/package_v2');
                                    endif;

                                    foreach (tdf_payment_packages_repository()->getRegularPaymentPackagesForModel($lstCurrentUser,
                                        $lstModel) as $lstPaymentPackage) :
                                        get_template_part('templates/widgets/general/panel/package_v2');
                                    endforeach;
                                    ?>
                                </div>
                            <?php endif; ?>

                            <div class="listivo-panel-section__button">
                                <div class="listivo-panel-section__buy-button">
                                    <?php if ($lstPackagesForModel->isNotEmpty()) : ?>
                                        <a
                                                class="listivo-button listivo-button--primary-2"
                                                href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_BUY_PACKAGE)); ?>?id=<?php echo esc_attr($lstModel->getId()); ?>"
                                        >
                                            <span>
                                                <?php echo esc_html(tdf_string('purchase_new_package')); ?>

                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11"
                                                     viewBox="0 0 12 11"
                                                     fill="none">
                                                    <path d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49605 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455586 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z"
                                                          fill="#FDFDFE"/>
                                                </svg>
                                            </span>
                                        </a>
                                    <?php endif; ?>
                                </div>

                                <button
                                        class="listivo-button listivo-button--primary-1"
                                        :class="{'listivo-button--loading': props.inProgress}"
                                        :disabled="props.inProgess"
                                        @click.prevent="props.onNext"
                                >
                                    <span>
                                        <?php echo esc_html(tdf_string('next')); ?>

                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11"
                                             viewBox="0 0 12 11"
                                             fill="none">
                                            <path d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49605 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455586 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z"
                                                  fill="#FDFDFE"/>
                                        </svg>
                                    </span>

                                    <template>
                                        <svg
                                                width='40'
                                                height='10'
                                                viewBox='0 0 120 30'
                                                xmlns='http://www.w3.org/2000/svg'
                                                fill='#fff'
                                                class="listivo-button__loading"
                                        >
                                            <circle cx='15' cy='15' r='15'>
                                                <animate attributeName='r' from='15' to='15' begin='0s' dur='0.8s'
                                                         values='15;9;15'
                                                         calcMode='linear' repeatCount='indefinite'/>
                                                <animate attributeName='fill-opacity' from='1' to='1' begin='0s'
                                                         dur='0.8s'
                                                         values='1;.5;1'
                                                         calcMode='linear' repeatCount='indefinite'/>
                                            </circle>

                                            <circle cx='60' cy='15' r='9' fill-opacity='0.3'>
                                                <animate attributeName='r' from='9' to='9' begin='0s' dur='0.8s'
                                                         values='9;15;9'
                                                         calcMode='linear' repeatCount='indefinite'/>
                                                <animate attributeName='fill-opacity' from='0.5' to='0.5' begin='0s'
                                                         dur='0.8s'
                                                         values='.5;1;.5' calcMode='linear' repeatCount='indefinite'/>
                                            </circle>

                                            <circle cx='105' cy='15' r='15'>
                                                <animate attributeName='r' from='15' to='15' begin='0s' dur='0.8s'
                                                         values='15;9;15'
                                                         calcMode='linear' repeatCount='indefinite'/>
                                                <animate attributeName='fill-opacity' from='1' to='1' begin='0s'
                                                         dur='0.8s'
                                                         values='1;.5;1'
                                                         calcMode='linear' repeatCount='indefinite'/>
                                            </circle>
                                        </svg>
                                    </template>
                                </button>
                            </div>
                        </div>
                    </lst-select-package>
                </template>
            <?php endif; ?>
        </div>
    </div>
</div>