<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<div id="tdf-number" class="tdf-content-section">
    <div class="tdf-content-section__left">
        <h2><?php esc_html_e('Number Format', 'listivo-core'); ?></h2>
    </div>

    <div class="tdf-content-section__right">
        <div class="tdf-field">
            <label for="<?php echo esc_attr(SettingKey::DECIMAL_SEPARATOR); ?>">
                <?php esc_html_e('Decimal Separator', 'listivo-core'); ?>
            </label>

            <input
                    name="<?php echo esc_attr(SettingKey::DECIMAL_SEPARATOR); ?>"
                    id="<?php echo esc_attr(SettingKey::DECIMAL_SEPARATOR); ?>"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getDecimalSeparator()); ?>"
            >
        </div>

        <div class="tdf-field">
            <label for="<?php echo esc_attr(SettingKey::THOUSANDS_SEPARATOR); ?>">
                <?php esc_html_e('Thousands Separator', 'listivo-core'); ?>
            </label>

            <input
                    name="<?php echo esc_attr(SettingKey::THOUSANDS_SEPARATOR); ?>"
                    id="<?php echo esc_attr(SettingKey::THOUSANDS_SEPARATOR); ?>"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getThousandsSeparator()); ?>"
            >
        </div>

        <?php tdf_load_view('dashboard/partials/save_changes_button'); ?>
    </div>
</div>