<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<div id="tdf-google" class="tdf-content-section">
    <div class="tdf-content-section__left">
        <h2><?php esc_html_e('Google Social Auth', 'listivo-core'); ?></h2>

        <div class="tdf-doc">
            <div class="tdf-doc__icon">
                <i class="fas fa-info"></i>
            </div>
            <div class="tdf-doc__text">
                <a target="_blank" href="https://support.listivotheme.com/support/solutions/articles/101000373803">
                    <?php esc_html_e('Click here to read how to configure Google Login', 'listivo-core'); ?>
                </a>
            </div>
        </div>

        <div>
            <u>OAuth Redirect URI:</u>
            <small><?php echo esc_url(site_url() . '/social-auth/google/'); ?></small>
        </div>
    </div>

    <div class="tdf-content-section__right">
        <div class="tdf-checkbox">
            <input
                    name="<?php echo esc_attr(SettingKey::GOOGLE_AUTH); ?>"
                    id="<?php echo esc_attr(SettingKey::GOOGLE_AUTH); ?>"
                    type="checkbox"
                    value="1"
                <?php if (tdf_settings()->googleAuth()) : ?>
                    checked
                <?php endif; ?>
            >

            <label for="<?php echo esc_attr(SettingKey::GOOGLE_AUTH); ?>">
                <?php esc_html_e('Google Auth', 'listivo-core'); ?>
            </label>
        </div>

        <div class="tdf-field">
            <label for="<?php echo esc_attr(SettingKey::GOOGLE_AUTH_CLIENT_ID); ?>">
                <?php esc_html_e('Google Client ID', 'listivo-core'); ?>
            </label>

            <input
                    name="<?php echo esc_attr(SettingKey::GOOGLE_AUTH_CLIENT_ID); ?>"
                    id="<?php echo esc_attr(SettingKey::GOOGLE_AUTH_CLIENT_ID); ?>"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getGoogleAuthClientId()); ?>"
            >
        </div>

        <div class="tdf-field">
            <label for="<?php echo esc_attr(SettingKey::GOOGLE_AUTH_CLIENT_SECRET); ?>">
                <?php esc_html_e('Google Client Secret', 'listivo-core'); ?>
            </label>

            <input
                    name="<?php echo esc_attr(SettingKey::GOOGLE_AUTH_CLIENT_SECRET); ?>"
                    id="<?php echo esc_attr(SettingKey::GOOGLE_AUTH_CLIENT_SECRET); ?>"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getGoogleAuthClientSecret()); ?>"
            >
        </div>

        <?php tdf_load_view('dashboard/partials/save_changes_button'); ?>
    </div>
</div>