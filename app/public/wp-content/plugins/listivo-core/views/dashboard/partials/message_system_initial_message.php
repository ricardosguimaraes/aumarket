<?php use Tangibledesign\Framework\Core\Settings\SettingKey; ?>
<div class="tdf-field">
    <label for="<?php echo esc_attr(SettingKey::MESSAGE_SYSTEM_INITIAL_MESSAGE); ?>">
        <i class="far fa-paper-plane"></i><?php esc_html_e('Private Message System - Custom Initial Message', 'listivo-core'); ?>
    </label>

    <div>
        <?php esc_html_e('Available variables: {listingName}, {listingPrice}, {listingAddress}, {listingId}, {listingUrl}', 'listivo-core'); ?>
    </div>

    <textarea
            id="<?php echo esc_attr(SettingKey::MESSAGE_SYSTEM_INITIAL_MESSAGE); ?>"
            name="<?php echo esc_attr(SettingKey::MESSAGE_SYSTEM_INITIAL_MESSAGE); ?>"
    ><?php echo wp_kses_post(tdf_settings()->getMessageSystemInitialMessageOption()); ?></textarea>
</div>
