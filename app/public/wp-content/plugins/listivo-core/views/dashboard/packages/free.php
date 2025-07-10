<?php use Tangibledesign\Framework\Core\Settings\SettingKey; ?>

<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::ENABLE_FREE_LISTING); ?>">
                <?php esc_html_e('Enabled', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::ENABLE_FREE_LISTING); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::ENABLE_FREE_LISTING); ?>"
                        id="<?php echo esc_attr(SettingKey::ENABLE_FREE_LISTING); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->isFreeListingEnabled()) : ?>
                        checked
                    <?php endif; ?>
                >
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::FREE_LISTING_LABEL); ?>">
                <?php esc_html_e('Label', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::FREE_LISTING_LABEL); ?>"
                    name="<?php echo esc_attr(SettingKey::FREE_LISTING_LABEL); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getFreeListingLabel()); ?>"
            >
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::FREE_LISTING_TEXT); ?>">
                <?php esc_html_e('Text', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::FREE_LISTING_TEXT); ?>"
                    name="<?php echo esc_attr(SettingKey::FREE_LISTING_TEXT); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getFreeListingText()); ?>"
            >
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::FREE_LISTING_EXPIRE); ?>">
                <?php esc_html_e('Ad Duration (days)', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::FREE_LISTING_EXPIRE); ?>"
                    name="<?php echo esc_attr(SettingKey::FREE_LISTING_EXPIRE); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getFreeListingExpire()); ?>"
            >

            <p class="description">
                <?php esc_html_e('0 means unlimited', 'listivo-core'); ?>
            </p>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::FREE_LISTING_FEATURED_EXPIRE); ?>">
                <?php esc_html_e('Featured Duration (days)', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::FREE_LISTING_FEATURED_EXPIRE); ?>"
                    name="<?php echo esc_attr(SettingKey::FREE_LISTING_FEATURED_EXPIRE); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getFreeListingFeaturedExpire()); ?>"
            >
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::FREE_LISTING_BUMPS_NUMBER); ?>">
                <?php esc_html_e('Bumps Number', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::FREE_LISTING_BUMPS_NUMBER); ?>"
                    name="<?php echo esc_attr(SettingKey::FREE_LISTING_BUMPS_NUMBER); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getFreeListingBumpsNumber()); ?>"
            >
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::FREE_LISTING_BUMPS_INTERVAL); ?>">
                <?php esc_html_e('Bumps Interval (days)', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::FREE_LISTING_BUMPS_INTERVAL); ?>"
                    name="<?php echo esc_attr(SettingKey::FREE_LISTING_BUMPS_INTERVAL); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getFreeListingBumpsInterval()); ?>"
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