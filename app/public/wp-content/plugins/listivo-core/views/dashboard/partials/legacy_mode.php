<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<div class="tdf-checkbox">
    <input
            name="<?php echo esc_attr(SettingKey::LEGACY_MODE); ?>"
            id="<?php echo esc_attr(SettingKey::LEGACY_MODE); ?>"
            type="checkbox"
            value="1"
        <?php if (tdf_settings()->isLegacyModeEnabled()) : ?>
            checked
        <?php endif; ?>
    >

    <label for="<?php echo esc_attr(SettingKey::LEGACY_MODE); ?>">
        <?php esc_html_e('Legacy Mode', 'listivo-core'); ?>
    </label>
</div>