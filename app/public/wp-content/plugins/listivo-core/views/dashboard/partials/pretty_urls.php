<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<div class="tdf-checkbox">
    <input
            name="<?php echo esc_attr(SettingKey::PRETTY_URLS); ?>"
            id="<?php echo esc_attr(SettingKey::PRETTY_URLS); ?>"
            type="checkbox"
            value="1"
        <?php if (tdf_settings()->prettyUrls()) : ?>
            checked
        <?php endif; ?>
    >

    <label for="<?php echo esc_attr(SettingKey::PRETTY_URLS); ?>">
        <?php esc_html_e('Generate pretty urls based on breadcrumbs settings. Slugs for search results and specific ad must be different.', 'listivo-core'); ?>
    </label>
</div>