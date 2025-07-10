<?php

use Tangibledesign\Framework\Widgets\General\PanelWidget;

do_action('listivo/users/sendVerificationToken');
?>
<div class="listivo-panel-small-form-wrapper">
    <div class="listivo-panel-small-form-container">
        <lst-panel-verify-phone
                request-url="<?php echo esc_url(admin_url('admin-post.php?action=listivo/users/verify')); ?>"
                redirect-url="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_LIST)); ?>"
                title-success-text="<?php echo esc_attr(tdf_string('success')); ?>"
                text-success-text="<?php echo esc_attr(tdf_string('verify_success')); ?>"
                error-title="<?php echo esc_attr(tdf_string('invalid_token')); ?>"
                confirm-button-text="<?php echo esc_attr(tdf_string('ok')); ?>"
        >
            <form
                    slot-scope="props"
                    class="listivo-panel-small-form"
                    @submit.prevent="props.onSubmit"
            >
                <h1 class="listivo-panel-small-form__heading">
                    <?php echo esc_html(tdf_string('phone_verification')); ?>
                </h1>

                <div class="listivo-panel-small-form__text">
                    <?php echo esc_html(tdf_string('phone_verification_send_token_text')); ?>
                </div>

                <div class="listivo-panel-small-form__field">
                    <div class="listivo-input-v2 listivo-input-v2--small">
                        <input
                                placeholder="<?php echo esc_attr(tdf_string('enter_token')); ?>"
                                type="text"
                                @input="props.setToken($event.target.value)"
                                :value="props.token"
                                required
                        >
                    </div>
                </div>

                <div class="listivo-panel-small-form__button">
                    <button
                            class="listivo-simple-button listivo-simple-button--background-primary-1 listivo-button-primary-1-selector listivo-simple-button--full-width"
                            :class="{'listivo-simple-button--loading': props.inProgress}"
                            :disabled="props.inProgress"
                    >
                        <span v-if="!props.inProgress">
                            <?php echo esc_html(tdf_string('verify')); ?>
                        </span>

                        <template>
                            <svg
                                    v-if="props.inProgress"
                                    width='40'
                                    height='10'
                                    viewBox='0 0 120 30'
                                    xmlns='http://www.w3.org/2000/svg'
                                    fill='#fff'
                                    class="listivo-simple-button__loading"
                            >
                                <circle cx='15' cy='15' r='15'>
                                    <animate attributeName='r' from='15' to='15' begin='0s' dur='0.8s' values='15;9;15'
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
                                    <animate attributeName='r' from='15' to='15' begin='0s' dur='0.8s' values='15;9;15'
                                             calcMode='linear' repeatCount='indefinite'/>
                                    <animate attributeName='fill-opacity' from='1' to='1' begin='0s' dur='0.8s'
                                             values='1;.5;1'
                                             calcMode='linear' repeatCount='indefinite'/>
                                </circle>
                            </svg>
                        </template>
                    </button>
                </div>
            </form>
        </lst-panel-verify-phone>

        <a
                class="listivo-panel-small-form-container__link"
                href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_SET_PHONE)); ?>"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18"/>
            </svg>

            <?php echo esc_html(tdf_string('change_phone_number')); ?>
        </a>
    </div>
</div>