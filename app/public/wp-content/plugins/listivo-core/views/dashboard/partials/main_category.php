<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;
use Tangibledesign\Framework\Models\Field\TaxonomyField;

$lstMainCategoryId = tdf_settings()->getMainCategoryId();
?>
<div class="tdf-field">
    <label for="<?php echo esc_attr(SettingKey::MAIN_CATEGORY); ?>">
        <i class="fas fa-folder-open"></i> <?php esc_html_e('Main Category', 'listivo-core'); ?>
    </label>

    <select
            id="<?php echo esc_attr(SettingKey::MAIN_CATEGORY); ?>"
            name="<?php echo esc_attr(SettingKey::MAIN_CATEGORY); ?>"
            class="tdf-selectize tdf-selectize-init"
    >
        <option value="0"><?php esc_html_e('Not Set', 'listivo-core'); ?></option>

        <?php foreach (tdf_taxonomy_fields() as $lstTaxonomy) : /* @var TaxonomyField $lstTaxonomy */ ?>
            <option
                    value="<?php echo esc_attr($lstTaxonomy->getId()); ?>"
                <?php if ($lstMainCategoryId === $lstTaxonomy->getId()) : ?>
                    selected
                <?php endif; ?>
            >
                <?php echo esc_html($lstTaxonomy->getName()); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
