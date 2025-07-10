<?php

use Tangibledesign\Framework\Models\Field\Fieldable;
use Tangibledesign\Framework\Models\Field\LinkField;

/* @var LinkField $lstField */
/* @var Fieldable $lstModel */
?>
<lst-link-field
        :field-id="<?php echo esc_attr($lstField->getId()); ?>"
        :field="<?php echo htmlspecialchars(json_encode($lstField)); ?>"
        :taxonomy-fields-values="props.taxonomyFieldsValues"
        :validation="props.validation"
        :is-required="<?php echo esc_attr($lstField->isRequired() ? 'true' : 'false'); ?>"
        initial-value="<?php echo esc_attr($lstField->getValue($lstModel)); ?>"
        :dependency-terms="props.dependencyTerms"
>
    <div
            slot-scope="fieldProps"
            v-if="fieldProps.isVisible"
            class="tdfm-field-group"
            :class="fieldProps.classes"
            data-name="<?php echo esc_attr($lstField->getName()); ?>"
    >
        <label
                class="tdfm-field-group__label"
                for="<?php echo esc_attr($lstField->getKey()); ?>"
        >
            <?php echo esc_html($lstField->getName()); ?>

            <?php if ($lstField->isRequired()): ?>
                <span class="tdfm-field-group__required">*</span>
            <?php endif; ?>
        </label>

        <div class="tdfm-field-group__field">
            <div class="tdfm-input">
                <input
                        id="<?php echo esc_attr($lstField->getKey()); ?>"
                        name="<?php echo esc_attr($lstField->getKey()); ?>"
                        :value="fieldProps.value"
                        @input="fieldProps.setValue($event.target.value)"
                        type="text"
                        @keypress.enter.prevent
                    <?php if ($lstField->hasInputPlaceholder()) : ?>
                        placeholder="<?php echo esc_attr($lstField->getInputPlaceholder()); ?>"
                    <?php else : ?>
                        placeholder="<?php echo esc_attr($lstField->getName()); ?>"
                    <?php endif; ?>
                >
            </div>
        </div>
    </div>
</lst-link-field>