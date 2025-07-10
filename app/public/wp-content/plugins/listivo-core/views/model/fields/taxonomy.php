<?php

use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Field\Fieldable;

/* @var TaxonomyField $lstField */
/* @var Fieldable $lstModel */

$lstParentTaxonomyFieldKeys = $lstField->getParentTaxonomyFields()->map(static function ($parentTaxonomyField) {
    /* @var TaxonomyField $parentTaxonomyField */
    return $parentTaxonomyField->getKey();
});
?>
<lst-taxonomy-field
        :field-id="<?php echo esc_attr($lstField->getId()); ?>"
        field-key="<?php echo esc_attr($lstField->getKey()); ?>"
        :field="<?php echo htmlspecialchars(json_encode($lstField)); ?>"
        :parent-taxonomy-keys="<?php echo htmlspecialchars(json_encode($lstParentTaxonomyFieldKeys)); ?>"
        :validation="props.validation"
        :is-required="<?php echo esc_attr($lstField->isRequired() ? 'true' : 'false'); ?>"
    <?php if ($lstParentTaxonomyFieldKeys->isEmpty()) : ?>
        :terms="<?php echo htmlspecialchars(json_encode($lstField->getTerms())); ?>"
    <?php endif; ?>
        :multiple="<?php echo esc_attr($lstField->multipleValues() ? 'true' : 'false'); ?>"
        :initial-value="<?php echo htmlspecialchars(json_encode($lstField->getValue($lstModel)->values())); ?>"
        :taxonomy-fields-values="props.taxonomyFieldsValues"
        :dependency-terms="props.dependencyTerms"
        fetch-terms-request-url="<?php echo esc_url(admin_url('admin-post.php?action=' . tdf_prefix() . '/search/terms/fetch')); ?>"
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
            <?php if ($lstField->multipleValues()) : ?>
                <lst-select :disabled="fieldProps.selectParentFirst">
                    <div slot-scope="select">
                        <div
                                class="tdfm-advanced-select"
                                @click.stop.prevent="select.onOpen"
                                @focusin="select.focusIn"
                                @focusout="select.focusOut"
                                @keyup.esc="select.onClose"
                                tabindex="0"
                        >
                            <div
                                    class="tdfm-input"
                                    :class="{'tdfm-input--disabled': fieldProps.selectParentFirst}"
                            >
                                <template>
                                    <div
                                            class="tdfm-field-pin"
                                            v-for="term in fieldProps.value"
                                            :key="term.key"
                                    >
                                        <span v-html="term.name"></span>

                                        <div class="tdfm-field-pin__separator"></div>

                                        <div
                                                class="tdfm-field-pin__close"
                                                @click.stop.prevent="fieldProps.removeTerm(term.id)"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8"
                                                 viewBox="0 0 8 8" fill="none">
                                                <path d="M0.889354 0.000385399C0.713166 0.000603672 0.541042 0.0533645 0.394971 0.151928C0.248899 0.250491 0.135512 0.390383 0.0692934 0.553731C0.00307477 0.71708 -0.0129688 0.89647 0.0232121 1.06899C0.059393 1.2415 0.146156 1.39931 0.272417 1.52225L2.74709 3.9981L0.272417 6.47394C0.187381 6.55563 0.119491 6.65346 0.0727219 6.76173C0.0259528 6.86999 0.00124506 6.9865 4.58543e-05 7.10443C-0.00115335 7.22237 0.0211801 7.33935 0.0657381 7.44855C0.110296 7.55774 0.176183 7.65694 0.25954 7.74033C0.342897 7.82373 0.442049 7.88965 0.551188 7.93423C0.660327 7.97881 0.77726 8.00115 0.895139 7.99995C1.01302 7.99875 1.12947 7.97403 1.23768 7.92724C1.34589 7.88045 1.44368 7.81252 1.52533 7.72745L4 5.2516L6.47467 7.72745C6.55631 7.81253 6.6541 7.88045 6.76231 7.92724C6.87052 7.97403 6.98698 7.99875 7.10486 7.99995C7.22274 8.00115 7.33967 7.97881 7.44881 7.93423C7.55795 7.88965 7.6571 7.82373 7.74046 7.74034C7.82382 7.65694 7.88971 7.55774 7.93426 7.44855C7.97882 7.33936 8.00115 7.22237 7.99995 7.10443C7.99875 6.9865 7.97405 6.86999 7.92728 6.76173C7.88051 6.65346 7.81261 6.55563 7.72758 6.47394L5.25291 3.9981L7.72758 1.52225C7.85561 1.39774 7.94306 1.23743 7.97847 1.06234C8.01387 0.887245 7.99558 0.705535 7.92599 0.541021C7.8564 0.376508 7.73876 0.236865 7.58848 0.140392C7.4382 0.0439203 7.26229 -0.00488048 7.08382 0.000385399C6.85363 0.00724757 6.63515 0.103498 6.47467 0.268746L4 2.74459L1.52533 0.268746C1.44266 0.183724 1.34377 0.116165 1.23453 0.0700682C1.12529 0.023972 1.00791 0.000276521 0.889354 0.000385399Z"
                                                      fill="#EA6A6A"/>
                                            </svg>
                                        </div>
                                    </div>
                                </template>

                                <input
                                        :value="fieldProps.keyword"
                                        @input="fieldProps.setKeyword($event.target.value)"
                                        @keydown.enter.stop.prevent="fieldProps.createTerm($event.target.value)"
                                        @keydown.delete="fieldProps.removeLastTerm"
                                        type="text"
                                    <?php if (!empty($lstField->getInputPlaceholder())) : ?>
                                        placeholder="<?php echo esc_html($lstField->getInputPlaceholder()); ?>"
                                    <?php else : ?>
                                        placeholder="<?php echo sprintf(esc_html__('Select %s', 'listivo-core'),
                                            $lstField->getName()); ?>"
                                    <?php endif; ?>
                                >
                            </div>

                            <template>
                                <div
                                        v-show="select.open && fieldProps.hasVisibleOptions"
                                        class="tdfm-advanced-select__dropdown"
                                >
                                    <div
                                            v-for="(option, index) in fieldProps.optionsTree"
                                            :key="option.id"
                                            class="tdfm-advanced-select__option-wrapper"
                                    >
                                        <div
                                                v-show="option.visible"
                                                class="tdfm-advanced-select__option"
                                                :class="{'tdfm-advanced-select__option--active': select.optionIndex === index}"
                                                @click.stop.prevent="fieldProps.addTerm(option.id)"
                                        >
                                            <div
                                                    class="tdfm-advanced-select__checkbox"
                                                    :class="{'tdfm-advanced-select__checkbox--selected': fieldProps.selectedTermIds.indexOf(option.id) !== -1}"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="10"
                                                     viewBox="0 0 11 10" fill="none">
                                                    <path d="M10.738 0.728889L9.75128 0.0970432C9.47826 -0.0771195 9.10421 -0.0102893 8.92148 0.244879L4.08453 6.96431L1.86169 4.87031C1.62951 4.65159 1.25116 4.65159 1.01898 4.87031L0.17413 5.66619C-0.0580433 5.88491 -0.0580433 6.24133 0.17413 6.46207L3.59224 9.68205C3.78357 9.86229 4.08453 10 4.3554 10C4.62627 10 4.89929 9.84001 5.07557 9.59902L10.8971 1.50857C11.082 1.2534 11.011 0.903051 10.738 0.728889Z"
                                                          fill="#FDFDFE"/>
                                                </svg>
                                            </div>

                                            <span v-html="option.name"></span>
                                        </div>

                                        <div
                                                v-if="option.children"
                                                class="tdfm-advanced-select__children"
                                        >
                                            <div
                                                    v-for="option2 in option.children"
                                                    :key="option2.id"
                                                    class="tdfm-advanced-select__option-wrapper"
                                            >
                                                <div
                                                        v-show="option2.visible"
                                                        class="tdfm-advanced-select__option tdfm-advanced-select__option--level-2"
                                                        @click.stop.prevent="fieldProps.addTerm(option2.id)"
                                                >
                                                    <div
                                                            class="tdfm-advanced-select__checkbox"
                                                            :class="{'tdfm-advanced-select__checkbox--selected': fieldProps.selectedTermIds.indexOf(option2.id) !== -1}"
                                                    >
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="10"
                                                             viewBox="0 0 11 10" fill="none">
                                                            <path d="M10.738 0.728889L9.75128 0.0970432C9.47826 -0.0771195 9.10421 -0.0102893 8.92148 0.244879L4.08453 6.96431L1.86169 4.87031C1.62951 4.65159 1.25116 4.65159 1.01898 4.87031L0.17413 5.66619C-0.0580433 5.88491 -0.0580433 6.24133 0.17413 6.46207L3.59224 9.68205C3.78357 9.86229 4.08453 10 4.3554 10C4.62627 10 4.89929 9.84001 5.07557 9.59902L10.8971 1.50857C11.082 1.2534 11.011 0.903051 10.738 0.728889Z"
                                                                  fill="#FDFDFE"/>
                                                        </svg>
                                                    </div>

                                                    <span v-html="option2.name"></span>
                                                </div>

                                                <div
                                                        v-if="option2.children"
                                                        class="tdfm-advanced-select__children"
                                                >
                                                    <div
                                                            v-for="option3 in option2.children"
                                                            :key="option3.id"
                                                            class="tdfm-advanced-select__option tdfm-advanced-select__option--level-3"
                                                            @click.stop.prevent="fieldProps.addTerm(option3.id)"
                                                            v-show="option3.visible"
                                                    >
                                                        <div
                                                                class="tdfm-advanced-select__checkbox"
                                                                :class="{'tdfm-advanced-select__checkbox--selected': fieldProps.selectedTermIds.indexOf(option3.id) !== -1}"
                                                        >
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="11"
                                                                 height="10"
                                                                 viewBox="0 0 11 10" fill="none">
                                                                <path d="M10.738 0.728889L9.75128 0.0970432C9.47826 -0.0771195 9.10421 -0.0102893 8.92148 0.244879L4.08453 6.96431L1.86169 4.87031C1.62951 4.65159 1.25116 4.65159 1.01898 4.87031L0.17413 5.66619C-0.0580433 5.88491 -0.0580433 6.24133 0.17413 6.46207L3.59224 9.68205C3.78357 9.86229 4.08453 10 4.3554 10C4.62627 10 4.89929 9.84001 5.07557 9.59902L10.8971 1.50857C11.082 1.2534 11.011 0.903051 10.738 0.728889Z"
                                                                      fill="#FDFDFE"/>
                                                            </svg>
                                                        </div>

                                                        <span v-html="option3.name"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </lst-select>
            <?php else : ?>
                <lst-select>
                    <div slot-scope="select">
                        <div
                                class="tdfm-select"
                                :class="{'tdfm-select--disabled': fieldProps.selectParentFirst}"
                                @click.stop.prevent="select.onOpen"
                                @focusin="select.focusIn"
                                @focusout="select.focusOut"
                                @keyup.esc="select.onClose"
                                tabindex="0"
                        >
                            <div
                                    v-if="fieldProps.value.length === 0"
                                    class="tdfm-select__input"
                            >
                                <input
                                        :value="fieldProps.keyword"
                                        @input="fieldProps.setKeyword($event.target.value)"
                                        @keydown.enter.stop.prevent="fieldProps.createTerm($event.target.value)"
                                        type="text"
                                    <?php if (!empty($lstField->getInputPlaceholder())) : ?>
                                        placeholder="<?php echo esc_html($lstField->getInputPlaceholder()); ?>"
                                    <?php else : ?>
                                        placeholder="<?php echo sprintf(esc_html__('Select %s', 'listivo-core'),
                                            $lstField->getName()); ?>"
                                    <?php endif; ?>
                                >
                            </div>

                            <div
                                    v-if="fieldProps.value.length > 0"
                                    class="tdfm-select__placeholder"
                            >
                                <span
                                        v-for="value in fieldProps.value"
                                        :key="value.id"
                                >
                                    {{ value.name }}
                                </span>
                            </div>

                            <div
                                    v-if="fieldProps.value.length > 0"
                                    class="tdfm-select__clear"
                                    @click.stop.prevent="fieldProps.setTerms([]); select.onClose()"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" viewBox="0 0 8 8"
                                     fill="none">
                                    <path d="M0.889354 0.000385399C0.713166 0.000603672 0.541042 0.0533645 0.394971 0.151928C0.248899 0.250491 0.135512 0.390383 0.0692934 0.553731C0.00307477 0.71708 -0.0129688 0.89647 0.0232121 1.06899C0.059393 1.2415 0.146156 1.39931 0.272417 1.52225L2.74709 3.9981L0.272417 6.47394C0.187381 6.55563 0.119491 6.65346 0.0727219 6.76173C0.0259528 6.86999 0.00124506 6.9865 4.58543e-05 7.10443C-0.00115335 7.22237 0.0211801 7.33935 0.0657381 7.44855C0.110296 7.55774 0.176183 7.65694 0.25954 7.74033C0.342897 7.82373 0.442049 7.88965 0.551188 7.93423C0.660327 7.97881 0.77726 8.00115 0.895139 7.99995C1.01302 7.99875 1.12947 7.97403 1.23768 7.92724C1.34589 7.88045 1.44368 7.81252 1.52533 7.72745L4 5.2516L6.47467 7.72745C6.55631 7.81253 6.6541 7.88045 6.76231 7.92724C6.87052 7.97403 6.98698 7.99875 7.10486 7.99995C7.22274 8.00115 7.33967 7.97881 7.44881 7.93423C7.55795 7.88965 7.6571 7.82373 7.74046 7.74034C7.82382 7.65694 7.88971 7.55774 7.93426 7.44855C7.97882 7.33936 8.00115 7.22237 7.99995 7.10443C7.99875 6.9865 7.97405 6.86999 7.92728 6.76173C7.88051 6.65346 7.81261 6.55563 7.72758 6.47394L5.25291 3.9981L7.72758 1.52225C7.85561 1.39774 7.94306 1.23743 7.97847 1.06234C8.01387 0.887245 7.99558 0.705535 7.92599 0.541021C7.8564 0.376508 7.73876 0.236865 7.58848 0.140392C7.4382 0.0439203 7.26229 -0.00488048 7.08382 0.000385399C6.85363 0.00724757 6.63515 0.103498 6.47467 0.268746L4 2.74459L1.52533 0.268746C1.44266 0.183724 1.34377 0.116165 1.23453 0.0700682C1.12529 0.023972 1.00791 0.000276521 0.889354 0.000385399Z"
                                          fill="#EA6A6A"/>
                                </svg>
                            </div>

                            <div
                                    v-show="select.open && fieldProps.hasVisibleOptions"
                                    class="tdfm-select__dropdown"
                            >
                                <div
                                        v-for="option in fieldProps.options"
                                        :key="option.id"
                                        v-show="option.visible"
                                        class="tdfm-select__option"
                                        v-html="option.name"
                                        @click.stop.prevent="fieldProps.setTerms([option.id]); select.onClose();"
                                >
                                </div>
                            </div>
                        </div>
                    </div>
                </lst-select>
            <?php endif; ?>

            <input
                    v-for="value in fieldProps.value"
                    :key="value.name"
                    name="<?php echo esc_attr($lstField->getKey()); ?>[]"
                    type="hidden"
                    :value="value.name"
            >
        </div>
    </div>
</lst-taxonomy-field>