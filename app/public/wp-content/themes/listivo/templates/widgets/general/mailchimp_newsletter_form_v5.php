<?php

use Tangibledesign\Listivo\Widgets\General\MailchimpNewsletterFormV5Widget;

/* @var MailchimpNewsletterFormV5Widget $lstCurrentWidget */
global $lstCurrentWidget;

if (!function_exists('mc4wp_show_form')) {
    return;
}
?>
<div class="listivo-newsletter-v5">
    <div class="listivo-newsletter-v5__container">
        <?php if (!empty($lstCurrentWidget->getFirstImage())) : ?>
            <div class="listivo-newsletter-v5__first-image-wrapper">
                <div class="listivo-newsletter-v5__first-image">
                    <img
                            class="lazyload"
                            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                            data-src="<?php echo esc_url($lstCurrentWidget->getFirstImage()); ?>"
                            alt="<?php echo esc_attr($lstCurrentWidget->getHeading()); ?>"
                    >
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($lstCurrentWidget->getSecondImage())) : ?>
            <div class="listivo-newsletter-v5__second-image-wrapper">
                <div class="listivo-newsletter-v5__second-image">
                    <img
                            class="lazyload"
                            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                            data-src="<?php echo esc_url($lstCurrentWidget->getSecondImage()); ?>"
                            alt="<?php echo esc_attr($lstCurrentWidget->getHeading()); ?>"
                    >
                </div>
            </div>
        <?php endif; ?>

        <div class="listivo-newsletter-v5__content">
            <div class="listivo-newsletter-v5__heading">
                <div class="listivo-heading-v2 listivo-heading-v2--tablet-light listivo-heading-v2--left listivo-heading-v2--tablet-center listivo-heading-v2--mobile-center">
                    <?php if ($lstCurrentWidget->hasSmallHeading())  : ?>
                        <h3 class="listivo-heading-v2__small-text">
                            <?php echo esc_html($lstCurrentWidget->getSmallHeading()); ?>
                        </h3>
                    <?php endif; ?>

                    <h2 class="listivo-heading-v2__text listivo-heading-v2__text--mobile-heading-2 listivo-heading-v2__text--heading-1">
                        <?php echo wp_kses_post(nl2br($lstCurrentWidget->getHeading())); ?>
                    </h2>
                </div>
            </div>

            <div class="listivo-newsletter-v5__text">
                <?php echo wp_kses_post(nl2br($lstCurrentWidget->getText())); ?>
            </div>

            <div class="listivo-newsletter-v5__form">
                <?php mc4wp_show_form(); ?>
            </div>
        </div>
    </div>
</div>