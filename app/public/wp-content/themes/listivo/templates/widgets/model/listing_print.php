<?php

use Tangibledesign\Listivo\Widgets\Listing\ListingPrintWidget;

/* @var ListingPrintWidget $lstCurrentWidget */
global $lstCurrentWidget;
$lstModel = $lstCurrentWidget->getModel();
if (!$lstModel) {
    return;
}
?>
<div class="listivo-app listivo-listing-print">
    <lst-print-button url="<?php echo esc_url($lstModel->getUrl() . '?print=1'); ?>">
        <div slot-scope="print">
            <button title="<?php echo esc_attr(tdf_string('print_listing_page')); ?>" class="listivo-print-button"
                    @click.prevent="print.onClick">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                          d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
            </button>
        </div>
    </lst-print-button>
</div>