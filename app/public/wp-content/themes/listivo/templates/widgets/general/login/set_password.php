<?php
/* @var \Tangibledesign\Listivo\Widgets\General\LoginAndRegisterWidget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div
    <?php if (!empty($lstCurrentWidget->getBackgroundImage())) : ?>
        class="listivo-app listivo-login-widget listivo-login-widget--with-background"
        style="background-image: url('<?php echo esc_url($lstCurrentWidget->getBackgroundImage()); ?>');"
    <?php else : ?>
        class="listivo-app listivo-login-widget"
    <?php endif; ?>
>
    <div class="listivo-set-password">
        <h1 class="listivo-set-password__label">
            <?php echo esc_html(tdf_string('set_new_password')); ?>
        </h1>

        <lst-set-password
                request-url="<?php echo esc_url(tdf_action_url('listivo/user/setPassword')); ?>"
                redirect-url="<?php echo esc_url(tdf_settings()->getLoginPageUrl()); ?>"
                td-nonce="<?php echo esc_attr(wp_create_nonce(tdf_prefix() . '_set_password')); ?>"
                selector="<?php echo esc_attr($lstCurrentWidget->getSelector()); ?>"
                validator="<?php echo esc_attr($lstCurrentWidget->getValidator()); ?>"
                close-text="<?php echo esc_attr(tdf_string('close')); ?>"
            <?php if (tdf_settings()->reCaptchaEnabled()) : ?>
                :re-captcha="true"
                re-captcha-key="<?php echo esc_attr(tdf_settings()->getReCaptchaSiteKey()); ?>"
            <?php endif; ?>
        >
            <div slot-scope="props" class="listivo-set-password__form">
                <form @submit.prevent="props.onSet">
                    <div
                            class="listivo-input-v2 listivo-input-v2--with-icon"
                            :class="{
                                'listivo-input-v2--active': props.password.length > 0,
                                'listivo-input-v2--error': props.showErrors && (!props.errors.password.required || !props.errors.password.minLength),
                            }"
                    >
                        <div class="listivo-input-v2__icon listivo-icon-v2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="16" viewBox="0 0 13 16"
                                 fill="none">
                                <path d="M6.09524 0C3.56281 0 1.52381 2.039 1.52381 4.57143V5.33333C0.691 5.33333 0 6.02433 0 6.85714V14.4762C0 15.309 0.691 16 1.52381 16H10.6667C11.4995 16 12.1905 15.309 12.1905 14.4762V6.85714C12.1905 6.02433 11.4995 5.33333 10.6667 5.33333V4.57143C10.6667 2.039 8.62766 0 6.09524 0ZM6.09524 1.52381C7.82948 1.52381 9.14286 2.83719 9.14286 4.57143V5.33333H3.04762V4.57143C3.04762 2.83719 4.361 1.52381 6.09524 1.52381ZM1.52381 6.85714H10.6667V14.4762H1.52381V6.85714ZM6.09524 9.14286C5.25714 9.14286 4.57143 9.82857 4.57143 10.6667C4.57143 11.5048 5.25714 12.1905 6.09524 12.1905C6.93333 12.1905 7.61905 11.5048 7.61905 10.6667C7.61905 9.82857 6.93333 9.14286 6.09524 9.14286Z"
                                      fill="#374B5C"/>
                            </svg>
                        </div>

                        <input
                                type="password"
                                :value="props.password"
                                @input="props.setPassword($event.target.value)"
                                placeholder="<?php echo esc_attr(tdf_string('new_password')); ?>"
                        >

                        <template>
                            <div
                                    class="listivo-input-v2__error listivo-field-error"
                                    v-if="props.showErrors && (!props.errors.password.required || !props.errors.password.minLength)"
                            >
                                <div class="listivo-field-error__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="9" viewBox="0 0 10 9"
                                         fill="none">
                                        <path d="M0.105217 7.80234L4.38783 0.354178C4.51386 0.135013 4.74732 0 4.99999 0C5.25265 0 5.48611 0.135013 5.61214 0.354178L9.89475 7.80234C10.0269 8.03213 10.0351 8.31277 9.91661 8.54991L9.9164 8.55032C9.78241 8.8181 9.50871 8.98722 9.20927 8.98722H0.790697C0.491259 8.98722 0.217558 8.8181 0.0837706 8.55032L0.0835662 8.54991C-0.035106 8.31277 -0.0269357 8.03213 0.105217 7.80234Z"
                                              fill="#FDFDFE"/>
                                        <path d="M5.40848 7.55742C5.40848 7.78313 5.22567 7.96593 4.99997 7.96593C4.77427 7.96593 4.59146 7.78313 4.59146 7.55742C4.59146 7.33172 4.77427 7.14891 4.99997 7.14891C5.22567 7.14891 5.40848 7.33172 5.40848 7.55742ZM4.99997 2.85956C4.66152 2.85956 4.38721 3.13387 4.38721 3.47232L4.5643 6.12846C4.57962 6.35783 4.77019 6.53615 4.99997 6.53615C5.22976 6.53615 5.42033 6.35783 5.43565 6.12846L5.61274 3.47232C5.61274 3.13387 5.33842 2.85956 4.99997 2.85956Z"
                                              fill="#F09965"/>
                                    </svg>
                                </div>

                                <template v-if="!props.errors.password.minLength">
                                    <?php echo esc_html(tdf_string('password_min_letters')); ?>
                                </template>

                                <template v-if="!props.errors.password.required">
                                    <?php echo esc_html(tdf_string('field_is_required')); ?>
                                </template>
                            </div>
                        </template>
                    </div>

                    <div class="listivo-set-password__button">
                        <button class="listivo-simple-button listivo-simple-button--height-60 listivo-simple-button--full-width listivo-simple-button--background-primary-1">
                            <span class="listivo-primary-button__text"><?php echo esc_html(tdf_string('set_new_password')); ?></span>
                        </button>
                    </div>
                </form>
            </div>
        </lst-set-password>
    </div>
</div>