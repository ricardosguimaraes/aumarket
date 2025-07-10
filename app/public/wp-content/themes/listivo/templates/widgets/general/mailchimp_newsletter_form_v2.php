<?php

use Tangibledesign\Listivo\Widgets\General\MailchimpNewsletterFormV2Widget;

/* @var MailchimpNewsletterFormV2Widget $lstCurrentWidget */
global $lstCurrentWidget;
if (!function_exists('mc4wp_show_form')) {
    return;
}
?>
<div
        class="listivo-newsletter-v2"
    <?php if (!empty($lstCurrentWidget->getBackgroundImage())): ?>
        style="background-image: url('<?php echo esc_url($lstCurrentWidget->getBackgroundImage()); ?>');"
    <?php endif; ?>
>
    <div class="listivo-newsletter-v2__container">
        <h3 class="listivo-newsletter-v2__heading">
            <?php echo wp_kses_post($lstCurrentWidget->getLabel()); ?>
        </h3>

        <div class="listivo-newsletter-v2__form">
            <?php mc4wp_show_form(); ?>
        </div>
    </div>
</div>
