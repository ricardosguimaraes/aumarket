<?php use Tangibledesign\Framework\Core\Settings\SettingKey; ?>
<div class="tdf-checkbox">
    <input
            name="<?php echo esc_attr(SettingKey::QUICK_VIEW); ?>"
            id="<?php echo esc_attr(SettingKey::QUICK_VIEW); ?>"
            type="checkbox"
            value="1"
        <?php if (tdf_settings()->isQuickViewEnabled()) : ?>
            checked
        <?php endif; ?>
    >

    <label for="<?php echo esc_attr(SettingKey::QUICK_VIEW); ?>">
        <?php esc_html_e('Quick View (for small card)', 'listivo-core'); ?>
    </label>
</div>