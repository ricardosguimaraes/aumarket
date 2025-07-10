<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<div class="tdf-checkbox">
    <input
            name="<?php echo esc_attr(SettingKey::MODERATION); ?>"
            id="<?php echo esc_attr(SettingKey::MODERATION); ?>"
            type="checkbox"
            value="1"
        <?php if (tdf_settings()->moderationEnabled()) : ?>
            checked
        <?php endif; ?>
    >

    <label for="<?php echo esc_attr(SettingKey::MODERATION); ?>">
        <?php esc_html_e('Moderation - admin needs to approve listings', 'listivo-core'); ?>
    </label>
</div>

<div class="tdf-checkbox">
    <input
            name="<?php echo esc_attr(SettingKey::MODERATION_RE_APPROVE); ?>"
            id="<?php echo esc_attr(SettingKey::MODERATION_RE_APPROVE); ?>"
            type="checkbox"
            value="1"
        <?php if (tdf_settings()->moderationRequiredReApprove()) : ?>
            checked
        <?php endif; ?>
    >

    <label for="<?php echo esc_attr(SettingKey::MODERATION_RE_APPROVE); ?>">
        <?php esc_html_e('Updating the listing requires re-approval', 'listivo-core'); ?>
    </label>
</div>