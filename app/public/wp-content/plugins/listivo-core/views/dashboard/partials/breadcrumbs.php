<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;
use Tangibledesign\Framework\Models\Field\TaxonomyField;

?>
<div class="tdf-field tdf-field--breadcrumbs">
    <label for="<?php echo esc_attr(SettingKey::BREADCRUMBS); ?>">
        <i class="fas fa-link"></i> <?php esc_html_e('Breadcrumbs', 'listivo-core'); ?>
    </label>

    <select
            id="<?php echo esc_attr(SettingKey::BREADCRUMBS); ?>"
            name="<?php echo esc_attr(SettingKey::BREADCRUMBS); ?>[]"
            class="tdf-selectize tdf-selectize-init"
            multiple
    >
        <?php foreach (tdf_settings()->getBreadcrumbs() as $tdfTaxonomyKey) :
            $tdfTaxonomyField = tdf_taxonomy_fields()->find(static function ($taxonomy) use ($tdfTaxonomyKey) {
                /* @var TaxonomyField $taxonomy */
                return $taxonomy->getKey() === $tdfTaxonomyKey;
            });

            if (!$tdfTaxonomyField instanceof TaxonomyField) {
                continue;
            }
            ?>
            <option value="<?php echo esc_attr($tdfTaxonomyField->getKey()); ?>" selected>
                <?php echo esc_html($tdfTaxonomyField->getName()); ?> <i class="fas fa-arrow-right"></i>
            </option>
        <?php endforeach; ?>

        <?php foreach (tdf_taxonomy_fields() as $tdfTaxonomyField) :
            if (in_array($tdfTaxonomyField->getKey(), tdf_settings()->getBreadcrumbs(), true)) {
                continue;
            }
            ?>
            <option value="<?php echo esc_attr($tdfTaxonomyField->getKey()); ?>">
                <?php echo esc_html($tdfTaxonomyField->getName()); ?> <i class="fas fa-arrow-right"></i>
            </option>
        <?php endforeach; ?>
    </select>
</div>