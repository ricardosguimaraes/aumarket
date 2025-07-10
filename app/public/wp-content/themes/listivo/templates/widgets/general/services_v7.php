<?php

use Tangibledesign\Listivo\Widgets\General\ServicesV7Widget;

/* @var ServicesV7Widget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-services-v7">
    <div class="listivo-services-v7__background-container">
        <div class="listivo-services-v7__background-wrapper">
            <div class="listivo-services-v7__background">
                <img
                        class="lazyload"
                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                        data-src="<?php echo esc_url($lstCurrentWidget->getImageUrl()); ?>"
                        alt="<?php echo esc_attr($lstCurrentWidget->getSmallHeading()); ?>"
                >
            </div>
        </div>
    </div>

    <div class="listivo-services-v7__container">
        <div class="listivo-services-v7__content">
            <div class="listivo-services-v7__heading">
                <div class="listivo-heading-v2 listivo-heading-v2--dark listivo-heading-v2--<?php echo esc_attr($lstCurrentWidget->getAlignment()); ?> listivo-heading-v2--tablet-<?php echo esc_attr($lstCurrentWidget->getTabletAlignment()); ?> listivo-heading-v2--mobile-<?php echo esc_attr($lstCurrentWidget->getMobileAlignment()); ?>">
                    <?php if ($lstCurrentWidget->hasSmallHeading())  : ?>
                        <h3 class="listivo-heading-v2__small-text">
                            <?php echo esc_html($lstCurrentWidget->getSmallHeading()); ?>
                        </h3>
                    <?php endif; ?>

                    <h2 class="listivo-heading-v2__text listivo-heading-v2__text--heading-1 listivo-heading-v2__text--mobile-heading-2">
                        <?php echo wp_kses_post(nl2br($lstCurrentWidget->getHeading())); ?>
                    </h2>
                </div>
            </div>

            <?php if (!empty($lstCurrentWidget->getButtonText())) : ?>
                <div class="listivo-services-v7__button">
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

            <div class="listivo-services-v7__list">
                <?php foreach ($lstCurrentWidget->getServices() as $lstService) : ?>
                    <div class="listivo-service-v7">
                        <?php if (!empty($lstService['image']['url'])) : ?>
                            <div class="listivo-service-v7__image">
                                <img
                                        class="lazyload"
                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                                        data-src="<?php echo esc_url($lstService['image']['url']); ?>"
                                        alt="<?php echo esc_attr($lstService['title']); ?>"
                                >
                            </div>
                        <?php endif; ?>

                        <h3 class="listivo-service-v7__label">
                            <?php echo esc_html($lstService['title']); ?>
                        </h3>

                        <div class="listivo-service-v7__text">
                            <?php echo nl2br(wp_kses_post($lstService['text'])); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
