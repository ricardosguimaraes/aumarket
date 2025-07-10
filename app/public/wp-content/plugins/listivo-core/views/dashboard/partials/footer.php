<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;
use Tangibledesign\Framework\Models\Menu;

?>
<div class="tdf-field">
        <label for="<?php echo esc_attr(SettingKey::COPYRIGHTS_TEXT); ?>">
            <i class="fas fa-copyright"></i> <?php esc_html_e('Copyright Notice', 'listivo-core'); ?>
        </label>
        <input
                name="<?php echo esc_attr(SettingKey::COPYRIGHTS_TEXT); ?>"
                id="<?php echo esc_attr(SettingKey::COPYRIGHTS_TEXT); ?>"
                type="text"
                value="<?php echo esc_attr(tdf_settings()->getCopyrightsText()); ?>"
        >
</div>