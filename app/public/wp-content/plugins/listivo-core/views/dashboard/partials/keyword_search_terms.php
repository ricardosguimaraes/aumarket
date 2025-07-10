<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<div class="tdf-checkbox">
    <input
            name="<?php echo esc_attr(SettingKey::KEYWORD_SEARCH_TERMS); ?>"
            id="<?php echo esc_attr(SettingKey::KEYWORD_SEARCH_TERMS); ?>"
            type="checkbox"
            value="1"
        <?php if (tdf_settings()->isKeywordSearchTermsEnabled()) : ?>
            checked
        <?php endif; ?>
    >

    <label for="<?php echo esc_attr(SettingKey::KEYWORD_SEARCH_TERMS); ?>">
        <?php esc_html_e('Searching by keyword includes terms', 'listivo-core'); ?>
    </label>
</div>