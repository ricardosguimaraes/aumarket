<?php
/* @var \Tangibledesign\Framework\Search\Field\LocationSearchField $lstSearchField */
global $lstSearchField;
?>
<lst-location-search-field
        class="listivo-field listivo-field--keyword"
        :field="<?php echo htmlspecialchars(json_encode($lstSearchField)); ?>"
        :filters="props.filters"
        :dependencies="props.dependencies"
        field-selector=".lst-location-<?php echo esc_attr($lstSearchField->getId()); ?>"
        custom-label="<?php echo esc_attr(tdf_string('selected_area_on_the_map')); ?>"
        :ask-for-location="<?php echo esc_attr($lstSearchField->askForLocation() ? 'true' : 'false'); ?>"
        active-text-class="listivo-select__option--highlight-text"
    <?php if ($lstSearchField->showMyLocationButton()) : ?>
        class="listivo-field listivo-field--with-icon"
    <?php else : ?>
        class="listivo-field"
    <?php endif; ?>
>
    <div
            slot-scope="locationField"
            v-if="locationField.isVisible"
            :class="{'listivo-field--active': locationField.keyword.length > 0}"
    >
        <div class="listivo-relative">
            <?php if ($lstSearchField->showMyLocationButton()) : ?>
                <div class="listivo-keyword-icon" style="cursor: pointer;">
                    <div class="listivo-field__set-my-location">
                        <svg @click.prevent="locationField.getCurrentLocation" xmlns="http://www.w3.org/2000/svg"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>

                        <div class="listivo-field__set-my-location-label">
                            <?php echo esc_attr(tdf_string('my_location')); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <template>
                <div v-show="locationField.showPlaceholder" class="listivo-select__placeholder">
                    {{ locationField.placeholder }}
                </div>
            </template>

            <input
                    @keyup.stop.prevent
                    @input="locationField.setKeyword($event.target.value)"
                    :value="locationField.keyword"
                    type="text"
                    placeholder="<?php echo esc_attr($lstSearchField->getPlaceholder()); ?>"
                    @focusin="locationField.focusin"
                    @focusout="locationField.focusout"
                    @keyup.up.stop="locationField.decreaseOptionIndex"
                    @keyup.down.stop="locationField.increaseOptionIndex"
                    @keyup.enter="locationField.setOptionByIndex"
                    @keydown.down.stop.prevent
                    @keydown.up.stop.prevent
            >

            <template>
                <div
                        v-if="locationField.keyword.length > 0"
                        @click.prevent="locationField.clear"
                        class="listivo-field__icon listivo-field__icon--clear"
                ></div>

                <div v-if="locationField.open" class="listivo-select__dropdown">
                    <div class="listivo-select__options">
                        <div
                                class="listivo-select__option"
                                v-for="(option, index) in locationField.options"
                                :key="option.id"
                                @click.prevent="locationField.setOption(option)"
                                :class="{'listivo-select__option--highlight-row': index === locationField.optionIndex}"
                        >
                            <span v-html="option.formatted"></span>
                        </div>
                    </div>
                </div>
            </template>

            <?php
            if ($lstSearchField->showRadiusControl()) :
                $lstRadiusOptions = $lstSearchField->getRadiusOptions();
                $lstRadiusInitial = $lstSearchField->getDefaultRadiusOption();
                ?>
                <lst-radius-search-field
                        :field="<?php echo htmlspecialchars(json_encode($lstSearchField)); ?>"
                        :filters="props.filters"
                        :dependencies="props.dependencies"
                    <?php if (!empty($lstRadiusInitial)) : ?>
                        :initial-radius="<?php echo htmlspecialchars(json_encode($lstRadiusInitial)); ?>"
                    <?php endif; ?>
                    <?php if (!empty($lstRadiusOptions)) : ?>
                        :options="<?php echo htmlspecialchars(json_encode($lstRadiusOptions)); ?>"
                    <?php endif; ?>
                >
                    <div slot-scope="radiusField" v-if="radiusField.isVisible && !radiusField.isDisabled">
                        <template>
                            <div class="listivo-field__location-radius">
                                <lst-select
                                        :options="radiusField.options"
                                        :value="radiusField.value"
                                        @input="radiusField.setValue"
                                        active-text-class="listivo-select__active-text"
                                        highlight-option-class="listivo-select__option--highlight"
                                        :disabled="radiusField.isDisabled"
                                        :is-selected="radiusField.isSelected"
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
                                            'listivo-select--disabled': radiusField.isDisabled,
                                        }"
                                    >
                                        <div @click="select.onOpen" class="listivo-select__field">
                                            <div v-if="!radiusField.value">
                                                <?php echo esc_html($lstSearchField->getRadiusPlaceholder()); ?>
                                            </div>

                                            <div v-if="radiusField.value">{{ radiusField.value.label }}</div>

                                            <div
                                                    @click="select.onOpen"
                                                    class="listivo-field__icon listivo-field__icon--arrow"
                                            ></div>

                                        </div>

                                        <div v-if="select.open" class="listivo-select__dropdown">
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
                                    </div>
                                </lst-select>
                            </div>
                        </template>
                    </div>
                </lst-radius-search-field>
            <?php endif; ?>
        </div>
    </div>
</lst-location-search-field>