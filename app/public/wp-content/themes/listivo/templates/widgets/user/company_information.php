<?php

use Tangibledesign\Listivo\Widgets\User\CompanyInformationWidget;

/* @var CompanyInformationWidget $lstCurrentWidget */
global $lstCurrentWidget;
$lstCompanyInformation = $lstCurrentWidget->getCompanyInformation();
if (empty($lstCompanyInformation)) {
    return;
}
?>
<div class="listivo-company-information">
    <?php echo wp_kses_post(nl2br($lstCompanyInformation)); ?>
</div>
