<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<div id="tdf-recaptcha" class="tdf-content-section">
    <div class="tdf-content-section__left">
        <h2>
            <?php esc_html_e('Google reCAPTCHA', 'listivo-core'); ?>
        </h2>

        <div class="tdf-doc">
            <div class="tdf-doc__icon">
                <i class="fas fa-info"></i>
            </div>

            <div class="tdf-doc__text">
                <a
                        href="https://www.google.com/recaptcha/admin/create"
                        target="_blank"
                >
                    <?php esc_html_e('Click here to create new reCAPTCHA v3', 'listivo-core'); ?>
                </a>
            </div>
        </div>
    </div>

    <div class="tdf-content-section__right">
        <div class="tdf-checkbox">
            <input
                    name="<?php echo esc_attr(SettingKey::RE_CAPTCHA); ?>"
                    id="<?php echo esc_attr(SettingKey::RE_CAPTCHA); ?>"
                    type="checkbox"
                    value="1"
                <?php if (tdf_settings()->isRecaptchaChecked()) : ?>
                    checked
                <?php endif; ?>
            >
            <label for="<?php echo esc_attr(SettingKey::RE_CAPTCHA); ?>">
                <?php esc_html_e('Enable Google reCAPTCHA', 'listivo-core'); ?>
            </label>
        </div>

        <div class="tdf-field">
            <label for="<?php echo esc_attr(SettingKey::RE_CAPTCHA_SITE_KEY); ?>">
                <?php esc_html_e('Google reCaptcha - Site key', 'listivo-core'); ?>
            </label>

            <input
                    name="<?php echo esc_attr(SettingKey::RE_CAPTCHA_SITE_KEY); ?>"
                    id="<?php echo esc_attr(SettingKey::RE_CAPTCHA_SITE_KEY); ?>"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getReCaptchaSiteKey()); ?>"
            >
        </div>

        <div class="tdf-field">
            <label for="<?php echo esc_attr(SettingKey::RE_CAPTCHA_SECRET_KEY); ?>">
                <?php esc_html_e('Google reCaptcha - Secret key', 'listivo-core'); ?>
            </label>

            <input
                    name="<?php echo esc_attr(SettingKey::RE_CAPTCHA_SECRET_KEY); ?>"
                    id="<?php echo esc_attr(SettingKey::RE_CAPTCHA_SECRET_KEY); ?>"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getReCaptchaSecretKey()); ?>"
            >
        </div>

        <?php tdf_load_view('dashboard/partials/save_changes_button'); ?>
    </div>
</div>