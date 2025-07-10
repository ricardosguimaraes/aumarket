<?php

use Tangibledesign\Listivo\Widgets\General\ContentV6Widget;

/* @var ContentV6Widget $lstCurrentWidget */
global $lstCurrentWidget;

$lstImage = $lstCurrentWidget->getImage();
?>
<div class="listivo-content-v6">
    <?php if ($lstImage) : ?>
        <div class="listivo-content-v6__image-wrapper">
            <div class="listivo-content-v6__image">
                <img
                        class="lazyload"
                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                        data-src="<?php echo esc_url($lstImage->getImageUrl()); ?>"
                        alt="<?php echo esc_attr($lstCurrentWidget->getSmallHeading()); ?>"
                        style="aspect-ratio: <?php echo esc_attr($lstImage->getWidth()); ?> / <?php echo esc_attr($lstImage->getHeight()); ?>;"
                >

                <?php if (!empty($lstCurrentWidget->getAwardValue() || !empty($lstCurrentWidget->getAwardText()))) : ?>
                    <div class="listivo-content-v6__award">
                        <div class="listivo-award-box-v3">
                            <div class="listivo-award-box-v3__content">
                                <?php if (!empty($lstCurrentWidget->getAwardImage())) : ?>
                                    <div class="listivo-award-box-v3__image">
                                        <img
                                                src="<?php echo esc_url($lstCurrentWidget->getAwardImage()); ?>"
                                                alt="<?php echo esc_attr($lstCurrentWidget->getAwardValue()); ?>"
                                        >
                                    </div>
                                <?php endif; ?>

                                <div class="listivo-award-box-v3__main">
                                    <?php echo esc_html($lstCurrentWidget->getAwardValue()); ?>
                                </div>

                                <div class="listivo-award-box-v3__text">
                                    <?php echo esc_html($lstCurrentWidget->getAwardText()); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="listivo-content-v6__content">
        <div class="listivo-content-v6__heading">
            <div class="listivo-heading-v2 listivo-heading-v2--left listivo-heading-v2--tablet-left listivo-heading-v2--mobile-left">
                <?php if ($lstCurrentWidget->hasSmallHeading())  : ?>
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
            <div class="listivo-content-v6__text">
                <?php echo nl2br(wp_kses_post($lstCurrentWidget->getText())); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($lstCurrentWidget->getButtonText())) : ?>
            <div class="listivo-content-v6__button">
                <a
                    <?php if ($lstCurrentWidget->isPrimary1Type()) : ?>
                        class="listivo-button listivo-button--primary-1"
                    <?php else : ?>
                        class="listivo-button listivo-button--primary-2"
                    <?php endif; ?>
                        href="<?php echo esc_url($lstCurrentWidget->getButtonUrl()); ?>"
                        title="<?php echo esc_attr($lstCurrentWidget->getButtonText()); ?>"
                >
                    <span>
                        <?php echo esc_html($lstCurrentWidget->getButtonText()); ?>

                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                             fill="none">
                            <path d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49605 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455586 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z"
                                  fill="#FDFDFE"/>
                        </svg>
                    </span>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
