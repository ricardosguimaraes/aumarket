<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;
use Tangibledesign\Listivo\Providers\Settings\SettingsServiceProvider;

?>
<form
        action="<?php echo esc_url(tdf_action_url(tdf_prefix().'/settings/save&type='.SettingsServiceProvider::TYPE_QUICK_WIZARD)); ?>"
        method="post"
>
    <input
            type="hidden"
            name="redirect"
            value="<?php echo esc_url(admin_url('admin.php?page='.tdf_prefix().'_basic_setup')); ?>"
    >

    <div class="tdf-app">
        <div class="wrap">
            <h1 class="wp-heading-inline">
                <?php esc_html_e('Quick Wizard', 'listivo-core'); ?>
            </h1>

            <p><?php esc_html_e('All settings can be modified later.', 'listivo-core'); ?></p>

            <input
                    type="hidden"
                    name="redirect"
                    value="<?php echo esc_url(admin_url('admin.php?page='.tdf_prefix().'_basic_setup')); ?>"
            >
        </div>

        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row">
                    <label for="<?php echo esc_attr(SettingKey::USER_REGISTRATION); ?>">
                        <?php esc_html_e('Registration', 'listivo-core'); ?>
                    </label>
                </th>

                <td>
                    <label for="<?php echo esc_attr(SettingKey::USER_REGISTRATION); ?>">
                        <input
                                name="<?php echo esc_attr(SettingKey::USER_REGISTRATION); ?>"
                                id="<?php echo esc_attr(SettingKey::USER_REGISTRATION); ?>"
                                type="checkbox"
                                value="1"
                            <?php if (tdf_settings()->userRegistrationOpen()) : ?>
                                checked
                            <?php endif; ?>
                        >
                    </label>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="<?php echo esc_attr(SettingKey::ENABLE_PAYMENTS); ?>">
                        <?php esc_html_e('Monetization', 'listivo-core'); ?>
                    </label>
                </th>

                <td>
                    <label for="<?php echo esc_attr(SettingKey::ENABLE_PAYMENTS); ?>">
                        <input
                                name="<?php echo esc_attr(SettingKey::ENABLE_PAYMENTS); ?>"
                                id="<?php echo esc_attr(SettingKey::ENABLE_PAYMENTS); ?>"
                                type="checkbox"
                                value="1"
                            <?php if (tdf_settings()->paymentsEnabled()) : ?>
                                checked
                            <?php endif; ?>
                        >
                    </label>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="<?php echo esc_attr(SettingKey::MODERATION); ?>">
                        <?php esc_html_e('Moderation', 'listivo-core'); ?>
                    </label>
                </th>

                <td>
                    <label for="<?php echo esc_attr(SettingKey::MODERATION); ?>">
                        <input
                                name="<?php echo esc_attr(SettingKey::MODERATION); ?>"
                                id="<?php echo esc_attr(SettingKey::MODERATION); ?>"
                                type="checkbox"
                                value="1"
                            <?php if (tdf_settings()->moderationEnabled()) : ?>
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
                <?php esc_html_e('Save', 'listivo-core'); ?>
            </button>
        </p>
    </div>
</form>