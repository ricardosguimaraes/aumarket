<?php

use Tangibledesign\Listivo\Widgets\General\ContentV4Widget;

/* @var ContentV4Widget $lstCurrentWidget */
global $lstCurrentWidget;

$lstImage = $lstCurrentWidget->getImage();
$lstAttributes = $lstCurrentWidget->getAttributes();
?>
<div class="listivo-content-v4">
    <?php if ($lstImage) : ?>
        <div class="listivo-content-v4__image-wrapper">
            <div class="listivo-content-v4__image">
                <img
                        class="lazyload"
                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                        data-src="<?php echo esc_url($lstImage->getImageUrl()); ?>"
                        alt="<?php echo esc_attr($lstCurrentWidget->getSmallHeading()); ?>"
                        style="aspect-ratio: <?php echo esc_attr($lstImage->getWidth()); ?> / <?php echo esc_attr($lstImage->getHeight()); ?>;"
                >

                <div class="listivo-content-v4__award">
                    <div class="listivo-award-box">
                        <?php if (!empty($lstCurrentWidget->getAwardImage())) : ?>
                            <div class="listivo-award-box__image">
                                <img
                                        class="lazyload"
                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                                        data-src="<?php echo esc_url($lstCurrentWidget->getAwardImage()); ?>"
                                        alt="<?php echo esc_attr($lstCurrentWidget->getAwardHeading()); ?>"
                                >
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($lstCurrentWidget->getAwardHeading())): ?>
                            <div class="listivo-award-box__heading">
                                <?php echo esc_html($lstCurrentWidget->getAwardHeading()); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($lstCurrentWidget->getText())) : ?>
                            <div class="listivo-award-box__text">
                                <?php echo esc_html($lstCurrentWidget->getAwardText()); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="listivo-content-v4__pattern listivo-content-v4__pattern--1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="311" height="299" viewBox="0 0 311 299" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M229.158 28.6655C184.615 8.79332 151.245 48.3032 114.723 64.9955C89.5777 76.4883 69.1606 89.9289 52.9199 109.216C30.1293 136.281 -8.43947 159.733 3.65881 196.892C16.6029 236.648 64.2122 270.252 111.22 288.278C155.276 305.172 199.972 299.09 238.398 286.905C272.667 276.038 300.747 255.735 309.012 225.555C316.536 198.082 291.294 168.419 279.088 138.324C263.593 100.119 273.634 48.5077 229.158 28.6655Z"
                              fill="#E6F0FA"/>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M228.306 5.95117C183.762 -13.921 150.392 25.5888 113.87 42.2811C88.7249 53.7739 68.3079 67.2146 52.0671 86.5015C29.2765 113.567 -9.29225 137.019 2.80603 174.177C15.7501 213.934 63.3594 247.538 110.367 265.564C154.424 282.458 199.119 276.376 237.546 264.19C271.814 253.323 299.894 233.021 308.159 202.841C315.683 175.367 290.441 145.705 278.235 115.61C262.74 77.4047 272.781 25.7933 228.306 5.95117Z"
                              fill="#FA823E"/>
                    </svg>
                </div>

                <div class="listivo-content-v4__pattern listivo-content-v4__pattern--2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="315" height="299" viewBox="0 0 315 299" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M228.306 28.9512C183.763 9.07896 150.392 48.5888 113.871 65.2811C88.7252 76.7739 68.3081 90.2146 52.0674 109.501C29.2768 136.567 -9.29201 160.019 2.80627 197.177C15.7503 236.934 63.3597 270.538 110.367 288.564C154.424 305.458 199.12 299.376 237.546 287.19C271.815 276.323 299.895 256.021 308.16 225.841C315.683 198.367 290.442 168.705 278.236 138.61C262.741 100.405 272.782 48.7933 228.306 28.9512Z"
                              fill="#E6F0FA"/>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M233.306 5.95117C188.763 -13.921 155.392 25.5888 118.871 42.2811C93.7252 53.7739 73.3081 67.2145 57.0674 86.5015C34.2767 113.567 -4.292 137.019 7.80627 174.177C20.7503 213.934 68.3597 247.538 115.367 265.564C159.424 282.458 204.12 276.376 242.546 264.19C276.815 253.323 304.895 233.021 313.16 202.841C320.683 175.367 295.442 145.705 283.236 115.61C267.741 77.4047 277.782 25.7933 233.306 5.95117Z"
                              fill="#FA823E"/>
                    </svg>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="listivo-content-v4__content">
        <div class="listivo-content-v4__heading">
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

        <div class="listivo-content-v4__text">
            <?php echo wp_kses_post($lstCurrentWidget->getText()); ?>
        </div>

        <?php if ($lstAttributes->isNotEmpty()) : ?>
            <div class="listivo-content-v4__attributes">
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
