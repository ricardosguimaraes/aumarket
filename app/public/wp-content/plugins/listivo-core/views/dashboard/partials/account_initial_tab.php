<?php use Tangibledesign\Framework\Core\Settings\SettingKey; ?>
<div class="tdf-field">
    <label for="<?php echo esc_attr(SettingKey::ACCOUNT_INITIAL_TAB); ?>">
        <?php esc_html_e('Login / Register - Initial Tab', 'listivo-core'); ?>
    </label>

    <select
            name="<?php echo esc_attr(SettingKey::ACCOUNT_INITIAL_TAB); ?>"
            id="<?php echo esc_attr(SettingKey::ACCOUNT_INITIAL_TAB); ?>"
            class="tdf-selectize tdf-selectize-init"
    >
        <option
                value="<?php echo esc_attr(SettingKey::ACCOUNT_TAB_LOGIN); ?>"
            <?php if (tdf_settings()->getInitialTab() === SettingKey::ACCOUNT_TAB_LOGIN) : ?>
                selected
            <?php endif; ?>
        >
            <?php echo esc_html__('Login', 'listivo-core'); ?>
        </option>

        <option
                value="<?php echo esc_attr(SettingKey::ACCOUNT_TAB_REGISTER); ?>"
            <?php if (tdf_settings()->getInitialTab() === SettingKey::ACCOUNT_TAB_REGISTER) : ?>
                selected
            <?php endif; ?>
        >
            <?php echo esc_html__('Register', 'listivo-core'); ?>
        </option>
    </select>
</div>
