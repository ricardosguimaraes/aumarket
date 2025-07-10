<?php use Tangibledesign\Framework\Core\Settings\SettingKey; ?>
<div class="tdf-checkbox">
    <input
            name="<?php echo esc_attr(SettingKey::DESCRIPTION_SIMPLE_EDITOR); ?>"
            id="<?php echo esc_attr(SettingKey::DESCRIPTION_SIMPLE_EDITOR); ?>"
            type="checkbox"
            value="1"
        <?php if (tdf_settings()->isDescriptionSimpleEditorEnabled()) : ?>
            checked
        <?php endif; ?>
    >

    <label for="<?php echo esc_attr(SettingKey::DESCRIPTION_SIMPLE_EDITOR); ?>">
        <?php esc_html_e('Disable Description Style Bar', 'listivo-core'); ?>
    </label>
</div>
