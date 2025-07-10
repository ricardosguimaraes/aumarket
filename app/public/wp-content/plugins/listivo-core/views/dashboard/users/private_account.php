<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::DISABLE_PRIVATE_ROLE_MODELS); ?>">
                <?php esc_html_e('Disable Ad Creation', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::DISABLE_PRIVATE_ROLE_MODELS); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::DISABLE_PRIVATE_ROLE_MODELS); ?>"
                        id="<?php echo esc_attr(SettingKey::DISABLE_PRIVATE_ROLE_MODELS); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->isPrivateRoleModelsDisabled()) : ?>
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

<h2><?php esc_html_e('User full name', 'listivo-core'); ?></h2>

<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::ENABLE_PRIVATE_ACCOUNT_FULL_NAME); ?>">
                <?php esc_html_e('Enabled', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::ENABLE_PRIVATE_ACCOUNT_FULL_NAME); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::ENABLE_PRIVATE_ACCOUNT_FULL_NAME); ?>"
                        id="<?php echo esc_attr(SettingKey::ENABLE_PRIVATE_ACCOUNT_FULL_NAME); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->isFullNameEnabledForPrivateAccount()) : ?>
                        checked
                    <?php endif; ?>
                >
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::REQUIRE_PRIVATE_ACCOUNT_FULL_NAME); ?>">
                <?php esc_html_e('Required', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::REQUIRE_PRIVATE_ACCOUNT_FULL_NAME); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::REQUIRE_PRIVATE_ACCOUNT_FULL_NAME); ?>"
                        id="<?php echo esc_attr(SettingKey::REQUIRE_PRIVATE_ACCOUNT_FULL_NAME); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->isFullNameRequiredForPrivateAccount()) : ?>
                        checked
                    <?php endif; ?>
                >
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::SHOW_REGISTER_FORM_PRIVATE_ACCOUNT_FULL_NAME); ?>">
                <?php esc_html_e('Show on register form', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::SHOW_REGISTER_FORM_PRIVATE_ACCOUNT_FULL_NAME); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::SHOW_REGISTER_FORM_PRIVATE_ACCOUNT_FULL_NAME); ?>"
                        id="<?php echo esc_attr(SettingKey::SHOW_REGISTER_FORM_PRIVATE_ACCOUNT_FULL_NAME); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->isFullNameRequiredForPrivateAccount()) : ?>
                        disabled
                    <?php endif; ?>
                    <?php if (tdf_settings()->showFullNameFieldOnRegisterFormForPrivateAccount()) : ?>
                        checked
                    <?php endif; ?>
                >

                <?php if (tdf_settings()->isFullNameRequiredForPrivateAccount()) : ?>
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