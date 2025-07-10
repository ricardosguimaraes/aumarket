<?php
/* @var \Tangibledesign\Listivo\Widgets\General\PanelWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstModels = $lstCurrentWidget->getModerationModels();
$lstMainCategory = tdf_settings()->getMainCategory();


get_template_part('templates/widgets/general/panel/header');
?>
<div class="listivo-panel-section">
    <lst-panel-model-moderation
            request-url="<?php echo esc_url(tdf_action_url('listivo/panel/moderation/models')); ?>"
            td-nonce="<?php echo esc_attr(wp_create_nonce('listivo/panel/moderation/models')); ?>"
            scroll-to-selector=".listivo-moderation__content"
            prefix="listivo"
            wrapper-class="listivo-moderation__content"
    >
        <div slot-scope="list" class="listivo-container">
            <div class="listivo-panel-section__top">
                <h1 class="listivo-panel-section__label">
                    <?php echo esc_html($lstCurrentWidget->getTitle()); ?>
                </h1>

                <?php get_template_part('templates/widgets/general/panel/packages_bar'); ?>
            </div>

            <div class="listivo-panel-section__bar">
                <div class="listivo-panel-tabs">
                    <div
                            @click="list.setStatus('any')"
                            class="listivo-panel-tabs__tab listivo-panel-tab"
                            :class="{'listivo-panel-tab--active': list.status === 'any'}"
                    >
                        <?php echo esc_html(tdf_string('all')) ?>

                        <div class="listivo-panel-tab__count">
                            <?php echo esc_html($lstCurrentWidget->getAllListingNumber()); ?>
                        </div>
                    </div>

                    <div
                            @click="list.setStatus('publish')"
                            class="listivo-panel-tabs__tab listivo-panel-tab"
                            :class="{'listivo-panel-tab--active': list.status === 'publish'}"
                    >
                        <?php echo esc_html(tdf_string('active')) ?>

                        <div class="listivo-panel-tab__count">
                            <?php echo esc_html($lstCurrentWidget->getActiveListingNumber()); ?>
                        </div>
                    </div>

                    <div
                            @click="list.setStatus('pending')"
                            class="listivo-panel-tabs__tab listivo-panel-tab"
                            :class="{'listivo-panel-tab--active': list.status === 'pending'}"
                    >
                        <?php echo esc_html(tdf_string('pending')) ?>

                        <div class="listivo-panel-tab__count">
                            <?php echo esc_html($lstCurrentWidget->getPendingListingNumber()); ?>
                        </div>
                    </div>

                    <div
                            @click="list.setStatus('draft')"
                            class="listivo-panel-tabs__tab listivo-panel-tab"
                            :class="{'listivo-panel-tab--active': list.status === 'draft'}"
                    >
                        <?php echo esc_html(tdf_string('draft')) ?>

                        <div class="listivo-panel-tab__count">
                            <?php echo esc_html($lstCurrentWidget->getDraftListingNumber()); ?>
                        </div>
                    </div>
                </div>

                <div class="listivo-panel-section__bar-right">
                    <div class="listivo-panel-section__sort-by">
                        <template>
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
                        </template>
                    </div>

                    <div class="listivo-panel-section__search">
                        <div
                                class="listivo-input-v2"
                                :class="{'listivo-input-v2--active': list.keyword !== ''}"
                        >
                            <input
                                    placeholder="<?php echo esc_attr(tdf_string('search')); ?>"
                                    @input="list.setKeyword($event.target.value)"
                                    :value="list.keyword"
                                    type="text"
                            >

                            <template>
                                <div
                                        v-if="list.keyword !== ''"
                                        class="listivo-input-v2__clear"
                                        @click.stop.prevent="list.setKeyword('')"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="6" height="6" viewBox="0 0 6 6"
                                         fill="none">
                                        <path d="M0.667016 0.000289049C0.534874 0.000452754 0.405782 0.0400233 0.296228 0.113946C0.186675 0.187868 0.101634 0.292787 0.05197 0.415298C0.00230608 0.53781 -0.00972662 0.672352 0.0174091 0.801739C0.0445448 0.931126 0.109617 1.04948 0.204313 1.14169L2.06032 2.99857L0.204313 4.85546C0.140536 4.91672 0.0896183 4.9901 0.0545414 5.07129C0.0194646 5.15249 0.000933792 5.23987 3.43907e-05 5.32832C-0.00086501 5.41677 0.0158851 5.50452 0.0493036 5.58641C0.0827221 5.6683 0.132137 5.7427 0.194655 5.80525C0.257173 5.8678 0.331537 5.91724 0.413391 5.95067C0.495245 5.9841 0.582945 6.00086 0.671354 5.99996C0.759763 5.99906 0.847104 5.98052 0.928262 5.94543C1.00942 5.91034 1.08276 5.85939 1.144 5.79559L3 3.9387L4.856 5.79559C4.91723 5.85939 4.99058 5.91034 5.07173 5.94543C5.15289 5.98053 5.24023 5.99907 5.32864 5.99997C5.41705 6.00087 5.50475 5.98411 5.58661 5.95067C5.66846 5.91724 5.74283 5.8678 5.80535 5.80525C5.86786 5.74271 5.91728 5.66831 5.9507 5.58641C5.98412 5.50452 6.00087 5.41678 5.99997 5.32832C5.99907 5.23987 5.98053 5.15249 5.94546 5.07129C5.91038 4.9901 5.85946 4.91672 5.79568 4.85546L3.93968 2.99857L5.79568 1.14169C5.89171 1.0483 5.9573 0.928073 5.98385 0.796753C6.01041 0.665433 5.99669 0.529151 5.94449 0.405766C5.8923 0.282381 5.80407 0.177648 5.69136 0.105294C5.57865 0.0329402 5.44672 -0.00366036 5.31286 0.000289049C5.14022 0.00543568 4.97636 0.0776237 4.856 0.20156L3 2.05844L1.144 0.20156C1.08199 0.137793 1.00783 0.0871234 0.925898 0.0525512C0.843967 0.017979 0.755935 0.000207391 0.667016 0.000289049Z"
                                              fill="#F09965"/>
                                    </svg>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <div class="listivo-panel-section__content">
                <template>
                    <div v-show="!list.inProgress">
                        <div class="listivo-moderation">
                            <div class="listivo-moderation__inner">
                                <div
                                        v-if="list.count === 0"
                                        class="listivo-panel-no-listings listivo-panel-no-listings--with-padding"
                                >
                                    <h2
                                            v-if="list.status === 'any'"
                                            class="listivo-panel-no-listings__heading"
                                    >
                                        <?php echo esc_html(tdf_string('no_listings')); ?>
                                    </h2>

                                    <h2
                                            v-if="list.status === 'publish'"
                                            class="listivo-panel-no-listings__heading"
                                    >
                                        <?php echo esc_html(tdf_string('no_active_listings')); ?>
                                    </h2>

                                    <h2
                                            v-if="list.status === 'pending'"
                                            class="listivo-panel-no-listings__heading"
                                    >
                                        <?php echo esc_html(tdf_string('no_pending_listings')); ?>
                                    </h2>

                                    <h2
                                            v-if="list.status === 'draft'"
                                            class="listivo-panel-no-listings__heading"
                                    >
                                        <?php echo esc_html(tdf_string('no_draft_listings')); ?>
                                    </h2>

                                    <div class="listivo-panel-no-listings__image">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="180" height="143"
                                             viewBox="0 0 180 143"
                                             fill="none">
                                            <path d="M19.9884 118.147L88.6452 142.463C88.7883 142.463 88.9313 142.606 89.0743 142.606C89.2174 142.606 89.2174 142.606 89.3604 142.606C89.5034 142.606 89.6465 142.606 89.9325 142.606H90.0756C90.3617 142.606 90.5047 142.606 90.7908 142.606H90.9338C91.0768 142.606 91.2199 142.463 91.3629 142.463L160.02 118.147C161.736 117.575 162.88 115.858 162.88 114.142V66.0822L177.184 61.076C178.328 60.6469 179.33 59.6457 179.759 58.5014C180.188 57.3571 180.045 55.9267 179.33 54.7825L162.165 26.1754C162.165 26.1754 162.165 26.1754 162.165 26.0324C162.165 25.8894 162.022 25.8894 162.022 25.7463C162.022 25.7463 162.022 25.7463 162.022 25.6033C162.022 25.4603 161.879 25.4603 161.879 25.3172L161.736 25.1742C161.736 25.1742 161.736 25.1742 161.593 25.0312C161.593 25.0312 161.593 25.0312 161.45 25.0312C161.307 25.0312 161.307 24.8881 161.164 24.8881L161.021 24.7451C161.021 24.7451 161.021 24.7451 160.878 24.7451H160.735C160.592 24.7451 160.592 24.602 160.449 24.602C160.306 24.602 160.306 24.602 160.163 24.459C160.163 24.459 160.163 24.459 160.02 24.459L91.3629 0.143033C91.0768 -2.17557e-06 90.7908 0 90.5047 0H90.3616C90.0756 0 89.9325 0 89.6465 0C89.5034 0 89.5034 0 89.3604 0C89.0743 0 88.7883 0.143033 88.5022 0.143033L19.8453 24.459C19.8453 24.459 19.7023 24.459 19.7023 24.602C19.5592 24.7451 19.2732 24.7451 19.1301 24.8881C18.8441 25.0312 18.558 25.3172 18.2719 25.6033L18.1289 25.7463C17.9859 25.8894 17.9859 26.0324 17.8428 26.0324C17.8428 26.0324 17.8428 26.0324 17.6998 26.1754L0.535571 54.7825C-0.0365694 55.7837 -0.179604 57.2141 0.249501 58.3583C0.678607 59.5026 1.67985 60.5039 2.82413 60.933L17.1276 65.9392V114.142C17.1276 116.002 18.2719 117.575 19.9884 118.147ZM154.441 111.138L94.3666 132.451V97.9791C94.3666 95.5475 92.5072 93.688 90.0756 93.688C87.644 93.688 85.7845 95.5475 85.7845 97.9791V132.451L25.7098 111.138V69.086L71.481 85.249C71.9101 85.392 72.4823 85.535 72.9114 85.535C74.3417 85.535 75.7721 84.8198 76.6303 83.3895L90.0756 60.933L103.521 83.3895C104.379 84.8198 105.809 85.535 107.24 85.535C107.669 85.535 108.241 85.392 108.67 85.249L154.441 69.086V111.138ZM94.3666 10.0125L145.859 28.321L94.3666 46.6295V10.0125ZM109.099 76.0947L96.3691 54.9255L156.73 33.4702L169.46 54.6394L109.099 76.0947ZM23.2782 33.4702L83.639 54.9255L70.9089 76.0947L10.548 54.6394L23.2782 33.4702Z"
                                                  fill="#D5E3EE"/>
                                        </svg>
                                    </div>

                                    <div class="listivo-panel-no-listings__button">
                                        <button
                                                class="listivo-button listivo-button--primary-2"
                                                @click="list.setStatus('any')"
                                        >
                                            <span>
                                                <?php echo esc_html(tdf_string('show_all')); ?>

                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11"
                                                     viewBox="0 0 12 11"
                                                     fill="none">
                                                    <path d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49605 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455586 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z"
                                                          fill="#FDFDFE"/>
                                                </svg>
                                            </span>
                                        </button>
                                    </div>
                                </div>

                                <div v-show="list.count > 0">
                                    <div class="listivo-moderation__row listivo-moderation__row--head">
                                        <div class="listivo-moderation__head-column">
                                            <?php echo esc_html(tdf_string('listing')); ?>
                                        </div>

                                        <div class="listivo-moderation__head-column">
                                            <?php echo esc_html(tdf_string('user')); ?>
                                        </div>

                                        <div class="listivo-moderation__head-column">
                                            <?php echo esc_html(tdf_string('status')); ?>
                                        </div>

                                        <div class="listivo-moderation__head-column">
                                            <?php echo esc_html(tdf_string('actions')); ?>
                                        </div>
                                    </div>

                                    <div class="listivo-moderation__content"></div>
                                </div>
                            </div>

                            <div class="listivo-moderation__pagination">
                                <lst-pagination
                                        :total-items="list.count"
                                        :current-page="list.page"
                                        :page-size="10"
                                        :max-pages="7"
                                >
                                    <div
                                            class="listivo-pagination"
                                            slot-scope="pagination"
                                    >
                                        <div v-if="list.count > 0" class="listivo-pagination__info">
                                            <div class="listivo-pagination__info">
                                                <?php echo esc_html(tdf_string('showing')); ?>
                                                <span>{{ pagination.startIndex + 1 >= 0 ? pagination.startIndex + 1
                                                    : 0
                                                    }}</span> <?php echo esc_html(tdf_string('to')); ?>

                                                <span>{{ pagination.endIndex + 1
                                                    }}</span> <?php echo esc_html(tdf_string('of')); ?>

                                                <span>{{ pagination.totalItems
                                                    }}</span> <?php echo esc_html(tdf_string('results_lower_case')); ?>
                                            </div>
                                        </div>

                                        <div v-if="pagination.pages.length > 1" class="listivo-pagination__list">
                                            <div
                                                    :class="{'listivo-pagination__item--disabled': pagination.currentPage <= 1}"
                                                    class="listivo-pagination__item"
                                                    @click.prevent="list.setPage(list.page - 1)"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11"
                                                     viewBox="0 0 12 11"
                                                     fill="none">
                                                    <path d="M4.86195 10.4713C4.99228 10.6017 5.16262 10.6667 5.33329 10.6667C5.50395 10.6667 5.67429 10.6017 5.80462 10.4713C6.06496 10.211 6.06496 9.78898 5.80462 9.52865L2.27593 5.99996H11.3333C11.7013 5.99996 12 5.70129 12 5.33329C12 4.96528 11.7013 4.66662 11.3333 4.66662H2.27593L5.80462 1.13792C6.06496 0.877589 6.06496 0.455586 5.80462 0.195251C5.54429 -0.0650838 5.12229 -0.0650838 4.86195 0.195251L0.195251 4.86195C-0.0650838 5.12229 -0.0650838 5.54429 0.195251 5.80462L4.86195 10.4713Z"
                                                          fill="#2A3946"/>
                                                </svg>
                                            </div>

                                            <div
                                                    v-if="pagination.startPage > 1"
                                                    class="listivo-pagination__item"
                                                    @click.prevent="list.setPage(1)"
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
                                                    :class="{'listivo-pagination__item--active': page === list.page}"
                                                    @click.prevent="list.setPage(page)"
                                            >
                                                {{ page }}
                                            </div>

                                            <div
                                                    :class="{'listivo-pagination__item--disabled': pagination.currentPage >= pagination.endPage}"
                                                    class="listivo-pagination__item"
                                                    @click.prevent="list.setPage(list.page + 1)"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11"
                                                     viewBox="0 0 12 11"
                                                     fill="none">
                                                    <path d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49605 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455586 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z"
                                                          fill="#2A3946"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </lst-pagination>
                            </div>

                            <div class="listivo-moderation__mobile-pagination">
                                <lst-pagination
                                        :total-items="list.count"
                                        :current-page="list.page"
                                        :page-size="10"
                                        :max-pages="3"
                                >
                                    <div
                                            class="listivo-pagination"
                                            slot-scope="pagination"
                                    >
                                        <div v-if="list.count > 0" class="listivo-pagination__info">
                                            <div class="listivo-pagination__info">
                                                <?php echo esc_html(tdf_string('showing')); ?>
                                                <span>{{ pagination.startIndex + 1 >= 0 ? pagination.startIndex + 1
                                                    : 0
                                                    }}</span> <?php echo esc_html(tdf_string('to')); ?>

                                                <span>{{ pagination.endIndex + 1
                                                    }}</span> <?php echo esc_html(tdf_string('of')); ?>

                                                <span>{{ pagination.totalItems
                                                    }}</span> <?php echo esc_html(tdf_string('results_lower_case')); ?>
                                            </div>
                                        </div>

                                        <div v-if="pagination.pages.length > 1" class="listivo-pagination__list">
                                            <div
                                                    :class="{'listivo-pagination__item--disabled': pagination.currentPage <= 1}"
                                                    class="listivo-pagination__item"
                                                    @click.prevent="list.setPage(list.page - 1)"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11"
                                                     viewBox="0 0 12 11"
                                                     fill="none">
                                                    <path d="M4.86195 10.4713C4.99228 10.6017 5.16262 10.6667 5.33329 10.6667C5.50395 10.6667 5.67429 10.6017 5.80462 10.4713C6.06496 10.211 6.06496 9.78898 5.80462 9.52865L2.27593 5.99996H11.3333C11.7013 5.99996 12 5.70129 12 5.33329C12 4.96528 11.7013 4.66662 11.3333 4.66662H2.27593L5.80462 1.13792C6.06496 0.877589 6.06496 0.455586 5.80462 0.195251C5.54429 -0.0650838 5.12229 -0.0650838 4.86195 0.195251L0.195251 4.86195C-0.0650838 5.12229 -0.0650838 5.54429 0.195251 5.80462L4.86195 10.4713Z"
                                                          fill="#2A3946"/>
                                                </svg>
                                            </div>

                                            <div
                                                    v-if="pagination.startPage > 1"
                                                    class="listivo-pagination__item"
                                                    @click.prevent="list.setPage(1)"
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
                                                    :class="{'listivo-pagination__item--active': page === list.page}"
                                                    @click.prevent="list.setPage(page)"
                                            >
                                                {{ page }}
                                            </div>

                                            <div
                                                    :class="{'listivo-pagination__item--disabled': pagination.currentPage >= pagination.endPage}"
                                                    class="listivo-pagination__item"
                                                    @click.prevent="list.setPage(list.page + 1)"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11"
                                                     viewBox="0 0 12 11"
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
                    </div>
                </template>
            </div>
        </div>
    </lst-panel-model-moderation>
</div>