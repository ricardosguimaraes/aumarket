<?php

use Tangibledesign\Framework\Models\Term\CustomTerm;
use Tangibledesign\Listivo\Widgets\General\CategoriesV3Widget;

/* @var CategoriesV3Widget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-categories-v3">
    <div class="listivo-categories-v3__heading">
        <div class="listivo-heading-v2 listivo-heading-v2--center listivo-heading-v2--tablet-center listivo-heading-v2--mobile-left">
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

    <div
        <?php if ($lstCurrentWidget->showPattern()) : ?>
            class="listivo-categories-v3__grid"
        <?php else : ?>
            class="listivo-categories-v3__grid listivo-categories-v3__grid--no-margin-top"
        <?php endif; ?>
    >
        <?php if ($lstCurrentWidget->showPattern()) : ?>
            <div class="listivo-categories-v3__pattern listivo-categories-v3__pattern--1">
                <svg xmlns="http://www.w3.org/2000/svg" width="352" height="300" viewBox="0 0 352 300" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M329.143 201.415C313.199 239.528 290.863 276.52 242.877 289.752C192.513 303.641 121.235 307.757 73.1727 272.001C26.2021 237.057 58.6894 186.461 42.874 140.958C33.3192 113.468 -3.11069 88.701 0.499338 62.9135C4.61671 33.5022 26.4761 7.22632 62.4474 1.14122C97.4765 -4.78451 135.068 22.5857 173.632 33.6254C228.269 49.2665 295.473 39.3675 331.405 78.1357C368.161 117.795 345.048 163.395 329.143 201.415Z"
                          fill="#E6F0FA"/>
                </svg>
            </div>

            <div class="listivo-categories-v3__pattern listivo-categories-v3__pattern--2">
                <svg xmlns="http://www.w3.org/2000/svg" width="381" height="328" viewBox="0 0 381 328" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M276.71 7.49369C221.547 -17.1371 181.399 29.1938 136.884 48.2824C106.235 61.425 81.439 76.9898 61.9008 99.6075C34.4828 131.347 -12.4008 158.441 3.26944 202.956C20.0353 250.584 79.2628 291.635 137.414 314.12C191.914 335.193 246.702 328.918 293.655 315.238C335.527 303.038 369.591 279.467 379.093 243.704C387.743 211.148 356.085 175.276 340.435 139.17C320.569 93.3352 331.789 32.0872 276.71 7.49369Z"
                          fill="#E6F0FA"/>
                </svg>
            </div>

            <div class="listivo-categories-v3__pattern listivo-categories-v3__pattern--3">
                <svg xmlns="http://www.w3.org/2000/svg" width="301" height="277" viewBox="0 0 301 277" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M153.723 7.86535C184.035 13.2651 210.202 28.1287 232.673 49.8875C256.188 72.6569 273.969 99.2912 281.598 131.688C292.272 177.008 318.208 236.405 283.64 266.295C248.528 296.653 198.026 254.005 153.723 242.254C126.024 234.907 100.158 228.456 76.7647 211.424C46.3169 189.256 8.60682 169.606 1.86189 131.688C-5.59462 89.769 9.65908 42.2796 41.9883 15.9194C72.4886 -8.94947 115.472 1.05143 153.723 7.86535Z"
                          fill="#E6F0FA"/>
                </svg>
            </div>
        <?php endif; ?>

        <?php foreach ($lstCurrentWidget->getCategories() as $lstCategory) :
            /* @var CustomTerm $lstTerm */
            $lstTerm = $lstCategory['term'];
            ?>
            <div class="listivo-category-v3">
                <div class="listivo-category-v3__head">
                    <?php if (!empty($lstCategory['icon']['url'])) : ?>
                        <div class="listivo-category-v3__icon">
                            <img
                                    src="<?php echo esc_url($lstCategory['icon']['url']); ?>"
                                    alt="<?php echo esc_attr($lstTerm->getName()); ?>"
                            >
                        </div>
                    <?php endif; ?>

                    <h3 class="listivo-category-v3__name">
                        <?php echo esc_html($lstTerm->getName()); ?>
                    </h3>
                </div>

                <div class="listivo-category-v3__list">
                    <?php foreach ($lstTerm->getMultilevelChildren($lstCurrentWidget->getLimit(), 'count') as $lstItem) : ?>
                        <a
                                class="listivo-category-v3__item"
                                href="<?php echo esc_url($lstItem->getUrl()); ?>"
                        >
                            <span class="listivo-category-v3__item-name">
                                <?php echo esc_html($lstItem->getName()); ?>
                            </span>

                            <span class="listivo-category-v3__count">
                                <?php echo esc_html($lstItem->getCount()); ?>
                            </span>
                        </a>
                    <?php endforeach; ?>
                </div>

                <div class="listivo-category-v3__bottom">
                    <a
                            class="listivo-button listivo-button--regular"
                            href="<?php echo esc_url($lstTerm->getUrl()); ?>"
                    >
                        <span>
                            <?php echo esc_html(tdf_string('view_all')); ?>

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
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>