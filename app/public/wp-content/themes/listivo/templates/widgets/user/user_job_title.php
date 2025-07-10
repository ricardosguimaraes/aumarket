<?php
/* @var \Tangibledesign\Framework\Widgets\User\UserJobTitleWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstUser = $lstCurrentWidget->getUser();
if (!$lstUser) {
    return;
}

$lstJobTitle = $lstUser->getJobTitle();
if (empty($lstJobTitle)) {
    return;
}
?>
<div class="listivo-user__job-title">
    <?php echo esc_html($lstJobTitle); ?>
</div>