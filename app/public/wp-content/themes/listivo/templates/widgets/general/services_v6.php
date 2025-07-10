<?php

use Tangibledesign\Listivo\Widgets\General\ServicesV6Widget;

/* @var ServicesV6Widget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-services-v6">
    <div class="listivo-services-v6__heading">
        <div class="listivo-heading-v2 listivo-heading-v2--center listivo-heading-v2--tablet-center listivo-heading-v2--mobile-center">
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

    <div class="listivo-services-v6__grid">
        <div class="listivo-services-v6__pattern listivo-services-v6__pattern--1">
            <svg xmlns="http://www.w3.org/2000/svg" width="352" height="300" viewBox="0 0 352 300" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M329.143 201.414C313.199 239.528 290.863 276.519 242.877 289.752C192.513 303.64 121.235 307.757 73.1727 272.001C26.2021 237.056 58.6894 186.46 42.874 140.958C33.3192 113.468 -3.11069 88.7007 0.499338 62.9133C4.61671 33.502 26.4761 7.22608 62.4474 1.14098C97.4765 -4.78476 135.068 22.5855 173.632 33.6252C228.269 49.2663 295.473 39.3673 331.405 78.1354C368.161 117.794 345.048 163.395 329.143 201.414Z"
                      fill="#E6F0FA"/>
            </svg>
        </div>
        
        <div class="listivo-services-v6__pattern listivo-services-v6__pattern--2">
            <svg xmlns="http://www.w3.org/2000/svg" width="381" height="328" viewBox="0 0 381 328" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M276.71 7.49344C221.547 -17.1373 181.399 29.1935 136.884 48.2821C106.235 61.4248 81.439 76.9895 61.9008 99.6072C34.4828 131.347 -12.4008 158.441 3.26944 202.956C20.0353 250.583 79.2628 291.635 137.414 314.119C191.914 335.193 246.702 328.918 293.655 315.237C335.527 303.038 369.591 279.467 379.093 243.704C387.743 211.147 356.085 175.275 340.435 139.17C320.569 93.3349 331.789 32.087 276.71 7.49344Z"
                      fill="#E6F0FA"/>
            </svg>
        </div>

        <div class="listivo-services-v6__pattern listivo-services-v6__pattern--3">
            <svg xmlns="http://www.w3.org/2000/svg" width="301" height="277" viewBox="0 0 301 277" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M153.723 7.8651C184.035 13.2648 210.202 28.1284 232.673 49.8873C256.188 72.6566 273.969 99.2909 281.598 131.687C292.272 177.008 318.208 236.405 283.64 266.294C248.528 296.653 198.026 254.004 153.723 242.254C126.024 234.907 100.158 228.456 76.7647 211.424C46.3169 189.256 8.60682 169.606 1.86189 131.687C-5.59462 89.7687 9.65908 42.2793 41.9883 15.9191C72.4886 -8.94972 115.472 1.05119 153.723 7.8651Z"
                      fill="#E6F0FA"/>
            </svg>
        </div>

        <?php foreach ($lstCurrentWidget->getServices() as $lstService) : ?>
            <div class="listivo-service-v6">
                <?php if (!empty($lstService['image']['url'])) : ?>
                    <div class="listivo-service-v6__image">
                        <img
                                src="<?php echo esc_url($lstService['image']['url']); ?>"
                                alt="<?php echo esc_attr($lstService['title']); ?>"
                        >
                    </div>
                <?php endif; ?>

                <?php if (!empty($lstService['title'])) : ?>
                    <h3 class="listivo-service-v6__heading">
                        <?php echo esc_html($lstService['title']); ?>
                    </h3>
                <?php endif; ?>

                <?php if (!empty($lstService['text'])) : ?>
                    <div class="listivo-service-v6__text">
                        <?php echo esc_html($lstService['text']); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
