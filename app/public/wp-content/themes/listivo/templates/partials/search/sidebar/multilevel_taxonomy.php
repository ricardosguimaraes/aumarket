<?php

use Tangibledesign\Framework\Search\Field\TaxonomySearchField;

/* @var TaxonomySearchField $lstSearchField */
global $lstSearchField;
?>
<lst-multilevel-taxonomy-search-field
        :field="<?php echo htmlspecialchars(json_encode($lstSearchField)); ?>"
        :filters="props.filters"
        :dependencies="props.dependencies"
        :term-count="props.termCount"
        :multiple="<?php echo esc_attr($lstSearchField->isSelectMultipleControl() ? 'true' : 'false'); ?>"
        order-type="<?php echo esc_attr($lstSearchField->getOrderType()); ?>"
        all-label="<?php echo esc_attr($lstSearchField->getAllLabel()); ?>"
        :initial-terms="<?php echo htmlspecialchars(json_encode($lstSearchField->getMainTerms())); ?>"
        fetch-terms-request-url="<?php echo esc_url(tdf_action_url(tdf_prefix() . '/terms/multilevel/fetch')); ?>"
        :custom-order="<?php echo esc_attr($lstSearchField->isCustomOrder() ? 'true' : 'false'); ?>"
    <?php if (!empty($lstSearchField->getOptionsLimit())) : ?>
        :options-limit="<?php echo esc_attr($lstSearchField->getOptionsLimit()); ?>"
    <?php endif; ?>
>
    <div
            slot-scope="taxonomyField"
        <?php if ($lstSearchField->isCheckboxControl() || $lstSearchField->isRadioControl()) : ?>
            v-if="taxonomyField.isVisible && !taxonomyField.isDisabled"
        <?php else : ?>
            v-if="taxonomyField.isVisible"
        <?php endif; ?>
            class="listivo-search-form-field listivo-search-form-field--<?php echo esc_attr($lstSearchField->getKey()); ?> elementor-repeater-item-<?php echo esc_attr($lstSearchField->getRepeaterFieldId()); ?>"
    >
        <div class="listivo-search-sidebar__children">
            <?php if ($lstSearchField->isRadioControl()) : ?>
                <div
                    <?php if ($lstSearchField->limitHeight()) : ?>
                        class="listivo-search-panel listivo-search-panel--limit-height"
                    <?php else : ?>
                        class="listivo-search-panel"
                    <?php endif; ?>
                        :class="{'listivo-search-panel--more': taxonomyField.showMoreOptionsButton && !taxonomyField.selectedTerms.length}"
                >
                    <div class="listivo-search-panel__top">
                        <div class="listivo-search-panel__label">
                            <?php echo esc_html($lstSearchField->getName()); ?>
                        </div>

                        <div
                                class="listivo-search-panel__circle"
                                :class="{'listivo-search-panel__circle--active': taxonomyField.selectedTerms.length}"
                        ></div>
                    </div>

                    <?php if ($lstSearchField->isMultilevel()) : ?>
                        <template>
                            <div
                                    class="listivo-search-panel__content"
                                    v-if="taxonomyField.selectedTerms.length"
                            >
                                <div class="listivo-search-panel__terms">
                                    <div
                                            class="listivo-search-panel__term-item"
                                            v-for="selectedTerm in taxonomyField.multilevelTermList"
                                            :key="'selected-' + selectedTerm.id"
                                            @click="taxonomyField.removeTerm(selectedTerm.id)"
                                    >
                                        <div class="listivo-search-panel__term-item-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="5" height="7"
                                                 viewBox="0 0 5 7" fill="none">
                                                <path d="M1.77261 3.5L4.39151 5.87477C4.67526 6.13207 4.67526 6.54972 4.39151 6.80702C4.10776 7.06433 3.64717 7.06433 3.36341 6.80702L0.200993 3.9394C-0.0669975 3.6964 -0.0669975 3.30298 0.200993 3.0606L3.36341 0.192977C3.64717 -0.0643257 4.10776 -0.0643257 4.39151 0.192977C4.67526 0.45028 4.67526 0.86793 4.39151 1.12523L1.77261 3.5Z"
                                                      fill="#537CD9"/>
                                            </svg>
                                        </div>

                                        <span v-html="selectedTerm.name + ' (' + selectedTerm.count + ')'"></span>
                                    </div>
                                </div>

                                <div
                                        v-if="taxonomyField.lastSelectedTerm"
                                        class="listivo-search-panel__label listivo-search-panel__label--smaller"
                                >
                                    <span v-html="taxonomyField.lastSelectedTerm.name + ' ('+ taxonomyField.lastSelectedTerm.count +')'"></span>
                                </div>
                            </div>
                        </template>
                    <?php endif; ?>

                    <div
                            class="listivo-search-panel__content"
                            v-if="!taxonomyField.selectedTerms.length"
                    >
                        <?php if ($lstSearchField->searchable()) : ?>
                            <div class="listivo-search-panel__keyword">
                                <div class="listivo-input-v2 listivo-input-v2--small">
                                    <input
                                            @input="taxonomyField.setKeyword($event.target.value)"
                                            :value="taxonomyField.keyword"
                                            type="text"
                                            placeholder="<?php echo esc_attr(tdf_string('search')); ?>"
                                    >

                                    <div
                                            v-if="taxonomyField.keyword !== ''"
                                            class="listivo-input-v2__clear"
                                            @click="taxonomyField.setKeyword('')"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="6" height="6" viewBox="0 0 6 6"
                                             fill="none">
                                            <path d="M0.667016 0.000289049C0.534874 0.000452754 0.405782 0.0400233 0.296228 0.113946C0.186675 0.187868 0.101634 0.292787 0.05197 0.415298C0.00230608 0.53781 -0.00972662 0.672352 0.0174091 0.801739C0.0445448 0.931126 0.109617 1.04948 0.204313 1.14169L2.06032 2.99857L0.204313 4.85546C0.140536 4.91672 0.0896183 4.9901 0.0545414 5.07129C0.0194646 5.15249 0.000933792 5.23987 3.43907e-05 5.32832C-0.00086501 5.41677 0.0158851 5.50452 0.0493036 5.58641C0.0827221 5.6683 0.132137 5.7427 0.194655 5.80525C0.257173 5.8678 0.331537 5.91724 0.413391 5.95067C0.495245 5.9841 0.582945 6.00086 0.671354 5.99996C0.759763 5.99906 0.847104 5.98052 0.928262 5.94543C1.00942 5.91034 1.08276 5.85939 1.144 5.79559L3 3.9387L4.856 5.79559C4.91723 5.85939 4.99058 5.91034 5.07173 5.94543C5.15289 5.98053 5.24023 5.99907 5.32864 5.99997C5.41705 6.00087 5.50475 5.98411 5.58661 5.95067C5.66846 5.91724 5.74283 5.8678 5.80535 5.80525C5.86786 5.74271 5.91728 5.66831 5.9507 5.58641C5.98412 5.50452 6.00087 5.41678 5.99997 5.32832C5.99907 5.23987 5.98053 5.15249 5.94546 5.07129C5.91038 4.9901 5.85946 4.91672 5.79568 4.85546L3.93968 2.99857L5.79568 1.14169C5.89171 1.0483 5.9573 0.928073 5.98385 0.796753C6.01041 0.665433 5.99669 0.529151 5.94449 0.405766C5.8923 0.282381 5.80407 0.177648 5.69136 0.105294C5.57865 0.0329402 5.44672 -0.00366036 5.31286 0.000289049C5.14022 0.00543568 4.97636 0.0776237 4.856 0.20156L3 2.05844L1.144 0.20156C1.08199 0.137793 1.00783 0.0871234 0.925898 0.0525512C0.843967 0.017979 0.755935 0.000207391 0.667016 0.000289049Z"
                                                  fill="#F09965"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <template>
                            <div class="listivo-search-panel__list">
                                <div
                                        class="listivo-search-panel__item"
                                        :class="{'listivo-search-panel__item--active': !taxonomyField.selectedTerms.length}"
                                        @click="taxonomyField.clear"
                                >
                                    <div class="listivo-search-panel__item-wrapper">
                                        <div class="listivo-search-panel__item-inner">
                                            <div class="listivo-search-panel__option-button-wrapper">
                                                <div
                                                        class="listivo-radio"
                                                        :class="{'listivo-radio--active': !taxonomyField.selectedTerms.length}"
                                                ></div>
                                            </div>

                                            <div class="listivo-search-panel__item-label">
                                                <?php echo esc_html(tdf_string('any')); ?>

                                                <?php if ($lstSearchField->showTermCount()) : ?>
                                                    <span>({{ taxonomyField.anyCount }})</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div
                                        v-for="option in taxonomyField.limitedOrderedOptions"
                                        class="listivo-search-panel__item"
                                        :class="{
                                            'listivo-search-panel__item--disabled': option.count === 0,
                                            'listivo-search-panel__item--active': option.active,
                                        }"
                                        @click="taxonomyField.setTerm(option.id)"
                                >
                                    <div class="listivo-search-panel__item-wrapper">
                                        <div class="listivo-search-panel__item-inner">
                                            <div class="listivo-search-panel__option-button-wrapper">
                                                <div
                                                        class="listivo-radio"
                                                        :class="{'listivo-radio--active': option.active}"
                                                ></div>
                                            </div>

                                            <?php if ($lstSearchField->showTermCount()) : ?>
                                                <div class="listivo-search-panel__item-label"
                                                     v-html="option.name + ' <span>('+ option.count +')</span>'"></div>
                                            <?php else : ?>
                                                <div class="listivo-search-panel__item-label"
                                                     v-html="option.name"></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <template>
                        <div
                                class="listivo-search-panel__more"
                                v-if="!taxonomyField.selectedTerms.length && taxonomyField.showMoreOptionsButton"
                                @click="taxonomyField.onShowAllOptions"
                        >
                            <?php echo esc_html(tdf_string('show_more')); ?>

                            ({{ taxonomyField.currentOptions.length
                            - <?php echo esc_html($lstSearchField->getOptionsLimit()); ?> }})

                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="12" viewBox="0 0 11 12"
                                 fill="none">
                                <path d="M0.194693 7.13805C0.0643593 7.00772 -0.000641187 6.83738 -0.000641187 6.66671C-0.000641187 6.49604 0.0643593 6.32571 0.194693 6.19538C0.455028 5.93504 0.877032 5.93504 1.13737 6.19538L4.66606 9.72407L4.66606 0.666671C4.66606 0.298669 4.96473 -1.19209e-06 5.33273 -1.19209e-06C5.70073 -1.19209e-06 5.9994 0.298669 5.9994 0.666671L5.9994 9.72407L9.52809 6.19538C9.78843 5.93504 10.2104 5.93504 10.4708 6.19538C10.7311 6.45571 10.7311 6.87771 10.4708 7.13805L5.80407 11.8047C5.54373 12.0651 5.12173 12.0651 4.86139 11.8047L0.194693 7.13805Z"
                                      fill="#374B5C"/>
                            </svg>
                        </div>
                    </template>
                </div>

                <?php if ($lstSearchField->showChildren()) : ?>
                    <template>
                        <lst-multilevel-taxonomy-search-field
                                v-for="term in taxonomyField.activeParentTerms"
                                :field="taxonomyField.field"
                                :initial-terms="taxonomyField.terms"
                                :filters="props.filters"
                                :dependencies="props.dependencies"
                                :term-count="props.termCount"
                                :parent="term.id"
                                :key="'field-' + term.id"
                                :multiple="<?php echo esc_attr($lstSearchField->isSelectMultipleControl() ? 'true' : 'false'); ?>"
                                order-type="<?php echo esc_attr($lstSearchField->getOrderType()); ?>"
                            <?php if (!empty($lstSearchField->getOptionsLimit())) : ?>
                                :options-limit="<?php echo esc_attr($lstSearchField->getOptionsLimit()); ?>"
                            <?php endif; ?>
                        >
                            <div
                                    slot-scope="taxonomyFieldProps"
                                <?php if ($lstSearchField->limitHeight()) : ?>
                                    class="listivo-search-panel listivo-search-panel--limit-height listivo-search-form-field"
                                <?php else : ?>
                                    class="listivo-search-panel listivo-search-form-field"
                                <?php endif; ?>
                                    :class="{'listivo-search-panel--more': taxonomyFieldProps.showMoreOptionsButton}"
                                    v-show="!taxonomyFieldProps.currentSelectedTermIds.length"
                            >
                                <div class="listivo-search-panel__content listivo-search-panel__content--padding-top-0">
                                    <?php if ($lstSearchField->searchable()) : ?>
                                        <div class="listivo-search-panel__keyword">
                                            <div class="listivo-input-v2 listivo-input-v2--small">
                                                <input
                                                        @input="taxonomyFieldProps.setKeyword($event.target.value)"
                                                        :value="taxonomyFieldProps.keyword"
                                                        type="text"
                                                        placeholder="<?php echo esc_attr(tdf_string('search')); ?>"
                                                >

                                                <div
                                                        v-if="taxonomyFieldProps.keyword !== ''"
                                                        class="listivo-input-v2__clear"
                                                        @click="taxonomyFieldProps.setKeyword('')"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="6" height="6"
                                                         viewBox="0 0 6 6"
                                                         fill="none">
                                                        <path d="M0.667016 0.000289049C0.534874 0.000452754 0.405782 0.0400233 0.296228 0.113946C0.186675 0.187868 0.101634 0.292787 0.05197 0.415298C0.00230608 0.53781 -0.00972662 0.672352 0.0174091 0.801739C0.0445448 0.931126 0.109617 1.04948 0.204313 1.14169L2.06032 2.99857L0.204313 4.85546C0.140536 4.91672 0.0896183 4.9901 0.0545414 5.07129C0.0194646 5.15249 0.000933792 5.23987 3.43907e-05 5.32832C-0.00086501 5.41677 0.0158851 5.50452 0.0493036 5.58641C0.0827221 5.6683 0.132137 5.7427 0.194655 5.80525C0.257173 5.8678 0.331537 5.91724 0.413391 5.95067C0.495245 5.9841 0.582945 6.00086 0.671354 5.99996C0.759763 5.99906 0.847104 5.98052 0.928262 5.94543C1.00942 5.91034 1.08276 5.85939 1.144 5.79559L3 3.9387L4.856 5.79559C4.91723 5.85939 4.99058 5.91034 5.07173 5.94543C5.15289 5.98053 5.24023 5.99907 5.32864 5.99997C5.41705 6.00087 5.50475 5.98411 5.58661 5.95067C5.66846 5.91724 5.74283 5.8678 5.80535 5.80525C5.86786 5.74271 5.91728 5.66831 5.9507 5.58641C5.98412 5.50452 6.00087 5.41678 5.99997 5.32832C5.99907 5.23987 5.98053 5.15249 5.94546 5.07129C5.91038 4.9901 5.85946 4.91672 5.79568 4.85546L3.93968 2.99857L5.79568 1.14169C5.89171 1.0483 5.9573 0.928073 5.98385 0.796753C6.01041 0.665433 5.99669 0.529151 5.94449 0.405766C5.8923 0.282381 5.80407 0.177648 5.69136 0.105294C5.57865 0.0329402 5.44672 -0.00366036 5.31286 0.000289049C5.14022 0.00543568 4.97636 0.0776237 4.856 0.20156L3 2.05844L1.144 0.20156C1.08199 0.137793 1.00783 0.0871234 0.925898 0.0525512C0.843967 0.017979 0.755935 0.000207391 0.667016 0.000289049Z"
                                                              fill="#F09965"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="listivo-search-panel__list">
                                        <div
                                                class="listivo-search-panel__item"
                                                :class="{'listivo-search-panel__item--active': !taxonomyFieldProps.selectedTerms.length}"
                                                @click="taxonomyFieldProps.clear"
                                        >
                                            <div class="listivo-search-panel__item-wrapper">
                                                <div class="listivo-search-panel__item-inner">
                                                    <div class="listivo-search-panel__option-button-wrapper">
                                                        <div
                                                                class="listivo-radio"
                                                                :class="{'listivo-radio--active': !taxonomyFieldProps.selectedTerms.length}"
                                                        ></div>
                                                    </div>

                                                    <div class="listivo-search-panel__item-label">
                                                        <?php echo esc_html(tdf_string('any')); ?>

                                                        <?php if ($lstSearchField->showTermCount()) : ?>
                                                            <span>({{ taxonomyFieldProps.anyCount }})</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div
                                                v-for="option in taxonomyFieldProps.limitedOrderedOptions"
                                                @click="taxonomyFieldProps.addTerm(option.id)"
                                                class="listivo-search-panel__item"
                                                :class="{
                                                    'listivo-search-panel__item--disabled': option.count === 0,
                                                    'listivo-search-panel__item--active': option.active,
                                                }"
                                        >
                                            <div class="listivo-search-panel__item-wrapper">
                                                <div class="listivo-search-panel__item-inner">
                                                    <div class="listivo-search-panel__option-button-wrapper">
                                                        <div
                                                                class="listivo-radio"
                                                                :class="{'listivo-radio--active': option.active}"
                                                        ></div>
                                                    </div>

                                                    <?php if ($lstSearchField->showTermCount()) : ?>
                                                        <div class="listivo-search-panel__item-label"
                                                             v-html="option.name + ' <span>('+ option.count +')</span>'"></div>
                                                    <?php else : ?>
                                                        <div class="listivo-search-panel__item-label"
                                                             v-html="option.name"></div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <template>
                                    <div
                                            class="listivo-search-panel__more"
                                            v-if="taxonomyFieldProps.showMoreOptionsButton"
                                            @click="taxonomyFieldProps.onShowAllOptions"
                                    >
                                        <?php echo esc_html(tdf_string('show_more')); ?>

                                        ({{ taxonomyFieldProps.currentOptions.length
                                        - <?php echo esc_html($lstSearchField->getOptionsLimit()); ?> }})

                                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="12"
                                             viewBox="0 0 11 12"
                                             fill="none">
                                            <path d="M0.194693 7.13805C0.0643593 7.00772 -0.000641187 6.83738 -0.000641187 6.66671C-0.000641187 6.49604 0.0643593 6.32571 0.194693 6.19538C0.455028 5.93504 0.877032 5.93504 1.13737 6.19538L4.66606 9.72407L4.66606 0.666671C4.66606 0.298669 4.96473 -1.19209e-06 5.33273 -1.19209e-06C5.70073 -1.19209e-06 5.9994 0.298669 5.9994 0.666671L5.9994 9.72407L9.52809 6.19538C9.78843 5.93504 10.2104 5.93504 10.4708 6.19538C10.7311 6.45571 10.7311 6.87771 10.4708 7.13805L5.80407 11.8047C5.54373 12.0651 5.12173 12.0651 4.86139 11.8047L0.194693 7.13805Z"
                                                  fill="#374B5C"/>
                                        </svg>
                                    </div>
                                </template>
                            </div>
                        </lst-multilevel-taxonomy-search-field>
                    </template>
                <?php endif; ?>
            <?php elseif ($lstSearchField->isCheckboxControl()) : ?>
                <div
                    <?php if ($lstSearchField->limitHeight()) : ?>
                        class="listivo-search-panel listivo-search-panel--limit-height"
                    <?php else : ?>
                        class="listivo-search-panel"
                    <?php endif; ?>
                        :class="{'listivo-search-panel--more': taxonomyField.showMoreOptionsButton}"
                >
                    <div class="listivo-search-panel__top">
                        <div class="listivo-search-panel__label">
                            <?php echo esc_html($lstSearchField->getName()); ?>
                        </div>

                        <div
                                class="listivo-search-panel__circle"
                                :class="{'listivo-search-panel__circle--active': taxonomyField.selectedTerms.length}"
                        ></div>
                    </div>

                    <div class="listivo-search-panel__content">
                        <?php if ($lstSearchField->searchable()) : ?>
                            <div class="listivo-search-panel__keyword">
                                <div class="listivo-input-v2 listivo-input-v2--small">
                                    <input
                                            @input="taxonomyField.setKeyword($event.target.value)"
                                            :value="taxonomyField.keyword"
                                            type="text"
                                            placeholder="<?php echo esc_attr(tdf_string('search')); ?>"
                                    >

                                    <div
                                            v-if="taxonomyField.keyword !== ''"
                                            class="listivo-input-v2__clear"
                                            @click="taxonomyField.setKeyword('')"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="6" height="6" viewBox="0 0 6 6"
                                             fill="none">
                                            <path d="M0.667016 0.000289049C0.534874 0.000452754 0.405782 0.0400233 0.296228 0.113946C0.186675 0.187868 0.101634 0.292787 0.05197 0.415298C0.00230608 0.53781 -0.00972662 0.672352 0.0174091 0.801739C0.0445448 0.931126 0.109617 1.04948 0.204313 1.14169L2.06032 2.99857L0.204313 4.85546C0.140536 4.91672 0.0896183 4.9901 0.0545414 5.07129C0.0194646 5.15249 0.000933792 5.23987 3.43907e-05 5.32832C-0.00086501 5.41677 0.0158851 5.50452 0.0493036 5.58641C0.0827221 5.6683 0.132137 5.7427 0.194655 5.80525C0.257173 5.8678 0.331537 5.91724 0.413391 5.95067C0.495245 5.9841 0.582945 6.00086 0.671354 5.99996C0.759763 5.99906 0.847104 5.98052 0.928262 5.94543C1.00942 5.91034 1.08276 5.85939 1.144 5.79559L3 3.9387L4.856 5.79559C4.91723 5.85939 4.99058 5.91034 5.07173 5.94543C5.15289 5.98053 5.24023 5.99907 5.32864 5.99997C5.41705 6.00087 5.50475 5.98411 5.58661 5.95067C5.66846 5.91724 5.74283 5.8678 5.80535 5.80525C5.86786 5.74271 5.91728 5.66831 5.9507 5.58641C5.98412 5.50452 6.00087 5.41678 5.99997 5.32832C5.99907 5.23987 5.98053 5.15249 5.94546 5.07129C5.91038 4.9901 5.85946 4.91672 5.79568 4.85546L3.93968 2.99857L5.79568 1.14169C5.89171 1.0483 5.9573 0.928073 5.98385 0.796753C6.01041 0.665433 5.99669 0.529151 5.94449 0.405766C5.8923 0.282381 5.80407 0.177648 5.69136 0.105294C5.57865 0.0329402 5.44672 -0.00366036 5.31286 0.000289049C5.14022 0.00543568 4.97636 0.0776237 4.856 0.20156L3 2.05844L1.144 0.20156C1.08199 0.137793 1.00783 0.0871234 0.925898 0.0525512C0.843967 0.017979 0.755935 0.000207391 0.667016 0.000289049Z"
                                                  fill="#F09965"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <template>
                            <div class="listivo-search-panel__list">
                                <div
                                        v-for="option in taxonomyField.limitedOrderedOptions"
                                        class="listivo-search-panel__item"
                                        :class="{
                                            'listivo-search-panel__item--disabled': option.count === 0,
                                            'listivo-search-panel__item--active': option.active,
                                        }"
                                        @click="taxonomyField.addTerm(option.id)"
                                >
                                    <div class="listivo-search-panel__item-wrapper">
                                        <div class="listivo-search-panel__item-inner">
                                            <div class="listivo-search-panel__option-button-wrapper">
                                                <div
                                                        class="listivo-checkbox listivo-checkbox--size-6"
                                                        :class="{'listivo-checkbox--checked': option.active}"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8"
                                                         viewBox="0 0 10 10" fill="none">
                                                        <path d="M9.76184 0.728889L8.8648 0.0970432C8.6166 -0.0771195 8.27655 -0.0102893 8.11043 0.244879L3.71321 6.96431L1.69244 4.87031C1.48138 4.65159 1.13741 4.65159 0.926348 4.87031L0.1583 5.66619C-0.0527667 5.88491 -0.0527667 6.24133 0.1583 6.46207L3.26567 9.68205C3.43961 9.86229 3.71321 10 3.95946 10C4.2057 10 4.4539 9.84001 4.61415 9.59902L9.90646 1.50857C10.0745 1.2534 10.01 0.903051 9.76184 0.728889Z"
                                                              fill="#FDFDFE"/>
                                                    </svg>
                                                </div>
                                            </div>

                                            <?php if ($lstSearchField->showTermCount()) : ?>
                                                <div class="listivo-search-panel__item-label"
                                                     v-html="option.name + '<span> ('+ option.count +')</span>'"></div>
                                            <?php else : ?>
                                                <div class="listivo-search-panel__item-label"
                                                     v-html="option.name"></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <template>
                        <div
                                class="listivo-search-panel__more"
                                v-if="taxonomyField.showMoreOptionsButton"
                                @click="taxonomyField.onShowAllOptions"
                        >
                            <?php echo esc_html(tdf_string('show_more')); ?>

                            ({{ taxonomyField.currentOptions.length
                            - <?php echo esc_html($lstSearchField->getOptionsLimit()); ?> }})

                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="12" viewBox="0 0 11 12"
                                 fill="none">
                                <path d="M0.194693 7.13805C0.0643593 7.00772 -0.000641187 6.83738 -0.000641187 6.66671C-0.000641187 6.49604 0.0643593 6.32571 0.194693 6.19538C0.455028 5.93504 0.877032 5.93504 1.13737 6.19538L4.66606 9.72407L4.66606 0.666671C4.66606 0.298669 4.96473 -1.19209e-06 5.33273 -1.19209e-06C5.70073 -1.19209e-06 5.9994 0.298669 5.9994 0.666671L5.9994 9.72407L9.52809 6.19538C9.78843 5.93504 10.2104 5.93504 10.4708 6.19538C10.7311 6.45571 10.7311 6.87771 10.4708 7.13805L5.80407 11.8047C5.54373 12.0651 5.12173 12.0651 4.86139 11.8047L0.194693 7.13805Z"
                                      fill="#374B5C"/>
                            </svg>
                        </div>
                    </template>
                </div>
            <?php elseif ($lstSearchField->isSelectControl()) : ?>
                <div class="listivo-search-panel">
                    <div class="listivo-search-panel__top">
                        <div class="listivo-search-panel__label">
                            <?php echo esc_html($lstSearchField->getName()); ?>
                        </div>

                        <div
                                class="listivo-search-panel__circle"
                                :class="{'listivo-search-panel__circle--active': taxonomyField.selectedTerms.length}"
                        ></div>
                    </div>

                    <div class="listivo-search-panel__content">
                        <lst-select
                                :options="taxonomyField.options"
                                @input="taxonomyField.addTerm"
                                :searchable="<?php echo esc_attr($lstSearchField->searchable() ? 'true' : 'false'); ?>"
                                active-text-class="listivo-select-v2__option--highlight-text"
                                highlight-option-class="listivo-select-v2__option--highlight"
                                order-type="<?php echo esc_attr($lstSearchField->getOrderType()); ?>"
                                :disabled="taxonomyField.isDisabled"
                                :is-selected="taxonomyField.isSelected"
                        >
                            <div
                                    slot-scope="select"
                                    @click.stop.prevent="select.onOpen"
                                    @focusin="select.focusIn"
                                    @focusout="select.focusOut"
                                    @keyup.esc="select.onClose"
                                    @keyup.up="select.decreaseOptionIndex"
                                    @keyup.down="select.increaseOptionIndex"
                                    @keyup.enter="select.setOptionByIndex"
                                    tabindex="0"
                                <?php if ($lstSearchField->hasIcon()) : ?>
                                    class="listivo-select-v2 listivo-select-v2--with-icon"
                                <?php else : ?>
                                    class="listivo-select-v2"
                                <?php endif; ?>
                                    :class="{
                                        'listivo-select-v2--active': taxonomyField.selectedTerms.length || select.open,
                                        'listivo-select-v2--open': select.open,
                                        'listivo-select-v2--disabled': taxonomyField.isDisabled,
                                    }"
                            >
                                <?php if ($lstSearchField->hasIcon()) :
                                    $lstIcon = $lstSearchField->getIcon();
                                    ?>
                                    <div class="listivo-select-v2__icon listivo-icon-v2">
                                        <?php if (isset($lstIcon['library']) && $lstIcon['library'] === 'svg' && !empty($lstIcon['value']['url'])) : ?>
                                            <?php echo tdf_load_icon($lstIcon['value']['url']); ?>
                                        <?php else : ?>
                                            <i class="<?php echo esc_attr($lstIcon['value']); ?>"></i>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                                <div
                                        v-if="!taxonomyField.currentSelectedTermIds.length"
                                        class="listivo-select-v2__placeholder"
                                >
                                    <?php echo esc_html($lstSearchField->getPlaceholder()); ?>
                                </div>

                                <div class="listivo-select-v2__arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5"
                                         viewBox="0 0 7 5" fill="none">
                                        <path d="M3.5 2.56768L5.87477 0.192917C6.13207 -0.0643854 6.54972 -0.0643854 6.80702 0.192917C7.06433 0.45022 7.06433 0.86787 6.80702 1.12517L3.9394 3.99279C3.6964 4.2358 3.30298 4.2358 3.0606 3.99279L0.192977 1.12517C-0.0643257 0.86787 -0.0643257 0.45022 0.192977 0.192917C0.45028 -0.0643854 0.86793 -0.0643854 1.12523 0.192917L3.5 2.56768Z"
                                              fill="#2A3946"/>
                                    </svg>
                                </div>

                                <template>
                                    <div
                                            v-if="taxonomyField.currentSelectedTermIds.length"
                                            class="listivo-select-v2__placeholder"
                                    >
                                        <div
                                                v-if="taxonomyField.currentSelectedTermIds.length === 1"
                                                v-for="term in taxonomyField.selectedTerms"
                                                v-html="term.name"
                                        ></div>
                                    </div>

                                    <div
                                            v-if="taxonomyField.currentSelectedTermIds.length === 1"
                                            class="listivo-select-v2__clear"
                                            @click.stop.prevent="taxonomyField.clear(); select.onClose()"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="6" height="6" viewBox="0 0 6 6"
                                             fill="none">
                                            <path d="M0.667016 0.000289049C0.534874 0.000452754 0.405782 0.0400233 0.296228 0.113946C0.186675 0.187868 0.101634 0.292787 0.05197 0.415298C0.00230608 0.53781 -0.00972662 0.672352 0.0174091 0.801739C0.0445448 0.931126 0.109617 1.04948 0.204313 1.14169L2.06032 2.99857L0.204313 4.85546C0.140536 4.91672 0.0896183 4.9901 0.0545414 5.07129C0.0194646 5.15249 0.000933792 5.23987 3.43907e-05 5.32832C-0.00086501 5.41677 0.0158851 5.50452 0.0493036 5.58641C0.0827221 5.6683 0.132137 5.7427 0.194655 5.80525C0.257173 5.8678 0.331537 5.91724 0.413391 5.95067C0.495245 5.9841 0.582945 6.00086 0.671354 5.99996C0.759763 5.99906 0.847104 5.98052 0.928262 5.94543C1.00942 5.91034 1.08276 5.85939 1.144 5.79559L3 3.9387L4.856 5.79559C4.91723 5.85939 4.99058 5.91034 5.07173 5.94543C5.15289 5.98053 5.24023 5.99907 5.32864 5.99997C5.41705 6.00087 5.50475 5.98411 5.58661 5.95067C5.66846 5.91724 5.74283 5.8678 5.80535 5.80525C5.86786 5.74271 5.91728 5.66831 5.9507 5.58641C5.98412 5.50452 6.00087 5.41678 5.99997 5.32832C5.99907 5.23987 5.98053 5.15249 5.94546 5.07129C5.91038 4.9901 5.85946 4.91672 5.79568 4.85546L3.93968 2.99857L5.79568 1.14169C5.89171 1.0483 5.9573 0.928073 5.98385 0.796753C6.01041 0.665433 5.99669 0.529151 5.94449 0.405766C5.8923 0.282381 5.80407 0.177648 5.69136 0.105294C5.57865 0.0329402 5.44672 -0.00366036 5.31286 0.000289049C5.14022 0.00543568 4.97636 0.0776237 4.856 0.20156L3 2.05844L1.144 0.20156C1.08199 0.137793 1.00783 0.0871234 0.925898 0.0525512C0.843967 0.017979 0.755935 0.000207391 0.667016 0.000289049Z"
                                                  fill="#F09965"/>
                                        </svg>
                                    </div>

                                    <div
                                            v-if="select.open"
                                            class="listivo-select-v2__dropdown"
                                            @click.stop.prevent
                                    >
                                        <?php if ($lstSearchField->searchable()) : ?>
                                            <div class="listivo-select-v2__searchable">
                                                <div class="listivo-input-v2">
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

                                        <div v-if="!select.options.length" class="listivo-select-v2__no-options">
                                            <span v-if="!taxonomyField.loadingTerms">
                                                <?php echo esc_html(tdf_string('no_options')); ?>
                                            </span>

                                            <span v-if="taxonomyField.loadingTerms">
                                                <?php echo esc_html(tdf_string('loading_options')); ?>
                                            </span>
                                        </div>

                                        <div
                                                v-for="(option, index) in select.options"
                                                :key="'option_' + option.id"
                                                @click.stop.prevent="select.setOption(option)"
                                                class="listivo-select-v2__option"
                                                :class="{
                                                    'listivo-select-v2__option--active': option.selected,
                                                    'listivo-select-v2__option--highlight': index === select.optionIndex,
                                                    'listivo-select-v2__option--disabled': option.disabled && !option.selected,
                                                }"
                                        >
                                            <div class="listivo-select-v2__value" v-html="option.label"></div>

                                            <?php if ($lstSearchField->showTermCount()) : ?>
                                                <div class="listivo-select-v2__count-wrapper">
                                                    <div class="listivo-select-v2__count">
                                                        {{ option.count }}
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </lst-select>
                    </div>
                </div>

                <?php if ($lstSearchField->showChildren()) : ?>
                    <template>
                        <lst-multilevel-taxonomy-search-field
                                v-for="term in taxonomyField.activeParentTerms"
                                :field="taxonomyField.field"
                                :initial-terms="taxonomyField.terms"
                                :filters="props.filters"
                                :dependencies="props.dependencies"
                                :term-count="props.termCount"
                                :parent="term.id"
                                :key="'field_' + term.id"
                                :multiple="<?php echo esc_attr($lstSearchField->isSelectMultipleControl() ? 'true' : 'false'); ?>"
                        >
                            <div
                                    slot-scope="taxonomyFieldProps"
                                    class="listivo-search-panel listivo-search-form-field"
                            >
                                <div class="listivo-search-panel__top">
                                    <div class="listivo-search-panel__label">
                                        {{ term.searchFormPlaceholder }}
                                    </div>

                                    <div
                                            class="listivo-search-panel__circle"
                                            :class="{'listivo-search-panel__circle--active': taxonomyFieldProps.currentSelectedTermIds.length}"
                                    ></div>
                                </div>

                                <div class="listivo-search-panel__content">
                                    <lst-select
                                            :options="taxonomyFieldProps.options"
                                            @input="taxonomyFieldProps.addTerm"
                                            :searchable="<?php echo esc_attr($lstSearchField->searchable() ? 'true' : 'false'); ?>"
                                            active-text-class="listivo-select-v2__active-text"
                                            highlight-option-class="listivo-select-v2__option--highlight"
                                            order-type="<?php echo esc_attr($lstSearchField->getOrderType()); ?>"
                                            :disabled="taxonomyFieldProps.isDisabled"
                                            :is-selected="taxonomyFieldProps.isSelected"
                                    >
                                        <div
                                                slot-scope="select"
                                                @click="select.onOpen"
                                                @focusin="select.focusIn"
                                                @focusout="select.focusOut"
                                                @keyup.esc="select.onClose"
                                                @keyup.up="select.decreaseOptionIndex"
                                                @keyup.down="select.increaseOptionIndex"
                                                @keyup.enter="select.setOptionByIndex"
                                                tabindex="0"
                                                class="listivo-select-v2"
                                                :class="{
                                                    'listivo-select-v2--active': taxonomyFieldProps.currentSelectedTermIds.length || select.open,
                                                    'listivo-select-v2--open': select.open,
                                                    'listivo-select-v2--disabled': taxonomyFieldProps.isDisabled,
                                                }"
                                        >
                                            <div
                                                    v-if="!taxonomyFieldProps.currentSelectedTermIds.length"
                                                    class="listivo-select-v2__placeholder"
                                            >
                                                {{ term.searchFormPlaceholder }}
                                            </div>

                                            <div class="listivo-select-v2__arrow">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5"
                                                     viewBox="0 0 7 5" fill="none">
                                                    <path d="M3.5 2.56768L5.87477 0.192917C6.13207 -0.0643854 6.54972 -0.0643854 6.80702 0.192917C7.06433 0.45022 7.06433 0.86787 6.80702 1.12517L3.9394 3.99279C3.6964 4.2358 3.30298 4.2358 3.0606 3.99279L0.192977 1.12517C-0.0643257 0.86787 -0.0643257 0.45022 0.192977 0.192917C0.45028 -0.0643854 0.86793 -0.0643854 1.12523 0.192917L3.5 2.56768Z"
                                                          fill="#2A3946"/>
                                                </svg>
                                            </div>

                                            <div
                                                    v-if="taxonomyFieldProps.currentSelectedTermIds.length"
                                                    class="listivo-select-v2__placeholder"
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

                                            <div
                                                    v-if="taxonomyFieldProps.currentSelectedTermIds.length > 0"
                                                    class="listivo-select-v2__clear"
                                                    @click.stop.prevent="taxonomyFieldProps.clear(); select.onClose()"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="6" height="6"
                                                     viewBox="0 0 6 6"
                                                     fill="none">
                                                    <path d="M0.667016 0.000289049C0.534874 0.000452754 0.405782 0.0400233 0.296228 0.113946C0.186675 0.187868 0.101634 0.292787 0.05197 0.415298C0.00230608 0.53781 -0.00972662 0.672352 0.0174091 0.801739C0.0445448 0.931126 0.109617 1.04948 0.204313 1.14169L2.06032 2.99857L0.204313 4.85546C0.140536 4.91672 0.0896183 4.9901 0.0545414 5.07129C0.0194646 5.15249 0.000933792 5.23987 3.43907e-05 5.32832C-0.00086501 5.41677 0.0158851 5.50452 0.0493036 5.58641C0.0827221 5.6683 0.132137 5.7427 0.194655 5.80525C0.257173 5.8678 0.331537 5.91724 0.413391 5.95067C0.495245 5.9841 0.582945 6.00086 0.671354 5.99996C0.759763 5.99906 0.847104 5.98052 0.928262 5.94543C1.00942 5.91034 1.08276 5.85939 1.144 5.79559L3 3.9387L4.856 5.79559C4.91723 5.85939 4.99058 5.91034 5.07173 5.94543C5.15289 5.98053 5.24023 5.99907 5.32864 5.99997C5.41705 6.00087 5.50475 5.98411 5.58661 5.95067C5.66846 5.91724 5.74283 5.8678 5.80535 5.80525C5.86786 5.74271 5.91728 5.66831 5.9507 5.58641C5.98412 5.50452 6.00087 5.41678 5.99997 5.32832C5.99907 5.23987 5.98053 5.15249 5.94546 5.07129C5.91038 4.9901 5.85946 4.91672 5.79568 4.85546L3.93968 2.99857L5.79568 1.14169C5.89171 1.0483 5.9573 0.928073 5.98385 0.796753C6.01041 0.665433 5.99669 0.529151 5.94449 0.405766C5.8923 0.282381 5.80407 0.177648 5.69136 0.105294C5.57865 0.0329402 5.44672 -0.00366036 5.31286 0.000289049C5.14022 0.00543568 4.97636 0.0776237 4.856 0.20156L3 2.05844L1.144 0.20156C1.08199 0.137793 1.00783 0.0871234 0.925898 0.0525512C0.843967 0.017979 0.755935 0.000207391 0.667016 0.000289049Z"
                                                          fill="#F09965"/>
                                                </svg>
                                            </div>

                                            <div
                                                    v-if="select.open"
                                                    class="listivo-select-v2__dropdown"
                                                    @click.stop.prevent
                                            >
                                                <?php if ($lstSearchField->searchable()) : ?>
                                                    <div class="listivo-select-v2__searchable">
                                                        <div class="listivo-input-v2">
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

                                                <div v-if="!select.options.length"
                                                     class="listivo-select-v2__no-options">
                                                    <span v-if="!taxonomyField.loadingTerms">
                                                        <?php echo esc_html(tdf_string('no_options')); ?>
                                                    </span>

                                                    <span v-if="taxonomyField.loadingTerms">
                                                        <?php echo esc_html(tdf_string('loading_options')); ?>
                                                    </span>
                                                </div>

                                                <div
                                                        v-for="(option, index) in select.options"
                                                        :key="'option_' + option.id"
                                                        @click.stop.prevent="select.setOption(option)"
                                                        class="listivo-select-v2__option"
                                                        :class="{
                                                            'listivo-select-v2__option--active': option.selected,
                                                            'listivo-select-v2__option--highlight': index === select.optionIndex,
                                                            'listivo-select-v2__option--disabled': option.disabled && !option.selected,
                                                        }"
                                                >
                                                    <div class="listivo-select-v2__value" v-html="option.label"></div>

                                                    <?php if ($lstSearchField->showTermCount()) : ?>
                                                        <div class="listivo-select-v2__count-wrapper">
                                                            <div class="listivo-select-v2__count">
                                                                {{ option.count }}
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </lst-select>
                                </div>
                            </div>
                        </lst-multilevel-taxonomy-search-field>
                    </template>
                <?php endif; ?>
            <?php elseif ($lstSearchField->isSelectMultipleControl()) : ?>
                <div class="listivo-search-panel">
                    <div class="listivo-search-panel__top">
                        <div class="listivo-search-panel__label">
                            <?php echo esc_html($lstSearchField->getName()); ?>
                        </div>

                        <div
                                class="listivo-search-panel__circle"
                                :class="{'listivo-search-panel__circle--active': taxonomyField.selectedTerms.length}"
                        ></div>
                    </div>

                    <div class="listivo-search-panel__content">
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
                                    @click.stop.prevent="select.onOpen"
                                    @focusin="select.focusIn"
                                    @focusout="select.focusOut"
                                    @keyup.esc="select.onClose"
                                    @keyup.up="select.decreaseOptionIndex"
                                    @keyup.down="select.increaseOptionIndex"
                                    @keyup.enter="select.setOptionByIndex"
                                    tabindex="0"
                                <?php if ($lstSearchField->hasIcon()) : ?>
                                    class="listivo-select-v2 listivo-select-v2--with-icon"
                                <?php else : ?>
                                    class="listivo-select-v2"
                                <?php endif; ?>
                                    :class="{
                                        'listivo-select-v2--active': taxonomyField.currentSelectedTermIds.length || select.open,
                                        'listivo-select-v2--open': select.open,
                                        'listivo-select-v2--disabled': taxonomyField.isDisabled,
                                    }"
                            >
                                <?php if ($lstSearchField->hasIcon()) :
                                    $lstIcon = $lstSearchField->getIcon();
                                    ?>
                                    <div class="listivo-select-v2__icon listivo-icon-v2">
                                        <?php if (isset($lstIcon['library']) && $lstIcon['library'] === 'svg' && !empty($lstIcon['value']['url'])) : ?>
                                            <?php echo tdf_load_icon($lstIcon['value']['url']); ?>
                                        <?php else : ?>
                                            <i class="<?php echo esc_attr($lstIcon['value']); ?>"></i>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                                <div
                                        v-if="!taxonomyField.selectedTerms.length"
                                        class="listivo-select-v2__placeholder"
                                >
                                    <?php echo esc_html($lstSearchField->getPlaceholder()) ?>
                                </div>

                                <div class="listivo-select-v2__arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5"
                                         viewBox="0 0 7 5" fill="none">
                                        <path d="M3.5 2.56768L5.87477 0.192917C6.13207 -0.0643854 6.54972 -0.0643854 6.80702 0.192917C7.06433 0.45022 7.06433 0.86787 6.80702 1.12517L3.9394 3.99279C3.6964 4.2358 3.30298 4.2358 3.0606 3.99279L0.192977 1.12517C-0.0643257 0.86787 -0.0643257 0.45022 0.192977 0.192917C0.45028 -0.0643854 0.86793 -0.0643854 1.12523 0.192917L3.5 2.56768Z"
                                              fill="#2A3946"/>
                                    </svg>
                                </div>

                                <template>
                                    <div
                                            v-if="taxonomyField.selectedTerms.length"
                                            class="listivo-select-v2__placeholder"
                                    >
                                        <div
                                                v-if="taxonomyField.selectedTerms.length === 1"
                                                v-for="term in taxonomyField.selectedTerms"
                                                v-html="term.name"
                                        ></div>

                                        <div
                                                v-if="taxonomyField.selectedTerms.length > 1"
                                                v-html="taxonomyField.selectedTerms.length + ' <?php echo esc_attr(tdf_string('selected')); ?>'"
                                        ></div>
                                    </div>

                                    <div
                                            v-if="taxonomyField.currentSelectedTermIds.length > 0"
                                            class="listivo-select-v2__clear"
                                            @click.stop.prevent="taxonomyField.clear(); select.onClose()"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="6" height="6" viewBox="0 0 6 6"
                                             fill="none">
                                            <path d="M0.667016 0.000289049C0.534874 0.000452754 0.405782 0.0400233 0.296228 0.113946C0.186675 0.187868 0.101634 0.292787 0.05197 0.415298C0.00230608 0.53781 -0.00972662 0.672352 0.0174091 0.801739C0.0445448 0.931126 0.109617 1.04948 0.204313 1.14169L2.06032 2.99857L0.204313 4.85546C0.140536 4.91672 0.0896183 4.9901 0.0545414 5.07129C0.0194646 5.15249 0.000933792 5.23987 3.43907e-05 5.32832C-0.00086501 5.41677 0.0158851 5.50452 0.0493036 5.58641C0.0827221 5.6683 0.132137 5.7427 0.194655 5.80525C0.257173 5.8678 0.331537 5.91724 0.413391 5.95067C0.495245 5.9841 0.582945 6.00086 0.671354 5.99996C0.759763 5.99906 0.847104 5.98052 0.928262 5.94543C1.00942 5.91034 1.08276 5.85939 1.144 5.79559L3 3.9387L4.856 5.79559C4.91723 5.85939 4.99058 5.91034 5.07173 5.94543C5.15289 5.98053 5.24023 5.99907 5.32864 5.99997C5.41705 6.00087 5.50475 5.98411 5.58661 5.95067C5.66846 5.91724 5.74283 5.8678 5.80535 5.80525C5.86786 5.74271 5.91728 5.66831 5.9507 5.58641C5.98412 5.50452 6.00087 5.41678 5.99997 5.32832C5.99907 5.23987 5.98053 5.15249 5.94546 5.07129C5.91038 4.9901 5.85946 4.91672 5.79568 4.85546L3.93968 2.99857L5.79568 1.14169C5.89171 1.0483 5.9573 0.928073 5.98385 0.796753C6.01041 0.665433 5.99669 0.529151 5.94449 0.405766C5.8923 0.282381 5.80407 0.177648 5.69136 0.105294C5.57865 0.0329402 5.44672 -0.00366036 5.31286 0.000289049C5.14022 0.00543568 4.97636 0.0776237 4.856 0.20156L3 2.05844L1.144 0.20156C1.08199 0.137793 1.00783 0.0871234 0.925898 0.0525512C0.843967 0.017979 0.755935 0.000207391 0.667016 0.000289049Z"
                                                  fill="#F09965"/>
                                        </svg>
                                    </div>

                                    <div
                                            v-show="select.open"
                                            class="listivo-select-v2__dropdown"
                                            @click.stop.prevent
                                    >
                                        <?php if ($lstSearchField->searchable()) : ?>
                                            <div class="listivo-select-v2__searchable">
                                                <div class="listivo-input-v2">
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

                                        <div v-if="!select.options.length" class="listivo-select-v2__no-options">
                                            <span v-if="!taxonomyField.loadingTerms">
                                                <?php echo esc_html(tdf_string('no_options')); ?>
                                            </span>

                                            <span v-if="taxonomyField.loadingTerms">
                                                <?php echo esc_html(tdf_string('loading_options')); ?>
                                            </span>
                                        </div>

                                        <div
                                                v-for="(option, index) in select.options"
                                                :key="option.id"
                                                @click.stop.prevent="select.setOption(option)"
                                                class="listivo-select-v2__option"
                                                :class="{
                                                    'listivo-select-v2__option--active': option.selected,
                                                    'listivo-select-v2__option--highlight': index === select.optionIndex,
                                                    'listivo-select-v2__option--disabled': option.disabled && !option.selected,
                                                }"
                                        >
                                            <div class="listivo-select-v2__label-with-checkbox">
                                                <div class="listivo-select-v2__checkbox-wrapper">
                                                    <div class="listivo-select-v2__checkbox">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10"
                                                             viewBox="0 0 10 10" fill="none">
                                                            <path d="M9.76184 0.728889L8.8648 0.0970432C8.6166 -0.0771195 8.27655 -0.0102893 8.11043 0.244879L3.71321 6.96431L1.69244 4.87031C1.48138 4.65159 1.13741 4.65159 0.926348 4.87031L0.1583 5.66619C-0.0527667 5.88491 -0.0527667 6.24133 0.1583 6.46207L3.26567 9.68205C3.43961 9.86229 3.71321 10 3.95946 10C4.2057 10 4.4539 9.84001 4.61415 9.59902L9.90646 1.50857C10.0745 1.2534 10.01 0.903051 9.76184 0.728889Z"
                                                                  fill="#FDFDFE"/>
                                                        </svg>
                                                    </div>
                                                </div>

                                                <div class="listivo-select-v2__value" v-html="option.label"></div>
                                            </div>

                                            <?php if ($lstSearchField->showTermCount()) : ?>
                                                <div class="listivo-select-v2__count-wrapper">
                                                    <div class="listivo-select-v2__count">
                                                        {{ option.count }}
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </lst-select>
                    </div>
                </div>

                <?php if ($lstSearchField->showChildren()) : ?>
                    <template>
                        <lst-multilevel-taxonomy-search-field
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
                            <div slot-scope="taxonomyFieldProps" class="listivo-search-panel listivo-search-form-field">
                                <div class="listivo-search-panel__top">
                                    <div class="listivo-search-panel__label">
                                        {{ term.searchFormPlaceholder }}
                                    </div>

                                    <div
                                            class="listivo-search-panel__circle"
                                            :class="{'listivo-search-panel__circle--active': taxonomyFieldProps.currentSelectedTermIds.length}"
                                    ></div>
                                </div>

                                <div class="listivo-search-panel__content">
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
                                                @click="select.onOpen"
                                                @focusin="select.focusIn"
                                                @focusout="select.focusOut"
                                                @keyup.esc="select.onClose"
                                                @keyup.up="select.decreaseOptionIndex"
                                                @keyup.down="select.increaseOptionIndex"
                                                @keyup.enter="select.setOptionByIndex"
                                                tabindex="0"
                                                class="listivo-select-v2"
                                                :class="{
                                                    'listivo-select-v2--active': taxonomyFieldProps.currentSelectedTermIds.length || select.open,
                                                    'listivo-select-v2--open': select.open,
                                                    'listivo-select-v2--disabled': taxonomyFieldProps.isDisabled,
                                                }"
                                        >
                                            <div
                                                    v-if="!taxonomyFieldProps.selectedTerms.length"
                                                    class="listivo-select-v2__placeholder"
                                            >
                                                {{ term.searchFormPlaceholder }}
                                            </div>

                                            <div class="listivo-select-v2__arrow">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5"
                                                     viewBox="0 0 7 5" fill="none">
                                                    <path d="M3.5 2.56768L5.87477 0.192917C6.13207 -0.0643854 6.54972 -0.0643854 6.80702 0.192917C7.06433 0.45022 7.06433 0.86787 6.80702 1.12517L3.9394 3.99279C3.6964 4.2358 3.30298 4.2358 3.0606 3.99279L0.192977 1.12517C-0.0643257 0.86787 -0.0643257 0.45022 0.192977 0.192917C0.45028 -0.0643854 0.86793 -0.0643854 1.12523 0.192917L3.5 2.56768Z"
                                                          fill="#2A3946"/>
                                                </svg>
                                            </div>

                                            <div
                                                    v-if="taxonomyFieldProps.selectedTerms.length"
                                                    class="listivo-select-v2__placeholder"
                                            >
                                                <div
                                                        v-if="taxonomyFieldProps.selectedTerms.length === 1"
                                                        v-for="term in taxonomyFieldProps.selectedTerms"
                                                        v-html="term.name"
                                                ></div>

                                                <div
                                                        v-if="taxonomyFieldProps.selectedTerms.length > 1"
                                                        v-html="taxonomyFieldProps.selectedTerms.length + ' <?php echo esc_attr(tdf_string('selected')); ?>'"
                                                ></div>
                                            </div>

                                            <div
                                                    v-if="taxonomyFieldProps.selectedTerms.length > 0"
                                                    class="listivo-select-v2__clear"
                                                    @click.stop.prevent="taxonomyFieldProps.clear(); select.onClose()"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="6" height="6"
                                                     viewBox="0 0 6 6"
                                                     fill="none">
                                                    <path d="M0.667016 0.000289049C0.534874 0.000452754 0.405782 0.0400233 0.296228 0.113946C0.186675 0.187868 0.101634 0.292787 0.05197 0.415298C0.00230608 0.53781 -0.00972662 0.672352 0.0174091 0.801739C0.0445448 0.931126 0.109617 1.04948 0.204313 1.14169L2.06032 2.99857L0.204313 4.85546C0.140536 4.91672 0.0896183 4.9901 0.0545414 5.07129C0.0194646 5.15249 0.000933792 5.23987 3.43907e-05 5.32832C-0.00086501 5.41677 0.0158851 5.50452 0.0493036 5.58641C0.0827221 5.6683 0.132137 5.7427 0.194655 5.80525C0.257173 5.8678 0.331537 5.91724 0.413391 5.95067C0.495245 5.9841 0.582945 6.00086 0.671354 5.99996C0.759763 5.99906 0.847104 5.98052 0.928262 5.94543C1.00942 5.91034 1.08276 5.85939 1.144 5.79559L3 3.9387L4.856 5.79559C4.91723 5.85939 4.99058 5.91034 5.07173 5.94543C5.15289 5.98053 5.24023 5.99907 5.32864 5.99997C5.41705 6.00087 5.50475 5.98411 5.58661 5.95067C5.66846 5.91724 5.74283 5.8678 5.80535 5.80525C5.86786 5.74271 5.91728 5.66831 5.9507 5.58641C5.98412 5.50452 6.00087 5.41678 5.99997 5.32832C5.99907 5.23987 5.98053 5.15249 5.94546 5.07129C5.91038 4.9901 5.85946 4.91672 5.79568 4.85546L3.93968 2.99857L5.79568 1.14169C5.89171 1.0483 5.9573 0.928073 5.98385 0.796753C6.01041 0.665433 5.99669 0.529151 5.94449 0.405766C5.8923 0.282381 5.80407 0.177648 5.69136 0.105294C5.57865 0.0329402 5.44672 -0.00366036 5.31286 0.000289049C5.14022 0.00543568 4.97636 0.0776237 4.856 0.20156L3 2.05844L1.144 0.20156C1.08199 0.137793 1.00783 0.0871234 0.925898 0.0525512C0.843967 0.017979 0.755935 0.000207391 0.667016 0.000289049Z"
                                                          fill="#F09965"/>
                                                </svg>
                                            </div>

                                            <div
                                                    v-if="select.open"
                                                    class="listivo-select-v2__dropdown"
                                                    @click.stop.prevent
                                            >
                                                <?php if ($lstSearchField->searchable()) : ?>
                                                    <div class="listivo-select-v2__searchable">
                                                        <div class="listivo-input-v2">
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

                                                <div
                                                        v-if="!select.options.length"
                                                        class="listivo-select-v2__no-options"
                                                >
                                                    <span v-if="!taxonomyField.loadingTerms">
                                                        <?php echo esc_html(tdf_string('no_options')); ?>
                                                    </span>

                                                    <span v-if="taxonomyField.loadingTerms">
                                                        <?php echo esc_html(tdf_string('loading_options')); ?>
                                                    </span>
                                                </div>

                                                <div
                                                        v-for="(option, index) in select.options"
                                                        :key="option.id"
                                                        @click.stop.prevent="select.setOption(option)"
                                                        class="listivo-select-v2__option"
                                                        :class="{
                                                            'listivo-select-v2__option--active': option.selected,
                                                            'listivo-select-v2__option--highlight': index === select.optionIndex,
                                                            'listivo-select-v2__option--disabled': option.disabled && !option.selected,
                                                        }"
                                                >
                                                    <div class="listivo-select-v2__label-with-checkbox">
                                                        <i v-if="!option.selected" class="far fa-square"></i>

                                                        <i v-if="option.selected" class="fas fa-check-square"></i>

                                                        <div class="listivo-select-v2__value"
                                                             v-html="option.label"></div>
                                                    </div>

                                                    <?php if ($lstSearchField->showTermCount()) : ?>
                                                        <div class="listivo-select-v2__count-wrapper">
                                                            <div class="listivo-select-v2__count">
                                                                {{ option.count }}
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </lst-select>
                                </div>
                            </div>
                        </lst-multilevel-taxonomy-search-field>
                    </template>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</lst-multilevel-taxonomy-search-field>