<?php
/* @var \Tangibledesign\Listivo\Widgets\User\UserCustomTextWidget $lstCurrentWidget */
global $lstCurrentWidget;
if (empty($lstCurrentWidget->getText())) {
    return;
}
?>
<div class="listivo-user-custom-text">
    <?php echo wp_kses_post($lstCurrentWidget->getText()); ?>
</div>
