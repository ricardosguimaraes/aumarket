<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<div class="tdf-checkbox">
    <input
            name="<?php echo esc_attr(SettingKey::DELETE_MODEL_IMAGES_ON_DELETE); ?>"
            id="<?php echo esc_attr(SettingKey::DELETE_MODEL_IMAGES_ON_DELETE); ?>"
            type="checkbox"
            value="1"
        <?php if (tdf_settings()->deleteModelImagesOnDelete()) : ?>
            checked
        <?php endif; ?>
    >

    <label for="<?php echo esc_attr(SettingKey::DELETE_MODEL_IMAGES_ON_DELETE); ?>">
        <?php esc_html_e('Remove listing images when listing is deleted', 'listivo-core'); ?>
    </label>
</div>