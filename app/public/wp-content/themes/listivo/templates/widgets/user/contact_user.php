<?php

use Tangibledesign\Listivo\Widgets\User\ContactUserWidget;

/* @var ContactUserWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstUser = $lstCurrentWidget->getUser();
if (!$lstUser) {
    return;
}

$lstModel = $lstCurrentWidget->getModel();
$lstInitialMessage = '';

if ($lstModel && is_singular(tdf_model_post_type())) {
    $lstInitialMessage = tdf_settings()->getMessageSystemInitialMessage($lstModel);
}

if ($lstCurrentWidget->isContactFormType()) : ?>
    <?php $lstCurrentWidget->displayForm(); ?>
<?php else : ?>
    <div class="listivo-app">
        <lst-create-direct-message
            request-url="<?php echo esc_url(tdf_action_url('listivo/directMessages/create')); ?>"
            :user-id="<?php echo esc_attr($lstUser->getId()); ?>"
            redirect-url="<?php echo esc_url($lstCurrentWidget->getRedirectUrl($lstUser->getId())); ?>"
            :is-logged="<?php echo esc_attr(is_user_logged_in() ? 'true' : 'false'); ?>"
            :same-user="<?php echo esc_attr($lstUser->getId() === get_current_user_id() ? 'true' : 'false'); ?>"
            same-user-text="<?php echo esc_attr(tdf_string('same_user_message')); ?>"
            initial-message="<?php echo esc_attr($lstInitialMessage); ?>"
            td-nonce="<?php echo esc_attr(wp_create_nonce('listivo_create_message')); ?>"
            create-message-nonce="<?php echo esc_attr(wp_create_nonce('listivo_create_message')); ?>"
        >
            <form slot-scope="props">
                <div
                    <?php if ($lstCurrentWidget->isUserPage()) : ?>
                        class="listivo-create-message-form listivo-create-message-form--user"
                    <?php else : ?>
                        class="listivo-create-message-form"
                    <?php endif; ?>
                >
                    <?php if ($lstCurrentWidget->showLabel()) : ?>
                        <div class="listivo-create-message-form__label">
                            <?php echo esc_html(tdf_string('send_message')); ?>
                        </div>
                    <?php endif; ?>

                    <div class="listivo-create-message-form__form">
                        <textarea
                            @focusin="props.checkSameUser"
                            @input="props.setMessage($event.target.value)"
                            :value="props.message"
                                <?php if ($lstCurrentWidget->isUserPage()) : ?>
                                    placeholder="<?php echo esc_attr(tdf_string('write_your_message_here')); ?>"
                                <?php endif; ?>
                        ></textarea>
                    </div>

                    <div class="listivo-create-message-form__button">
                        <button
                            <?php if ($lstCurrentWidget->isPrimary1ButtonType()) : ?>
                                class="listivo-button listivo-button--primary-1"
                            <?php else : ?>
                                class="listivo-button listivo-button--primary-2"
                            <?php endif; ?>
                            :disabled="props.inProgress"
                            @click.prevent="props.onCreate"
                        >
                            <span>
                                <?php if ($lstCurrentWidget->isUserPage()) : ?>
                                    <?php echo esc_html(tdf_string('send_message')); ?>
                                <?php else : ?>
                                    <?php echo esc_html(tdf_string('send')); ?>
                                <?php endif; ?>

                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                     fill="none">
                                    <path
                                        d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49605 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455586 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z"
                                        fill="#FDFDFE"/>
                                </svg>
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </lst-create-direct-message>
    </div>
<?php
endif;