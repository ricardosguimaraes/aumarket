<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<div class="tdf-checkbox">
    <input
            name="<?php echo esc_attr(SettingKey::DISABLE_DEMO_IMPORTER); ?>"
            id="<?php echo esc_attr(SettingKey::DISABLE_DEMO_IMPORTER); ?>"
            type="checkbox"
            value="1"
        <?php if (!tdf_settings()->showDemoImporter()) : ?>
            checked
        <?php endif; ?>
    >

    <label for="<?php echo esc_attr(SettingKey::DISABLE_DEMO_IMPORTER); ?>">
        <?php esc_html_e('Disable Demo Importer', 'listivo-core'); ?>
    </label>
</div>