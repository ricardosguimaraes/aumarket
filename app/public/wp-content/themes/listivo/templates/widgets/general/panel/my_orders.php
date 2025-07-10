<?php

use Tangibledesign\Framework\Models\Payments\OrderStatus;
use Tangibledesign\Listivo\Widgets\General\PanelWidget;

/* @var PanelWidget $lstCurrentWidget */
global $lstCurrentWidget;

if (!tdf_current_user()) {
    return;
}

get_template_part('templates/widgets/general/panel/header');

if (!tdf_current_user()->hasOrders()) : ?>
    <div class="listivo-panel-section">
        <div class="listivo-container">
            <div class="listivo-panel-section__content listivo-panel-section__content--no-margin-top listivo-panel-section__content--with-background">
                <div class="listivo-panel-no-listings">
                    <h2 class="listivo-panel-no-listings__heading">
                        <?php echo esc_html(tdf_string('no_orders_yet')); ?>
                    </h2>

                    <div class="listivo-panel-no-listings__image">
                        <svg xmlns="http://www.w3.org/2000/svg" width="180" height="143" viewBox="0 0 180 143"
                             fill="none">
                            <path d="M19.9884 118.147L88.6452 142.463C88.7883 142.463 88.9313 142.606 89.0743 142.606C89.2174 142.606 89.2174 142.606 89.3604 142.606C89.5034 142.606 89.6465 142.606 89.9325 142.606H90.0756C90.3617 142.606 90.5047 142.606 90.7908 142.606H90.9338C91.0768 142.606 91.2199 142.463 91.3629 142.463L160.02 118.147C161.736 117.575 162.88 115.858 162.88 114.142V66.0822L177.184 61.076C178.328 60.6469 179.33 59.6457 179.759 58.5014C180.188 57.3571 180.045 55.9267 179.33 54.7825L162.165 26.1754C162.165 26.1754 162.165 26.1754 162.165 26.0324C162.165 25.8894 162.022 25.8894 162.022 25.7463C162.022 25.7463 162.022 25.7463 162.022 25.6033C162.022 25.4603 161.879 25.4603 161.879 25.3172L161.736 25.1742C161.736 25.1742 161.736 25.1742 161.593 25.0312C161.593 25.0312 161.593 25.0312 161.45 25.0312C161.307 25.0312 161.307 24.8881 161.164 24.8881L161.021 24.7451C161.021 24.7451 161.021 24.7451 160.878 24.7451H160.735C160.592 24.7451 160.592 24.602 160.449 24.602C160.306 24.602 160.306 24.602 160.163 24.459C160.163 24.459 160.163 24.459 160.02 24.459L91.3629 0.143033C91.0768 -2.17557e-06 90.7908 0 90.5047 0H90.3616C90.0756 0 89.9325 0 89.6465 0C89.5034 0 89.5034 0 89.3604 0C89.0743 0 88.7883 0.143033 88.5022 0.143033L19.8453 24.459C19.8453 24.459 19.7023 24.459 19.7023 24.602C19.5592 24.7451 19.2732 24.7451 19.1301 24.8881C18.8441 25.0312 18.558 25.3172 18.2719 25.6033L18.1289 25.7463C17.9859 25.8894 17.9859 26.0324 17.8428 26.0324C17.8428 26.0324 17.8428 26.0324 17.6998 26.1754L0.535571 54.7825C-0.0365694 55.7837 -0.179604 57.2141 0.249501 58.3583C0.678607 59.5026 1.67985 60.5039 2.82413 60.933L17.1276 65.9392V114.142C17.1276 116.002 18.2719 117.575 19.9884 118.147ZM154.441 111.138L94.3666 132.451V97.9791C94.3666 95.5475 92.5072 93.688 90.0756 93.688C87.644 93.688 85.7845 95.5475 85.7845 97.9791V132.451L25.7098 111.138V69.086L71.481 85.249C71.9101 85.392 72.4823 85.535 72.9114 85.535C74.3417 85.535 75.7721 84.8198 76.6303 83.3895L90.0756 60.933L103.521 83.3895C104.379 84.8198 105.809 85.535 107.24 85.535C107.669 85.535 108.241 85.392 108.67 85.249L154.441 69.086V111.138ZM94.3666 10.0125L145.859 28.321L94.3666 46.6295V10.0125ZM109.099 76.0947L96.3691 54.9255L156.73 33.4702L169.46 54.6394L109.099 76.0947ZM23.2782 33.4702L83.639 54.9255L70.9089 76.0947L10.548 54.6394L23.2782 33.4702Z"
                                  fill="#D5E3EE"/>
                        </svg>
                    </div>

                    <div class="listivo-panel-no-listings__button">
                        <?php if (tdf_payment_packages()->isNotEmpty()) : ?>
                            <a
                                    class="listivo-button listivo-button--primary-2"
                                    href="<?php echo esc_url(PanelWidget::getUrl(\Tangibledesign\Framework\Widgets\General\PanelWidget::ACTION_BUY_PACKAGE)); ?>"
                            >
                                <span>
                                    <?php echo esc_html(tdf_string('buy_the_package')); ?>

                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11"
                                         viewBox="0 0 12 11"
                                         fill="none">
                                        <path d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49605 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455586 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z"
                                              fill="#FDFDFE"/>
                                    </svg>
                                </span>
                            </a>
                        <?php elseif (tdf_settings()->subscriptionsEnabled()) : ?>
                            <a
                                    class="listivo-button listivo-button--primary-2"
                                    href="<?php echo esc_url(PanelWidget::getUrl(\Tangibledesign\Framework\Widgets\General\PanelWidget::ACTION_SELECT_SUBSCRIPTION)); ?>"
                            >
                                <span>
                                    <?php echo esc_html(tdf_string('choose_subscription')); ?>

                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11"
                                         viewBox="0 0 12 11"
                                         fill="none">
                                        <path d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49605 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455586 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z"
                                              fill="#FDFDFE"/>
                                    </svg>
                                </span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    return;
endif;
?>
<lst-panel-my-orders
        request-url="<?php echo esc_url(tdf_action_url('listivo/panel/user/orders')); ?>"
        scroll-to-selector=".listivo-panel-section__content"
>
    <div slot-scope="myOrders" class="listivo-panel-section listivo-panel-orders">
        <div class="listivo-container">
            <div class="listivo-panel-section__top">
                <h1 class="listivo-panel-section__label">
                    <?php echo esc_html($lstCurrentWidget->getTitle()); ?>
                </h1>
            </div>

            <div class="listivo-panel-orders__top">
                <div class="listivo-panel-orders__tabs">
                    <div class="listivo-panel-tabs">
                        <div
                                @click="myOrders.setStatus('any')"
                                class="listivo-panel-tabs__tab listivo-panel-tab"
                                :class="{'listivo-panel-tab--active': myOrders.status === 'any'}"
                        >
                            <?php echo esc_html(tdf_string('all')) ?>

                            <div class="listivo-panel-tab__count">
                                <?php echo esc_html(tdf_current_user()->getOrdersNumber()); ?>
                            </div>
                        </div>

                        <?php if (!empty(tdf_current_user()->getOrdersNumber(OrderStatus::COMPLETED))) : ?>
                            <div
                                    @click="myOrders.setStatus('<?php echo esc_attr(OrderStatus::COMPLETED); ?>')"
                                    class="listivo-panel-tabs__tab listivo-panel-tab"
                                    :class="{'listivo-panel-tab--active': myOrders.status === '<?php echo esc_attr(OrderStatus::COMPLETED); ?>'}"
                            >
                                <?php echo esc_html(tdf_string('completed')) ?>

                                <div class="listivo-panel-tab__count">
                                    <?php echo esc_html(tdf_current_user()->getOrdersNumber(OrderStatus::COMPLETED)); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty(tdf_current_user()->getOrdersNumber(OrderStatus::PROCESSING))) : ?>
                            <div
                                    @click="myOrders.setStatus('<?php echo esc_attr(OrderStatus::PROCESSING); ?>')"
                                    class="listivo-panel-tabs__tab listivo-panel-tab"
                                    :class="{'listivo-panel-tab--active': myOrders.status === '<?php echo esc_attr(OrderStatus::PROCESSING); ?>'}"
                            >
                                <?php echo esc_html(tdf_string('processing')) ?>

                                <div class="listivo-panel-tab__count">
                                    <?php echo esc_html(tdf_current_user()->getOrdersNumber(OrderStatus::PROCESSING)); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty(tdf_current_user()->getOrdersNumber(OrderStatus::PENDING))) : ?>
                            <div
                                    @click="myOrders.setStatus('<?php echo esc_attr(OrderStatus::PENDING); ?>')"
                                    class="listivo-panel-tabs__tab listivo-panel-tab"
                                    :class="{'listivo-panel-tab--active': myOrders.status === '<?php echo esc_attr(OrderStatus::PENDING); ?>'}"
                            >
                                <?php echo esc_html(tdf_string('pending')) ?>

                                <div class="listivo-panel-tab__count">
                                    <?php echo esc_html(tdf_current_user()->getOrdersNumber(OrderStatus::PENDING)); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty(tdf_current_user()->getOrdersNumber(OrderStatus::ON_HOLD))) : ?>
                            <div
                                    @click="myOrders.setStatus('<?php echo esc_attr(OrderStatus::ON_HOLD); ?>')"
                                    class="listivo-panel-tabs__tab listivo-panel-tab"
                                    :class="{'listivo-panel-tab--active': myOrders.status === '<?php echo esc_attr(OrderStatus::ON_HOLD); ?>'}"
                            >
                                <?php echo esc_html(tdf_string('on_hold')) ?>

                                <div class="listivo-panel-tab__count">
                                    <?php echo esc_html(tdf_current_user()->getOrdersNumber(OrderStatus::ON_HOLD)); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty(tdf_current_user()->getOrdersNumber(OrderStatus::REFUNDED))) : ?>
                            <div
                                    @click="myOrders.setStatus('<?php echo esc_attr(OrderStatus::REFUNDED); ?>')"
                                    class="listivo-panel-tabs__tab listivo-panel-tab"
                                    :class="{'listivo-panel-tab--active': myOrders.status === '<?php echo esc_attr(OrderStatus::REFUNDED); ?>'}"
                            >
                                <?php echo esc_html(tdf_string('refunded')) ?>

                                <div class="listivo-panel-tab__count">
                                    <?php echo esc_html(tdf_current_user()->getOrdersNumber(OrderStatus::REFUNDED)); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty(tdf_current_user()->getOrdersNumber(OrderStatus::CANCELLED))) : ?>
                            <div
                                    @click="myOrders.setStatus('<?php echo esc_attr(OrderStatus::CANCELLED); ?>')"
                                    class="listivo-panel-tabs__tab listivo-panel-tab"
                                    :class="{'listivo-panel-tab--active': myOrders.status === '<?php echo esc_attr(OrderStatus::CANCELLED); ?>'}"
                            >
                                <?php echo esc_html(tdf_string('cancelled')) ?>

                                <div class="listivo-panel-tab__count">
                                    <?php echo esc_html(tdf_current_user()->getOrdersNumber(OrderStatus::CANCELLED)); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty(tdf_current_user()->getOrdersNumber(OrderStatus::FAILED))) : ?>
                            <div
                                    @click="myOrders.setStatus('<?php echo esc_attr(OrderStatus::FAILED); ?>')"
                                    class="listivo-panel-tabs__tab listivo-panel-tab"
                                    :class="{'listivo-panel-tab--active': myOrders.status === '<?php echo esc_attr(OrderStatus::FAILED); ?>'}"
                            >
                                <?php echo esc_html(tdf_string('failed')) ?>

                                <div class="listivo-panel-tab__count">
                                    <?php echo esc_html(tdf_current_user()->getOrdersNumber(OrderStatus::FAILED)); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <template>
                <div class="listivo-panel-section__content">
                    <div class="listivo-panel-orders__table">
                        <div class="listivo-panel-orders__row listivo-panel-orders__row--my-orders listivo-panel-orders__row--head">
                            <div class="listivo-panel-orders__main-col listivo-panel-orders__head">
                                <?php echo esc_html(tdf_string('general_info')); ?>
                            </div>

                            <div class="listivo-panel-orders__col listivo-panel-orders__head">
                                <?php echo esc_html(tdf_string('status')); ?>
                            </div>
                        </div>

                        <div
                                class="listivo-panel-orders__list"
                                v-html="myOrders.template"
                        ></div>

                    </div>
                </div>
            </template>

            <div>
                <template v-if="myOrders.count > 0">
                    <div class="listivo-panel-section__pagination">
                        <lst-pagination
                                :total-items="myOrders.count"
                                :current-page="myOrders.page"
                                :page-size="10"
                                :max-pages="7"
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
                                            @click.prevent="myOrders.setPage(myOrders.page - 1)"
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
                                            @click.prevent="myOrders.setPage(1)"
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
                                            :class="{'listivo-pagination__item--active': page === myOrders.page}"
                                            @click.prevent="myOrders.setPage(page)"
                                    >
                                        {{ page }}
                                    </div>

                                    <div
                                            :class="{'listivo-pagination__item--disabled': pagination.currentPage >= pagination.endPage}"
                                            class="listivo-pagination__item"
                                            @click.prevent="myOrders.setPage(myOrders.page + 1)"
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
                </template>
            </div>

            <div>
                <template v-if="myOrders.count > 0">
                    <div class="listivo-panel-section__mobile-pagination">
                        <lst-pagination
                                :total-items="myOrders.count"
                                :current-page="myOrders.page"
                                :page-size="10"
                                :max-pages="3"
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
                                            @click.prevent="myOrders.setPage(myOrders.page - 1)"
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
                                            @click.prevent="myOrders.setPage(1)"
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
                                            :class="{'listivo-pagination__item--active': page === myOrders.page}"
                                            @click.prevent="myOrders.setPage(page)"
                                    >
                                        {{ page }}
                                    </div>

                                    <div
                                            :class="{'listivo-pagination__item--disabled': pagination.currentPage >= pagination.endPage}"
                                            class="listivo-pagination__item"
                                            @click.prevent="myOrders.setPage(myOrders.page + 1)"
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
                </template>
            </div>
        </div>
    </div>
</lst-panel-my-orders>