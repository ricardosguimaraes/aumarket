<?php use Tangibledesign\Framework\Core\Settings\SettingKey; ?>
<div class="tdf-checkbox">
    <input
            name="<?php echo esc_attr(SettingKey::COMPARE_MODELS); ?>"
            id="<?php echo esc_attr(SettingKey::COMPARE_MODELS); ?>"
            type="checkbox"
            value="1"
        <?php if (tdf_settings()->isCompareModelsEnabled()) : ?>
            checked
        <?php endif; ?>
    >

    <label for="<?php echo esc_attr(SettingKey::COMPARE_MODELS); ?>">
        <?php esc_html_e('Compare Listings Feature', 'listivo-core'); ?>
    </label>
</div>