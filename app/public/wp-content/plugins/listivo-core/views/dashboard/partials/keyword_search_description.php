<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<div class="tdf-checkbox">
    <input
            name="<?php echo esc_attr(SettingKey::KEYWORD_SEARCH_DESCRIPTION); ?>"
            id="<?php echo esc_attr(SettingKey::KEYWORD_SEARCH_DESCRIPTION); ?>"
            type="checkbox"
            value="1"
        <?php if (tdf_settings()->keywordSearchDescription()) : ?>
            checked
        <?php endif; ?>
    >

    <label for="<?php echo esc_attr(SettingKey::KEYWORD_SEARCH_DESCRIPTION); ?>">
        <?php esc_html_e('Searching by keyword results includes listing descriptions', 'listivo-core'); ?>
    </label>
</div>