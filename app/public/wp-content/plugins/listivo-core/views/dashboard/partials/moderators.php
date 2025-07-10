<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<div class="tdf-field">
    <label for="<?php echo esc_attr(SettingKey::MODERATORS); ?>">
        <i class="fas fa-folder-open"></i> <?php esc_html_e('Who has access to Moderation Page', 'listivo-core'); ?>
    </label>

    <select
            id="<?php echo esc_attr(SettingKey::MODERATORS); ?>"
            name="<?php echo esc_attr(SettingKey::MODERATORS); ?>[]"
            class="tdf-selectize tdf-selectize-init"
            placeholder="<?php esc_attr_e('Only Administrators', 'listivo-core'); ?>"
            multiple
    >
        <?php foreach (tdf_query_users()->roleNotIn('administrator')->get() as $lstUser) : ?>
            <option
                    value="<?php echo esc_attr($lstUser->getId()); ?>"
                <?php if (in_array($lstUser->getId(), tdf_settings()->getModeratorIds(), true)): ?>
                    selected
                <?php endif; ?>
            >
                <?php echo esc_html($lstUser->getDisplayName()); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
