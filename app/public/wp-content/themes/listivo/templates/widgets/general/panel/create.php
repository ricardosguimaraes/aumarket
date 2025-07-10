<?php

use Tangibledesign\Listivo\Widgets\General\PanelWidget;

/* @var PanelWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstNameRequired = tdf_settings()->getAutoGenerateModelTitleFields()->isEmpty() && tdf_settings()->nameRequired();

if (is_user_logged_in()) :
    get_template_part('templates/widgets/general/panel/header');
endif;
?>
<div class="listivo-panel-section">
    <lst-panel-model-form
            class="listivo-container"
            terms-and-conditions-error-title="<?php echo esc_attr(tdf_string('terms_and_conditions_not_accepted')); ?>"
            terms-and-conditions-error-text="<?php echo esc_attr(tdf_string('terms_and_conditions_not_accepted_text')); ?>"
            :terms-accept-required="<?php echo esc_attr(!empty(tdf_settings()->getListingTermsAndConditions()) ? 'true' : 'false'); ?>"
            request-url="<?php echo esc_url(tdf_action_url('listivo/listings/create')); ?>"
            :initial-model="<?php echo htmlspecialchars(json_encode($lstCurrentWidget->getInitialModel())); ?>"
            :dependency-terms="<?php echo htmlspecialchars(json_encode(tdf_app('dependency_terms'))); ?>"
            error-title-text="<?php echo esc_attr(tdf_string('required_field_is_empty')); ?>"
            error-message-text="<?php echo esc_attr(tdf_string('complete_all_required_fields')); ?>"
            confirm-button-text="<?php echo esc_attr(tdf_string('ok')); ?>"
            error-title="<?php echo esc_attr(tdf_string('something_went_wrong')); ?>"
            error-selector=".listivo-has-error, .listivo-field-error"
            login-button-text="<?php echo esc_attr(tdf_string('log_in')); ?>"
            login-url="<?php echo esc_url(tdf_settings()->getLoginPageUrl()); ?>"
            register-button-text="<?php echo esc_attr(tdf_string('register')); ?>"
            register-url="<?php echo esc_url(tdf_settings()->getRegisterPageUrl()); ?>"
        <?php if (tdf_settings()->userRegistrationOpen()) : ?>
            :registration-enabled="true"
        <?php endif; ?>
            name-too-long-title="<?php echo esc_attr(tdf_string('name_too_long')); ?>"
            name-too-long-message="<?php echo esc_attr(tdf_string('name_too_long_message')); ?>"
            :max-name-length="<?php echo esc_attr(tdf_settings()->getNameLength()); ?>"
            :name-required="<?php echo esc_attr($lstNameRequired ? 'true' : 'false'); ?>"
            :description-required="<?php echo esc_attr(tdf_settings()->descriptionRequired() ? 'true' : 'false'); ?>"
            redirect-url="<?php echo esc_url($lstCurrentWidget->getModelFormRedirectUrl()); ?>"
            nonce="<?php echo esc_attr(wp_create_nonce(tdf_prefix() . '_create_model')); ?>"
            td-nonce="<?php echo esc_attr(wp_create_nonce(tdf_prefix() . '_create_model')); ?>"
        <?php if (!empty($lstCurrentWidget->getPackageId())) : ?>
            :package-id="<?php echo esc_attr($lstCurrentWidget->getPackageId()); ?>"
        <?php endif; ?>
    >
        <div class="listivo-container" slot-scope="modelForm">
            <div class="listivo-panel-section__top">
                <h1 class="listivo-panel-section__label">
                    <?php echo esc_html(tdf_string('add_listing')); ?>
                </h1>

                <?php get_template_part('templates/widgets/general/panel/packages_bar'); ?>
            </div>

            <?php if (!is_user_logged_in()) : ?>
                <div class="listivo-panel-form__not-logged">
                    <?php echo esc_html(tdf_string('you_can_also')) ?> <a
                            href="<?php echo esc_url(tdf_settings()->getLoginPageUrl()) ?>"
                    ><?php echo esc_html(tdf_string('log_in')); ?></a>
                    <?php if (tdf_settings()->userRegistrationOpen()) : ?>
                        <?php echo esc_html(tdf_string('or')); ?> <a
                                href="<?php echo esc_url(tdf_settings()->getRegisterPageUrl()); ?>"
                        ><?php echo esc_html(tdf_string('register')); ?></a>
                    <?php endif; ?>
                    <?php echo esc_html(tdf_string('first.')); ?>
                </div>
            <?php endif; ?>

            <template>
                <div class="listivo-panel-section__form listivo-panel-form">
                    <div class="listivo-panel-form__fields">
                        <?php get_template_part('templates/widgets/general/panel/form_fields'); ?>
                    </div>

                    <?php if (!empty(tdf_settings()->getListingTermsAndConditions())) : ?>
                        <div
                                class="listivo-panel-form__terms-and-conditions"
                                :class="{'listivo-panel-form__terms-and-conditions--error listivo-has-error': !modelForm.termsAccept && modelForm.showErrors}"
                        >
                            <div class="listivo-panel-form__terms-and-conitions-checkbox-wrapper">
                                <div
                                        @click.stop.prevent="modelForm.setTermsAccept"
                                        class="listivo-checkbox"
                                        :class="{'listivo-checkbox--checked': modelForm.termsAccept}"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                         fill="none">
                                        <path
                                                d="M11.7142 0.779513L10.6378 0.103783C10.3399 -0.0824758 9.93186 -0.011004 9.73252 0.261887L4.45585 7.44801L2.03093 5.20858C1.77765 4.97467 1.3649 4.97467 1.11162 5.20858L0.18996 6.05974C-0.06332 6.29364 -0.06332 6.67482 0.18996 6.9109L3.91881 10.3545C4.12753 10.5473 4.45585 10.6945 4.75135 10.6945C5.04684 10.6945 5.34468 10.5235 5.53698 10.2657L11.8877 1.61335C12.0894 1.34046 12.012 0.965772 11.7142 0.779513Z"
                                                fill="#FDFDFE"/>
                                    </svg>
                                </div>
                            </div>

                            <span><?php echo wp_kses_post(tdf_settings()->getListingTermsAndConditions()); ?></span>
                        </div>
                    <?php endif; ?>

                    <div class="listivo-panel-form__bottom">
                        <button
                                class="listivo-button listivo-button--primary-1"
                                :class="{'listivo-button--loading': modelForm.isDisabled}"
                                :disabled="modelForm.isDisabled"
                                @click.prevent="modelForm.onSubmit"
                        >
                            <span>
                                <?php echo esc_html(tdf_string('add_listing')); ?>

                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
                                     fill="none">
                                    <path
                                            d="M5.00488 11.525V7.075H0.854883V5.125H5.00488V0.65H7.00488V5.125H11.1549V7.075H7.00488V11.525H5.00488Z"
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
                                        <animate attributeName='fill-opacity' from='1' to='1' begin='0s' dur='0.8s'
                                                 values='1;.5;1'
                                                 calcMode='linear' repeatCount='indefinite'/>
                                    </circle>

                                    <circle cx='60' cy='15' r='9' fill-opacity='0.3'>
                                        <animate attributeName='r' from='9' to='9' begin='0s' dur='0.8s' values='9;15;9'
                                                 calcMode='linear' repeatCount='indefinite'/>
                                        <animate attributeName='fill-opacity' from='0.5' to='0.5' begin='0s' dur='0.8s'
                                                 values='.5;1;.5' calcMode='linear' repeatCount='indefinite'/>
                                    </circle>

                                    <circle cx='105' cy='15' r='15'>
                                        <animate attributeName='r' from='15' to='15' begin='0s' dur='0.8s'
                                                 values='15;9;15'
                                                 calcMode='linear' repeatCount='indefinite'/>
                                        <animate attributeName='fill-opacity' from='1' to='1' begin='0s' dur='0.8s'
                                                 values='1;.5;1'
                                                 calcMode='linear' repeatCount='indefinite'/>
                                    </circle>
                                </svg>
                            </template>
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </lst-panel-model-form>
</div>