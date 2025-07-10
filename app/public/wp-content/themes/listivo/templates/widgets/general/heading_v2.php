<?php

use Tangibledesign\Listivo\Widgets\General\HeadingV2Widget;

/* @var HeadingV2Widget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-heading-v2-wrapper">
    <div class="listivo-heading-v2 listivo-heading-v2--<?php echo esc_attr($lstCurrentWidget->getAlignment()); ?> listivo-heading-v2--tablet-<?php echo esc_attr($lstCurrentWidget->getTabletAlignment()); ?> listivo-heading-v2--mobile-<?php echo esc_attr($lstCurrentWidget->getMobileAlignment()); ?>">
        <?php if ($lstCurrentWidget->hasSmallHeading())  : ?>
            <<?php echo esc_html($lstCurrentWidget->getSmallHeadingTag()) ?> class="listivo-heading-v2__small-text">
                <?php echo esc_html($lstCurrentWidget->getSmallHeading()); ?>
            </<?php echo esc_html($lstCurrentWidget->getSmallHeadingTag()) ?>>
        <?php endif; ?>

        <<?php echo esc_html($lstCurrentWidget->getHeadingTag()) ?> class="listivo-heading-v2__text">
            <?php echo wp_kses_post(nl2br($lstCurrentWidget->getHeading())); ?>
        </<?php echo esc_html($lstCurrentWidget->getHeadingTag()) ?>>
    </div>
</div>