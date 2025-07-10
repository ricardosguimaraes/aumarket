<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<p>
    <a
            href="https://www.google.com/recaptcha/admin/create"
            target="_blank"
    >
        <?php esc_html_e('Click here to create new reCAPTCHA v3', 'listivo-core'); ?>
    </a>
</p>

<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::RE_CAPTCHA); ?>">
                <?php esc_html_e('Enabled', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::RE_CAPTCHA); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::RE_CAPTCHA); ?>"
                        id="<?php echo esc_attr(SettingKey::RE_CAPTCHA); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->isRecaptchaChecked()) : ?>
                        checked
                    <?php endif; ?>
                >
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::RE_CAPTCHA_SITE_KEY); ?>">
                <?php esc_html_e('Site Key', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    name="<?php echo esc_attr(SettingKey::RE_CAPTCHA_SITE_KEY); ?>"
                    id="<?php echo esc_attr(SettingKey::RE_CAPTCHA_SITE_KEY); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getReCaptchaSiteKey()); ?>"
            >
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::RE_CAPTCHA_SECRET_KEY); ?>">
                <?php esc_html_e('Secret Key', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    name="<?php echo esc_attr(SettingKey::RE_CAPTCHA_SECRET_KEY); ?>"
                    id="<?php echo esc_attr(SettingKey::RE_CAPTCHA_SECRET_KEY); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getReCaptchaSecretKey()); ?>"
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