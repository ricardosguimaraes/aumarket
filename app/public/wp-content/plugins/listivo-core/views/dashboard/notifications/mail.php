<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;
use Tangibledesign\Framework\Models\Page;

?>
<div class="listivo-backend-content">
    <table class="form-table">
        <tbody>
        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr(SettingKey::MAIL_FOOTER); ?>">
                    <?php esc_html_e('Mail Footer', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                <textarea
                        name="<?php echo esc_attr(SettingKey::MAIL_FOOTER); ?>"
                        id="<?php echo esc_attr(SettingKey::MAIL_FOOTER); ?>"
                        class="regular-text"
                        rows="5"
                ><?php echo wp_kses_post(tdf_settings()->getMailFooter()); ?></textarea>
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr(SettingKey::SENDER_NAME); ?>">
                    <?php esc_html_e('Name', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                <input
                        name="<?php echo esc_attr(SettingKey::SENDER_NAME); ?>"
                        id="<?php echo esc_attr(SettingKey::SENDER_NAME); ?>"
                        class="regular-text"
                        type="text"
                        value="<?php echo esc_attr(tdf_settings()->getSenderName()); ?>"
                >
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr(SettingKey::SENDER_EMAIL); ?>">
                    <?php esc_html_e('Email', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                <input
                        name="<?php echo esc_attr(SettingKey::SENDER_EMAIL); ?>"
                        id="<?php echo esc_attr(SettingKey::SENDER_EMAIL); ?>"
                        class="regular-text"
                        type="text"
                        value="<?php echo esc_attr(tdf_settings()->getSenderEmail()); ?>"
                >
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