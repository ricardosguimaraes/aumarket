<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::DECIMAL_SEPARATOR); ?>">
                <?php esc_html_e('Decimal Separator', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::DECIMAL_SEPARATOR); ?>"
                    name="<?php echo esc_attr(SettingKey::DECIMAL_SEPARATOR); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_html(tdf_settings()->getDecimalSeparator()); ?>"
            >
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::THOUSANDS_SEPARATOR); ?>">
                <?php esc_html_e('Thousands Separator', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::THOUSANDS_SEPARATOR); ?>"
                    name="<?php echo esc_attr(SettingKey::THOUSANDS_SEPARATOR); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_html(tdf_settings()->getThousandsSeparator()); ?>"
            >
        </td>
    </tr>
    </tbody>
</table>

<p class="submit">
    <button class="button button-primary">
        <?php esc_html_e('Save Changes', 'listivo-core'); ?>
    </button>
</p>