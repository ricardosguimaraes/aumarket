<?php

use Tangibledesign\Framework\Search\Field\NumberSearchField;

/* @var NumberSearchField $lstSearchField */
global $lstSearchField, $lstSelectedDependencyTermIds;

if ($lstSearchField->isSelectControl()) :?>
    <lst-select-number-search-field
            field-key="<?php echo esc_attr($lstSearchField->getKey()); ?>"
            :field="<?php echo htmlspecialchars(json_encode($lstSearchField)); ?>"
            :filters="props.filters"
            :dependencies="props.dependencies"
            :options="<?php echo htmlspecialchars(json_encode($lstSearchField->getOptions())); ?>"
            compare-type="<?php echo esc_attr($lstSearchField->getSelectCompareType()); ?>"
    >
        <div
                slot-scope="numberField"
                v-if="numberField.isVisible"
                class="listivo-field"
        >
            <lst-select
                    :options="numberField.options"
                    @input="numberField.setValue"
                    active-text-class="listivo-select__active-text"
                    highlight-option-class="listivo-select__option--highlight"
                    :is-selected="numberField.isSelected"
                    order-type="custom"
            >
                <div
                        slot-scope="select"
                        @focusin="select.focusIn"
                        @focusout="select.focusOut"
                        @keyup.esc="select.onClose"
                        @keyup.up="select.decreaseOptionIndex"
                        @keyup.down="select.increaseOptionIndex"
                        @keyup.enter="select.setOptionByIndex"
                        tabindex="0"
                        class="listivo-select"
                        :class="{
                            'listivo-select__field--active': numberField.value !== '',
                        }"
                >
                    <div
                            v-if="numberField.value === ''"
                            @click="select.onOpen"
                            class="listivo-select__field"
                    >
                        <?php echo esc_html($lstSearchField->getName()); ?>
                    </div>

                    <template>
                        <div
                                v-if="numberField.value !== ''"
                                @click="select.onOpen"
                                class="listivo-select__field"
                        >
                            <div v-html="numberField.currentValue.name"></div>
                        </div>

                        <div v-if="select.open" class="listivo-select__dropdown">
                            <div v-if="!select.options.length" class="listivo-select__no-options">
                                <?php echo esc_html(tdf_string('no_options')); ?>
                            </div>

                            <div class="listivo-select__options">
                                <div
                                        v-for="(option, index) in select.options"
                                        :key="option.id"
                                        @click="select.setOption(option)"
                                        class="listivo-select__option"
                                        :class="{
                                            'listivo-select__option--active': option.selected,
                                            'listivo-select__option--highlight': index === select.optionIndex,
                                            'listivo-select__option--disabled': option.disabled && !option.selected,
                                        }"
                                >
                                    <div class="listivo-select__value" v-html="option.label"></div>
                                </div>
                            </div>
                        </div>

                        <div
                                v-if="numberField.value === ''"
                                @click.prevent="select.onOpen"
                                class="listivo-field__icon listivo-field__icon--arrow"
                        ></div>

                        <div
                                v-if="numberField.value !== ''"
                                @click.prevent="numberField.clear"
                                class="listivo-field__icon listivo-field__icon--clear"
                        ></div>
                    </template>
                </div>
            </lst-select>
        </div>
    </lst-select-number-search-field>
<?php elseif ($lstSearchField->isTextInputRangeControl()) : ?>
    <lst-number-search-field
            :field="<?php echo htmlspecialchars(json_encode($lstSearchField)); ?>"
            :filters="props.filters"
            :dependencies="props.dependencies"
            class="listivo-field listivo-field--double"
    >
        <div slot-scope="mainNumberField" v-if="mainNumberField.isVisible">
            <div class="listivo-field__fields">
                <lst-number-search-field
                        :field="<?php echo htmlspecialchars(json_encode($lstSearchField)); ?>"
                        field-key="<?php echo esc_attr($lstSearchField->getKey() . '_from'); ?>"
                        :filters="props.filters"
                        :dependencies="props.dependencies"
                        compare-type="<?php echo esc_attr(NumberSearchField::COMPARE_TYPE_GREATER); ?>"
                >
                    <div
                            slot-scope="numberField"
                            class="listivo-field"
                            :class="{'listivo-field--active': numberField.value !== ''}"
                    >
                        <div class="listivo-relative">
                            <input
                                    :value="numberField.value"
                                    @input="numberField.setValue($event.target.value)"
                                    type="text"
                                    placeholder="<?php echo esc_attr($lstSearchField->getPlaceholderFrom()); ?>"
                            >

                            <template>
                                <div
                                        v-if="numberField.value !== ''"
                                        @click.prevent="numberField.clear"
                                        class="listivo-field__icon listivo-field__icon--clear"
                                ></div>
                            </template>
                        </div>
                    </div>
                </lst-number-search-field>

                <lst-number-search-field
                        :field="<?php echo htmlspecialchars(json_encode($lstSearchField)); ?>"
                        field-key="<?php echo esc_attr($lstSearchField->getKey() . '_to'); ?>"
                        :filters="props.filters"
                        :dependencies="props.dependencies"
                        compare-type="<?php echo esc_attr(NumberSearchField::COMPARE_TYPE_LESS); ?>"
                >
                    <div
                            slot-scope="numberField"
                            class="listivo-field"
                            :class="{'listivo-field--active': numberField.value !== ''}"
                    >
                        <div class="listivo-relative">
                            <input
                                    :value="numberField.value"
                                    @input="numberField.setValue($event.target.value)"
                                    type="text"
                                    placeholder="<?php echo esc_attr($lstSearchField->getPlaceholderTo()); ?>"
                            >

                            <template>
                                <div
                                        v-if="numberField.value !== ''"
                                        @click.prevent="numberField.clear"
                                        class="listivo-field__icon listivo-field__icon--clear"
                                ></div>
                            </template>
                        </div>
                    </div>
                </lst-number-search-field>
            </div>
        </div>
    </lst-number-search-field>
<?php
endif;