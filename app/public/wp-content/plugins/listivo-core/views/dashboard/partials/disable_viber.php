<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<div class="tdf-checkbox">
    <input
            name="<?php echo esc_attr(SettingKey::DISABLE_VIBER); ?>"
            id="<?php echo esc_attr(SettingKey::DISABLE_VIBER); ?>"
            type="checkbox"
            value="1"
        <?php if (tdf_settings()->disableViber()) : ?>
            checked
        <?php endif; ?>
    >

    <label for="<?php echo esc_attr(SettingKey::DISABLE_VIBER); ?>">
        <?php esc_html_e('Disable Viber', 'listivo-core'); ?>
    </label>
</div>
