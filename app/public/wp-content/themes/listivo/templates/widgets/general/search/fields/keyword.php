<?php
/* @var \Tangibledesign\Framework\Search\Field\KeywordSearchField $lstSearchField */
global $lstSearchField, $lstCurrentWidget;
$lstResetValues = $lstCurrentWidget instanceof \Tangibledesign\Framework\Widgets\General\SearchWidget;
?>
<lst-keyword-search-field
        class="listivo-field listivo-field--keyword"
        request-url="<?php echo esc_url(tdf_action_url('listivo/keyword')); ?>"
        :field="<?php echo htmlspecialchars(json_encode($lstSearchField)); ?>"
        :filters="props.filters"
        :min-characters="<?php echo esc_attr($lstSearchField->getMinCharacters()); ?>"
        :taxonomy-keys="<?php echo htmlspecialchars(json_encode($lstSearchField->getTaxonomyKeys())); ?>"
        highlight-option-class="listivo-select__option--highlight-row"
        :keyword-suggestion-limit="<?php echo esc_attr($lstSearchField->getKeywordSuggestionLimit()); ?>"
        active-text-class="listivo-select__option--highlight-text"
        :reset-values="<?php echo esc_attr($lstResetValues ? 'true' : 'false'); ?>"
>
    <div
            slot-scope="keywordProps"
            :class="{'listivo-field--active': keywordProps.keyword.length > 0}"
    >
        <div class="listivo-relative">
            <div class="listivo-keyword-icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                          d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                </svg>
            </div>

            <template>
                <div v-show="keywordProps.showPlaceholder" class="listivo-select__placeholder">
                    {{ keywordProps.placeholder }}
                </div>
            </template>

            <input
                    @keyup.stop.prevent
                    @input="keywordProps.setKeyword($event.target.value)"
                    :value="keywordProps.keyword"
                    type="text"
                    placeholder="<?php echo esc_attr($lstSearchField->getPlaceholder()); ?>"
                    @focusin="keywordProps.focusin"
                    @focusout="keywordProps.focusout"
                    @keyup.up.stop="keywordProps.decreaseOptionIndex"
                    @keyup.down.stop="keywordProps.increaseOptionIndex"
                    @keyup.enter="keywordProps.setOptionByIndex"
                    @keydown.down.stop.prevent
                    @keydown.up.stop.prevent
            >

            <template>
                <div
                        v-if="keywordProps.keyword.length > 0"
                        @click.prevent="keywordProps.clear"
                        class="listivo-field__icon listivo-field__icon--clear"
                ></div>

                <div v-if="keywordProps.open" class="listivo-select__dropdown">
                    <div class="listivo-select__options">
                        <div
                                class="listivo-select__option"
                                v-for="(option, index) in keywordProps.options"
                                :key="option.id"
                                @click.prevent="keywordProps.setOption(option)"
                                :class="{'listivo-select__option--highlight-row': index === keywordProps.optionIndex}"
                        >
                            <div v-if="option.keyword !== ''">
                                <span v-html="option.label"></span>

                                <span v-if="option.term !== ''" class="listivo-select__in-category">
                                    <?php echo esc_html(tdf_string('_in')); ?>

                                    <span v-html="option.term"></span>
                                </span>
                            </div>

                            <div v-if="option.keyword === '' && option.label !== ''" v-html="option.label"></div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</lst-keyword-search-field>