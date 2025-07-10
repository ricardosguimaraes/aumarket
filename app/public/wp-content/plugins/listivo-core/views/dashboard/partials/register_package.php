<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<h3><?php esc_html_e('"Free Package" Option for New Registered Users', 'listivo-core'); ?></h3>

<div class="tdf-checkbox">
    <input
            name="<?php echo esc_attr(SettingKey::ENABLE_REGISTER_PACKAGE); ?>"
            id="<?php echo esc_attr(SettingKey::ENABLE_REGISTER_PACKAGE); ?>"
            type="checkbox"
            value="1"
        <?php if (tdf_settings()->isRegisterPackageEnabled()) : ?>
            checked
        <?php endif; ?>
    >

    <label for="<?php echo esc_attr(SettingKey::ENABLE_REGISTER_PACKAGE); ?>">
        <?php esc_html_e('Enable', 'listivo-core'); ?>
    </label>
</div>

<div class="tdf-field">
    <label for="<?php echo esc_attr(SettingKey::REGISTER_PACKAGE_NUMBER); ?>">
        <?php esc_html_e('Number of ads', 'listivo-core'); ?>
    </label>

    <input
            id="<?php echo esc_attr(SettingKey::REGISTER_PACKAGE_NUMBER); ?>"
            name="<?php echo esc_attr(SettingKey::REGISTER_PACKAGE_NUMBER); ?>"
            type="text"
            value="<?php echo esc_attr(tdf_settings()->getRegisterPackageNumber()); ?>"
    >
</div>

<div class="tdf-field">
    <label for="<?php echo esc_attr(SettingKey::REGISTER_PACKAGE_EXPIRE); ?>">
        <?php esc_html_e('Duration (days)', 'listivo-core'); ?>
    </label>

    <input
            id="<?php echo esc_attr(SettingKey::REGISTER_PACKAGE_EXPIRE); ?>"
            name="<?php echo esc_attr(SettingKey::REGISTER_PACKAGE_EXPIRE); ?>"
            type="text"
            value="<?php echo esc_attr(tdf_settings()->getRegisterPackageExpire()); ?>"
    >

    <p class="description">
        <?php esc_html_e('0 means unlimited', 'listivo-core'); ?>
    </p>
</div>

<div class="tdf-field">
    <label for="<?php echo esc_attr(SettingKey::REGISTER_PACKAGE_FEATURED_EXPIRE); ?>">
        <?php esc_html_e('Featured (days)', 'listivo-core'); ?>
    </label>

    <input
            id="<?php echo esc_attr(SettingKey::REGISTER_PACKAGE_FEATURED_EXPIRE); ?>"
            name="<?php echo esc_attr(SettingKey::REGISTER_PACKAGE_FEATURED_EXPIRE); ?>"
            type="text"
            value="<?php echo esc_attr(tdf_settings()->getRegisterPackageFeaturedExpire()); ?>"
    >
</div>

<div class="tdf-field">
    <label for="<?php echo esc_attr(SettingKey::REGISTER_PACKAGE_BUMPS_NUMBER); ?>">
        <?php esc_html_e('Auto bumps', 'listivo-core'); ?>
    </label>

    <input
            id="<?php echo esc_attr(SettingKey::REGISTER_PACKAGE_BUMPS_NUMBER); ?>"
            name="<?php echo esc_attr(SettingKey::REGISTER_PACKAGE_BUMPS_NUMBER); ?>"
            type="text"
            value="<?php echo esc_attr(tdf_settings()->getRegisterPackageBumpsNumber()); ?>"
    >
</div>

<div class="tdf-field">
    <label for="<?php echo esc_attr(SettingKey::REGISTER_PACKAGE_BUMPS_INTERVAL); ?>">
        <?php esc_html_e('Bump every (days)', 'listivo-core'); ?>
    </label>

    <input
            id="<?php echo esc_attr(SettingKey::REGISTER_PACKAGE_BUMPS_INTERVAL); ?>"
            name="<?php echo esc_attr(SettingKey::REGISTER_PACKAGE_BUMPS_INTERVAL); ?>"
            type="text"
            value="<?php echo esc_attr(tdf_settings()->getRegisterPackageBumpsNumber()); ?>"
    >
</div>