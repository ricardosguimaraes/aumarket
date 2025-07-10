<?php

use Tangibledesign\Framework\Widgets\User\UserDescriptionWidget;

/* @var UserDescriptionWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstUser = $lstCurrentWidget->getUser();
if (!$lstUser) {
    return;
}

$lstDescription = $lstUser->getDescription();
if (empty($lstDescription)) {
    return;
}
?>
<div class="listivo-user-description">
    <?php echo nl2br(wp_kses_post($lstDescription)); ?>
</div>