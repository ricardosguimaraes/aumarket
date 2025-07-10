<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<div id="tdf-social" class="tdf-content-section">
    <div class="tdf-content-section__left">
        <h2><?php esc_html_e('Social Profiles', 'listivo-core'); ?></h2>

        <div>
            <?php esc_html_e('Add links to your social media profiles. Remove "#" sign to hide icons on your website. Facebook API Key is required to share images correctly.', 'listivo-core'); ?>
        </div>
    </div>

    <div class="tdf-content-section__right">
        <div class="tdf-field">
            <label for="<?php echo esc_attr(SettingKey::FACEBOOK_PROFILE); ?>">
                <i class="fab fa-facebook-square"></i> <?php esc_html_e('Facebook', 'listivo-core'); ?>
            </label>

            <input
                    name="<?php echo esc_attr(SettingKey::FACEBOOK_PROFILE); ?>"
                    id="<?php echo esc_attr(SettingKey::FACEBOOK_PROFILE); ?>"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getFacebookProfile()); ?>"
            >
        </div>

        <div class="tdf-field">
            <label for="<?php echo esc_attr(SettingKey::TWITTER_PROFILE); ?>">
                <i class="fab fa-twitter-square"></i> <?php esc_html_e('X (Twitter)', 'listivo-core'); ?>
            </label>

            <input
                    name="<?php echo esc_attr(SettingKey::TWITTER_PROFILE); ?>"
                    id="<?php echo esc_attr(SettingKey::TWITTER_PROFILE); ?>"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getTwitterProfile()); ?>"
            >
        </div>

        <div class="tdf-field">
            <label for="<?php echo esc_attr(SettingKey::INSTAGRAM_PROFILE); ?>">
                <i class="fab fa-instagram-square"></i> <?php esc_html_e('Instagram', 'listivo-core'); ?>
            </label>

            <input
                    name="<?php echo esc_attr(SettingKey::INSTAGRAM_PROFILE); ?>"
                    id="<?php echo esc_attr(SettingKey::INSTAGRAM_PROFILE); ?>"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getInstagramProfile()); ?>"
            >
        </div>

        <div class="tdf-field">
            <label for="<?php echo esc_attr(SettingKey::LINKED_IN_PROFILE); ?>">
                <i class="fab fa-linkedin"></i> <?php esc_html_e('LinkedIn', 'listivo-core'); ?>
            </label>

            <input
                    name="<?php echo esc_attr(SettingKey::LINKED_IN_PROFILE); ?>"
                    id="<?php echo esc_attr(SettingKey::LINKED_IN_PROFILE); ?>"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getLinkedInProfile()); ?>"
            >
        </div>

        <div class="tdf-field">
            <label for="<?php echo esc_attr(SettingKey::YOU_TUBE_PROFILE); ?>">
                <i class="fab fa-youtube-square"></i> <?php esc_html_e('YouTube', 'listivo-core'); ?>
            </label>

            <input
                    name="<?php echo esc_attr(SettingKey::YOU_TUBE_PROFILE); ?>"
                    id="<?php echo esc_attr(SettingKey::YOU_TUBE_PROFILE); ?>"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getYouTubeProfile()); ?>"
            >
        </div>

        <div class="tdf-field">
            <label for="<?php echo esc_attr(SettingKey::FACEBOOK_API_KEY); ?>">
                <i class="fas fa-key fa-flip-horizontal"></i> <?php esc_html_e('Facebook API Key', 'listivo-core'); ?>
                <span>
                    - <a
                            target="_blank"
                            href="https://developers.facebook.com/docs/pages/getting-started/"
                    >
                        <?php esc_html_e('click here create key', 'listivo-core'); ?>
                    </a>
                </span>
            </label>

            <input
                    name="<?php echo esc_attr(SettingKey::FACEBOOK_API_KEY); ?>"
                    id="<?php echo esc_attr(SettingKey::FACEBOOK_API_KEY); ?>"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getFacebookApiKey()); ?>"
            >
        </div>

        <?php tdf_load_view('dashboard/partials/save_changes_button'); ?>
    </div>
</div>