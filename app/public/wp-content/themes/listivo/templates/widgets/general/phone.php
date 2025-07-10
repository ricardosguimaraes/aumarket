<?php

use Tangibledesign\Listivo\Widgets\General\PhoneWidget;

/* @var PhoneWidget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-phone-wrapper">
    <a href="tel:<?php echo esc_attr($lstCurrentWidget->getPhoneUrl()); ?>" class="listivo-phone">
        <?php echo esc_html($lstCurrentWidget->getPhone()); ?>
    </a>
</div>