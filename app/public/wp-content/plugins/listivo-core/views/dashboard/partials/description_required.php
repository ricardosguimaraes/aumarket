<?php use Tangibledesign\Framework\Core\Settings\SettingKey; ?>
<div class="tdf-checkbox">
    <input
            name="<?php echo esc_attr(SettingKey::DESCRIPTION_REQUIRED); ?>"
            id="<?php echo esc_attr(SettingKey::DESCRIPTION_REQUIRED); ?>"
            type="checkbox"
            value="1"
        <?php if (tdf_settings()->descriptionRequired()) : ?>
            checked
        <?php endif; ?>
    >

    <label for="<?php echo esc_attr(SettingKey::DESCRIPTION_REQUIRED); ?>">
        <?php esc_html_e('Listing description required', 'listivo-core'); ?>
    </label>
</div>
