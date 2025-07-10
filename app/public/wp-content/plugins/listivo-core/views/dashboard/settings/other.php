<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::DISABLE_DEMO_IMPORTER); ?>">
                <?php esc_html_e('Disable Demo Importer', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::DISABLE_DEMO_IMPORTER); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::DISABLE_DEMO_IMPORTER); ?>"
                        id="<?php echo esc_attr(SettingKey::DISABLE_DEMO_IMPORTER); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (!tdf_settings()->showDemoImporter()) : ?>
                        checked
                    <?php endif; ?>
                >

                <?php esc_html_e('Remove demo importer from the menu.', 'listivo-core'); ?>
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::DELETE_MODEL_IMAGES_ON_DELETE); ?>">
                <?php esc_html_e('Automatically Delete Images', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::DELETE_MODEL_IMAGES_ON_DELETE); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::DELETE_MODEL_IMAGES_ON_DELETE); ?>"
                        id="<?php echo esc_attr(SettingKey::DELETE_MODEL_IMAGES_ON_DELETE); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->deleteModelImagesOnDelete()) : ?>
                        checked
                    <?php endif; ?>
                >

                <?php esc_html_e('When an ad is deleted, delete the photos associated with it.', 'listivo-core'); ?>
            </label>
        </td>
    </tr>
    </tbody>
</table>

<p class="submit">
    <button class="button button-primary">
        <?php esc_html_e('Save Changes', 'listivo-core'); ?>
    </button>
</p>