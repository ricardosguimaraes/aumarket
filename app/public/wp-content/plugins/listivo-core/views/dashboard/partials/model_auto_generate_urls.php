<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;
use Tangibledesign\Framework\Models\Field\Helpers\SimpleTextValue;

?>
<div class="tdf-field">
    <label for="<?php echo esc_attr(SettingKey::AUTO_GENERATE_MODEL_TITLE); ?>">
        <i class="fas fa-folder-open"></i> <?php esc_html_e('Auto-Generate Listing Title', 'listivo-core'); ?>
    </label>

    <select
            id="<?php echo esc_attr(SettingKey::AUTO_GENERATE_MODEL_TITLE); ?>"
            name="<?php echo esc_attr(SettingKey::AUTO_GENERATE_MODEL_TITLE); ?>[]"
            class="tdf-selectize tdf-selectize-init"
            placeholder="<?php esc_attr_e('Do not auto generate - user enter title manually', 'listivo-core'); ?>"
            multiple
    >
        <?php foreach (tdf_settings()->getAutoGenerateModelTitleFields() as $lstField) : /* @var SimpleTextValue $lstField */ ?>
            <option
                    value="<?php echo esc_attr($lstField->getId()); ?>"
                    selected
            >
                <?php echo esc_html($lstField->getName()); ?>
            </option>
        <?php endforeach; ?>

        <?php foreach (tdf_settings()->getNotAutoGenerateModelTitleFields() as $lstField) : /* @var SimpleTextValue $lstField */ ?>
            <option value="<?php echo esc_attr($lstField->getId()); ?>">
                <?php echo esc_html($lstField->getName()); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>