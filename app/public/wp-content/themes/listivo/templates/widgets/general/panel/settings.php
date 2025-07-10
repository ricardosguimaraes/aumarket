<?php

use Tangibledesign\Framework\Models\User\User;
use Tangibledesign\Listivo\Widgets\General\PanelWidget;

/* @var PanelWidget $lstCurrentWidget */
global $lstCurrentWidget;

get_template_part('templates/widgets/general/panel/header');

$lstCurrentUser = tdf_current_user();
if (!$lstCurrentUser instanceof User) {
    return;
}
?>
<div class="listivo-panel-section">
    <div class="listivo-container">
        <div class="listivo-panel-section__top">
            <h1 class="listivo-panel-section__label">
                <?php echo esc_html($lstCurrentWidget->getTitle()); ?>
            </h1>

            <?php get_template_part('templates/widgets/general/panel/packages_bar'); ?>
        </div>

        <div class="listivo-panel-section__content">
            <lst-accordion
                    class="listivo-panel-accordions"
                    item-selector=".listivo-panel-accordion__content-wrapper--"
                <?php if (tdf_settings()->subscriptionsEnabled() && $lstCurrentUser->hasUserSubscription()) : ?>
                    initial-open="subscription"
                <?php else : ?>
                    initial-open="details"
                <?php endif; ?>
            >
                <div slot-scope="accordions" class="listivo-panel-accordions">
                    <?php get_template_part('templates/widgets/general/panel/settings/subscription'); ?>

                    <?php get_template_part('templates/widgets/general/panel/settings/details'); ?>

                    <?php get_template_part('templates/widgets/general/panel/settings/image'); ?>

                    <?php get_template_part('templates/widgets/general/panel/settings/cover_image'); ?>

                    <?php get_template_part('templates/widgets/general/panel/settings/socials'); ?>

                    <?php get_template_part('templates/widgets/general/panel/settings/change_password'); ?>

                    <?php get_template_part('templates/widgets/general/panel/settings/change_email'); ?>
                </div>
            </lst-accordion>
        </div>

        <div class="listivo-panel-section__bottom">
            <lst-delete-account
                    request-url="<?php echo esc_url(tdf_action_url('listivo/users/delete')); ?>"
                    redirect-url="<?php echo esc_url(tdf_settings()->getLoginPageUrl()); ?>"
                    delete-title-text="<?php echo esc_attr(tdf_string('delete_account')); ?>"
                    delete-text="<?php echo esc_attr(tdf_string('account_delete_confirm_text')); ?>"
                    confirm-button-text="<?php echo esc_attr(tdf_string('confirm')); ?>"
                    cancel-button-text="<?php echo esc_attr(tdf_string('cancel')); ?>"
            >
                <div
                        slot-scope="deleteAccount"
                        class="listivo-panel-section__delete-account"
                        @click="deleteAccount.onClick"
                >
                    <?php echo esc_html(tdf_string('delete_account')); ?>
                </div>
            </lst-delete-account>
        </div>
    </div>
</div>