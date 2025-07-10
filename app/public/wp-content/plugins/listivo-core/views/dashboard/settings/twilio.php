<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<div class="listivo-backend-content">
    <p class="listivo-backend-description">
        <a href="https://support.listivotheme.com/support/solutions/articles/101000465715/" target="_blank">
            <?php esc_html_e('Learn more about Twilio setup', 'listivo-core'); ?>
        </a>
    </p>

    <table class="form-table">
        <tbody>
        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr(SettingKey::TWILIO_ACCOUNT_SID); ?>">
                    <?php esc_html_e('Account SID', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                <input
                        name="<?php echo esc_attr(SettingKey::TWILIO_ACCOUNT_SID); ?>"
                        id="<?php echo esc_attr(SettingKey::TWILIO_ACCOUNT_SID); ?>"
                        class="regular-text"
                        type="text"
                        value="<?php echo esc_attr(tdf_settings()->getTwilioAccountSid()); ?>"
                >
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr(SettingKey::TWILIO_AUTH_TOKEN); ?>">
                    <?php esc_html_e('Auth Token', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                <input
                        name="<?php echo esc_attr(SettingKey::TWILIO_AUTH_TOKEN); ?>"
                        id="<?php echo esc_attr(SettingKey::TWILIO_AUTH_TOKEN); ?>"
                        class="regular-text"
                        type="password"
                        value="<?php echo esc_attr(tdf_settings()->getTwilioAuthToken()); ?>"
                >
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr(SettingKey::TWILIO_PHONE_NUMBER); ?>">
                    <?php esc_html_e('My Twilio phone number', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                <input
                        name="<?php echo esc_attr(SettingKey::TWILIO_PHONE_NUMBER); ?>"
                        id="<?php echo esc_attr(SettingKey::TWILIO_PHONE_NUMBER); ?>"
                        class="regular-text"
                        type="text"
                        value="<?php echo esc_attr(tdf_settings()->getTwilioPhoneNumber()); ?>"
                >
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr(SettingKey::TWILIO_VERIFY_SERVICE_SID); ?>">
                    <?php esc_html_e('Verify Service SID', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                <input
                        name="<?php echo esc_attr(SettingKey::TWILIO_VERIFY_SERVICE_SID); ?>"
                        id="<?php echo esc_attr(SettingKey::TWILIO_VERIFY_SERVICE_SID); ?>"
                        class="regular-text"
                        type="text"
                        value="<?php echo esc_attr(tdf_settings()->getTwilioVerifyServiceSid()); ?>"
                >
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr(SettingKey::USER_PHONE_VERIFICATION); ?>">
                    <?php esc_html_e('Phone Verification', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                <label for="<?php echo esc_attr(SettingKey::USER_PHONE_VERIFICATION); ?>">
                    <input
                            name="<?php echo esc_attr(SettingKey::USER_PHONE_VERIFICATION); ?>"
                            id="<?php echo esc_attr(SettingKey::USER_PHONE_VERIFICATION); ?>"
                            type="checkbox"
                            value="1"
                        <?php if (tdf_settings()->isUserPhoneVerificationEnabled()) : ?>
                            checked
                        <?php endif; ?>
                    >

                    <?php esc_html_e('Require users to verify phone number', 'listivo-core'); ?>
                </label>
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
        </tbody>
    </table>

    <p class="submit">
        <button class="button button-primary">
            <?php esc_html_e('Save Changes', 'listivo-core'); ?>
        </button>
    </p>
</div>