<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::ACCOUNT_TYPE); ?>">
                <?php esc_html_e('Account Type', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::ACCOUNT_TYPE); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::ACCOUNT_TYPE); ?>"
                        id="<?php echo esc_attr(SettingKey::ACCOUNT_TYPE); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->isAccountTypeEnabled()) : ?>
                        checked
                    <?php endif; ?>
                >

                <?php esc_html_e('User determines whether the account is private or business.', 'listivo-core'); ?>
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::CAN_USER_CHANGE_ACCOUNT_TYPE); ?>">
                <?php esc_html_e('Change Account Type', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::CAN_USER_CHANGE_ACCOUNT_TYPE); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::CAN_USER_CHANGE_ACCOUNT_TYPE); ?>"
                        id="<?php echo esc_attr(SettingKey::CAN_USER_CHANGE_ACCOUNT_TYPE); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->canUserChangeAccountType()) : ?>
                        checked
                    <?php endif; ?>
                >

                <?php esc_html_e('User can change the account type at any time.', 'listivo-core'); ?>
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::DISABLE_BUSINESS_ROLE_MODELS); ?>">
                <?php esc_html_e('Disable Ad Creation', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::DISABLE_BUSINESS_ROLE_MODELS); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::DISABLE_BUSINESS_ROLE_MODELS); ?>"
                        id="<?php echo esc_attr(SettingKey::DISABLE_BUSINESS_ROLE_MODELS); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->isBusinessRoleModelsDisabled()) : ?>
                        checked
                    <?php endif; ?>
                >

                <?php esc_html_e('Disables the ability for users to create ads, purchase payment packages, or use subscriptions.',
                    'listivo-core'); ?>
            </label>
        </td>
    </tr>
    </tbody>
</table>

<h2><?php esc_html_e('Full name of a company representative', 'listivo-core'); ?></h2>

<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::ENABLE_BUSINESS_ACCOUNT_FULL_NAME); ?>">
                <?php esc_html_e('Enabled', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::ENABLE_BUSINESS_ACCOUNT_FULL_NAME); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::ENABLE_BUSINESS_ACCOUNT_FULL_NAME); ?>"
                        id="<?php echo esc_attr(SettingKey::ENABLE_BUSINESS_ACCOUNT_FULL_NAME); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->isFullNameEnabledForBusinessAccount()) : ?>
                        checked
                    <?php endif; ?>
                >
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::REQUIRE_BUSINESS_ACCOUNT_FULL_NAME); ?>">
                <?php esc_html_e('Required', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::REQUIRE_BUSINESS_ACCOUNT_FULL_NAME); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::REQUIRE_BUSINESS_ACCOUNT_FULL_NAME); ?>"
                        id="<?php echo esc_attr(SettingKey::REQUIRE_BUSINESS_ACCOUNT_FULL_NAME); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->isFullNameRequiredForBusinessAccount()) : ?>
                        checked
                    <?php endif; ?>
                >
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::SHOW_REGISTER_FORM_BUSINESS_ACCOUNT_FULL_NAME); ?>">
                <?php esc_html_e('Show on register form', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::SHOW_REGISTER_FORM_BUSINESS_ACCOUNT_FULL_NAME); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::SHOW_REGISTER_FORM_BUSINESS_ACCOUNT_FULL_NAME); ?>"
                        id="<?php echo esc_attr(SettingKey::SHOW_REGISTER_FORM_BUSINESS_ACCOUNT_FULL_NAME); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->isFullNameRequiredForBusinessAccount()) : ?>
                        disabled
                    <?php endif; ?>
                    <?php if (tdf_settings()->showFullNameFieldOnRegisterFormForBusinessAccount()) : ?>
                        checked
                    <?php endif; ?>
                >

                <?php if (tdf_settings()->isFullNameRequiredForBusinessAccount()) : ?>
                    <?php esc_html_e('When a field is required, it must always be on the registration form.',
                        'listivo-core'); ?>
                <?php endif; ?>
            </label>
        </td>
    </tr>
    </tbody>
</table>

<h2><?php esc_html_e('Company information field', 'listivo-core'); ?></h2>

<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::ENABLE_COMPANY_INFORMATION); ?>">
                <?php esc_html_e('Enabled', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::ENABLE_COMPANY_INFORMATION); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::ENABLE_COMPANY_INFORMATION); ?>"
                        id="<?php echo esc_attr(SettingKey::ENABLE_COMPANY_INFORMATION); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->isCompanyInformationEnabled()) : ?>
                        checked
                    <?php endif; ?>
                >
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::REQUIRE_COMPANY_INFORMATION); ?>">
                <?php esc_html_e('Required', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::REQUIRE_COMPANY_INFORMATION); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::REQUIRE_COMPANY_INFORMATION); ?>"
                        id="<?php echo esc_attr(SettingKey::REQUIRE_COMPANY_INFORMATION); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->requireCompanyInformation()) : ?>
                        checked
                    <?php endif; ?>
                >
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::SHOW_REGISTER_FORM_COMPANY_INFORMATION); ?>">
                <?php esc_html_e('Show on register form', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::SHOW_REGISTER_FORM_COMPANY_INFORMATION); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::SHOW_REGISTER_FORM_COMPANY_INFORMATION); ?>"
                        id="<?php echo esc_attr(SettingKey::SHOW_REGISTER_FORM_COMPANY_INFORMATION); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->requireCompanyInformation()) : ?>
                        disabled
                    <?php endif; ?>
                    <?php if (tdf_settings()->showCompanyInformationFieldOnRegisterForm()) : ?>
                        checked
                    <?php endif; ?>
                >

                <?php if (tdf_settings()->requireCompanyInformation()) : ?>
                    <?php esc_html_e('When a field is required, it must always be on the registration form.',
                        'listivo-core'); ?>
                <?php endif; ?>
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