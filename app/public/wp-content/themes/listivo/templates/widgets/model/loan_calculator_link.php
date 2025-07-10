<?php
/* @var \Tangibledesign\Listivo\Widgets\General\LoanCalculatorLinkWidget $lstCurrentWidget */
global $lstCurrentWidget;

if (!$lstCurrentWidget->hasPrice()) {
    return;
}
?>
<div class="listivo-app">
    <div class="listivo-loan-calculator-link">
        <template>
            <lst-scroll-to-link selector=".listivo-loan-calculator-anchor" prefix="listivo">
                <a slot-scope="props" v-if="props.visible" @click.prevent="props.onClick" href="#">
                    <i class="fas fa-calculator"></i> 
                    <?php echo esc_html($lstCurrentWidget->getLabel()); ?>
                </a>
            </lst-scroll-to-link>
        </template>
    </div>
</div>