<?php

use Tangibledesign\Framework\Models\User\User;
use Tangibledesign\Listivo\Widgets\General\PanelWidget;

/* @var PanelWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstCurrentUser = tdf_current_user();
if (!$lstCurrentUser instanceof User) {
    return;
}
?>
<lst-user-settings
        class="listivo-panel-accordions__item listivo-panel-accordion"
        request-url="<?php echo esc_url(tdf_action_url('listivo/user/settings/save')); ?>"
        td-nonce="<?php echo esc_attr(wp_create_nonce('listivo_save_user_settings')); ?>"
        success-text="<?php echo esc_attr(tdf_string('changes_have_been_saved')); ?>"
        error-text="<?php echo esc_attr(tdf_string('something_went_wrong')); ?>"
        confirm-button-text="<?php echo esc_attr(tdf_string('ok')); ?>"
        :initial-user="<?php echo htmlspecialchars(json_encode($lstCurrentWidget->getUserSettings())); ?>"
        :login-min-length="<?php echo esc_attr(tdf_settings()->getLoginMinLength()); ?>"
    <?php if ($lstCurrentUser->isBusinessAccount() && tdf_settings()->isCompanyInformationEnabled() && tdf_settings()->requireCompanyInformation()) : ?>
        :company-information-required="true"
    <?php endif; ?>
    <?php if (
        ($lstCurrentUser->isBusinessAccount() && tdf_settings()->isFullNameEnabledForBusinessAccount() && tdf_settings()->isFullNameRequiredForBusinessAccount())
        || ($lstCurrentUser->isPrivateAccount() && tdf_settings()->isFullNameEnabledForPrivateAccount() && tdf_settings()->isFullNameRequiredForPrivateAccount())
    ) : ?>
        :full-name-required="true"
    <?php endif; ?>
>
    <div
            slot-scope="props"
            class="listivo-panel-accordions__item listivo-panel-accordion"
            :class="{'listivo-panel-accordion--active': accordions.open === 'details'}"
    >
        <div
                class="listivo-panel-accordion__top"
                @click.prevent="accordions.onOpen('details')"
        >
            <h3 class="listivo-panel-accordion__label">
                <?php echo esc_html(tdf_string('change_details')); ?>
            </h3>

            <div class="listivo-panel-accordion__icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14"
                     viewBox="0 0 16 14"
                     fill="none">
                    <path d="M6.0872 0.243733C6.25012 0.0808152 6.46304 -0.000435034 6.67637 -0.000435034C6.88971 -0.000435034 7.10263 0.0808152 7.26554 0.243733C7.59096 0.569152 7.59096 1.09666 7.26554 1.42208L2.85468 5.83294L14.1764 5.83294C14.6364 5.83294 15.0098 6.20627 15.0098 6.66628C15.0098 7.12628 14.6364 7.49962 14.1764 7.49962L2.85468 7.49962L7.26554 11.9105C7.59096 12.2359 7.59096 12.7634 7.26554 13.0888C6.94013 13.4142 6.41262 13.4142 6.0872 13.0888L0.25383 7.25545C-0.0715891 6.93003 -0.0715891 6.40253 0.25383 6.07711L6.0872 0.243733Z"
                          fill="#2A3946"/>
                </svg>
            </div>
        </div>

        <form @submit.prevent="props.onSave">
            <div class="listivo-panel-accordion__content-wrapper listivo-panel-accordion__content-wrapper--details">
                <div class="listivo-panel-accordion__content listivo-panel-user-settings">
                    <div class="listivo-panel-user-settings__field listivo-field-group">
                        <label
                                class="listivo-field-group__label"
                                for="listivo-name"
                        >
                            <?php echo esc_html(tdf_string('display_name')); ?>
                        </label>

                        <div class="listivo-field-group__field">
                            <div
                                    class="listivo-input-v2"
                                    :class="{
                                        'listivo-input-v2--error': props.showErrors && (!props.errors.name.required || !props.errors.name.minLength),
                                    }"
                            >
                                <input
                                        id="listivo-name"
                                        type="text"
                                        :value="props.name"
                                        @input="props.setName($event.target.value)"
                                        placeholder="<?php echo esc_attr(tdf_string('enter_your_display_name')); ?>"
                                >

                                <template>
                                    <div
                                            v-if="props.showErrors && (!props.errors.name.required || !props.errors.name.minLength)"
                                            class="listivo-input-v2__error"
                                    >
                                        <div class="listivo-field-error">
                                            <div class="listivo-field-error__icon">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     width="10" height="9" viewBox="0 0 10 9"
                                                     fill="none">
                                                    <path d="M0.105217 7.80234L4.38783 0.354178C4.51386 0.135013 4.74732 0 4.99999 0C5.25265 0 5.48611 0.135013 5.61214 0.354178L9.89475 7.80234C10.0269 8.03213 10.0351 8.31277 9.91661 8.54991L9.9164 8.55032C9.78241 8.8181 9.50871 8.98722 9.20927 8.98722H0.790697C0.491259 8.98722 0.217558 8.8181 0.0837706 8.55032L0.0835662 8.54991C-0.035106 8.31277 -0.0269357 8.03213 0.105217 7.80234Z"
                                                          fill="#FDFDFE"/>
                                                    <path d="M5.40848 7.55742C5.40848 7.78313 5.22567 7.96593 4.99997 7.96593C4.77427 7.96593 4.59146 7.78313 4.59146 7.55742C4.59146 7.33172 4.77427 7.14891 4.99997 7.14891C5.22567 7.14891 5.40848 7.33172 5.40848 7.55742ZM4.99997 2.85956C4.66152 2.85956 4.38721 3.13387 4.38721 3.47232L4.5643 6.12846C4.57962 6.35783 4.77019 6.53615 4.99997 6.53615C5.22976 6.53615 5.42033 6.35783 5.43565 6.12846L5.61274 3.47232C5.61274 3.13387 5.33842 2.85956 4.99997 2.85956Z"
                                                          fill="#F09965"/>
                                                </svg>
                                            </div>

                                            <div v-if="!props.errors.name.required">
                                                <?php echo esc_html(tdf_string('field_is_required')); ?>
                                            </div>

                                            <div v-if="!props.errors.name.minLength">
                                                <?php echo sprintf(esc_html(tdf_string('display_name_min_letters')),
                                                    tdf_settings()->getLoginMinLength()); ?>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <?php if (
                        ($lstCurrentUser->isBusinessAccount() && tdf_settings()->isFullNameEnabledForBusinessAccount())
                        || ($lstCurrentUser->isPrivateAccount() && tdf_settings()->isFullNameEnabledForPrivateAccount())
                    ) : ?>
                        <div class="listivo-panel-user-settings__field listivo-field-group">
                            <label
                                    class="listivo-field-group__label"
                                    for="listivo-first-name"
                            >
                                <?php echo esc_html(tdf_string('first_name')); ?>
                            </label>

                            <div class="listivo-field-group__field">
                                <div
                                        class="listivo-input-v2"
                                    <?php if (
                                        ($lstCurrentUser->isBusinessAccount() && tdf_settings()->isFullNameRequiredForBusinessAccount())
                                        || ($lstCurrentUser->isPrivateAccount() && tdf_settings()->isFullNameRequiredForPrivateAccount())
                                    ) : ?>
                                        :class="{
                                            'listivo-input-v2--error': props.showErrors && !props.errors.firstName.required,
                                        }"
                                    <?php endif; ?>
                                >
                                    <input
                                            id="listivo-first-name"
                                            type="text"
                                            :value="props.firstName"
                                            @input="props.setFirstName($event.target.value)"
                                    >

                                    <?php if (
                                        ($lstCurrentUser->isBusinessAccount() && tdf_settings()->isFullNameRequiredForBusinessAccount())
                                        || ($lstCurrentUser->isPrivateAccount() && tdf_settings()->isFullNameRequiredForPrivateAccount())
                                    ) : ?>
                                        <template>
                                            <div
                                                    v-if="props.showErrors && !props.errors.firstName.required"
                                                    class="listivo-input-v2__error"
                                            >
                                                <div class="listivo-field-error">
                                                    <div class="listivo-field-error__icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                             width="10" height="9"
                                                             viewBox="0 0 10 9"
                                                             fill="none">
                                                            <path d="M0.105217 7.80234L4.38783 0.354178C4.51386 0.135013 4.74732 0 4.99999 0C5.25265 0 5.48611 0.135013 5.61214 0.354178L9.89475 7.80234C10.0269 8.03213 10.0351 8.31277 9.91661 8.54991L9.9164 8.55032C9.78241 8.8181 9.50871 8.98722 9.20927 8.98722H0.790697C0.491259 8.98722 0.217558 8.8181 0.0837706 8.55032L0.0835662 8.54991C-0.035106 8.31277 -0.0269357 8.03213 0.105217 7.80234Z"
                                                                  fill="#FDFDFE"/>
                                                            <path d="M5.40848 7.55742C5.40848 7.78313 5.22567 7.96593 4.99997 7.96593C4.77427 7.96593 4.59146 7.78313 4.59146 7.55742C4.59146 7.33172 4.77427 7.14891 4.99997 7.14891C5.22567 7.14891 5.40848 7.33172 5.40848 7.55742ZM4.99997 2.85956C4.66152 2.85956 4.38721 3.13387 4.38721 3.47232L4.5643 6.12846C4.57962 6.35783 4.77019 6.53615 4.99997 6.53615C5.22976 6.53615 5.42033 6.35783 5.43565 6.12846L5.61274 3.47232C5.61274 3.13387 5.33842 2.85956 4.99997 2.85956Z"
                                                                  fill="#F09965"/>
                                                        </svg>
                                                    </div>

                                                    <div v-if="!props.errors.firstName.required">
                                                        <?php echo esc_html(tdf_string('field_is_required')); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="listivo-panel-user-settings__field listivo-field-group">
                            <label
                                    class="listivo-field-group__label"
                                    for="listivo-last-name"
                            >
                                <?php echo esc_html(tdf_string('last_name')); ?>
                            </label>

                            <div class="listivo-field-group__field">
                                <div
                                        class="listivo-input-v2"
                                    <?php if (
                                        ($lstCurrentUser->isBusinessAccount() && tdf_settings()->isFullNameRequiredForBusinessAccount())
                                        || ($lstCurrentUser->isPrivateAccount() && tdf_settings()->isFullNameRequiredForPrivateAccount())
                                    ) : ?>
                                        :class="{
                                            'listivo-input-v2--error': props.showErrors && (!props.errors.lastName.required),
                                        }"
                                    <?php endif; ?>
                                >
                                    <input
                                            id="listivo-last-name"
                                            type="text"
                                            :value="props.lastName"
                                            @input="props.setLastName($event.target.value)"
                                    >

                                    <?php if (
                                        ($lstCurrentUser->isBusinessAccount() && tdf_settings()->isFullNameRequiredForBusinessAccount())
                                        || ($lstCurrentUser->isPrivateAccount() && tdf_settings()->isFullNameRequiredForPrivateAccount())
                                    ) : ?>
                                        <template>
                                            <div
                                                    v-if="props.showErrors && (!props.errors.lastName.required)"
                                                    class="listivo-input-v2__error"
                                            >
                                                <div class="listivo-field-error">
                                                    <div class="listivo-field-error__icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                             width="10" height="9"
                                                             viewBox="0 0 10 9"
                                                             fill="none">
                                                            <path d="M0.105217 7.80234L4.38783 0.354178C4.51386 0.135013 4.74732 0 4.99999 0C5.25265 0 5.48611 0.135013 5.61214 0.354178L9.89475 7.80234C10.0269 8.03213 10.0351 8.31277 9.91661 8.54991L9.9164 8.55032C9.78241 8.8181 9.50871 8.98722 9.20927 8.98722H0.790697C0.491259 8.98722 0.217558 8.8181 0.0837706 8.55032L0.0835662 8.54991C-0.035106 8.31277 -0.0269357 8.03213 0.105217 7.80234Z"
                                                                  fill="#FDFDFE"/>
                                                            <path d="M5.40848 7.55742C5.40848 7.78313 5.22567 7.96593 4.99997 7.96593C4.77427 7.96593 4.59146 7.78313 4.59146 7.55742C4.59146 7.33172 4.77427 7.14891 4.99997 7.14891C5.22567 7.14891 5.40848 7.33172 5.40848 7.55742ZM4.99997 2.85956C4.66152 2.85956 4.38721 3.13387 4.38721 3.47232L4.5643 6.12846C4.57962 6.35783 4.77019 6.53615 4.99997 6.53615C5.22976 6.53615 5.42033 6.35783 5.43565 6.12846L5.61274 3.47232C5.61274 3.13387 5.33842 2.85956 4.99997 2.85956Z"
                                                                  fill="#F09965"/>
                                                        </svg>
                                                    </div>

                                                    <div v-if="!props.errors.lastName.required">
                                                        <?php echo esc_html(tdf_string('field_is_required')); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (tdf_settings()->isAccountTypeEnabled() && tdf_settings()->canUserChangeAccountType()) : ?>
                        <div class="listivo-panel-user-settings__field listivo-field-group">
                            <label
                                    class="listivo-field-group__label"
                                    for="listivo-account-type"
                            >
                                <?php echo esc_html(tdf_string('account_type')); ?>
                            </label>

                            <div class="listivo-field-group__field">
                                <lst-select
                                        :options="<?php echo htmlspecialchars(json_encode([
                                            [
                                                'name' => tdf_string('private_account_type'),
                                                'value' => 'regular',
                                            ],
                                            [
                                                'name' => tdf_string('business'),
                                                'value' => 'business',
                                            ]
                                        ])); ?>"
                                        @input="props.setAccountType"
                                        active-text-class="listivo-select-v2__option--highlight-text"
                                        highlight-option-class="listivo-select-v2__option--highlight"
                                        :is-selected="props.isAccountType"
                                        order-type="custom"
                                >
                                    <div
                                            slot-scope="select"
                                            @click="select.onOpen"
                                            @focusin="select.focusIn"
                                            @focusout="select.focusOut"
                                            @keyup.esc="select.onClose"
                                            @keyup.up="select.decreaseOptionIndex"
                                            @keyup.down="select.increaseOptionIndex"
                                            @keyup.enter="select.setOptionByIndex"
                                            tabindex="0"
                                            class="listivo-login-form__field listivo-select-v2"
                                            :class="{
                                                                    'listivo-select-v2--open':  select.open,
                                                                }"
                                    >
                                        <div class="listivo-select-v2__arrow">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="7"
                                                 height="5"
                                                 viewBox="0 0 7 5" fill="none">
                                                <path d="M3.5 2.56768L5.87477 0.192917C6.13207 -0.0643854 6.54972 -0.0643854 6.80702 0.192917C7.06433 0.45022 7.06433 0.86787 6.80702 1.12517L3.9394 3.99279C3.6964 4.2358 3.30298 4.2358 3.0606 3.99279L0.192977 1.12517C-0.0643257 0.86787 -0.0643257 0.45022 0.192977 0.192917C0.45028 -0.0643854 0.86793 -0.0643854 1.12523 0.192917L3.5 2.56768Z"
                                                      fill="#2A3946"/>
                                            </svg>
                                        </div>

                                        <template>
                                            <div class="listivo-select-v2__placeholder">
                                                <div v-if="props.accountType === 'regular'">
                                                    <?php echo esc_html(tdf_string('private_account_type')); ?>
                                                </div>

                                                <div v-if="props.accountType === 'business'">
                                                    <?php echo esc_html(tdf_string('business')); ?>
                                                </div>
                                            </div>

                                            <div v-if="select.open"
                                                 class="listivo-select-v2__dropdown">
                                                <div
                                                        v-for="(option, index) in select.options"
                                                        :key="option.id"
                                                        @click="select.setOption(option)"
                                                        class="listivo-select-v2__option"
                                                        :class="{
                                                            'listivo-select-v2__option--active': option.selected,
                                                            'listivo-select-v2__option--highlight': index === select.optionIndex,
                                                            'listivo-select-v2__option--disabled': option.disabled && !option.selected,
                                                        }"
                                                >
                                                    <div class="listivo-select-v2__value"
                                                         v-html="option.label"></div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </lst-select>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($lstCurrentUser->isBusinessAccount() && tdf_settings()->isCompanyInformationEnabled() && tdf_settings()->isAccountTypeEnabled()) : ?>
                        <div class="listivo-panel-user-settings__field listivo-panel-user-settings__field--full-width listivo-field-group">
                            <label
                                    class="listivo-field-group__label"
                                    for="listivo-company-information"
                            >
                                <?php echo esc_html(tdf_string('company_information')); ?>
                            </label>

                            <div class="listivo-field-group__field">
                                <div
                                        class="listivo-textarea"
                                    <?php if (tdf_settings()->requireCompanyInformation()) : ?>
                                        :class="{
                                            'listivo-textarea--error': props.showErrors && (!props.errors.companyInformation.required),
                                        }"
                                    <?php endif; ?>
                                >
                                    <textarea
                                            id="listivo-company-information"
                                            :value="props.companyInformation"
                                            @input="props.setCompanyInformation($event.target.value)"
                                    ></textarea>

                                    <?php if (tdf_settings()->requireCompanyInformation()) : ?>
                                        <template>
                                            <div
                                                    class="listivo-textarea__error"
                                                    v-if="props.showErrors && !props.errors.companyInformation.required"
                                            >
                                                <div class="listivo-field-error">
                                                    <div class="listivo-field-error__icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                             width="10" height="9"
                                                             viewBox="0 0 10 9"
                                                             fill="none">
                                                            <path d="M0.105217 7.80234L4.38783 0.354178C4.51386 0.135013 4.74732 0 4.99999 0C5.25265 0 5.48611 0.135013 5.61214 0.354178L9.89475 7.80234C10.0269 8.03213 10.0351 8.31277 9.91661 8.54991L9.9164 8.55032C9.78241 8.8181 9.50871 8.98722 9.20927 8.98722H0.790697C0.491259 8.98722 0.217558 8.8181 0.0837706 8.55032L0.0835662 8.54991C-0.035106 8.31277 -0.0269357 8.03213 0.105217 7.80234Z"
                                                                  fill="#FDFDFE"/>
                                                            <path d="M5.40848 7.55742C5.40848 7.78313 5.22567 7.96593 4.99997 7.96593C4.77427 7.96593 4.59146 7.78313 4.59146 7.55742C4.59146 7.33172 4.77427 7.14891 4.99997 7.14891C5.22567 7.14891 5.40848 7.33172 5.40848 7.55742ZM4.99997 2.85956C4.66152 2.85956 4.38721 3.13387 4.38721 3.47232L4.5643 6.12846C4.57962 6.35783 4.77019 6.53615 4.99997 6.53615C5.22976 6.53615 5.42033 6.35783 5.43565 6.12846L5.61274 3.47232C5.61274 3.13387 5.33842 2.85956 4.99997 2.85956Z"
                                                                  fill="#F09965"/>
                                                        </svg>
                                                    </div>

                                                    <div v-if="!props.errors.companyInformation.required">
                                                        <?php echo esc_html(tdf_string('field_is_required')); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (tdf_settings()->showPhoneInSettings()) : ?>
                        <div class="listivo-panel-user-settings__field listivo-field-group">
                            <label
                                    class="listivo-field-group__label"
                                    for="listivo-phone"
                            >
                                <?php echo esc_html(tdf_string('phone_number')); ?>
                            </label>

                            <div class="listivo-field-group__field">
                                <?php if (tdf_settings()->isPhoneCountryCodeSelectEnabled()) : ?>
                                    <label for="listivo-phone-with-country-code">
                                        <div
                                                class="listivo-phone-with-country-code"
                                        >
                                            <div class="listivo-phone-with-country-code__icon listivo-icon-v2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10"
                                                     height="16" viewBox="0 0 10 16"
                                                     fill="none">
                                                    <path d="M1.8 0C0.813 0 0 0.813 0 1.8V14.2C0 15.187 0.813 16 1.8 16H7.8C8.787 16 9.6 15.187 9.6 14.2V1.8C9.6 0.813 8.787 0 7.8 0H1.8ZM1.8 1.2H7.8C8.1386 1.2 8.4 1.4614 8.4 1.8V14.2C8.4 14.5386 8.1386 14.8 7.8 14.8H1.8C1.4614 14.8 1.2 14.5386 1.2 14.2V1.8C1.2 1.4614 1.4614 1.2 1.8 1.2ZM4.8 2.4C4.64087 2.4 4.48826 2.46321 4.37574 2.57574C4.26321 2.68826 4.2 2.84087 4.2 3C4.2 3.15913 4.26321 3.31174 4.37574 3.42426C4.48826 3.53679 4.64087 3.6 4.8 3.6C4.95913 3.6 5.11174 3.53679 5.22426 3.42426C5.33679 3.31174 5.4 3.15913 5.4 3C5.4 2.84087 5.33679 2.68826 5.22426 2.57574C5.11174 2.46321 4.95913 2.4 4.8 2.4ZM3.8 12.4C3.72049 12.3989 3.64156 12.4136 3.56777 12.4432C3.49399 12.4729 3.42684 12.5169 3.37022 12.5727C3.3136 12.6285 3.26864 12.6951 3.23795 12.7684C3.20726 12.8418 3.19145 12.9205 3.19145 13C3.19145 13.0795 3.20726 13.1582 3.23795 13.2316C3.26864 13.3049 3.3136 13.3715 3.37022 13.4273C3.42684 13.4831 3.49399 13.5271 3.56777 13.5568C3.64156 13.5864 3.72049 13.6011 3.8 13.6H5.8C5.87951 13.6011 5.95845 13.5864 6.03223 13.5568C6.10601 13.5271 6.17316 13.4831 6.22978 13.4273C6.2864 13.3715 6.33137 13.3049 6.36205 13.2316C6.39274 13.1582 6.40855 13.0795 6.40855 13C6.40855 12.9205 6.39274 12.8418 6.36205 12.7684C6.33137 12.6951 6.2864 12.6285 6.22978 12.5727C6.17316 12.5169 6.10601 12.4729 6.03223 12.4432C5.95845 12.4136 5.87951 12.3989 5.8 12.4H3.8Z"
                                                          fill="#FDFDFE"/>
                                                </svg>
                                            </div>

                                            <select
                                                    @change="props.setPhoneCountryCode($event.target.value)"
                                                    :value="props.phoneCountryCode"
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
                                                <?php if (tdf_settings()->isPhoneRequired()) : ?>
                                                    placeholder="<?php echo esc_attr(tdf_string('phone')); ?>*"
                                                <?php else : ?>
                                                    placeholder="<?php echo esc_attr(tdf_string('phone')); ?>"
                                                <?php endif; ?>
                                                <?php if (tdf_settings()->isPhoneRequired()) : ?>
                                                    required
                                                <?php endif; ?>
                                            >
                                        </div>
                                    </label>
                                <?php else : ?>
                                    <div class="listivo-input-v2">
                                        <input
                                                id="listivo-phone"
                                                type="tel"
                                                :value="props.phone"
                                                @input="props.setPhone($event.target.value)"
                                            <?php if (tdf_settings()->isPhoneRequired()) : ?>
                                                placeholder="<?php echo esc_attr(tdf_string('enter_your_phone_number')); ?>"
                                                required
                                            <?php else : ?>
                                                placeholder="<?php echo esc_attr(tdf_string('enter_your_phone_number')); ?>"
                                            <?php endif; ?>
                                        >
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if (!tdf_settings()->disableWhatsApp()) : ?>
                            <div class="listivo-field-group listivo-field-group--checkbox listivo-margin-top-7">
                                <div class="listivo-field-group__field">
                                    <div
                                            class="listivo-checkbox"
                                            :class="{'listivo-checkbox--checked': props.whatsApp}"
                                            @click.prevent="props.setWhatsApp"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                             height="11"
                                             viewBox="0 0 12 11"
                                             fill="none">
                                            <path d="M11.7142 0.779513L10.6378 0.103783C10.3399 -0.0824758 9.93186 -0.011004 9.73252 0.261887L4.45585 7.44801L2.03093 5.20858C1.77765 4.97467 1.3649 4.97467 1.11162 5.20858L0.18996 6.05974C-0.06332 6.29364 -0.06332 6.67482 0.18996 6.9109L3.91881 10.3545C4.12753 10.5473 4.45585 10.6945 4.75135 10.6945C5.04684 10.6945 5.34468 10.5235 5.53698 10.2657L11.8877 1.61335C12.0894 1.34046 12.012 0.965772 11.7142 0.779513Z"
                                                  fill="#FDFDFE"/>
                                        </svg>
                                    </div>
                                </div>

                                <div
                                        class="listivo-field-group__label"
                                        @click.prevent="props.setWhatsApp"
                                >
                                    <?php echo esc_html(tdf_string('enable_whats_app')); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!tdf_settings()->disableViber()) : ?>
                            <div class="listivo-field-group listivo-field-group--checkbox listivo-margin-top-7">
                                <div class="listivo-field-group__field">
                                    <div
                                            class="listivo-checkbox"
                                            :class="{'listivo-checkbox--checked': props.viber}"
                                            @click.prevent="props.setViber"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                             height="11"
                                             viewBox="0 0 12 11"
                                             fill="none">
                                            <path d="M11.7142 0.779513L10.6378 0.103783C10.3399 -0.0824758 9.93186 -0.011004 9.73252 0.261887L4.45585 7.44801L2.03093 5.20858C1.77765 4.97467 1.3649 4.97467 1.11162 5.20858L0.18996 6.05974C-0.06332 6.29364 -0.06332 6.67482 0.18996 6.9109L3.91881 10.3545C4.12753 10.5473 4.45585 10.6945 4.75135 10.6945C5.04684 10.6945 5.34468 10.5235 5.53698 10.2657L11.8877 1.61335C12.0894 1.34046 12.012 0.965772 11.7142 0.779513Z"
                                                  fill="#FDFDFE"/>
                                        </svg>
                                    </div>
                                </div>

                                <div
                                        class="listivo-field-group__label"
                                        @click.prevent="props.setViber"
                                >
                                    <?php echo esc_html(tdf_string('enable_viber')); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if (tdf_settings()->isWebsiteFieldEnabled()) : ?>
                        <div class="listivo-panel-user-settings__field listivo-field-group">
                            <label
                                    class="listivo-field-group__label"
                                    for="listivo-website"
                            >
                                <?php echo esc_html(tdf_string('website')); ?>
                            </label>

                            <div class="listivo-field-group__field">
                                <div class="listivo-input-v2">
                                    <input
                                            id="listivo-website"
                                            type="text"
                                            :value="props.website"
                                            @input="props.setWebsite($event.target.value)"
                                            placeholder="<?php echo esc_attr(tdf_string('enter_your_website')); ?>"
                                    >
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="listivo-panel-user-settings__field listivo-panel-user-settings__field--full-width listivo-field-group">
                        <label
                                class="listivo-field-group__label"
                                for="listivo-description"
                        >
                            <?php echo esc_html(tdf_string('profile_description')); ?>
                        </label>

                        <div class="listivo-field-group__field">
                            <div class="listivo-textarea">
                                <textarea
                                        id="listivo-description"
                                        :value="props.description"
                                        @input="props.setDescription($event.target.value)"
                                        placeholder="<?php echo esc_attr(tdf_string('write_something_about_yourself')); ?>"
                                ></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="listivo-panel-user-settings__field listivo-panel-user-settings__field--full-width listivo-field-group">
                        <label
                                class="listivo-field-group__label"
                                for="listivo-user-address"
                        >
                            <?php echo esc_html(tdf_string('address')); ?>
                        </label>

                        <div class="listivo-field-group__field">
                            <div class="listivo-input-v2">
                                <input
                                        id="listivo-user-address"
                                        type="text"
                                        @input="props.setAddress($event.target.value)"
                                        :value="props.address"
                                        placeholder="<?php echo esc_attr(tdf_string('enter_your_address')); ?>"
                                >
                            </div>
                        </div>

                        <?php if (tdf_settings()->isMarketingConsentsEnabled()) : ?>
                            <div class="listivo-field-group listivo-field-group--checkbox listivo-margin-top-7">
                                <div class="listivo-field-group__field">
                                    <div
                                            class="listivo-checkbox"
                                            :class="{'listivo-checkbox--checked': props.marketingConsent}"
                                            @click.prevent="props.setMarketingConsent"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                             height="11"
                                             viewBox="0 0 12 11"
                                             fill="none">
                                            <path d="M11.7142 0.779513L10.6378 0.103783C10.3399 -0.0824758 9.93186 -0.011004 9.73252 0.261887L4.45585 7.44801L2.03093 5.20858C1.77765 4.97467 1.3649 4.97467 1.11162 5.20858L0.18996 6.05974C-0.06332 6.29364 -0.06332 6.67482 0.18996 6.9109L3.91881 10.3545C4.12753 10.5473 4.45585 10.6945 4.75135 10.6945C5.04684 10.6945 5.34468 10.5235 5.53698 10.2657L11.8877 1.61335C12.0894 1.34046 12.012 0.965772 11.7142 0.779513Z"
                                                  fill="#FDFDFE"/>
                                        </svg>
                                    </div>
                                </div>

                                <div
                                        class="listivo-field-group__label"
                                        @click.prevent="props.setMarketingConsent"
                                >
                                    <?php echo wp_kses_post(tdf_settings()->getMarketingConsentsLabel()); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="listivo-panel-accordion__bottom">
                    <button
                            class="listivo-button listivo-button--primary-1 listivo-button-primary-1-colors-with-stroke-selector"
                            :class="{'listivo-button--loading': props.inProgress}"
                    >
                        <span>
                            <?php echo esc_html(tdf_string('save_changes')); ?>

                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="10"
                                 viewBox="0 0 14 10" fill="none">
                                <rect x="12.2676" y="0.646447" width="1.53602" height="11.5509"
                                      rx="0.768011" transform="rotate(45 12.2676 0.646447)"
                                      fill="#FDFDFE" stroke="#FDFDFE" stroke-width="0.5"/>
                                <path d="M1.19345 4.98425C0.891119 5.28658 0.897654 5.77873 1.20791 6.07292L4.70642 9.39036C4.94829 9.61971 5.32032 9.64118 5.58696 9.44116C5.91859 9.1924 5.95423 8.70807 5.66258 8.41344L2.27076 4.98699C1.97447 4.68767 1.49125 4.68644 1.19345 4.98425Z"
                                      fill="#FDFDFE" stroke="#FDFDFE" stroke-width="0.5"/>
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
                                    <animate attributeName='r' from='15' to='15' begin='0s'
                                             dur='0.8s' values='15;9;15'
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
                                    <animate attributeName='fill-opacity' from='0.5' to='0.5'
                                             begin='0s' dur='0.8s'
                                             values='.5;1;.5' calcMode='linear'
                                             repeatCount='indefinite'/>
                                </circle>

                                <circle cx='105' cy='15' r='15'>
                                    <animate attributeName='r' from='15' to='15' begin='0s'
                                             dur='0.8s' values='15;9;15'
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
        </form>
    </div>
</lst-user-settings>