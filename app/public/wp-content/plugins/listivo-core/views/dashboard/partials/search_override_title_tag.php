<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<div class="tdf-checkbox">
    <input
            name="<?php echo esc_attr(SettingKey::SEARCH_OVERRIDE_TITLE_TAG); ?>"
            id="<?php echo esc_attr(SettingKey::SEARCH_OVERRIDE_TITLE_TAG); ?>"
            type="checkbox"
            value="1"
        <?php if (tdf_settings()->searchOverrideTitleTag()) : ?>
            checked
        <?php endif; ?>
    >

    <label for="<?php echo esc_attr(SettingKey::SEARCH_OVERRIDE_TITLE_TAG); ?>">
        <?php esc_html_e('Override search title tag', 'listivo-core'); ?>
    </label>
</div>