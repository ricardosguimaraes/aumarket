<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<h3><?php esc_html_e('Google Authentication', 'listivo-core'); ?></h3>

<p>
    <a target="_blank" href="https://support.listivotheme.com/support/solutions/articles/101000373803">
        <?php esc_html_e('Learn how to configure google authentication.', 'listivo-core'); ?>
    </a>
</p>

<p>
    Redirect URI: <strong><?php echo esc_url(site_url() . '/social-auth/google/'); ?></strong>
</p>

<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::GOOGLE_AUTH); ?>">
                <?php esc_html_e('Enabled', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::GOOGLE_AUTH); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::GOOGLE_AUTH); ?>"
                        id="<?php echo esc_attr(SettingKey::GOOGLE_AUTH); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->googleAuth()) : ?>
                        checked
                    <?php endif; ?>
                >
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::GOOGLE_AUTH_CLIENT_ID); ?>">
                <?php esc_html_e('Client ID', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::GOOGLE_AUTH_CLIENT_ID); ?>"
                    name="<?php echo esc_attr(SettingKey::GOOGLE_AUTH_CLIENT_ID); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getGoogleAuthClientId()); ?>"
            >
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::GOOGLE_AUTH_CLIENT_SECRET); ?>">
                <?php esc_html_e('Client Secret', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::GOOGLE_AUTH_CLIENT_SECRET); ?>"
                    name="<?php echo esc_attr(SettingKey::GOOGLE_AUTH_CLIENT_SECRET); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getGoogleAuthClientSecret()); ?>"
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

<h3><?php esc_html_e('Facebook Authentication', 'listivo-core'); ?></h3>

<p>
    <a target="_blank" href="https://support.listivotheme.com/support/solutions/articles/101000373806">
        <?php esc_html_e('Learn how to configure facebook authentication.', 'listivo-core'); ?>
    </a>
</p>

<p>
    Redirect URI: <strong><?php echo esc_url(site_url() . '/social-auth/facebook/'); ?></strong>
</p>

<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::FACEBOOK_AUTH); ?>">
                <?php esc_html_e('Enabled', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::FACEBOOK_AUTH); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::FACEBOOK_AUTH); ?>"
                        id="<?php echo esc_attr(SettingKey::FACEBOOK_AUTH); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->facebookAuth()) : ?>
                        checked
                    <?php endif; ?>
                >
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::FACEBOOK_AUTH_APP_ID); ?>">
                <?php esc_html_e('Facebook App ID', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::FACEBOOK_AUTH_APP_ID); ?>"
                    name="<?php echo esc_attr(SettingKey::FACEBOOK_AUTH_APP_ID); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getFacebookAuthAppId()); ?>"
            >
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::FACEBOOK_AUTH_APP_SECRET); ?>">
                <?php esc_html_e('Facebook App Secret', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::FACEBOOK_AUTH_APP_SECRET); ?>"
                    name="<?php echo esc_attr(SettingKey::FACEBOOK_AUTH_APP_SECRET); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getFacebookAuthAppSecret()); ?>"
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