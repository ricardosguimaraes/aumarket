<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::USER_EMAIL_CONFIRMATION); ?>">
                <?php esc_html_e('Email Confirmation', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::USER_EMAIL_CONFIRMATION); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::USER_EMAIL_CONFIRMATION); ?>"
                        id="<?php echo esc_attr(SettingKey::USER_EMAIL_CONFIRMATION); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->isUserEmailConfirmationEnabled()) : ?>
                        checked
                    <?php endif; ?>
                >

                <?php esc_html_e('Require new users to verify account via email.', 'listivo-core'); ?>
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::LOGIN_MIN_LENGTH); ?>">
                <?php esc_html_e('Login Min. Length', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::LOGIN_MIN_LENGTH); ?>"
                    name="<?php echo esc_attr(SettingKey::LOGIN_MIN_LENGTH); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getLoginMinLength()); ?>"
            >

            <p class="description">
                <?php esc_html_e('The minimum number of characters for user login.', 'listivo-core'); ?>
            </p>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::PHONE_LOGIC); ?>">
                <?php esc_html_e('Phone', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <select
                    id="<?php echo esc_attr(SettingKey::PHONE_LOGIC); ?>"
                    name="<?php echo esc_attr(SettingKey::PHONE_LOGIC); ?>"
                    class="tdf-selectize tdf-selectize-init"
            >
                <option
                        value="optional_show"
                    <?php if (tdf_settings()->isPhoneLogic('optional_show')) : ?>
                        selected
                    <?php endif; ?>
                >
                    <?php esc_html_e('Optional + show on the register form', 'listivo-core'); ?>
                </option>

                <option
                        value="optional_hide"
                    <?php if (tdf_settings()->isPhoneLogic('optional_hide')) : ?>
                        selected
                    <?php endif; ?>
                >
                    <?php esc_html_e('Optional + hide on the register form', 'listivo-core'); ?>
                </option>

                <option
                        value="required"
                    <?php if (tdf_settings()->isPhoneLogic('required')) : ?>
                        selected
                    <?php endif; ?>
                >
                    <?php esc_html_e('Required', 'listivo-core'); ?>
                </option>

                <option
                        value="disable"
                    <?php if (tdf_settings()->isPhoneLogic('disable')) : ?>
                        selected
                    <?php endif; ?>
                >
                    <?php esc_html_e('Disabled', 'listivo-core'); ?>
                </option>
            </select>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::USER_PHONE_UNIQUE); ?>">
                <?php esc_html_e('Unique Phone Number', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::USER_PHONE_UNIQUE); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::USER_PHONE_UNIQUE); ?>"
                        id="<?php echo esc_attr(SettingKey::USER_PHONE_UNIQUE); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->isUserPhoneUnique()) : ?>
                        checked
                    <?php endif; ?>
                >

                <?php esc_html_e('Require unique phone number for each user', 'listivo-core'); ?>
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::PHONE_COUNTRY_CODE_SELECT); ?>">
                <?php esc_html_e('Phone Country Code Select', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::PHONE_COUNTRY_CODE_SELECT); ?>">
                <input
                        id="<?php echo esc_attr(SettingKey::PHONE_COUNTRY_CODE_SELECT); ?>"
                        name="<?php echo esc_attr(SettingKey::PHONE_COUNTRY_CODE_SELECT); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->isPhoneCountryCodeSelectEnabled()) : ?>
                        checked
                    <?php endif; ?>
                >
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::PHONE_DEFAULT_COUNTRY_CODE); ?>">
                <?php esc_html_e('Phone Default Country Code', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <select
                    name="<?php echo esc_attr(SettingKey::PHONE_DEFAULT_COUNTRY_CODE); ?>"
                    id="<?php echo esc_attr(SettingKey::PHONE_DEFAULT_COUNTRY_CODE); ?>"
            >
                <?php foreach (tdf_app('phone_country_codes_with_flags') as $text => $code) : ?>
                    <option
                            value="<?php echo esc_attr($text); ?>"
                        <?php if (tdf_settings()->getPhoneDefaultCountryCode() === $text): ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php echo tdf_filter($text); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::ACTIVATE_CHAT_APPS_ON_REGISTRATION); ?>">
                <?php esc_html_e('Activate Chat Apps on Registration', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::ACTIVATE_CHAT_APPS_ON_REGISTRATION); ?>">
                <input
                        id="<?php echo esc_attr(SettingKey::ACTIVATE_CHAT_APPS_ON_REGISTRATION); ?>"
                        name="<?php echo esc_attr(SettingKey::ACTIVATE_CHAT_APPS_ON_REGISTRATION); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->isChatAppsOnRegistrationActivated()) : ?>
                        checked
                    <?php endif; ?>
                >

                <?php esc_html_e('Activates messaging features on registration. Requires visible phone field. Ensure services are not disabled.', 'listivo-core'); ?>
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::DISABLE_WHATS_APP); ?>">
                <?php esc_html_e('Disable WhatsApp', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::DISABLE_WHATS_APP); ?>">
                <input
                        id="<?php echo esc_attr(SettingKey::DISABLE_WHATS_APP); ?>"
                        name="<?php echo esc_attr(SettingKey::DISABLE_WHATS_APP); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->disableWhatsApp()) : ?>
                        checked
                    <?php endif; ?>
                >
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::DISABLE_VIBER); ?>">
                <?php esc_html_e('Disable Viber', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::DISABLE_VIBER); ?>">
                <input
                        id="<?php echo esc_attr(SettingKey::DISABLE_VIBER); ?>"
                        name="<?php echo esc_attr(SettingKey::DISABLE_VIBER); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->disableViber()) : ?>
                        checked
                    <?php endif; ?>
                >
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::ENABLE_WEBSITE_FIELD); ?>">
                <?php esc_html_e('Website Field', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::ENABLE_WEBSITE_FIELD); ?>">
                <input
                        id="<?php echo esc_attr(SettingKey::ENABLE_WEBSITE_FIELD); ?>"
                        name="<?php echo esc_attr(SettingKey::ENABLE_WEBSITE_FIELD); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->isWebsiteFieldEnabled()) : ?>
                        checked
                    <?php endif; ?>
                >
            </label>
        </td>
    </tr>
    </tbody>
</table>

<p class="submit">
    <button class="button button-primary">
        <?php esc_html_e('Save Changes', 'listivo-core'); ?>
    </button>
</p>