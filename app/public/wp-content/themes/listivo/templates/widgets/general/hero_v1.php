<?php

use Tangibledesign\Listivo\Widgets\General\HeroV1Widget;

/* @var HeroV1Widget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-hero-v1">
    <div class="listivo-hero-v1__background">
        <?php if (!empty($lstCurrentWidget->getImage())) : ?>
            <img
                    src="<?php echo esc_url($lstCurrentWidget->getImage()); ?>"
                    alt="<?php echo esc_attr($lstCurrentWidget->getSmallHeading()); ?>"
            >
        <?php endif; ?>
    </div>

    <div class="listivo-hero-v1__background listivo-hero-v1__background--mobile">
        <?php if (!empty($lstCurrentWidget->getMobileImage())) : ?>
            <img
                    src="<?php echo esc_url($lstCurrentWidget->getMobileImage()); ?>"
                    alt="<?php echo esc_attr($lstCurrentWidget->getSmallHeading()); ?>"
            >
        <?php endif; ?>
    </div>

    <div class="listivo-hero-v1__content">
        <h2 class="listivo-hero-v1__small-heading">
            <?php echo esc_html($lstCurrentWidget->getSmallHeading()); ?>
        </h2>

        <h1 class="listivo-hero-v1__heading">
            <?php echo wp_kses_post($lstCurrentWidget->getHeading()); ?>
        </h1>

        <div class="listivo-hero-v1__buttons">
            <?php if (!empty($lstCurrentWidget->getFirstButtonText())) : ?>
                <a
                        class="listivo-button listivo-button--primary-1 listivo-button--color-1"
                        href="<?php echo esc_url($lstCurrentWidget->getFirstButtonUrl()); ?>"
                >
                    <span>
                        <?php echo esc_html($lstCurrentWidget->getFirstButtonText()); ?>

                        <svg width="8" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 14">
                            <g>
                                <g>
                                    <path d="M7.33974,6.18666v0l-5.45414,-5.86846c-0.24639,-0.30357 -0.50858,-0.30357 -0.78587,0l-0.32364,0.35442c-0.24616,0.26968 -0.24616,0.55668 0,0.85987l4.71474,5.05868v0l-4.71474,5.05905c-0.27718,0.30282 -0.27718,0.58982 0,0.8595l0.32364,0.35404c0.27729,0.30395 0.53947,0.30395 0.78587,0l5.45414,-5.86846c0.24696,-0.26892 0.24696,-0.5386 0,-0.80865z"
                                          fill="#ffffff" fill-opacity="1"></path>
                                </g>
                            </g>
                        </svg>
                    </span>
                </a>
            <?php endif; ?>

            <?php if (!empty($lstCurrentWidget->getSecondButtonUrl())) : ?>
                <a
                        class="listivo-button listivo-button--white"
                        href="<?php echo esc_url($lstCurrentWidget->getSecondButtonUrl()); ?>"
                >
                    <span>
                        <?php echo esc_html($lstCurrentWidget->getSecondButtonText()); ?>

                        <svg width="8" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 14">
                            <g>
                                <g>
                                    <path d="M7.33974,6.18666v0l-5.45414,-5.86846c-0.24639,-0.30357 -0.50858,-0.30357 -0.78587,0l-0.32364,0.35442c-0.24616,0.26968 -0.24616,0.55668 0,0.85987l4.71474,5.05868v0l-4.71474,5.05905c-0.27718,0.30282 -0.27718,0.58982 0,0.8595l0.32364,0.35404c0.27729,0.30395 0.53947,0.30395 0.78587,0l5.45414,-5.86846c0.24696,-0.26892 0.24696,-0.5386 0,-0.80865z"
                                          fill="#ffffff" fill-opacity="1"></path>
                                </g>
                            </g>
                        </svg>
                    </span>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
