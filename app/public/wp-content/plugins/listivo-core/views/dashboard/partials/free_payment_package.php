<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<h3><?php esc_html_e('"Add for Free" Option', 'listivo-core'); ?></h3>

<div class="tdf-checkbox">
    <input
            name="<?php echo esc_attr(SettingKey::ENABLE_FREE_LISTING); ?>"
            id="<?php echo esc_attr(SettingKey::ENABLE_FREE_LISTING); ?>"
            type="checkbox"
            value="1"
        <?php if (tdf_settings()->isFreeListingEnabled()) : ?>
            checked
        <?php endif; ?>
    >

    <label for="<?php echo esc_attr(SettingKey::ENABLE_FREE_LISTING); ?>">
        <?php esc_html_e('Enable', 'listivo-core'); ?>
    </label>
</div>

<div class="tdf-field">
    <label for="<?php echo esc_attr(SettingKey::FREE_LISTING_EXPIRE); ?>">
        <?php esc_html_e('Duration (days)', 'listivo-core'); ?>
    </label>

    <input
            id="<?php echo esc_attr(SettingKey::FREE_LISTING_EXPIRE); ?>"
            name="<?php echo esc_attr(SettingKey::FREE_LISTING_EXPIRE); ?>"
            type="text"
            value="<?php echo esc_attr(tdf_settings()->getFreeListingExpire()); ?>"
    >

    <p class="description">
        <?php esc_html_e('0 means unlimited', 'listivo-core'); ?>
    </p>
</div>

<div class="tdf-field">
    <label for="<?php echo esc_attr(SettingKey::FREE_LISTING_FEATURED_EXPIRE); ?>">
        <?php esc_html_e('Featured (days)', 'listivo-core'); ?>
    </label>

    <input
            id="<?php echo esc_attr(SettingKey::FREE_LISTING_FEATURED_EXPIRE); ?>"
            name="<?php echo esc_attr(SettingKey::FREE_LISTING_FEATURED_EXPIRE); ?>"
            type="text"
            value="<?php echo esc_attr(tdf_settings()->getFreeListingFeaturedExpire()); ?>"
    >
</div>

<div class="tdf-field">
    <label for="<?php echo esc_attr(SettingKey::FREE_LISTING_BUMPS_NUMBER); ?>">
        <?php esc_html_e('Auto bumps', 'listivo-core'); ?>
    </label>

    <input
            id="<?php echo esc_attr(SettingKey::FREE_LISTING_BUMPS_NUMBER); ?>"
            name="<?php echo esc_attr(SettingKey::FREE_LISTING_BUMPS_NUMBER); ?>"
            type="text"
            value="<?php echo esc_attr(tdf_settings()->getFreeListingBumpsNumber()); ?>"
    >
</div>

<div class="tdf-field">
    <label for="<?php echo esc_attr(SettingKey::FREE_LISTING_BUMPS_INTERVAL); ?>">
        <?php esc_html_e('Auto bump every (days)', 'listivo-core'); ?>
    </label>

    <input
            id="<?php echo esc_attr(SettingKey::FREE_LISTING_BUMPS_INTERVAL); ?>"
            name="<?php echo esc_attr(SettingKey::FREE_LISTING_BUMPS_INTERVAL); ?>"
            type="text"
            value="<?php echo esc_attr(tdf_settings()->getFreeListingBumpsNumber()); ?>"
    >
</div>