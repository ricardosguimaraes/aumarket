<?php

use Tangibledesign\Framework\Models\User\Helpers\UserSettingKey;
use Tangibledesign\Framework\Models\User\User;

/* @var User $user */
?>
<table class="form-table" role="presentation">
    <tr class="user-first-name-wrap">
        <th>
            <label for="<?php echo esc_attr(UserSettingKey::FACEBOOK_PROFILE); ?>">
                <?php esc_html_e('Facebook Profile', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    name="<?php echo esc_attr(UserSettingKey::FACEBOOK_PROFILE); ?>"
                    id="<?php echo esc_attr(UserSettingKey::FACEBOOK_PROFILE); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr($user->getFacebookProfile()); ?>"
            >
        </td>
    </tr>

    <tr class="user-first-name-wrap">
        <th>
            <label for="<?php echo esc_attr(UserSettingKey::TWITTER_PROFILE); ?>">
                <?php esc_html_e('Twitter Profile', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    name="<?php echo esc_attr(UserSettingKey::TWITTER_PROFILE); ?>"
                    id="<?php echo esc_attr(UserSettingKey::TWITTER_PROFILE); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr($user->getTwitterProfile()); ?>"
            >
        </td>
    </tr>

    <tr class="user-first-name-wrap">
        <th>
            <label for="<?php echo esc_attr(UserSettingKey::INSTAGRAM_PROFILE); ?>">
                <?php esc_html_e('Instagram Profile', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    name="<?php echo esc_attr(UserSettingKey::INSTAGRAM_PROFILE); ?>"
                    id="<?php echo esc_attr(UserSettingKey::INSTAGRAM_PROFILE); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr($user->getInstagramProfile()); ?>"
            >
        </td>
    </tr>

    <tr class="user-first-name-wrap">
        <th>
            <label for="<?php echo esc_attr(UserSettingKey::LINKED_IN_PROFILE); ?>">
                <?php esc_html_e('LinkedIn Profile', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    name="<?php echo esc_attr(UserSettingKey::LINKED_IN_PROFILE); ?>"
                    id="<?php echo esc_attr(UserSettingKey::LINKED_IN_PROFILE); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr($user->getLinkedInProfile()); ?>"
            >
        </td>
    </tr>

    <tr class="user-first-name-wrap">
        <th>
            <label for="<?php echo esc_attr(UserSettingKey::YOU_TUBE_PROFILE); ?>">
                <?php esc_html_e('YouTube Profile', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    name="<?php echo esc_attr(UserSettingKey::YOU_TUBE_PROFILE); ?>"
                    id="<?php echo esc_attr(UserSettingKey::YOU_TUBE_PROFILE); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr($user->getYouTubeProfile()); ?>"
            >
        </td>
    </tr>

    <tr class="user-first-name-wrap">
        <th>
            <label for="<?php echo esc_attr(UserSettingKey::TIKTOK_PROFILE); ?>">
                <?php esc_html_e('TikTok Profile', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    name="<?php echo esc_attr(UserSettingKey::TIKTOK_PROFILE); ?>"
                    id="<?php echo esc_attr(UserSettingKey::TIKTOK_PROFILE); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr($user->getTiktokProfile()); ?>"
            >
        </td>
    </tr>

    <tr class="user-first-name-wrap">
        <th>
            <label for="<?php echo esc_attr(UserSettingKey::TELEGRAM_PROFILE); ?>">
                <?php esc_html_e('Telegram Profile', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    name="<?php echo esc_attr(UserSettingKey::TELEGRAM_PROFILE); ?>"
                    id="<?php echo esc_attr(UserSettingKey::TELEGRAM_PROFILE); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr($user->getTelegramProfile()); ?>"
            >
        </td>
    </tr>

    <tr class="user-first-name-wrap">
        <th>
            <label for="<?php echo esc_attr(UserSettingKey::EBAY_PROFILE); ?>">
                <?php esc_html_e('eBay Profile', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    name="<?php echo esc_attr(UserSettingKey::EBAY_PROFILE); ?>"
                    id="<?php echo esc_attr(UserSettingKey::EBAY_PROFILE); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr($user->getEbayProfile()); ?>"
            >
        </td>
    </tr>
</table>
