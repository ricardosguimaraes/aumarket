<?php

use Tangibledesign\Listivo\Widgets\General\ContentV1Widget;

/* @var ContentV1Widget $lstCurrentWidget */
global $lstCurrentWidget;

$lstAttributes = $lstCurrentWidget->getAttributes();
?>
<div class="listivo-content-v1">
    <div class="listivo-content-v1__image">
        <?php
        $lstImage = $lstCurrentWidget->getImage();
        if ($lstImage) : ?>
            <img
                    class="lazyload"
                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                    data-src="<?php echo esc_url($lstImage->getImageUrl()); ?>"
                    alt="<?php echo esc_attr($lstCurrentWidget->getHeading()); ?>"
                    style="aspect-ratio: <?php echo esc_attr($lstImage->getWidth()); ?> / <?php echo esc_attr($lstImage->getHeight()); ?>"
            >
        <?php endif; ?>
    </div>

    <div class="listivo-content-v1__content">
        <div class="listivo-content-v1__heading">
            <div class="listivo-heading-v2 listivo-heading-v2--left">
                <?php if (!empty($lstCurrentWidget->getSmallHeading())) : ?>
                    <h3 class="listivo-heading-v2__small-text">
                        <?php echo esc_html($lstCurrentWidget->getSmallHeading()); ?>
                    </h3>
                <?php endif; ?>

                <h2 class="listivo-heading-v2__text">
                    <?php echo wp_kses_post(nl2br($lstCurrentWidget->getHeading())); ?>
                </h2>
            </div>
        </div>

        <?php if (!empty($lstCurrentWidget->getText())) : ?>
            <div class="listivo-content-v1__text">
                <?php echo wp_kses_post(nl2br($lstCurrentWidget->getText())); ?>
            </div>
        <?php endif; ?>

        <?php if ($lstAttributes->isNotEmpty()) : ?>
            <div class="listivo-content-v1__attributes">
                <div class="listivo-attributes-v3">
                    <?php foreach ($lstAttributes as $lstAttribute) : ?>
                        <div class="listivo-attributes-v3__attribute">
                            <div class="listivo-attributes-v3__value">
                                <?php echo esc_html($lstAttribute['value']); ?>

                                <?php if (!empty($lstAttribute['after_value'])): ?>
                                    <div class="listivo-attributes-v3__after-value">
                                        <?php echo esc_html($lstAttribute['after_value']); ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="listivo-attributes-v3__label">
                                <?php echo esc_html($lstAttribute['label']); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
