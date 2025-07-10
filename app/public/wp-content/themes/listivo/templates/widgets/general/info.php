<?php
/* @var \Tangibledesign\Listivo\Widgets\General\InfoWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstImageUrl = $lstCurrentWidget->getImage();
?>
<div class="listivo-info-section">
    <div class="listivo-info-section__image">
        <?php if (!empty($lstImageUrl)) : ?>
            <img src="<?php echo esc_url($lstImageUrl); ?>" alt="">
        <?php endif; ?>

        <div class="listivo-info-section__image-decoration">
            <svg
                    width="381"
                    height="340"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 381 340"
            >
                <g>
                    <g>
                        <path
                                d="M1.39385,106.15659c-3.83022,28.88128 2.2879,46.45476 10.43633,55.83875c12.35321,14.2261 33.3395,15.69288 45.65117,19.96399c35.19894,12.21104 50.25936,71.63518 67.8138,92.44207c46.5398,55.16235 145.07366,87.26214 204.74133,47.81167c62.96471,-41.63016 61.56235,-149.01347 26.10649,-213.82688c-63.32188,-115.7527 -255.0079,-136.67766 -322.96703,-69.31879c-20.2692,20.09026 -29.18152,47.47905 -31.78207,67.08919z"
                                fill="#fffaf2"
                                fill-opacity="1"
                        ></path>
                    </g>
                </g>
            </svg>
        </div>
    </div>

    <div class="listivo-info-section__content">
        <h2 class="listivo-info-section__heading">
            <?php echo wp_kses_post($lstCurrentWidget->getTitle()); ?>

            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 117 6"
                 width="117.0pt" height="6.0pt">
                <path d="M 50.00 1.17 C 61.34 0.90 72.67 1.06 84.00 0.45 C 94.56 0.41 105.35 -0.61 115.72 0.63 L 115.67 2.00 C 106.41 1.93 97.23 2.05 88.00 2.85 C 69.99 3.10 52.02 3.97 34.00 4.02 C 22.99 4.28 12.01 5.08 1.00 5.15 L 0.92 3.04 C 9.00 3.23 16.94 1.74 25.00 1.98 C 33.35 2.05 41.65 1.21 50.00 1.17 Z"
                      fill="#ffa820"/>
            </svg>
        </h2>

        <?php if (!empty($lstCurrentWidget->getText())) : ?>
            <div class="listivo-info-section__text">
                <?php echo wp_kses_post($lstCurrentWidget->getText()); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($lstCurrentWidget->getAttributes())) : ?>
            <div class="listivo-info-section__attributes">
                <?php foreach ($lstCurrentWidget->getAttributes() as $lstAttribute) : ?>
                    <div class="listivo-info-section__attribute">
                        <div class="listivo-info-section__attribute-value">
                            <?php echo esc_html($lstAttribute['value']); ?>
                        </div>

                        <div class="listivo-info-section__attribute-text">
                            <?php echo esc_html($lstAttribute['text']); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($lstCurrentWidget->getButtonUrl())) : ?>
            <div class="listivo-info-section__button">
                <a
                        class="listivo-primary-outline-button listivo-primary-outline-button--height-57"
                        href="<?php echo esc_url($lstCurrentWidget->getButtonUrl()); ?>"
                        title="<?php echo esc_attr($lstCurrentWidget->getButtonText()); ?>"
                >
                    <span class="listivo-primary-outline-button__text">
                        <?php echo esc_html($lstCurrentWidget->getButtonText()); ?>
                    </span>

                    <?php if (!empty($lstCurrentWidget->getIcon())) : ?>
                        <span class="listivo-primary-outline-button__icon">
                            <?php if ($lstCurrentWidget->isSvgIcon()) : ?>
                                <img
                                        src="<?php echo esc_url($lstCurrentWidget->getIcon()); ?>"
                                        alt="<?php echo esc_attr($lstCurrentWidget->getText()); ?>"
                                >
                            <?php else : ?>
                                <i class="<?php echo esc_attr($lstCurrentWidget->getIcon()); ?>"></i>
                            <?php endif; ?>
                        </span>
                    <?php endif; ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
