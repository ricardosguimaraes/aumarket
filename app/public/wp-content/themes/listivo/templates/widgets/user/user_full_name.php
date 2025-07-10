<?php

use Tangibledesign\Listivo\Widgets\User\UserFullNameWidget;

/* @var UserFullNameWidget $lstCurrentWidget */
global $lstCurrentWidget;
$lstUserFullName = $lstCurrentWidget->getFullName();
if (empty($lstUserFullName)) {
    return;
}
?>
<div class="listivo-user-full-name">
    <?php echo esc_html($lstUserFullName); ?>
</div>