<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<div class="tdf-checkbox">
    <input
            name="<?php echo esc_attr(SettingKey::SUBMIT_WITHOUT_LOGIN); ?>"
            id="<?php echo esc_attr(SettingKey::SUBMIT_WITHOUT_LOGIN); ?>"
            type="checkbox"
            value="1"
        <?php if (tdf_settings()->submitWithoutLogin()) : ?>
            checked
        <?php endif; ?>
    >

    <label for="<?php echo esc_attr(SettingKey::SUBMIT_WITHOUT_LOGIN); ?>">
        <?php esc_html_e('Allow adding listing before login', 'listivo-core'); ?>
    </label>
</div>