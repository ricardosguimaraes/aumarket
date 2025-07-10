<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<div class="tdf-checkbox">
    <input
            name="<?php echo esc_attr(SettingKey::MESSAGE_SYSTEM); ?>"
            id="<?php echo esc_attr(SettingKey::MESSAGE_SYSTEM); ?>"
            type="checkbox"
            value="1"
        <?php if (tdf_settings()->messageSystem()) : ?>
            checked
        <?php endif; ?>
    >
    <label for="<?php echo esc_attr(SettingKey::MESSAGE_SYSTEM); ?>">
        <?php esc_html_e('Private Message System', 'listivo-core'); ?>
    </label>
</div>