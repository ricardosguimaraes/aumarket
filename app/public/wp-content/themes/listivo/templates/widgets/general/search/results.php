<?php

use Tangibledesign\Listivo\Widgets\General\Search\HasResults;
use Tangibledesign\Listivo\Widgets\General\Search\SearchMapWidget;

/* @var HasResults $lstCurrentWidget */
global $lstCurrentWidget, $lstCurrentListings;

$lstCurrentListings = $lstCurrentWidget->getResults();
?>
<div
    <?php if ($lstCurrentWidget instanceof SearchMapWidget) : ?>
        class="listivo-search-results listivo-highlight-featured-listings listivo-search-results--map"
    <?php else : ?>
        class="listivo-search-results listivo-highlight-featured-listings"
    <?php endif; ?>
>
    <?php if (!$lstCurrentWidget->hideSearchResultsBar()) : ?>
        <div class="listivo-search-results__row">
            <div class="listivo-search-results__row-left">
                <template>
                    <div class="listivo-search-results__results-number">
                        <span class="listivo-search-results__results-number-count">
                            {{ props.count }}
                        </span>

                        <span class="listivo-search-results__results-number-label">
                            <?php echo esc_html(tdf_string('results')); ?>
                        </span>
                    </div>

                    <template v-if="props.title !== ''">
                        <h1 class="listivo-search-results__title" v-html="props.title"></h1>
                    </template>
                </template>
            </div>

            <div class="listivo-search-results__row-right">
                <?php if ($lstCurrentWidget->showSortBy()) : ?>
                    <div class="listivo-search-results__sort-by">
                        <div class="listivo-search-results__sort-by-label">
                            <?php echo esc_html(tdf_string('sort_by')); ?>
                        </div>

                        <template>
                            <lst-sort-by-options
                                    :options="<?php echo htmlspecialchars(json_encode($lstCurrentWidget->getSortByOptions())); ?>"
                                    :dependencies="props.dependencies"
                                    :sort-by="props.sortBy"
                            >
                                <div slot-scope="sortByOptions">
                                    <lst-select
                                            :options="sortByOptions.options"
                                            @input="props.setSortBy"
                                            :is-selected="props.isSortBy"
                                            active-text-class="listivo-select-v2__option--highlight-text"
                                            highlight-option-class="listivo-select-v2__option--highlight"
                                            order-type="none"
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
                                                @click="select.onOpen"
                                                class="listivo-select-v2 listivo-select-v2--width-auto"
                                                :class="{
                                                        'listivo-select-v2--open': select.open
                                                    }"
                                        >
                                            <div
                                                    class="listivo-select-v2__placeholder"
                                                    v-html="select.getOptionLabel(props.sortBy)"
                                            ></div>

                                            <div class="listivo-select-v2__arrow">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5"
                                                     viewBox="0 0 7 5" fill="none">
                                                    <path d="M3.5 2.56768L5.87477 0.192917C6.13207 -0.0643854 6.54972 -0.0643854 6.80702 0.192917C7.06433 0.45022 7.06433 0.86787 6.80702 1.12517L3.9394 3.99279C3.6964 4.2358 3.30298 4.2358 3.0606 3.99279L0.192977 1.12517C-0.0643257 0.86787 -0.0643257 0.45022 0.192977 0.192917C0.45028 -0.0643854 0.86793 -0.0643854 1.12523 0.192917L3.5 2.56768Z"
                                                          fill="#2A3946"/>
                                                </svg>
                                            </div>

                                            <template>
                                                <div
                                                        v-if="select.open"
                                                        class="listivo-select-v2__dropdown listivo-select-v2__dropdown--auto-width"
                                                >
                                                    <div
                                                            v-for="(option, index) in select.options"
                                                            :key="option.id"
                                                            @click="select.setOption(option)"
                                                            class="listivo-select-v2__option"
                                                            :class="{
                                                                    'listivo-select-v2__option--active': option.selected,
                                                                    'listivo-select-v2__option--highlight': index === select.optionIndex,
                                                                    'listivo-select-v2__option--disabled': option.disabled && !option.selected,
                                                                }"
                                                    >
                                                        <div class="listivo-select-v2__value"
                                                             v-html="option.label"></div>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </lst-select>
                                </div>
                            </lst-sort-by-options>
                        </template>
                    </div>
                <?php endif; ?>

                <?php if ($lstCurrentWidget->showViewSelector()) : ?>
                    <div class="listivo-search-results__views">
                        <div
                                @click.prevent="props.setTemplate('<?php echo esc_attr($lstCurrentWidget->getCardTemplatePath()); ?>')"
                                class="listivo-view-selector"
                                :class="{'listivo-view-selector--active': props.template === 'templates/partials/search_results_card_regular' || props.template === 'templates/partials/search_results_card_small' || props.template === 'templates/partials/search_results_simple_card'}"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                 fill="none">
                                <path d="M2.60078 0.800049C1.61378 0.800049 0.800781 1.61305 0.800781 2.60005V5.80005C0.800781 6.78705 1.61378 7.60005 2.60078 7.60005H5.80078C6.78778 7.60005 7.60078 6.78705 7.60078 5.80005V2.60005C7.60078 1.61305 6.78778 0.800049 5.80078 0.800049H2.60078ZM10.2008 0.800049C9.21378 0.800049 8.40078 1.61305 8.40078 2.60005V5.80005C8.40078 6.78705 9.21378 7.60005 10.2008 7.60005H13.4008C14.3878 7.60005 15.2008 6.78705 15.2008 5.80005V2.60005C15.2008 1.61305 14.3878 0.800049 13.4008 0.800049H10.2008ZM2.60078 2.00005H5.80078C6.13938 2.00005 6.40078 2.26145 6.40078 2.60005V5.80005C6.40078 6.13865 6.13938 6.40005 5.80078 6.40005H2.60078C2.26218 6.40005 2.00078 6.13865 2.00078 5.80005V2.60005C2.00078 2.26145 2.26218 2.00005 2.60078 2.00005ZM10.2008 2.00005H13.4008C13.7394 2.00005 14.0008 2.26145 14.0008 2.60005V5.80005C14.0008 6.13865 13.7394 6.40005 13.4008 6.40005H10.2008C9.86218 6.40005 9.60078 6.13865 9.60078 5.80005V2.60005C9.60078 2.26145 9.86218 2.00005 10.2008 2.00005ZM2.60078 8.40005C1.61378 8.40005 0.800781 9.21305 0.800781 10.2V13.4C0.800781 14.387 1.61378 15.2 2.60078 15.2H5.80078C6.78778 15.2 7.60078 14.387 7.60078 13.4V10.2C7.60078 9.21305 6.78778 8.40005 5.80078 8.40005H2.60078ZM10.2008 8.40005C9.21378 8.40005 8.40078 9.21305 8.40078 10.2V13.4C8.40078 14.387 9.21378 15.2 10.2008 15.2H13.4008C14.3878 15.2 15.2008 14.387 15.2008 13.4V10.2C15.2008 9.21305 14.3878 8.40005 13.4008 8.40005H10.2008ZM2.60078 9.60005H5.80078C6.13938 9.60005 6.40078 9.86145 6.40078 10.2V13.4C6.40078 13.7386 6.13938 14 5.80078 14H2.60078C2.26218 14 2.00078 13.7386 2.00078 13.4V10.2C2.00078 9.86145 2.26218 9.60005 2.60078 9.60005ZM10.2008 9.60005H13.4008C13.7394 9.60005 14.0008 9.86145 14.0008 10.2V13.4C14.0008 13.7386 13.7394 14 13.4008 14H10.2008C9.86218 14 9.60078 13.7386 9.60078 13.4V10.2C9.60078 9.86145 9.86218 9.60005 10.2008 9.60005Z"
                                      fill="#FDFDFE"/>
                            </svg>
                        </div>

                        <div
                                @click.prevent="props.setTemplate('<?php echo esc_attr($lstCurrentWidget->getRowCardTemplatePath()); ?>')"
                                class="listivo-view-selector"
                                :class="{'listivo-view-selector--active': props.template === 'templates/partials/search_results_row' || props.template === 'templates/partials/search_results_row_regular' || props.template === 'templates/partials/search_results_row_regular_v2'}"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                 fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M13.5988 2.00005H2.39883C2.17791 2.00005 1.99883 2.17913 1.99883 2.40005V2.80005C1.99883 3.02096 2.17791 3.20005 2.39883 3.20005H13.5988C13.8197 3.20005 13.9988 3.02096 13.9988 2.80005V2.40005C13.9988 2.17913 13.8197 2.00005 13.5988 2.00005ZM2.39883 0.800049C1.51517 0.800049 0.798828 1.51639 0.798828 2.40005V2.80005C0.798828 3.6837 1.51517 4.40005 2.39883 4.40005H13.5988C14.4825 4.40005 15.1988 3.6837 15.1988 2.80005V2.40005C15.1988 1.51639 14.4825 0.800049 13.5988 0.800049H2.39883Z"
                                      fill="#2A3946"/>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M13.5988 12.8001H2.39883C2.17791 12.8001 1.99883 12.9792 1.99883 13.2001V13.6001C1.99883 13.821 2.17791 14.0001 2.39883 14.0001H13.5988C13.8197 14.0001 13.9988 13.821 13.9988 13.6001V13.2001C13.9988 12.9792 13.8197 12.8001 13.5988 12.8001ZM2.39883 11.6001C1.51517 11.6001 0.798828 12.3164 0.798828 13.2001V13.6001C0.798828 14.4838 1.51517 15.2001 2.39883 15.2001H13.5988C14.4825 15.2001 15.1988 14.4838 15.1988 13.6001V13.2001C15.1988 12.3164 14.4825 11.6001 13.5988 11.6001H2.39883Z"
                                      fill="#2A3946"/>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M13.5988 7.2H2.39883C2.17791 7.2 1.99883 7.37909 1.99883 7.6V8C1.99883 8.22091 2.17791 8.4 2.39883 8.4H13.5988C13.8197 8.4 13.9988 8.22091 13.9988 8V7.6C13.9988 7.37909 13.8197 7.2 13.5988 7.2ZM2.39883 6C1.51517 6 0.798828 6.71634 0.798828 7.6V8C0.798828 8.88366 1.51517 9.6 2.39883 9.6H13.5988C14.4825 9.6 15.1988 8.88366 15.1988 8V7.6C15.1988 6.71634 14.4825 6 13.5988 6H2.39883Z"
                                      fill="#2A3946"/>
                            </svg>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($lstCurrentWidget->showSearchFilters()) : ?>
        <?php get_template_part('templates/widgets/general/search/results_filters'); ?>
    <?php endif; ?>

    <template>
        <div
                class="listivo-search-results__description"
                v-if="props.description !== ''"
                v-html="props.description"
        ></div>
    </template>

    <div v-show="props.count > 0" class="listivo-search-results__list">
        <template>
            <?php if ($lstCurrentWidget->isRegularCardType()) : ?>
                <div
                        v-if="props.inProgress && props.template === 'templates/partials/search_results_card_regular'"
                        class="listivo-listing-grid listivo-listing-grid--cards"
                >
                    <?php get_template_part('templates/partials/card/skeleton_listing_card_v3'); ?>
                </div>
            <?php elseif ($lstCurrentWidget->isSmallCardType()) : ?>
                <div
                        v-if="props.inProgress && props.template === 'templates/partials/search_results_card_small'"
                        class="listivo-listing-grid listivo-listing-grid--small-cards listivo-listing-grid--cards"
                >
                    <?php get_template_part('templates/partials/card/skeleton_listing_card_v4'); ?>
                </div>
            <?php endif; ?>

            <?php if ($lstCurrentWidget->isRowV1CardType()) : ?>
                <div
                        v-if="props.inProgress && (props.template === 'templates/partials/search_results_row' || props.template === 'templates/partials/search_results_row_regular')"
                        class="listivo-listing-grid listivo-listing-grid--rows listivo-listing-grid--1-col"
                >
                    <?php get_template_part('templates/partials/card/skeleton_listing_row'); ?>
                </div>
            <?php elseif ($lstCurrentWidget->isRowV2CardType()) : ?>
                <div
                        v-if="props.inProgress && (props.template === 'templates/partials/search_results_row_regular_v2')"
                        class="listivo-listing-grid listivo-listing-grid--rows-v2 listivo-listing-grid--1-col"
                >
                    <?php get_template_part('templates/partials/card/skeleton_listing_row_v2'); ?>
                </div>
            <?php endif ?>
        </template>

        <div v-show="!props.inProgress">
            <div class="listivo-search-results__list-results">
                <?php get_template_part($lstCurrentWidget->getInitialTemplate()); ?>
            </div>
        </div>
    </div>

    <template>
        <div v-if="props.count > 0" class="listivo-search-results__pagination">
            <div class="listivo-search-results__pagination-desktop">
                <lst-pagination
                        :total-items="props.count"
                        :current-page="props.page"
                        :page-size="<?php echo esc_attr($lstCurrentWidget->getLimit()); ?>"
                        :max-pages="4"
                >
                    <div
                            class="listivo-pagination"
                            slot-scope="pagination"
                    >
                        <div class="listivo-pagination__info">
                            <div class="listivo-pagination__info">
                                <?php echo esc_html(tdf_string('showing')); ?>
                                <span>{{ pagination.startIndex + 1 >= 0 ? pagination.startIndex + 1 : 0
                                    }}</span> <?php echo esc_html(tdf_string('to')); ?>

                                <span>{{ pagination.endIndex + 1 }}</span> <?php echo esc_html(tdf_string('of')); ?>

                                <span>{{ pagination.totalItems
                                    }}</span> <?php echo esc_html(tdf_string('results_lower_case')); ?>
                            </div>
                        </div>

                        <div v-if="pagination.pages.length > 1" class="listivo-pagination__list">
                            <div
                                    :class="{'listivo-pagination__item--disabled': pagination.currentPage <= 1}"
                                    class="listivo-pagination__item"
                                    @click.prevent="props.setPage(props.page - 1)"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                     fill="none">
                                    <path d="M4.86195 10.4713C4.99228 10.6017 5.16262 10.6667 5.33329 10.6667C5.50395 10.6667 5.67429 10.6017 5.80462 10.4713C6.06496 10.211 6.06496 9.78898 5.80462 9.52865L2.27593 5.99996H11.3333C11.7013 5.99996 12 5.70129 12 5.33329C12 4.96528 11.7013 4.66662 11.3333 4.66662H2.27593L5.80462 1.13792C6.06496 0.877589 6.06496 0.455586 5.80462 0.195251C5.54429 -0.0650838 5.12229 -0.0650838 4.86195 0.195251L0.195251 4.86195C-0.0650838 5.12229 -0.0650838 5.54429 0.195251 5.80462L4.86195 10.4713Z"
                                          fill="#2A3946"/>
                                </svg>
                            </div>

                            <div
                                    v-if="pagination.startPage > 1"
                                    class="listivo-pagination__item"
                                    @click.prevent="props.setPage(1)"
                            >
                                1
                            </div>

                            <div
                                    v-if="pagination.startPage > 2"
                                    class="listivo-pagination__item"
                            >
                                ...
                            </div>

                            <div
                                    v-for="page in pagination.pages"
                                    class="listivo-pagination__item"
                                    :class="{'listivo-pagination__item--active': page === props.page}"
                                    @click.prevent="props.setPage(page)"
                            >
                                {{ page }}
                            </div>

                            <div
                                    :class="{'listivo-pagination__item--disabled': pagination.currentPage >= pagination.endPage}"
                                    class="listivo-pagination__item"
                                    @click.prevent="props.setPage(props.page + 1)"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                     fill="none">
                                    <path d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49605 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455586 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z"
                                          fill="#2A3946"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </lst-pagination>
            </div>

            <div class="listivo-search-results__pagination-mobile">
                <lst-pagination
                        :total-items="props.count"
                        :current-page="props.page"
                        :page-size="<?php echo esc_attr($lstCurrentWidget->getLimit()); ?>"
                        :max-pages="3"
                >
                    <div
                            class="listivo-pagination"
                            slot-scope="pagination"
                    >
                        <div class="listivo-pagination__info">
                            <?php echo esc_html(tdf_string('showing')); ?>
                            <span>{{ pagination.startIndex + 1
                                }}</span> <?php echo esc_html(tdf_string('to')); ?>

                            <span>{{ pagination.endIndex + 1 }}</span> <?php echo esc_html(tdf_string('of')); ?>

                            <span>{{ pagination.totalItems
                                }}</span> <?php echo esc_html(tdf_string('results_lower_case')); ?>
                        </div>

                        <div
                                v-if="pagination.pages.length > 1"
                                class="listivo-pagination__list"
                        >
                            <div
                                    :class="{'listivo-pagination__item--disabled': pagination.currentPage <= 1}"
                                    class="listivo-pagination__item"
                                    @click.prevent="props.setPage(props.page - 1)"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                     fill="none">
                                    <path d="M4.86195 10.4713C4.99228 10.6017 5.16262 10.6667 5.33329 10.6667C5.50395 10.6667 5.67429 10.6017 5.80462 10.4713C6.06496 10.211 6.06496 9.78898 5.80462 9.52865L2.27593 5.99996H11.3333C11.7013 5.99996 12 5.70129 12 5.33329C12 4.96528 11.7013 4.66662 11.3333 4.66662H2.27593L5.80462 1.13792C6.06496 0.877589 6.06496 0.455586 5.80462 0.195251C5.54429 -0.0650838 5.12229 -0.0650838 4.86195 0.195251L0.195251 4.86195C-0.0650838 5.12229 -0.0650838 5.54429 0.195251 5.80462L4.86195 10.4713Z"
                                          fill="#2A3946"/>
                                </svg>
                            </div>

                            <div
                                    v-if="pagination.startPage > 1"
                                    class="listivo-pagination__item"
                                    @click.prevent="props.setPage(1)"
                            >
                                1
                            </div>

                            <div
                                    v-if="pagination.startPage > 2"
                                    class="listivo-pagination__item"
                            >
                                ...
                            </div>

                            <div
                                    v-for="page in pagination.pages"
                                    class="listivo-pagination__item"
                                    :class="{'listivo-pagination__item--active': page === props.page}"
                                    @click.prevent="props.setPage(page)"
                            >
                                {{ page }}
                            </div>

                            <div
                                    :class="{'listivo-pagination__item--disabled': pagination.currentPage >= pagination.endPage}"
                                    class="listivo-pagination__item"
                                    @click.prevent="props.setPage(props.page + 1)"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                     fill="none">
                                    <path d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49605 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455586 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z"
                                          fill="#2A3946"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </lst-pagination>
            </div>
        </div>
    </template>
</div>