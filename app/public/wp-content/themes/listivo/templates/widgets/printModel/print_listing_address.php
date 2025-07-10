<?php

use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Listivo\Widgets\PrintModel\PrintListingAddressWidget;

/* @var PrintListingAddressWidget $lstCurrentWidget */
global $lstCurrentWidget;
$lstModel = $lstCurrentWidget->getModel();
if (!$lstModel instanceof Model) {
    return;
}

$lstAddress = $lstModel->getAddress();
if (empty($lstAddress)) {
    return;
}
?>
<div class="listivo-print-address-wrapper">
    <div class="listivo-print-address">
        <div class="listivo-print-address__icon listivo-small-icon listivo-small-icon--primary-2 listivo-small-icon--circle">
            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="14" viewBox="0 0 10 14" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M5 0C2.24609 0 0 2.27981 0 5.07505C0 5.8601 0.316406 6.72048 0.753906 7.62843C1.19141 8.54036 1.76172 9.49193 2.33594 10.3602C3.47656 12.1008 4.61328 13.5163 4.61328 13.5163L5 14L5.38672 13.5163C5.38672 13.5163 6.52344 12.1008 7.66797 10.3602C8.23828 9.49193 8.80859 8.54036 9.24609 7.62843C9.68359 6.72048 10 5.8601 10 5.07505C10 2.27981 7.75391 0 5 0ZM5 1.01514C7.21484 1.01514 9 2.82709 9 5.07518C9 5.55096 8.75391 6.33997 8.34766 7.18449C7.94141 8.03298 7.38672 8.95283 6.83594 9.80132C5.99563 11.0789 5.40082 11.8315 5.08146 12.2356L5 12.3388L4.91854 12.2356C4.59919 11.8315 4.00437 11.0789 3.16406 9.80132C2.61328 8.95283 2.05859 8.03298 1.65234 7.18449C1.24609 6.33997 1 5.55096 1 5.07518C1 2.82709 2.78516 1.01514 5 1.01514ZM4.00002 5.06006C4.00002 4.50928 4.44924 4.06006 5.00002 4.06006C5.5508 4.06006 6.00002 4.50928 6.00002 5.06006C6.00002 5.61084 5.5508 6.06006 5.00002 6.06006C4.44924 6.06006 4.00002 5.61084 4.00002 5.06006Z"
                      fill="#FDFDFE"/>
            </svg>
        </div>

        <?php echo esc_html($lstAddress); ?>
    </div>
</div>