<?php use Tangibledesign\Framework\Widgets\General\PanelWidget; ?>
<div class="listivo-panel-small-form-wrapper">
    <div class="listivo-panel-small-form-container">
        <lst-panel-set-phone
                set-phone-nonce="<?php echo esc_attr(wp_create_nonce('listivo/user/setPhone')); ?>"
                request-url="<?php echo esc_url(admin_url('admin-post.php?action=listivo/user/setPhone')); ?>"
                redirect-url="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_LIST)); ?>"
                title-success-text="<?php echo esc_attr(tdf_string('success')); ?>"
                text-success-text="<?php echo esc_attr(tdf_string('changes_have_been_saved')); ?>"
                error-title="<?php echo esc_attr(tdf_string('something_went_wrong')); ?>"
                confirm-button-text="<?php echo esc_attr(tdf_string('ok')); ?>"
                initial-country-code="<?php echo esc_attr(tdf_app('phone_initial_country_code')); ?>"
        >
            <form
                    slot-scope="props"
                    class="listivo-panel-small-form"
                    @submit.prevent="props.onSubmit"
            >
                <h1 class="listivo-panel-small-form__heading">
                    <?php echo esc_html(tdf_string('phone_number')); ?>
                </h1>

                <div class="listivo-panel-small-form__field">
                    <?php if (tdf_settings()->isPhoneCountryCodeSelectEnabled()) : ?>
                        <label for="listivo-phone-with-country-code">
                            <div class="listivo-phone-with-country-code">
                                <div class="listivo-phone-with-country-code__icon listivo-icon-v2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16"
                                         fill="none">
                                        <path d="M1.8 0C0.813 0 0 0.813 0 1.8V14.2C0 15.187 0.813 16 1.8 16H7.8C8.787 16 9.6 15.187 9.6 14.2V1.8C9.6 0.813 8.787 0 7.8 0H1.8ZM1.8 1.2H7.8C8.1386 1.2 8.4 1.4614 8.4 1.8V14.2C8.4 14.5386 8.1386 14.8 7.8 14.8H1.8C1.4614 14.8 1.2 14.5386 1.2 14.2V1.8C1.2 1.4614 1.4614 1.2 1.8 1.2ZM4.8 2.4C4.64087 2.4 4.48826 2.46321 4.37574 2.57574C4.26321 2.68826 4.2 2.84087 4.2 3C4.2 3.15913 4.26321 3.31174 4.37574 3.42426C4.48826 3.53679 4.64087 3.6 4.8 3.6C4.95913 3.6 5.11174 3.53679 5.22426 3.42426C5.33679 3.31174 5.4 3.15913 5.4 3C5.4 2.84087 5.33679 2.68826 5.22426 2.57574C5.11174 2.46321 4.95913 2.4 4.8 2.4ZM3.8 12.4C3.72049 12.3989 3.64156 12.4136 3.56777 12.4432C3.49399 12.4729 3.42684 12.5169 3.37022 12.5727C3.3136 12.6285 3.26864 12.6951 3.23795 12.7684C3.20726 12.8418 3.19145 12.9205 3.19145 13C3.19145 13.0795 3.20726 13.1582 3.23795 13.2316C3.26864 13.3049 3.3136 13.3715 3.37022 13.4273C3.42684 13.4831 3.49399 13.5271 3.56777 13.5568C3.64156 13.5864 3.72049 13.6011 3.8 13.6H5.8C5.87951 13.6011 5.95845 13.5864 6.03223 13.5568C6.10601 13.5271 6.17316 13.4831 6.22978 13.4273C6.2864 13.3715 6.33137 13.3049 6.36205 13.2316C6.39274 13.1582 6.40855 13.0795 6.40855 13C6.40855 12.9205 6.39274 12.8418 6.36205 12.7684C6.33137 12.6951 6.2864 12.6285 6.22978 12.5727C6.17316 12.5169 6.10601 12.4729 6.03223 12.4432C5.95845 12.4136 5.87951 12.3989 5.8 12.4H3.8Z"
                                              fill="#FDFDFE"/>
                                    </svg>
                                </div>

                                <select
                                        @change="props.setCountryCode($event.target.value)"
                                        :value="props.countryCode"
                                >
                                    <?php foreach (tdf_app('phone_country_codes_with_flags') as $text => $code) : ?>
                                        <option value="<?php echo esc_attr($text); ?>">
                                            <?php echo tdf_filter($text); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <input
                                        id="listivo-phone-with-country-code"
                                        name="phone"
                                        @input="props.setPhone($event.target.value)"
                                        :value="props.phone"
                                        type="tel"
                                        placeholder="<?php echo esc_attr(tdf_string('phone')); ?>"
                                        required
                                >
                            </div>
                        </label>
                    <?php else : ?>
                        <div class="listivo-input-v2 listivo-input-v2--small">
                            <input
                                    placeholder="<?php echo esc_attr(tdf_string('enter_your_phone_number')); ?>"
                                    type="text"
                                    @input="props.setPhone($event.target.value)"
                                    :value="props.phone"
                                    required
                            >
                        </div>
                    <?php endif; ?>
                </div>

                <?php if (tdf_settings()->isChatAppsOnRegistrationActivated()) : ?>
                    <?php if (!tdf_settings()->disableWhatsApp()) : ?>
                        <div class="listivo-panel-small-form__field">
                            <div
                                    class="listivo-panel-small-form__chat-app"
                                    @click.stop.prevent="props.setWhatsAppEnabled"
                            >
                                <div
                                        class="listivo-panel-small-form__checkbox listivo-checkbox"
                                        :class="{'listivo-checkbox--checked': props.whatsAppEnabled}"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                         fill="none">
                                        <path
                                                d="M11.7142 0.779513L10.6378 0.103783C10.3399 -0.0824758 9.93186 -0.011004 9.73252 0.261887L4.45585 7.44801L2.03093 5.20858C1.77765 4.97467 1.3649 4.97467 1.11162 5.20858L0.18996 6.05974C-0.06332 6.29364 -0.06332 6.67482 0.18996 6.9109L3.91881 10.3545C4.12753 10.5473 4.45585 10.6945 4.75135 10.6945C5.04684 10.6945 5.34468 10.5235 5.53698 10.2657L11.8877 1.61335C12.0894 1.34046 12.012 0.965772 11.7142 0.779513Z"
                                                fill="#FDFDFE"/>
                                    </svg>
                                </div>

                                <span><?php echo esc_html(tdf_string('enable_whats_app_communication')); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!tdf_settings()->disableViber()) : ?>
                        <div class="listivo-panel-small-form__field">
                            <div
                                    class="listivo-panel-small-form__chat-app"
                                    @click.stop.prevent="props.setViberEnabled"
                            >
                                <div
                                        class="listivo-panel-small-form__checkbox listivo-checkbox"
                                        :class="{'listivo-checkbox--checked': props.viberEnabled}"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                         fill="none">
                                        <path
                                                d="M11.7142 0.779513L10.6378 0.103783C10.3399 -0.0824758 9.93186 -0.011004 9.73252 0.261887L4.45585 7.44801L2.03093 5.20858C1.77765 4.97467 1.3649 4.97467 1.11162 5.20858L0.18996 6.05974C-0.06332 6.29364 -0.06332 6.67482 0.18996 6.9109L3.91881 10.3545C4.12753 10.5473 4.45585 10.6945 4.75135 10.6945C5.04684 10.6945 5.34468 10.5235 5.53698 10.2657L11.8877 1.61335C12.0894 1.34046 12.012 0.965772 11.7142 0.779513Z"
                                                fill="#FDFDFE"/>
                                    </svg>
                                </div>

                                <span><?php echo esc_html(tdf_string('enable_viber_communication')); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <div class="listivo-panel-small-form__button">
                    <button
                            class="listivo-simple-button listivo-simple-button--background-primary-1 listivo-button-primary-1-selector listivo-simple-button--full-width"
                            :class="{'listivo-simple-button--loading': props.inProgress}"
                            :disabled="props.inProgress"
                    >
                        <span v-if="!props.inProgress">
                            <?php echo esc_html(tdf_string('save_changes')); ?>
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
        </lst-panel-set-phone>
    </div>
</div>