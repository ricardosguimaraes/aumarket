<?php
/* @var \Tangibledesign\Framework\Widgets\User\UserPhoneWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstUser = $lstCurrentWidget->getUser();
if (!$lstUser) {
    return;
}

$lstPhone = $lstUser->getPhone();
if (empty($lstPhone)) {
    return;
}
?>
<a href="tel:<?php echo esc_attr($lstUser->getPhoneUrl()); ?>" class="listivo-user__phone">
    <?php echo esc_html($lstPhone); ?>
</a>