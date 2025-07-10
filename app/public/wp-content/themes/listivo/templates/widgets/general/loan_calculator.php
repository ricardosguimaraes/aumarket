<?php

use Tangibledesign\Framework\Models\Currency;
use Tangibledesign\Listivo\Widgets\General\LoanCalculatorWidget;

/* @var LoanCalculatorWidget $lstCurrentWidget */
global $lstCurrentWidget;
$lstInitialPrice = $lstCurrentWidget->getInitialPrice();
$lstModel = $lstCurrentWidget->getModel();

if (is_singular(tdf_model_post_type())) {
    if (!$lstCurrentWidget->display($lstModel)) {
        return;
    }

    if (empty($lstInitialPrice)) {
        return;
    }
}

/* @var Currency $lstCurrency */
$lstCurrency = tdf_app('current_currency');
?>
<div class="listivo-loan-calculator-anchor"></div>

<div class="listivo-app">
    <lst-loan-calculator
            css-selector-prefix="listivo"
            decimal-separator="<?php echo esc_attr(tdf_settings()->getDecimalSeparator()); ?>"
            thousands-separator="<?php echo esc_attr(tdf_settings()->getThousandsSeparator()); ?>"
            :price-decimal-places="<?php echo esc_attr($lstCurrency->getDecimalPlaces()); ?>"
            price-decimal-separator="<?php echo esc_attr($lstCurrency->getDecimalSeparator()); ?>"
            price-thousands-separator="<?php echo esc_attr($lstCurrency->getThousandsSeparator()); ?>"
            :currency="<?php echo htmlspecialchars(json_encode($lstCurrency)); ?>"
    >
        <div slot-scope="props" class="listivo-loan-calculator">
            <div class="listivo-loan-calculator__heading">
                <?php echo esc_html(tdf_string('buy_now_pay_later')); ?>
            </div>

            <form @submit.prevent="props.onCalculate">
                <div class="listivo-loan-calculator__fields">
                    <div class="listivo-field-group">
                        <div class="listivo-field-group__label">
                            <?php echo esc_html(tdf_string('price')); ?>

                            <span>*</span>
                        </div>

                        <div class="listivo-field-group__field">
                            <div class="listivo-input-v2 listivo-input-v2--with-icon">
                                <div class="listivo-input-v2__icon listivo-icon-v2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                         viewBox="0 0 16 16" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M9.15179 0C8.65645 0 8.18515 0.197174 7.8437 0.548242L0.533814 7.91584C-0.177938 8.6324 -0.177938 9.80583 0.533814 10.5224L5.47761 15.4662C6.19417 16.1779 7.3676 16.1779 8.08416 15.4662L15.4566 8.1563C15.8028 7.81004 16 7.33874 16 6.84821V1.84671C16 0.83198 15.168 0 14.1533 0H9.15179ZM9.15179 1.23114H14.1533C14.4995 1.23114 14.7689 1.50045 14.7689 1.84671V6.84821C14.7689 7.01172 14.7015 7.17042 14.5861 7.28584L7.21852 14.5957C6.97325 14.841 6.59333 14.8362 6.35287 14.5957L1.40908 9.64713C1.159 9.40186 1.159 9.02675 1.40427 8.78149L8.71416 1.41389C8.82958 1.29847 8.98828 1.23114 9.15179 1.23114ZM12.3066 3.07785C12.3066 2.7364 12.5807 2.46228 12.9222 2.46228C13.2636 2.46228 13.5377 2.7364 13.5377 3.07785C13.5377 3.4193 13.2636 3.69342 12.9222 3.69342C12.5807 3.69342 12.3066 3.4193 12.3066 3.07785Z"
                                              fill="#FDFDFE"/>
                                    </svg>
                                </div>

                                <input
                                        id="listivo-loan-calculator__price"
                                        type="text"
                                    <?php if (!empty($lstInitialPrice)) : ?>
                                        value="<?php echo esc_attr($lstInitialPrice); ?>"
                                    <?php endif; ?>
                                >
                            </div>
                        </div>
                    </div>

                    <div class="listivo-field-group">
                        <div class="listivo-field-group__label">
                            <?php echo esc_attr(tdf_string('interest_rate')); ?>

                            <span>*</span>
                        </div>

                        <div class="listivo-field-group__field">
                            <div class="listivo-input-v2 listivo-input-v2--with-icon">
                                <div class="listivo-input-v2__icon listivo-icon-v2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
                                         fill="none">
                                        <path d="M0 2.85893C0 2.06897 0.282132 1.39812 0.846395 0.846395C1.39812 0.282132 2.06897 0 2.85893 0C3.6489 0 4.31975 0.282132 4.87147 0.846395C5.43574 1.39812 5.71787 2.06897 5.71787 2.85893C5.71787 3.6489 5.43574 4.31975 4.87147 4.87147C4.31975 5.43574 3.6489 5.71787 2.85893 5.71787C2.06897 5.71787 1.39812 5.43574 0.846395 4.87147C0.282132 4.31975 0 3.6489 0 2.85893ZM1.279 2.85893C1.279 3.33542 1.43574 3.73668 1.74922 4.0627C2.05016 4.40125 2.42006 4.57053 2.85893 4.57053C3.28527 4.57053 3.65517 4.40125 3.96865 4.0627C4.26959 3.73668 4.42006 3.33542 4.42006 2.85893C4.42006 2.38245 4.26959 1.98119 3.96865 1.65517C3.65517 1.31661 3.28527 1.14734 2.85893 1.14734C2.42006 1.14734 2.05016 1.31661 1.74922 1.65517C1.43574 1.98119 1.279 2.38245 1.279 2.85893ZM1.84326 11.4357L8.84013 0H10.3072L3.29154 11.4357H1.84326ZM6.28213 8.5768C6.28213 7.78683 6.56426 7.11599 7.12853 6.56426C7.68025 6 8.3511 5.71787 9.14107 5.71787C9.93103 5.71787 10.6019 6 11.1536 6.56426C11.7179 7.11599 12 7.78683 12 8.5768C12 9.36677 11.7179 10.0376 11.1536 10.5893C10.6019 11.1536 9.93103 11.4357 9.14107 11.4357C8.3511 11.4357 7.68025 11.1536 7.12853 10.5893C6.56426 10.0376 6.28213 9.36677 6.28213 8.5768ZM7.56113 8.5768C7.56113 9.09091 7.71787 9.52978 8.03135 9.89342C8.33229 10.2571 8.70219 10.4389 9.14107 10.4389C9.57994 10.4389 9.94984 10.2571 10.2508 9.89342C10.5643 9.52978 10.721 9.09091 10.721 8.5768C10.721 8.0627 10.5643 7.63009 10.2508 7.279C9.94984 6.91536 9.57994 6.73354 9.14107 6.73354C8.70219 6.73354 8.33229 6.91536 8.03135 7.279C7.71787 7.63009 7.56113 8.0627 7.56113 8.5768Z"
                                              fill="#FDFDFE"/>
                                    </svg>
                                </div>

                                <input
                                        id="listivo-loan-calculator__rate"
                                        type="text"
                                    <?php if ($lstModel) : ?>
                                        value="<?php echo esc_attr($lstCurrentWidget->getInitialRate($lstModel)); ?>"
                                    <?php else : ?>
                                        value="<?php echo esc_attr($lstCurrentWidget->getInitialRate()); ?>"
                                    <?php endif; ?>
                                >
                            </div>
                        </div>
                    </div>

                    <div class="listivo-field-group">
                        <Div class="listivo-field-group__label">
                            <?php echo esc_attr(tdf_string('period_months')); ?>
                        </Div>

                        <div class="listivo-field-group__field">
                            <div class="listivo-input-v2 listivo-input-v2--with-icon">
                                <div class="listivo-input-v2__icon listivo-icon-v2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13"
                                         fill="none">
                                        <path d="M2.16667 0V1.3H1.44444C0.65 1.3 0 1.885 0 2.6V11.7C0 12.415 0.65 13 1.44444 13H11.5556C12.35 13 13 12.415 13 11.7V2.6C13 1.885 12.35 1.3 11.5556 1.3H10.8333V0H9.38889V1.3H3.61111V0H2.16667ZM1.44444 2.6H2.16667H3.61111H9.38889H10.8333H11.5556V3.9H1.44444V2.6ZM1.44444 5.2H11.5556V11.7H1.44444V5.2Z"
                                              fill="#FDFDFE"/>
                                    </svg>
                                </div>

                                <input
                                        id="listivo-loan-calculator__months"
                                        type="text"
                                    <?php if ($lstModel) : ?>
                                        value="<?php echo esc_attr($lstCurrentWidget->getInitialMonths($lstModel)); ?>"
                                    <?php else : ?>
                                        value="<?php echo esc_attr($lstCurrentWidget->getInitialMonths()); ?>"
                                    <?php endif; ?>
                                >
                            </div>
                        </div>
                    </div>

                    <div class="listivo-field-group">
                        <div class="listivo-field-group__label">
                            <?php echo esc_attr(tdf_string('down_payment')); ?>
                        </div>

                        <div class="listivo-field-group__field">
                            <div class="listivo-input-v2 listivo-input-v2--with-icon">
                                <div class="listivo-input-v2__icon listivo-icon-v2">
                                    <?php echo esc_html($lstCurrency->getSign()); ?>
                                </div>

                                <input
                                        id="listivo-loan-calculator__contribution"
                                        type="text"
                                    <?php if (!empty($lstCurrentWidget->getDownPayment())): ?>
                                        value="<?php echo esc_attr($lstCurrentWidget->getDownPayment()); ?>"
                                    <?php endif; ?>
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="listivo-loan-calculator__results">
                <div class="listivo-loan-calculator__result">
                    <?php echo esc_html(tdf_string('monthly_payment')); ?>

                    <span v-if="!props.showResults">-</span>

                    <template>
                        <span v-if="props.showResults">{{ props.installment }}</span>
                    </template>
                </div>

                <div class="listivo-loan-calculator__result">
                    <?php echo esc_html(tdf_string('total_interest')); ?>

                    <span v-if="!props.showResults">-</span>

                    <template>
                        <span v-if="props.showResults">{{ props.interest }}</span>
                    </template>
                </div>

                <div class="listivo-loan-calculator__result listivo-loan-calculator__result--primary">
                    <?php echo esc_html(tdf_string('total_payments')); ?>

                    <span v-if="!props.showResults">-</span>

                    <template>
                        <span v-if="props.showResults">
                            {{ props.total }}
                        </span>
                    </template>
                </div>
            </div>
        </div>
    </lst-loan-calculator>
</div>
