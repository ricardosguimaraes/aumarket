<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<div id="tdf-facebook" class="tdf-content-section">
    <div class="tdf-content-section__left">
        <h2><?php esc_html_e('Facebook Social Auth', 'listivo-core'); ?></h2>

        <div class="tdf-doc">
            <div class="tdf-doc__icon">
                <i class="fas fa-info"></i>
            </div>
            <div class="tdf-doc__text">
                <a target="_blank" href="https://support.listivotheme.com/support/solutions/articles/101000373806">
                    <?php esc_html_e('Click here to read how to configure Facebook Login', 'listivo-core'); ?>
                </a>
            </div>
        </div>

        <div>
            <u>OAuth Redirect URI:</u>
            <small><?php echo esc_url(site_url() . '/social-auth/facebook/'); ?></small>
        </div>
    </div>

    <div class="tdf-content-section__right">
        <div class="tdf-checkbox">
            <input
                    name="<?php echo esc_attr(SettingKey::FACEBOOK_AUTH); ?>"
                    id="<?php echo esc_attr(SettingKey::FACEBOOK_AUTH); ?>"
                    type="checkbox"
                    value="1"
                <?php if (tdf_settings()->facebookAuth()) : ?>
                    checked
                <?php endif; ?>
            >

            <label for="<?php echo esc_attr(SettingKey::FACEBOOK_AUTH); ?>">
                <?php esc_html_e('Facebook Auth', 'listivo-core'); ?>
            </label>
        </div>

        <div class="tdf-field">
            <label for="<?php echo esc_attr(SettingKey::FACEBOOK_AUTH_APP_ID); ?>">
                <?php esc_html_e('Facebook App ID', 'listivo-core'); ?>
            </label>

            <input
                    name="<?php echo esc_attr(SettingKey::FACEBOOK_AUTH_APP_ID); ?>"
                    id="<?php echo esc_attr(SettingKey::FACEBOOK_AUTH_APP_ID); ?>"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getFacebookAuthAppId()); ?>"
            >
        </div>

        <div class="tdf-field">
            <label for="<?php echo esc_attr(SettingKey::FACEBOOK_AUTH_APP_SECRET); ?>">
                <?php esc_html_e('Facebook App Secret', 'listivo-core'); ?>
            </label>

            <input
                    name="<?php echo esc_attr(SettingKey::FACEBOOK_AUTH_APP_SECRET); ?>"
                    id="<?php echo esc_attr(SettingKey::FACEBOOK_AUTH_APP_SECRET); ?>"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getFacebookAuthAppSecret()); ?>"
            >
        </div>

        <?php tdf_load_view('dashboard/partials/save_changes_button'); ?>
    </div>
</div>