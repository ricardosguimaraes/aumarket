<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<div class="tdf-doc">
    <div class="tdf-doc__icon">
        <i class="fas fa-info"></i>
    </div>
    <div class="tdf-doc__text">
        <a target="_blank" href="https://support.listivotheme.com/support/solutions/articles/101000373800">
            <?php esc_html_e('Click here if you are not receiving emails or emails goes to spam.', 'listivo-core'); ?>
        </a>
    </div>
</div>

<div class="tdf-content-section">
    <div class="tdf-content-section__left">
        <h2><?php esc_html_e('General', 'listivo-core'); ?></h2>
    </div>

    <div class="tdf-content-section__right">
        <div class="tdf-checkbox">
            <input
                    name="<?php echo esc_attr(SettingKey::USER_EMAIL_CONFIRMATION); ?>"
                    id="<?php echo esc_attr(SettingKey::USER_EMAIL_CONFIRMATION); ?>"
                    type="checkbox"
                    value="1"
                <?php if (tdf_settings()->isUserEmailConfirmationEnabled()) : ?>
                    checked
                <?php endif; ?>
            >

            <label for="<?php echo esc_attr(SettingKey::USER_EMAIL_CONFIRMATION); ?>">
                <?php esc_html_e('Require new users to verify account via email', 'listivo-core'); ?>
            </label>
        </div>

        <div class="tdf-field">
            <label for="<?php echo esc_attr(SettingKey::SENDER_NAME); ?>">
                <i class="fas fa-signature"></i> <?php esc_html_e('Sender Name', 'listivo-core'); ?>
            </label>

            <input
                    name="<?php echo esc_attr(SettingKey::SENDER_NAME); ?>"
                    id="<?php echo esc_attr(SettingKey::SENDER_NAME); ?>"
                    type="text"
                    placeholder="Type name here"
                    value="<?php echo esc_attr(tdf_settings()->getSenderName()); ?>"
            >
        </div>

        <div class="tdf-field">
            <label for="<?php echo esc_attr(SettingKey::SENDER_EMAIL); ?>">
                <i class="far fa-envelope"></i> <?php esc_html_e('Sender Email', 'listivo-core'); ?>
            </label>

            <input
                    name="<?php echo esc_attr(SettingKey::SENDER_EMAIL); ?>"
                    id="<?php echo esc_attr(SettingKey::SENDER_EMAIL); ?>"
                    type="text"
                    placeholder="name@domain.com"
                    value="<?php echo esc_attr(tdf_settings()->getSenderEmail()); ?>"
            >
        </div>

        <?php tdf_load_view('dashboard/partials/save_changes_button'); ?>
    </div>
</div>