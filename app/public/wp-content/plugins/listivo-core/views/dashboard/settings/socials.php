<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::FACEBOOK_PROFILE); ?>">
                <?php esc_html_e('Facebook', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::FACEBOOK_PROFILE); ?>"
                    name="<?php echo esc_attr(SettingKey::FACEBOOK_PROFILE); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getFacebookProfile()); ?>"
            >
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::TWITTER_PROFILE); ?>">
                <?php esc_html_e('Twitter', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::TWITTER_PROFILE); ?>"
                    name="<?php echo esc_attr(SettingKey::TWITTER_PROFILE); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getTwitterProfile()); ?>"
            >
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::INSTAGRAM_PROFILE); ?>">
                <?php esc_html_e('Instagram', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::INSTAGRAM_PROFILE); ?>"
                    name="<?php echo esc_attr(SettingKey::INSTAGRAM_PROFILE); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getInstagramProfile()); ?>"
            >
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::LINKED_IN_PROFILE); ?>">
                <?php esc_html_e('LinkedIn', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::LINKED_IN_PROFILE); ?>"
                    name="<?php echo esc_attr(SettingKey::LINKED_IN_PROFILE); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getLinkedInProfile()); ?>"
            >
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::YOU_TUBE_PROFILE); ?>">
                <?php esc_html_e('YouTube', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::YOU_TUBE_PROFILE); ?>"
                    name="<?php echo esc_attr(SettingKey::YOU_TUBE_PROFILE); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getYouTubeProfile()); ?>"
            >
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::TIKTOK_PROFILE); ?>">
                <?php esc_html_e('TikTok', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::TIKTOK_PROFILE); ?>"
                    name="<?php echo esc_attr(SettingKey::TIKTOK_PROFILE); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getTiktokProfile()); ?>"
            >
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::TELEGRAM_PROFILE); ?>">
                <?php esc_html_e('Telegram', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::TELEGRAM_PROFILE); ?>"
                    name="<?php echo esc_attr(SettingKey::TELEGRAM_PROFILE); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getTelegramProfile()); ?>"
            >
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::EBAY_PROFILE); ?>">
                <?php esc_html_e('eBay', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::EBAY_PROFILE); ?>"
                    name="<?php echo esc_attr(SettingKey::EBAY_PROFILE); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getEbayProfile()); ?>"
            >
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::FACEBOOK_API_KEY); ?>">
                <?php esc_html_e('Facebook API Key', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::FACEBOOK_API_KEY); ?>"
                    name="<?php echo esc_attr(SettingKey::FACEBOOK_API_KEY); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getFacebookApiKey()); ?>"
            >

            <p class="description">
                <a
                        target="_blank"
                        href="https://developers.facebook.com/docs/pages/getting-started/"
                >
                    <?php esc_html_e('Create a new api key', 'listivo-core'); ?>
                </a>
            </p>
        </td>
    </tr>
    </tbody>
</table>

<p class="submit">
    <button class="button button-primary">
        <?php esc_html_e('Save Changes', 'listivo-core'); ?>
    </button>
</p>