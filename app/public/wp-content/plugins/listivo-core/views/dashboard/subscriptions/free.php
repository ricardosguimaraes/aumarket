<?php use Tangibledesign\Framework\Core\Settings\SettingKey; ?>
<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::ENABLE_FREE_SUBSCRIPTION); ?>">
                <?php esc_html_e('Enabled', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::ENABLE_FREE_SUBSCRIPTION); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::ENABLE_FREE_SUBSCRIPTION); ?>"
                        id="<?php echo esc_attr(SettingKey::ENABLE_FREE_SUBSCRIPTION); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->isFreeSubscriptionEnabled()) : ?>
                        checked
                    <?php endif; ?>
                >
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::FREE_SUBSCRIPTION_NAME); ?>">
                <?php esc_html_e('Name', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::FREE_SUBSCRIPTION_NAME); ?>"
                    name="<?php echo esc_attr(SettingKey::FREE_SUBSCRIPTION_NAME); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getFreeSubscriptionName()); ?>"
            >
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::FREE_SUBSCRIPTION_LABEL); ?>">
                <?php esc_html_e('Label', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::FREE_SUBSCRIPTION_LABEL); ?>"
                    name="<?php echo esc_attr(SettingKey::FREE_SUBSCRIPTION_LABEL); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getFreeSubscriptionLabel()); ?>"
            >
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::FREE_SUBSCRIPTION_TEXT); ?>">
                <?php esc_html_e('Text', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::FREE_SUBSCRIPTION_TEXT); ?>"
                    name="<?php echo esc_attr(SettingKey::FREE_SUBSCRIPTION_TEXT); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getFreeSubscriptionText()); ?>"
            >
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::FREE_SUBSCRIPTION_EXPIRE); ?>">
                <?php esc_html_e('Ad Duration (days)', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::FREE_SUBSCRIPTION_EXPIRE); ?>"
                    name="<?php echo esc_attr(SettingKey::FREE_SUBSCRIPTION_EXPIRE); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getFreeSubscriptionExpire()); ?>"
            >

            <p class="description">
                <?php esc_html_e('0 means unlimited', 'listivo-core'); ?>
            </p>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::FREE_SUBSCRIPTION_NUMBER); ?>">
                <?php esc_html_e('Number of Ads', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::FREE_SUBSCRIPTION_NUMBER); ?>"
                    name="<?php echo esc_attr(SettingKey::FREE_SUBSCRIPTION_NUMBER); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getFreeSubscriptionNumber()); ?>"
            >
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::FREE_SUBSCRIPTION_FEATURED_EXPIRE); ?>">
                <?php esc_html_e('Featured Duration (days)', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::FREE_SUBSCRIPTION_FEATURED_EXPIRE); ?>"
                    name="<?php echo esc_attr(SettingKey::FREE_SUBSCRIPTION_FEATURED_EXPIRE); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getFreeSubscriptionFeaturedExpire()); ?>"
            >
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::FREE_SUBSCRIPTION_BUMPS_NUMBER); ?>">
                <?php esc_html_e('Number of Bumps', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::FREE_SUBSCRIPTION_BUMPS_NUMBER); ?>"
                    name="<?php echo esc_attr(SettingKey::FREE_SUBSCRIPTION_BUMPS_NUMBER); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getFreeSubscriptionBumpsNumber()); ?>"
            >
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::FREE_SUBSCRIPTION_BUMPS_INTERVAL); ?>">
                <?php esc_html_e('Bumps Interval (days)', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::FREE_SUBSCRIPTION_BUMPS_INTERVAL); ?>"
                    name="<?php echo esc_attr(SettingKey::FREE_SUBSCRIPTION_BUMPS_INTERVAL); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getFreeSubscriptionBumpsInterval()); ?>"
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