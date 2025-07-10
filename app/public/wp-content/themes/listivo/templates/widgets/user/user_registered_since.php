<?php
/* @var \Tangibledesign\Listivo\Widgets\User\UserRegisteredSinceWidget $lstCurrentWidget */
global $lstCurrentWidget;
$lstUser = $lstCurrentWidget->getUser();
if (!$lstUser) {
    return;
}
?>
<div class="listivo-user-date">
    <?php echo esc_html(tdf_string('member_since') . ' ' . $lstUser->getRegistrationDateDiff()); ?>
</div>