<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<h3 class="tdf-margin-top-big"><?php esc_html_e('Search Results Page H1 Title (next to XX Results)', 'listivo-core'); ?></h3>
<div class="tdf-field">
    <label for="<?php echo esc_attr(SettingKey::SEARCH_DEFAULT_TITLE); ?>">
        <?php esc_html_e('Default text', 'listivo-core'); ?>
    </label>

    <input
            name="<?php echo esc_attr(SettingKey::SEARCH_DEFAULT_TITLE); ?>"
            id="<?php echo esc_attr(SettingKey::SEARCH_DEFAULT_TITLE); ?>"
            type="text"
            value="<?php echo esc_attr(tdf_settings()->getSearchDefaultTitle()); ?>"
    >
</div>
