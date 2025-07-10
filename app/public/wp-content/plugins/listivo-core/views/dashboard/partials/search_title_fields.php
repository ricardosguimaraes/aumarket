<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<div class="tdf-field">
    <label for="<?php echo esc_attr(SettingKey::SEARCH_TITLE_FIELDS); ?>">
        <?php esc_html_e('Category Fields', 'listivo-core'); ?>
    </label>

    <select
            id="<?php echo esc_attr(SettingKey::SEARCH_TITLE_FIELDS); ?>"
            name="<?php echo esc_attr(SettingKey::SEARCH_TITLE_FIELDS); ?>[]"
            class="tdf-selectize tdf-selectize-init"
            placeholder="<?php esc_attr_e('Search Title Fields', 'listivo-core'); ?>"
            multiple
    >
        <?php foreach (tdf_settings()->getSearchTitleFields() as $taxonomyField) : ?>
            <option
                    value="<?php echo esc_attr($taxonomyField->getId()); ?>"
                    selected
            >
                <?php echo esc_html($taxonomyField->getName()); ?>
            </option>
        <?php endforeach; ?>

        <?php foreach (tdf_taxonomy_fields() as $taxonomyField) :
            if (in_array($taxonomyField->getId(), tdf_settings()->getSearchTitleFieldIds(), true)) {
                continue;
            }
            ?>
            <option value="<?php echo esc_attr($taxonomyField->getId()); ?>">
                <?php echo esc_html($taxonomyField->getName()); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <div><?php esc_html_e('Example: Select "Category" to display there "Vehicles" or "Cars" when user selects it.', 'listivo-core'); ?></div>
</div>

<div class="tdf-field">
    <label for="<?php echo esc_attr(SettingKey::SECOND_SEARCH_TITLE_FIELDS); ?>">
        <?php esc_html_e('Priority Category', 'listivo-core'); ?>
    </label>

    <select
            id="<?php echo esc_attr(SettingKey::SECOND_SEARCH_TITLE_FIELDS); ?>"
            name="<?php echo esc_attr(SettingKey::SECOND_SEARCH_TITLE_FIELDS); ?>[]"
            class="tdf-selectize tdf-selectize-init"
            placeholder="<?php esc_attr_e('Search Title Fields', 'listivo-core'); ?>"
            multiple
    >
        <?php foreach (tdf_settings()->getSearchTitleFields2() as $taxonomyField) : ?>
            <option
                    value="<?php echo esc_attr($taxonomyField->getId()); ?>"
                    selected
            >
                <?php echo esc_html($taxonomyField->getName()); ?>
            </option>
        <?php endforeach; ?>

        <?php foreach (tdf_taxonomy_fields() as $taxonomyField) :
            if (in_array($taxonomyField->getId(), tdf_settings()->getSearchTitleFieldIds2(), true)) {
                continue;
            }
            ?>
            <option value="<?php echo esc_attr($taxonomyField->getId()); ?>">
                <?php echo esc_html($taxonomyField->getName()); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <div><?php esc_html_e('Example: Select "Make" + "Model" displays "Audi S8" text instead of "Vehicles" or "Cars"', 'listivo-core'); ?></div>
</div>

