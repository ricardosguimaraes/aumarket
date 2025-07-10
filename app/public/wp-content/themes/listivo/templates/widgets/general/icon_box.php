<?php

use Tangibledesign\Listivo\Widgets\General\IconBoxWidget;

/* @var IconBoxWidget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-icon-box">
    <div class="listivo-icon-box__icon">
        <?php if ($lstCurrentWidget->isTypeIcon()) : ?>
            <?php
            $lstIcon = $lstCurrentWidget->getIcon();
            if ($lstIcon['library'] === 'svg') : ?>
                <?php tdf_load_icon($lstIcon['value']['url']); ?>
            <?php else : ?>
                <i class="<?php echo esc_attr($lstIcon['value']); ?>"></i>
            <?php endif; ?>
        <?php else : ?>
            <img
                    class="lazyload"
                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                    data-src="<?php echo esc_url($lstCurrentWidget->getImage()); ?>"
                    alt="<?php echo esc_attr($lstCurrentWidget->getHeading()); ?>"
            >
        <?php endif; ?>
    </div>

    <?php if (!empty($lstCurrentWidget->getHeading())) : ?>
        <h3 class="listivo-icon-box__heading">
            <?php echo esc_html($lstCurrentWidget->getHeading()); ?>
        </h3>
    <?php endif; ?>

    <?php if (!empty($lstCurrentWidget->getText())) : ?>
        <div class="listivo-icon-box__text">
            <?php echo esc_html($lstCurrentWidget->getText()); ?>
        </div>
    <?php endif; ?>
</div>
