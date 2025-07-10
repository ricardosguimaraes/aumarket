<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;
use Tangibledesign\Framework\Models\Page;

?>
<p class="submit">
    <button class="button button-primary">
        <?php esc_html_e('Save Changes', 'listivo-core'); ?>
    </button>
</p>

<table class="form-table">
    <tbody>
    <?php foreach (tdf_app('slugs') as $lstSlug) : ?>
        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr($lstSlug['key']); ?>">
                    <?php echo esc_html($lstSlug['name']); ?>
                </label>
            </th>

            <td>
                <input
                        id="<?php echo esc_attr($lstSlug['key']); ?>"
                        name="slugs[<?php echo esc_attr($lstSlug['key']); ?>]"
                        class="regular-text"
                        type="text"
                        placeholder="<?php esc_attr_e('Translate / rename here', 'listivo-core'); ?>"
                        value="<?php echo esc_attr($lstSlug['value']); ?>"
                >
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<p class="submit">
    <button class="button button-primary">
        <?php esc_html_e('Save Changes', 'listivo-core'); ?>
    </button>
</p>