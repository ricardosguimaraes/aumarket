<?php

use Tangibledesign\Framework\Models\Field\Fieldable;
use Tangibledesign\Framework\Models\Field\PriceField;

/* @var PriceField $lstField */
/* @var Fieldable $lstModel */

foreach (tdf_currencies() as $currency) : ?>
    <lst-price-field
            :field-id="<?php echo esc_attr($lstField->getId()); ?>"
            field-key="<?php echo esc_attr($lstField->getValueKey($currency)); ?>"
            :field="<?php echo htmlspecialchars(json_encode($lstField)); ?>"
            :taxonomy-fields-values="props.taxonomyFieldsValues"
            :validation="props.validation"
            :is-required="<?php echo esc_attr($lstField->isRequired() ? 'true' : 'false'); ?>"
            initial-value="<?php echo esc_attr($lstField->getRawValueByCurrency($lstModel, $currency)); ?>"
            :decimal-places="<?php echo esc_attr($currency->getDecimalPlaces()); ?>"
            decimal-separator="<?php echo esc_attr($currency->getDecimalSeparator()); ?>"
            thousands-separator="<?php echo esc_attr($currency->getThousandsSeparator()); ?>"
            currency-sign="<?php echo esc_attr($currency->getSign()); ?>"
            currency-sign-position="<?php echo esc_attr($currency->getSignPosition() === 'before' ? 'p' : 's'); ?>"
            :dependency-terms="props.dependencyTerms"
    >
        <div
                slot-scope="fieldProps"
                v-if="fieldProps.isVisible"
                class="tdfm-field-group"
                :class="fieldProps.classes"
                data-name="<?php echo esc_attr($lstField->getName() . ' (' . $currency->getSign() . ')'); ?>"
        >
            <label
                    class="tdfm-field-group__label"
                    for="<?php echo esc_attr($lstField->getValueKey($currency)); ?>"
            >
                <?php echo esc_html($lstField->getName()); ?>

                <?php if ($lstField->isRequired()): ?>
                    <span class="tdfm-field-group__required">*</span>
                <?php endif; ?>
            </label>

            <div class="tdfm-field-group__field">
                <div class="tdfm-input">
                    <input
                            id="<?php echo esc_attr($lstField->getValueKey($currency)); ?>"
                            name="<?php echo esc_attr($lstField->getKey()); ?>[<?php echo esc_attr($lstField->getValueKey($currency)); ?>]"
                            :value="fieldProps.value"
                            @input="fieldProps.setValue($event.target.value)"
                            type="text"
                            @keypress.enter.prevent
                        <?php if ($lstField->hasInputPlaceholder()) : ?>
                            placeholder="<?php echo esc_attr($lstField->getInputPlaceholder()); ?> (<?php echo esc_attr($currency->getSign()); ?>)"
                        <?php else : ?>
                            placeholder="<?php echo esc_attr($lstField->getName()); ?> (<?php echo esc_attr($currency->getSign()); ?>)"
                        <?php endif; ?>
                    >
                </div>
            </div>
        </div>
    </lst-price-field>
<?php
endforeach;