<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<div class="tdf-checkbox">
    <input
            name="<?php echo esc_attr(SettingKey::ACCOUNT_TYPE); ?>"
            id="<?php echo esc_attr(SettingKey::ACCOUNT_TYPE); ?>"
            type="checkbox"
            value="1"
        <?php if (tdf_settings()->isAccountTypeEnabled()) : ?>
            checked
        <?php endif; ?>
    >

    <label for="<?php echo esc_attr(SettingKey::ACCOUNT_TYPE); ?>">
        <?php esc_html_e('2 account types (Private/Business)', 'listivo-core'); ?>
    </label>
</div>
