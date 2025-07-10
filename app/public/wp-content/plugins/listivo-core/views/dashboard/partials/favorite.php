<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<div class="tdf-checkbox">
    <input
            name="<?php echo esc_attr(SettingKey::FAVORITE); ?>"
            id="<?php echo esc_attr(SettingKey::FAVORITE); ?>"
            type="checkbox"
            value="1"
        <?php if (tdf_settings()->isFavoriteEnabled()) : ?>
            checked
        <?php endif; ?>
    >
    <label for="<?php echo esc_attr(SettingKey::FAVORITE); ?>">
        <?php esc_html_e('Add to favorites', 'listivo-core'); ?>
    </label>
</div>