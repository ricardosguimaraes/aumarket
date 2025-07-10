<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>

<div class="tdf-field">
    <label for="<?php echo esc_attr(SettingKey::POLICY_LABEL); ?>">
        <i class="fas fa-gavel"></i> <?php esc_html_e('Policy Label', 'listivo-core'); ?>
    </label>

    <textarea
            class="tdf-textarea-small"
            id="<?php echo esc_attr(SettingKey::POLICY_LABEL); ?>"
            name="<?php echo esc_attr(SettingKey::POLICY_LABEL); ?>"
    ><?php echo wp_kses_post(tdf_settings()->getPolicyLabel()); ?></textarea>
</div>