<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<div class="tdf-field">
    <label for="<?php echo esc_attr(SettingKey::MAIL); ?>">
        <i class="far fa-envelope"></i> <?php esc_html_e('Public Email', 'listivo-core'); ?>
    </label>

    <input
            id="<?php echo esc_attr(SettingKey::MAIL); ?>"
            name="<?php echo esc_attr(SettingKey::MAIL); ?>"
            type="text"
            value="<?php echo esc_attr(tdf_settings()->getMail()); ?>"
    >
</div>

<div class="tdf-field">
    <label for="<?php echo esc_attr(SettingKey::PHONE); ?>">
        <i class="fas fa-phone-square-alt"></i> <?php esc_html_e('Public Phone', 'listivo-core'); ?>
    </label>

    <input
            id="<?php echo esc_attr(SettingKey::PHONE); ?>"
            name="<?php echo esc_attr(SettingKey::PHONE); ?>"
            type="text"
            value="<?php echo esc_attr(tdf_settings()->getPhone()); ?>"
    >
</div>

<div class="tdf-field">
    <label for="<?php echo esc_attr(SettingKey::ADDRESS); ?>">
        <i class="fas fa-map-marker-alt"></i> <?php esc_html_e('Public Address', 'listivo-core'); ?>
    </label>

    <textarea
            id="<?php echo esc_attr(SettingKey::ADDRESS); ?>"
            name="<?php echo esc_attr(SettingKey::ADDRESS); ?>"
            class="tdf-textarea-small"
    ><?php echo esc_html(tdf_settings()->getAddress()); ?></textarea>
</div>
