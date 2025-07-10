<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<div class="tdf-checkbox">
    <input
            name="<?php echo esc_attr(SettingKey::USER_REGISTRATION); ?>"
            id="<?php echo esc_attr(SettingKey::USER_REGISTRATION); ?>"
            type="checkbox"
            value="1"
        <?php if (tdf_settings()->userRegistrationOpen()) : ?>
            checked
        <?php endif; ?>
    >
    <label for="<?php echo esc_attr(SettingKey::USER_REGISTRATION); ?>">
        <?php esc_html_e('Registration - enable user registration', 'listivo-core'); ?>
    </label>
</div>
