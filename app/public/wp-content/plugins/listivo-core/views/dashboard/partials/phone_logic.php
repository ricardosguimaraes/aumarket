<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<div class="tdf-field">
    <label for="<?php echo esc_attr(SettingKey::PHONE_LOGIC); ?>">
        <i class="fas fa-mobile-alt"></i> <?php esc_html_e('User Phone Number', 'listivo-core'); ?>
    </label>

    <select
            id="<?php echo esc_attr(SettingKey::PHONE_LOGIC); ?>"
            name="<?php echo esc_attr(SettingKey::PHONE_LOGIC); ?>"
            class="tdf-selectize tdf-selectize-init"
    >
        <option
                value="optional_show"
            <?php if (tdf_settings()->isPhoneLogic('optional_show')) : ?>
                selected
            <?php endif; ?>
        >
            <?php esc_html_e('Optional + show on the register form', 'listivo-core'); ?>
        </option>

        <option
                value="optional_hide"
            <?php if (tdf_settings()->isPhoneLogic('optional_hide')) : ?>
                selected
            <?php endif; ?>
        >
            <?php esc_html_e('Optional + hide on the register form', 'listivo-core'); ?>
        </option>

        <option
                value="required"
            <?php if (tdf_settings()->isPhoneLogic('required')) : ?>
                selected
            <?php endif; ?>
        >
            <?php esc_html_e('Required', 'listivo-core'); ?>
        </option>

        <option
                value="disable"
            <?php if (tdf_settings()->isPhoneLogic('disable')) : ?>
                selected
            <?php endif; ?>
        >
            <?php esc_html_e('Disable', 'listivo-core'); ?>
        </option>
    </select>
</div>
