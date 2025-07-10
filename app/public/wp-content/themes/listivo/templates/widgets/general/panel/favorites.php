<?php
/* @var \Tangibledesign\Listivo\Widgets\General\PanelWidget $lstCurrentWidget */
global $lstCurrentWidget;

get_template_part('templates/widgets/general/panel/header');

$lstInitialCount = tdf_current_user()->getFavoriteNumber();
?>
<div class="listivo-panel-section">
    <lst-panel-favorite-model-list
            class="listivo-container"
            request-url="<?php echo esc_url(tdf_action_url('listivo/panel/favorites')); ?>"
            wrapper-class="listivo-panel-section__favorites"
            initial-template="templates/partials/search_results_row"
            initial-sort-by="<?php echo esc_attr(tdf_app('newest')); ?>"
            :initial-count="<?php echo esc_attr($lstInitialCount); ?>"
    >
        <div class="listivo-container" slot-scope="list">
            <template>
                <div
                        v-if="list.count > 0"
                        class="listivo-panel-section__top"
                >
                    <h1 class="listivo-panel-section__label">
                        <?php echo esc_html($lstCurrentWidget->getTitle()); ?>
                    </h1>

                    <?php get_template_part('templates/widgets/general/panel/packages_bar'); ?>
                </div>
            </template>

            <?php if ($lstInitialCount > 0) : ?>
            <template>
                <?php endif; ?>

                <div
                        v-if="list.count === 0"
                        class="listivo-panel-section__content listivo-panel-section__content--no-margin-top listivo-panel-section__content--with-background"
                >
                    <div class="listivo-panel-no-listings">
                        <h2 class="listivo-panel-no-listings__heading">
                            <?php echo esc_html(tdf_string('no_favorites_text')); ?>
                        </h2>

                        <div class="listivo-panel-no-listings__image">
                            <svg xmlns="http://www.w3.org/2000/svg" width="180" height="143" viewBox="0 0 180 143"
                                 fill="none">
                                <path d="M19.9884 118.147L88.6452 142.463C88.7883 142.463 88.9313 142.606 89.0743 142.606C89.2174 142.606 89.2174 142.606 89.3604 142.606C89.5034 142.606 89.6465 142.606 89.9325 142.606H90.0756C90.3617 142.606 90.5047 142.606 90.7908 142.606H90.9338C91.0768 142.606 91.2199 142.463 91.3629 142.463L160.02 118.147C161.736 117.575 162.88 115.858 162.88 114.142V66.0822L177.184 61.076C178.328 60.6469 179.33 59.6457 179.759 58.5014C180.188 57.3571 180.045 55.9267 179.33 54.7825L162.165 26.1754C162.165 26.1754 162.165 26.1754 162.165 26.0324C162.165 25.8894 162.022 25.8894 162.022 25.7463C162.022 25.7463 162.022 25.7463 162.022 25.6033C162.022 25.4603 161.879 25.4603 161.879 25.3172L161.736 25.1742C161.736 25.1742 161.736 25.1742 161.593 25.0312C161.593 25.0312 161.593 25.0312 161.45 25.0312C161.307 25.0312 161.307 24.8881 161.164 24.8881L161.021 24.7451C161.021 24.7451 161.021 24.7451 160.878 24.7451H160.735C160.592 24.7451 160.592 24.602 160.449 24.602C160.306 24.602 160.306 24.602 160.163 24.459C160.163 24.459 160.163 24.459 160.02 24.459L91.3629 0.143033C91.0768 -2.17557e-06 90.7908 0 90.5047 0H90.3616C90.0756 0 89.9325 0 89.6465 0C89.5034 0 89.5034 0 89.3604 0C89.0743 0 88.7883 0.143033 88.5022 0.143033L19.8453 24.459C19.8453 24.459 19.7023 24.459 19.7023 24.602C19.5592 24.7451 19.2732 24.7451 19.1301 24.8881C18.8441 25.0312 18.558 25.3172 18.2719 25.6033L18.1289 25.7463C17.9859 25.8894 17.9859 26.0324 17.8428 26.0324C17.8428 26.0324 17.8428 26.0324 17.6998 26.1754L0.535571 54.7825C-0.0365694 55.7837 -0.179604 57.2141 0.249501 58.3583C0.678607 59.5026 1.67985 60.5039 2.82413 60.933L17.1276 65.9392V114.142C17.1276 116.002 18.2719 117.575 19.9884 118.147ZM154.441 111.138L94.3666 132.451V97.9791C94.3666 95.5475 92.5072 93.688 90.0756 93.688C87.644 93.688 85.7845 95.5475 85.7845 97.9791V132.451L25.7098 111.138V69.086L71.481 85.249C71.9101 85.392 72.4823 85.535 72.9114 85.535C74.3417 85.535 75.7721 84.8198 76.6303 83.3895L90.0756 60.933L103.521 83.3895C104.379 84.8198 105.809 85.535 107.24 85.535C107.669 85.535 108.241 85.392 108.67 85.249L154.441 69.086V111.138ZM94.3666 10.0125L145.859 28.321L94.3666 46.6295V10.0125ZM109.099 76.0947L96.3691 54.9255L156.73 33.4702L169.46 54.6394L109.099 76.0947ZM23.2782 33.4702L83.639 54.9255L70.9089 76.0947L10.548 54.6394L23.2782 33.4702Z"
                                      fill="#D5E3EE"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <?php if ($lstInitialCount > 0) : ?>
            </template>
        <?php endif; ?>

            <?php if ($lstInitialCount > 0) : ?>
                <div
                        v-if="list.count > 0"
                        class="listivo-panel-section__bar listivo-panel-section__bar--break-mobile"
                >
                    <div class="listivo-panel-section__results">
                        <div v-if="false">
                            <?php echo esc_html($lstInitialCount . ' ' . tdf_string('results')); ?>
                        </div>

                        <template>
                            {{ list.count }} <?php echo esc_html(tdf_string('results')); ?>
                        </template>
                    </div>

                    <div class="listivo-panel-section__bar-right listivo-panel-section__bar-right--no-margin-top">
                        <div class="listivo-panel-section__sort-by">
                            <span>
                                <?php echo esc_html(tdf_string('sort_by')); ?>
                            </span>

                            <lst-select
                                    class="listivo-select-v2 listivo-select-v2--width-auto"
                                    :options="<?php echo htmlspecialchars(json_encode($lstCurrentWidget->getSortByOptions())); ?>"
                                    @input="list.setSortBy"
                                    :is-selected="list.isSortBy"
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
                                            v-html="select.getOptionById(list.sortBy).label"
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
                                                <div class="listivo-select-v2__value" v-html="option.label"></div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </lst-select>
                        </div>

                        <div class="listivo-panel-section__view-selector">
                            <div
                                    @click.prevent="list.setTemplate('templates/partials/search_results_card_small')"
                                    class="listivo-view-selector"
                                    :class="{'listivo-view-selector--active': list.template === 'templates/partials/search_results_card_small'}"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                     fill="none">
                                    <path d="M2.60078 0.800049C1.61378 0.800049 0.800781 1.61305 0.800781 2.60005V5.80005C0.800781 6.78705 1.61378 7.60005 2.60078 7.60005H5.80078C6.78778 7.60005 7.60078 6.78705 7.60078 5.80005V2.60005C7.60078 1.61305 6.78778 0.800049 5.80078 0.800049H2.60078ZM10.2008 0.800049C9.21378 0.800049 8.40078 1.61305 8.40078 2.60005V5.80005C8.40078 6.78705 9.21378 7.60005 10.2008 7.60005H13.4008C14.3878 7.60005 15.2008 6.78705 15.2008 5.80005V2.60005C15.2008 1.61305 14.3878 0.800049 13.4008 0.800049H10.2008ZM2.60078 2.00005H5.80078C6.13938 2.00005 6.40078 2.26145 6.40078 2.60005V5.80005C6.40078 6.13865 6.13938 6.40005 5.80078 6.40005H2.60078C2.26218 6.40005 2.00078 6.13865 2.00078 5.80005V2.60005C2.00078 2.26145 2.26218 2.00005 2.60078 2.00005ZM10.2008 2.00005H13.4008C13.7394 2.00005 14.0008 2.26145 14.0008 2.60005V5.80005C14.0008 6.13865 13.7394 6.40005 13.4008 6.40005H10.2008C9.86218 6.40005 9.60078 6.13865 9.60078 5.80005V2.60005C9.60078 2.26145 9.86218 2.00005 10.2008 2.00005ZM2.60078 8.40005C1.61378 8.40005 0.800781 9.21305 0.800781 10.2V13.4C0.800781 14.387 1.61378 15.2 2.60078 15.2H5.80078C6.78778 15.2 7.60078 14.387 7.60078 13.4V10.2C7.60078 9.21305 6.78778 8.40005 5.80078 8.40005H2.60078ZM10.2008 8.40005C9.21378 8.40005 8.40078 9.21305 8.40078 10.2V13.4C8.40078 14.387 9.21378 15.2 10.2008 15.2H13.4008C14.3878 15.2 15.2008 14.387 15.2008 13.4V10.2C15.2008 9.21305 14.3878 8.40005 13.4008 8.40005H10.2008ZM2.60078 9.60005H5.80078C6.13938 9.60005 6.40078 9.86145 6.40078 10.2V13.4C6.40078 13.7386 6.13938 14 5.80078 14H2.60078C2.26218 14 2.00078 13.7386 2.00078 13.4V10.2C2.00078 9.86145 2.26218 9.60005 2.60078 9.60005ZM10.2008 9.60005H13.4008C13.7394 9.60005 14.0008 9.86145 14.0008 10.2V13.4C14.0008 13.7386 13.7394 14 13.4008 14H10.2008C9.86218 14 9.60078 13.7386 9.60078 13.4V10.2C9.60078 9.86145 9.86218 9.60005 10.2008 9.60005Z"
                                          fill="#FDFDFE"/>
                                </svg>
                            </div>

                            <div
                                    @click.prevent="list.setTemplate('templates/partials/search_results_row')"
                                    class="listivo-view-selector"
                                    :class="{'listivo-view-selector--active': list.template === 'templates/partials/search_results_row'}"
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
                    </div>
                </div>

                <template>
                    <div v-show="!list.inProgress">
                        <div class="listivo-panel-section__favorites"></div>
                    </div>
                </template>
            <?php endif; ?>
        </div>
    </lst-panel-favorite-model-list>
</div>