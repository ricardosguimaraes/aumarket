<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<div class="tdf-field">
    <label for="<?php echo esc_attr(SettingKey::LOGIN_MIN_LENGTH); ?>">
        <?php esc_html_e('Login minimum number of characters', 'listivo-core'); ?>
    </label>

    <input
            name="<?php echo esc_attr(SettingKey::LOGIN_MIN_LENGTH); ?>"
            id="<?php echo esc_attr(SettingKey::LOGIN_MIN_LENGTH); ?>"
            type="text"
            value="<?php echo esc_attr(tdf_settings()->getLoginMinLength()); ?>"
    >
</div>