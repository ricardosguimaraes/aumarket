<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Term\CustomTerm;

?>
<div class="tdf-field">
    <label for="<?php echo esc_attr(SettingKey::EXCLUDE_FROM_SEARCH); ?>">
        <i class="far fa-minus-square"></i> <?php esc_html_e('Exclude From Search Results', 'listivo-core'); ?>
    </label>

    <select
            id="<?php echo esc_attr(SettingKey::EXCLUDE_FROM_SEARCH); ?>"
            name="<?php echo esc_attr(SettingKey::EXCLUDE_FROM_SEARCH); ?>[]"
            class="tdf-selectize tdf-selectize-init"
            multiple
    >
        <?php foreach (TaxonomyField::getAllTermList() as $tdfTerm) : /* @var CustomTerm $tdfTerm */ ?>
            <option
                    value="<?php echo esc_attr($tdfTerm->getId()); ?>"
                <?php if (in_array($tdfTerm->getId(), tdf_settings()->getExcludedFromSearchTermIds(), true)) : ?>
                    selected
                <?php endif; ?>
            >
                <?php echo esc_html($tdfTerm->getName()); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>