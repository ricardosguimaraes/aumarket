<?php use Tangibledesign\Framework\Core\Settings\SettingKey; ?>

<h3><?php esc_html_e('Free package for new users', 'listivo-core'); ?></h3>

<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::ENABLE_REGISTER_PACKAGE); ?>">
                <?php esc_html_e('Enabled', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::ENABLE_REGISTER_PACKAGE); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::ENABLE_REGISTER_PACKAGE); ?>"
                        id="<?php echo esc_attr(SettingKey::ENABLE_REGISTER_PACKAGE); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->isRegisterPackageEnabled()) : ?>
                        checked
                    <?php endif; ?>
                >
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::REGISTER_PACKAGE_NUMBER); ?>">
                <?php esc_html_e('Number', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::REGISTER_PACKAGE_NUMBER); ?>"
                    name="<?php echo esc_attr(SettingKey::REGISTER_PACKAGE_NUMBER); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getRegisterPackageNumber()); ?>"
            >
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::REGISTER_PACKAGE_EXPIRE); ?>">
                <?php esc_html_e('Ad Duration (days)', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::REGISTER_PACKAGE_EXPIRE); ?>"
                    name="<?php echo esc_attr(SettingKey::REGISTER_PACKAGE_EXPIRE); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getRegisterPackageExpire()); ?>"
            >

            <p class="description">
                <?php esc_html_e('0 means unlimited', 'listivo-core'); ?>
            </p>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::REGISTER_PACKAGE_FEATURED_EXPIRE); ?>">
                <?php esc_html_e('Featured Duration (days)', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::REGISTER_PACKAGE_FEATURED_EXPIRE); ?>"
                    name="<?php echo esc_attr(SettingKey::REGISTER_PACKAGE_FEATURED_EXPIRE); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getRegisterPackageFeaturedExpire()); ?>"
            >
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::REGISTER_PACKAGE_BUMPS_NUMBER); ?>">
                <?php esc_html_e('Bumps Number', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::REGISTER_PACKAGE_BUMPS_NUMBER); ?>"
                    name="<?php echo esc_attr(SettingKey::REGISTER_PACKAGE_BUMPS_NUMBER); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getRegisterPackageBumpsNumber()); ?>"
            >
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::REGISTER_PACKAGE_BUMPS_INTERVAL); ?>">
                <?php esc_html_e('Bumps Interval (days)', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::REGISTER_PACKAGE_BUMPS_INTERVAL); ?>"
                    name="<?php echo esc_attr(SettingKey::REGISTER_PACKAGE_BUMPS_INTERVAL); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getRegisterPackageBumpsInterval()); ?>"
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