<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<div class="tdf-checkbox">
    <input
            name="<?php echo esc_attr(SettingKey::DISABLE_WHATS_APP); ?>"
            id="<?php echo esc_attr(SettingKey::DISABLE_WHATS_APP); ?>"
            type="checkbox"
            value="1"
        <?php if (tdf_settings()->disableWhatsApp()) : ?>
            checked
        <?php endif; ?>
    >

    <label for="<?php echo esc_attr(SettingKey::DISABLE_WHATS_APP); ?>">
        <?php esc_html_e('Disable WhatsApp', 'listivo-core'); ?>
    </label>
</div>