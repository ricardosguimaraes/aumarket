<?php

use Tangibledesign\Framework\Search\Field\PriceSearchField;

/* @var PriceSearchField $lstSearchField */
global $lstSearchField;

if ($lstSearchField->isSelectControl()) :?>
    <lst-price-search-field
        <?php if ($lstSearchField->getCompareType() === PriceSearchField::COMPARE_TYPE_GREATER) : ?>
            field-key="<?php echo esc_attr($lstSearchField->getKey()); ?>_from"
        <?php else : ?>
            field-key="<?php echo esc_attr($lstSearchField->getKey()); ?>_to"
        <?php endif; ?>
            :field="<?php echo htmlspecialchars(json_encode($lstSearchField)); ?>"
            :filters="props.filters"
            :dependencies="props.dependencies"
            compare-type="<?php echo esc_attr($lstSearchField->getCompareType()); ?>"
            :options="<?php echo htmlspecialchars(json_encode($lstSearchField->getSelectOptions())); ?>"
    >
        <div slot-scope="priceField" v-if="priceField.isVisible">
            <lst-select
                    :options="priceField.options"
                    @input="priceField.setValue"
                    :is-selected="priceField.isSelected"
                    active-text-class="listivo-select__active-text"
                    highlight-option-class="listivo-select__option--highlight"
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
                            'listivo-select__field--active': priceField.value !== '',
                        }"
                >
                    <div
                            v-if="priceField.value === ''"
                            @click="select.onOpen"
                            class="listivo-select__field"
                    >
                        <?php echo esc_html($lstSearchField->getName()); ?>
                    </div>

                    <template>
                        <div
                                v-if="priceField.value !== ''"
                                @click="select.onOpen"
                                class="listivo-select__field"
                        >
                            <div v-html="priceField.currentValue.name"></div>
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
                                v-if="priceField.value === ''"
                                @click.prevent="select.onOpen"
                                class="listivo-field__icon listivo-field__icon--arrow"
                        ></div>

                        <div
                                v-if="priceField.value !== ''"
                                @click.prevent="priceField.clear"
                                class="listivo-field__icon listivo-field__icon--clear"
                        ></div>
                    </template>
                </div>
            </lst-select>
        </div>
    </lst-price-search-field>
<?php elseif ($lstSearchField->isTextInputRangeControl()) : ?>
    <lst-price-search-field
            :field="<?php echo htmlspecialchars(json_encode($lstSearchField)); ?>"
            :filters="props.filters"
            :dependencies="props.dependencies"
            class="listivo-field listivo-field--double"
    >
        <div slot-scope="mainPriceField" v-if="mainPriceField.isVisible">
            <div class="listivo-field__fields">
                <lst-price-search-field
                        :field="<?php echo htmlspecialchars(json_encode($lstSearchField)); ?>"
                        field-key="<?php echo esc_attr($lstSearchField->getKey() . '_from'); ?>"
                        :filters="props.filters"
                        :dependencies="props.dependencies"
                        compare-type="<?php echo esc_attr(PriceSearchField::COMPARE_TYPE_GREATER); ?>"
                >
                    <div
                            slot-scope="priceField"
                            class="listivo-field"
                            :class="{'listivo-field--active': priceField.value !== ''}"
                    >
                        <div class="listivo-relative">
                            <input
                                    :value="priceField.value"
                                    @input="priceField.setValue($event.target.value)"
                                    type="text"
                                    placeholder="<?php echo esc_attr($lstSearchField->getPlaceholderFrom()); ?>"
                            >

                            <template>
                                <div
                                        v-if="priceField.value !== ''"
                                        @click.prevent="priceField.clear"
                                        class="listivo-field__icon listivo-field__icon--clear"
                                ></div>
                            </template>
                        </div>
                    </div>
                </lst-price-search-field>

                <lst-price-search-field
                        :field="<?php echo htmlspecialchars(json_encode($lstSearchField)); ?>"
                        field-key="<?php echo esc_attr($lstSearchField->getKey() . '_to'); ?>"
                        :filters="props.filters"
                        :dependencies="props.dependencies"
                        compare-type="<?php echo esc_attr(PriceSearchField::COMPARE_TYPE_LESS); ?>"
                >
                    <div
                            slot-scope="priceField"
                            class="listivo-field"
                            slot-scope="priceField"
                            :class="{'listivo-field--active': priceField.value !== ''}"
                    >
                        <div class="listivo-relative">
                            <input
                                    :value="priceField.value"
                                    @input="priceField.setValue($event.target.value)"
                                    type="text"
                                    placeholder="<?php echo esc_attr($lstSearchField->getPlaceholderTo()); ?>"
                            >

                            <template>
                                <div
                                        v-if="priceField.value !== ''"
                                        @click.prevent="priceField.clear"
                                        class="listivo-field__icon listivo-field__icon--clear"
                                ></div>
                            </template>
                        </div>
                    </div>
                </lst-price-search-field>
            </div>
        </div>
    </lst-price-search-field>
<?php elseif ($lstSearchField->isSelectRangeControl()) : ?>
    <lst-price-search-field
            :field="<?php echo htmlspecialchars(json_encode($lstSearchField)); ?>"
            :filters="props.filters"
            :dependencies="props.dependencies"
            class="listivo-field listivo-field--double"

    >
        <div slot-scope="mainPriceField" v-if="mainPriceField.isVisible">
            <div class="listivo-field__fields">
                <lst-price-search-field
                        field-key="<?php echo esc_attr($lstSearchField->getKey() . '_from'); ?>"
                        :field="<?php echo htmlspecialchars(json_encode($lstSearchField)); ?>"
                        :filters="props.filters"
                        :dependencies="props.dependencies"
                        compare-type="<?php echo esc_attr(PriceSearchField::COMPARE_TYPE_GREATER); ?>"
                        :options="<?php echo htmlspecialchars(json_encode($lstSearchField->getSelectFromOptions())); ?>"
                >
                    <div slot-scope="priceField" v-if="priceField.isVisible">
                        <lst-select
                                :options="priceField.options"
                                @input="priceField.setValue"
                                :is-selected="priceField.isSelected"
                                active-text-class="listivo-select__active-text"
                                highlight-option-class="listivo-select__option--highlight"
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
                                    'listivo-select__field--active': priceField.value !== '',
                                }"
                            >
                                <div
                                        v-if="priceField.value === ''"
                                        @click="select.onOpen"
                                        class="listivo-select__field"
                                >
                                    <?php echo esc_html($lstSearchField->getName()); ?>
                                </div>

                                <template>
                                    <div
                                            v-if="priceField.value !== ''"
                                            @click="select.onOpen"
                                            class="listivo-select__field"
                                    >
                                        <div v-html="priceField.currentValue.name"></div>
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
                                            v-if="priceField.value === ''"
                                            @click.prevent="select.onOpen"
                                            class="listivo-field__icon listivo-field__icon--arrow"
                                    ></div>

                                    <div
                                            v-if="priceField.value !== ''"
                                            @click.prevent="priceField.clear"
                                            class="listivo-field__icon listivo-field__icon--clear"
                                    ></div>
                                </template>
                            </div>
                        </lst-select>
                    </div>
                </lst-price-search-field>

                <lst-price-search-field
                        field-key="<?php echo esc_attr($lstSearchField->getKey() . '_to'); ?>"
                        :field="<?php echo htmlspecialchars(json_encode($lstSearchField)); ?>"
                        :filters="props.filters"
                        :dependencies="props.dependencies"
                        compare-type="<?php echo esc_attr(PriceSearchField::COMPARE_TYPE_LESS); ?>"
                        :options="<?php echo htmlspecialchars(json_encode($lstSearchField->getSelectToOptions())); ?>"
                >
                    <div slot-scope="priceField" v-if="priceField.isVisible">
                        <lst-select
                                :options="priceField.options"
                                @input="priceField.setValue"
                                :is-selected="priceField.isSelected"
                                active-text-class="listivo-select__active-text"
                                highlight-option-class="listivo-select__option--highlight"
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
                                    'listivo-select__field--active': priceField.value !== '',
                                }"
                            >
                                <div
                                        v-if="priceField.value === ''"
                                        @click="select.onOpen"
                                        class="listivo-select__field"
                                >
                                    <?php echo esc_html($lstSearchField->getName()); ?>
                                </div>

                                <template>
                                    <div
                                            v-if="priceField.value !== ''"
                                            @click="select.onOpen"
                                            class="listivo-select__field"
                                    >
                                        <div v-html="priceField.currentValue.name"></div>
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
                                            v-if="priceField.value === ''"
                                            @click.prevent="select.onOpen"
                                            class="listivo-field__icon listivo-field__icon--arrow"
                                    ></div>

                                    <div
                                            v-if="priceField.value !== ''"
                                            @click.prevent="priceField.clear"
                                            class="listivo-field__icon listivo-field__icon--clear"
                                    ></div>
                                </template>
                            </div>
                        </lst-select>
                    </div>
                </lst-price-search-field>
            </div>
        </div>
    </lst-price-search-field>
<?php
endif;