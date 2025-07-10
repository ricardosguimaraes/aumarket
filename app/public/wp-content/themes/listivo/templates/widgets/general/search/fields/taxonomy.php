<?php

use Tangibledesign\Framework\Search\Field\TaxonomySearchField;

/* @var TaxonomySearchField $lstSearchField */
global $lstSearchField;
$disableLazyLoadTerms = $lstSearchField->disableLazyLoadTerms();
?>
<lst-taxonomy-search-field
        :field="<?php echo htmlspecialchars(json_encode($lstSearchField)); ?>"
        :terms="<?php echo htmlspecialchars(json_encode($lstSearchField->getTerms())); ?>"
        :filters="props.filters"
        :dependencies="props.dependencies"
        :term-count="props.termCount"
        :multiple="<?php echo esc_attr($lstSearchField->isSelectMultipleControl() ? 'true' : 'false'); ?>"
    <?php if ($disableLazyLoadTerms) : ?>
        :initial-terms="<?php echo htmlspecialchars(json_encode($lstSearchField->getTerms())); ?>"
        :disable-fetch-terms="true"
    <?php else : ?>
        fetch-terms-request-url="<?php echo esc_url(admin_url('admin-post.php?action='.tdf_prefix().'/search/terms/fetch')); ?>"
    <?php endif; ?>
>
    <div
            slot-scope="taxonomyField"
            v-if="taxonomyField.isVisible"
            class="listivo-field"
            :class="{
                'listivo-field--1': taxonomyField.activeParentTerms.length === 1,
                'listivo-field--2': taxonomyField.activeParentTerms.length === 2,
                'listivo-field--3': taxonomyField.activeParentTerms.length === 3,
                'listivo-field--4': taxonomyField.activeParentTerms.length === 4,
            }"
    >
        <?php if ($lstSearchField->isSelectControl()) : ?>
            <div class="listivo-field">
                <lst-select
                        :options="taxonomyField.options"
                        @input="taxonomyField.addTerm"
                        :searchable="<?php echo esc_attr($lstSearchField->searchable() ? 'true' : 'false'); ?>"
                        active-text-class="listivo-select__active-text"
                        highlight-option-class="listivo-select__option--highlight-row"
                        order-type="<?php echo esc_attr($lstSearchField->getOrderType()); ?>"
                        :disabled="taxonomyField.isDisabled"
                        :is-selected="taxonomyField.isSelected"
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
                        <?php if ($lstSearchField->searchable()) : ?>
                            class="listivo-select listivo-select--searchable"
                        <?php else: ?>
                            class="listivo-select"
                        <?php endif; ?>
                            :class="{
                                'listivo-select__field--active': taxonomyField.selectedTerms.length,
                                'listivo-select--disabled': taxonomyField.isDisabled,
                            }"
                    >
                        <div
                                v-if="!taxonomyField.currentSelectedTermIds.length"
                                @click="select.onOpen"
                                class="listivo-select__field"
                        >
                            <?php echo esc_html($lstSearchField->getPlaceholder()); ?>
                        </div>

                        <template>
                            <div
                                    v-if="taxonomyField.currentSelectedTermIds.length"
                                    @click="select.onOpen"
                                    class="listivo-select__field"
                            >
                                <div
                                        v-if="taxonomyField.currentSelectedTermIds.length === 1"
                                        v-for="term in taxonomyField.selectedTerms"
                                        v-html="term.name"
                                ></div>

                                <div v-if="taxonomyField.currentSelectedTermIds.length > 1">
                                    {{ taxonomyField.selectedTerms.length
                                    }} <?php echo esc_html(tdf_string('selected')); ?>
                                </div>
                            </div>

                            <div v-if="select.open" class="listivo-select__dropdown">
                                <?php if ($lstSearchField->searchable()) : ?>
                                    <div class="listivo-select__search">
                                        <div class="listivo-select__search__inner">
                                            <input
                                                    type="text"
                                                    @input="select.setKeyword($event.target.value)"
                                                    :value="select.keyword"
                                                    placeholder="<?php echo esc_attr(tdf_string('search_dots')); ?>"
                                                    @keydown.up.prevent.stop
                                                    @keydown.down.prevent.stop
                                            >
                                        </div>
                                    </div>
                                <?php endif; ?>

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
                                                'listivo-select__option--highlight-row': index === select.optionIndex,
                                                'listivo-select__option--disabled': option.disabled && !option.selected,
                                            }"
                                    >
                                        <div class="listivo-select__value" v-html="option.label"></div>

                                        <?php if ($lstSearchField->showTermCount()) : ?>
                                            <div class="listivo-select__count">
                                                ({{ option.count }})
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div
                                    v-if="taxonomyField.selectedTermIds.length === 0"
                                    @click.prevent="select.onOpen"
                                    class="listivo-field__icon listivo-field__icon--arrow"
                            ></div>

                            <div
                                    v-if="taxonomyField.currentSelectedTermIds.length > 0"
                                    @click.prevent="taxonomyField.clear"
                                    class="listivo-field__icon listivo-field__icon--clear"
                            ></div>
                        </template>
                    </div>
                </lst-select>
            </div>

            <?php if ($lstSearchField->showChildren()) : ?>
                <template>
                    <lst-taxonomy-search-field
                            v-for="term in taxonomyField.activeParentTerms"
                            :field="taxonomyField.field"
                            :initial-terms="taxonomyField.terms"
                            :filters="props.filters"
                            :dependencies="props.dependencies"
                            :term-count="props.termCount"
                            :parent="term.id"
                            :key="term.id"
                            :multiple="<?php echo esc_attr($lstSearchField->isSelectMultipleControl() ? 'true' : 'false'); ?>"
                    >
                        <div slot-scope="taxonomyFieldProps" class="listivo-field">
                            <lst-select
                                    :options="taxonomyFieldProps.options"
                                    @input="taxonomyFieldProps.addTerm"
                                    :searchable="<?php echo esc_attr($lstSearchField->searchable() ? 'true' : 'false'); ?>"
                                    active-text-class="listivo-select__active-text"
                                    highlight-option-class="listivo-select__option--highlight"
                                    order-type="<?php echo esc_attr($lstSearchField->getOrderType()); ?>"
                                    :disabled="taxonomyFieldProps.isDisabled"
                                    :is-selected="taxonomyFieldProps.isSelected"
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
                                    <?php if ($lstSearchField->searchable()) : ?>
                                        class="listivo-select listivo-select--searchable"
                                    <?php else: ?>
                                        class="listivo-select"
                                    <?php endif; ?>
                                        :class="{
                                            'listivo-select__field--active': taxonomyFieldProps.currentSelectedTermIds.length,
                                            'listivo-select--disabled': taxonomyFieldProps.isDisabled,
                                        }"
                                >
                                    <div
                                            v-if="!taxonomyFieldProps.currentSelectedTermIds.length"
                                            @click="select.onOpen"
                                            class="listivo-select__field"
                                    >
                                        {{ term.searchFormPlaceholder }}
                                    </div>

                                    <div
                                            v-if="taxonomyFieldProps.currentSelectedTermIds.length"
                                            @click="select.onOpen"
                                            class="listivo-select__field"
                                    >
                                        <div
                                                v-if="taxonomyFieldProps.currentSelectedTermIds.length === 1"
                                                v-for="term in taxonomyFieldProps.selectedTerms"
                                                v-html="term.name"
                                        ></div>

                                        <div v-if="taxonomyFieldProps.currentSelectedTermIds.length > 1">
                                            {{ taxonomyField.selectedTerms.length
                                            }} <?php echo esc_html(tdf_string('selected')); ?>
                                        </div>
                                    </div>

                                    <div v-if="select.open" class="listivo-select__dropdown">
                                        <?php if ($lstSearchField->searchable()) : ?>
                                            <div class="listivo-select__search">
                                                <div class="listivo-select__search__inner">
                                                    <input
                                                            type="text"
                                                            @input="select.setKeyword($event.target.value)"
                                                            :value="select.keyword"
                                                            placeholder="<?php echo esc_attr(tdf_string('search_dots')); ?>"
                                                            @keydown.up.prevent.stop
                                                            @keydown.down.prevent.stop
                                                    >
                                                </div>
                                            </div>
                                        <?php endif; ?>

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

                                                <?php if ($lstSearchField->showTermCount()) : ?>
                                                    <div class="listivo-select__count">
                                                        ({{ option.count }})
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                            v-if="taxonomyFieldProps.currentSelectedTermIds.length === 0"
                                            @click.prevent="select.onOpen"
                                            class="listivo-field__icon listivo-field__icon--arrow"
                                    ></div>

                                    <div
                                            v-if="taxonomyFieldProps.currentSelectedTermIds.length > 0"
                                            @click.prevent="taxonomyFieldProps.clear"
                                            class="listivo-field__icon listivo-field__icon--clear"
                                    ></div>
                                </div>
                            </lst-select>
                        </div>
                    </lst-taxonomy-search-field>
                </template>
            <?php endif; ?>
        <?php elseif ($lstSearchField->isSelectMultipleControl()) : ?>
            <div class="listivo-field">
                <lst-select
                        :options="taxonomyField.options"
                        :multiple="true"
                        :searchable="<?php echo esc_attr($lstSearchField->searchable() ? 'true' : 'false'); ?>"
                        active-text-class="listivo-select__active-text"
                        highlight-option-class="listivo-select__option--highlight"
                        @input="taxonomyField.addTerm"
                        order-type="<?php echo esc_attr($lstSearchField->getOrderType()); ?>"
                        :disabled="taxonomyField.isDisabled"
                        :is-selected="taxonomyField.isSelected"
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
                        <?php if ($lstSearchField->searchable()) : ?>
                            class="listivo-select listivo-select--searchable"
                        <?php else: ?>
                            class="listivo-select"
                        <?php endif; ?>
                            :class="{
                                'listivo-select__field--active': taxonomyField.currentSelectedTermIds.length,
                                'listivo-select--disabled': taxonomyField.isDisabled,
                            }"
                    >
                        <div
                                v-if="!taxonomyField.selectedTerms.length"
                                @click="select.onOpen"
                                class="listivo-select__field"
                        >
                            <?php echo esc_html($lstSearchField->getPlaceholder()) ?>
                        </div>

                        <template>
                            <div
                                    v-if="taxonomyField.selectedTerms.length"
                                    @click="select.onOpen"
                            >
                                <div
                                        v-if="taxonomyField.selectedTerms.length === 1"
                                        v-for="term in taxonomyField.selectedTerms"
                                        v-html="term.name"
                                        class="listivo-select__field"
                                ></div>

                                <div
                                        v-if="taxonomyField.selectedTerms.length > 1"
                                        v-html="taxonomyField.selectedTerms.length + ' <?php echo esc_attr(tdf_string('selected')); ?>'"
                                        class="listivo-select__field"
                                ></div>
                            </div>

                            <div v-if="select.open" class="listivo-select__dropdown">
                                <div class="listivo-select__mobile-dropdown-top">
                                    <h3 class="listivo-select__mobile-title">
                                        <?php echo esc_html($lstSearchField->getName()); ?>
                                    </h3>

                                    <div
                                            @click.prevent="select.onClose"
                                            class="listivo-select__mobile-close"
                                    >
                                        <i class="fa fa-times"></i>
                                    </div>
                                </div>

                                <?php if ($lstSearchField->searchable()) : ?>
                                    <div class="listivo-select__search">
                                        <div class="listivo-select__search__inner">
                                            <input
                                                    type="text"
                                                    @input="select.setKeyword($event.target.value)"
                                                    :value="select.keyword"
                                                    placeholder="<?php echo esc_attr(tdf_string('search_dots')); ?>"
                                                    @keydown.up.prevent.stop
                                                    @keydown.down.prevent.stop
                                            >
                                        </div>
                                    </div>
                                <?php endif; ?>

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
                                        <i v-if="!option.selected" class="far fa-square"></i>

                                        <i v-if="option.selected" class="fas fa-check-square"></i>

                                        <div class="listivo-select__value" v-html="option.label"></div>

                                        <?php if ($lstSearchField->showTermCount()) : ?>
                                            <div class="listivo-select__count">
                                                ({{ option.count }})
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="listivo-select__mobile-dropdown-bottom">
                                    <button
                                            @click.prevent="select.onClose"
                                            class="listivo-primary-button listivo-primary-button--icon listivo-primary-button--full-width"
                                    >
                                        <span class="listivo-primary-button__text">
                                            <?php echo esc_html(tdf_string('apply')); ?>
                                        </span>

                                        <span class="listivo-primary-button__icon">
                                            <i class="fas fa-check"></i>
                                        </span>
                                    </button>
                                </div>
                            </div>

                            <div
                                    v-if="taxonomyField.selectedTermIds.length === 0 || select.open"
                                    @click.prevent="select.onOpen"
                                    class="listivo-field__icon listivo-field__icon--arrow"
                            ></div>

                            <div
                                    v-if="taxonomyField.selectedTermIds.length > 0 && !select.open"
                                    @click.prevent="taxonomyField.clear"
                                    class="listivo-field__icon listivo-field__icon--clear"
                            ></div>
                        </template>
                    </div>
                </lst-select>
            </div>

            <?php if ($lstSearchField->showChildren()) : ?>
                <template>
                    <lst-taxonomy-search-field
                            v-for="term in taxonomyField.activeParentTerms"
                            :field="taxonomyField.field"
                            :terms="taxonomyField.terms"
                            :filters="props.filters"
                            :dependencies="props.dependencies"
                            :term-count="props.termCount"
                            :parent="term.id"
                            :key="term.id"
                            :multiple="<?php echo esc_attr($lstSearchField->isSelectMultipleControl() ? 'true' : 'false'); ?>"
                    >
                        <div slot-scope="taxonomyFieldProps" class="listivo-field">
                            <lst-select
                                    :options="taxonomyFieldProps.options"
                                    :multiple="true"
                                    :searchable="<?php echo esc_attr($lstSearchField->searchable() ? 'true' : 'false'); ?>"
                                    active-text-class="listivo-select__active-text"
                                    highlight-option-class="listivo-select__option--highlight"
                                    @input="taxonomyFieldProps.addTerm"
                                    order-type="<?php echo esc_attr($lstSearchField->getOrderType()); ?>"
                                    :disabled="taxonomyFieldProps.isDisabled"
                                    :is-selected="taxonomyFieldProps.isSelected"
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
                                    <?php if ($lstSearchField->searchable()) : ?>
                                        class="listivo-select listivo-select--searchable"
                                    <?php else: ?>
                                        class="listivo-select"
                                    <?php endif; ?>
                                        :class="{
                                            'listivo-select__field--active': taxonomyFieldProps.currentSelectedTermIds.length,
                                            'listivo-select--disabled': taxonomyFieldProps.isDisabled,
                                        }"
                                >
                                    <div
                                            v-if="!taxonomyFieldProps.selectedTerms.length"
                                            @click="select.onOpen"
                                            class="listivo-select__field"
                                    >
                                        {{ term.searchFormPlaceholder }}
                                    </div>

                                    <div
                                            v-if="taxonomyFieldProps.selectedTerms.length"
                                            @click="select.onOpen"
                                    >
                                        <div
                                                v-if="taxonomyFieldProps.selectedTerms.length === 1"
                                                v-for="term in taxonomyFieldProps.selectedTerms"
                                                v-html="term.name"
                                                class="listivo-select__field"
                                        ></div>

                                        <div
                                                v-if="taxonomyFieldProps.selectedTerms.length > 1"
                                                v-html="taxonomyFieldProps.selectedTerms.length + ' <?php echo esc_attr(tdf_string('selected')); ?>'"
                                                class="listivo-select__field"
                                        ></div>
                                    </div>

                                    <div v-if="select.open" class="listivo-select__dropdown">
                                        <div class="listivo-select__mobile-dropdown-top">
                                            <h3 class="listivo-select__mobile-title">
                                                <?php echo esc_html($lstSearchField->getName()); ?>
                                            </h3>

                                            <div
                                                    @click.prevent="select.onClose"
                                                    class="listivo-select__mobile-close"
                                            >
                                                <i class="fa fa-times"></i>
                                            </div>
                                        </div>

                                        <?php if ($lstSearchField->searchable()) : ?>
                                            <div class="listivo-select__search">
                                                <div class="listivo-select__search__inner">
                                                    <input
                                                            type="text"
                                                            @input="select.setKeyword($event.target.value)"
                                                            :value="select.keyword"
                                                            placeholder="<?php echo esc_attr(tdf_string('search_dots')); ?>"
                                                            @keydown.up.prevent.stop
                                                            @keydown.down.prevent.stop
                                                    >
                                                </div>
                                            </div>
                                        <?php endif; ?>

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
                                                <i v-if="!option.selected" class="far fa-square"></i>

                                                <i v-if="option.selected" class="fas fa-check-square"></i>

                                                <div class="listivo-select__value" v-html="option.label"></div>

                                                <?php if ($lstSearchField->showTermCount()) : ?>
                                                    <div class="listivo-select__count">
                                                        ({{ option.count }})
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="listivo-select__mobile-dropdown-bottom">
                                            <button
                                                    @click.prevent="select.onClose"
                                                    class="listivo-primary-button listivo-primary-button--icon listivo-primary-button--full-width"
                                            >
                                                <span class="listivo-primary-button__text">
                                                    <?php echo esc_html(tdf_string('apply')); ?>
                                                </span>

                                                <span class="listivo-primary-button__icon">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                            </button>
                                        </div>
                                    </div>

                                    <div
                                            v-if="taxonomyFieldProps.currentSelectedTermIds.length === 0 || select.open"
                                            @click.prevent="select.onOpen"
                                            class="listivo-field__icon listivo-field__icon--arrow"
                                    ></div>

                                    <div
                                            v-if="taxonomyFieldProps.currentSelectedTermIds.length > 0 && !select.open"
                                            @click.prevent="taxonomyFieldProps.clear"
                                            class="listivo-field__icon listivo-field__icon--clear"
                                    ></div>
                                </div>
                            </lst-select>
                        </div>
                    </lst-taxonomy-search-field>
                </template>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</lst-taxonomy-search-field>