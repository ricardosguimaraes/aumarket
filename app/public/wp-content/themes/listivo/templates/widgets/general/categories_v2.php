<?php

use Tangibledesign\Listivo\Widgets\General\CategoriesV2Widget;

/* @var CategoriesV2Widget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-categories-v2">
    <div class="listivo-categories-v2__list">
        <?php foreach ($lstCurrentWidget->getCategories() as $lstCategory) : ?>
            <a
                    class="listivo-category-v2"
                    href="<?php echo esc_url($lstCategory['url']); ?>"
            >
                <div class="listivo-category-v2__image">
                    <img
                            class="lazyload"
                            data-src="<?php echo esc_url($lstCategory['image']); ?>"
                            alt="<?php echo esc_attr($lstCategory['name']); ?>"
                    >
                </div>

                <div class="listivo-category-v2__label">
                    <?php echo esc_html($lstCategory['name']); ?>
                </div>

                <div class="listivo-category-v2__arrow-wrapper">
                    <div class="listivo-category-v2__arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" viewBox="0 0 16 15" fill="none">
                            <path d="M9.5174 13.9618C9.34362 14.1355 9.11651 14.2222 8.88895 14.2222C8.66139 14.2222 8.43428 14.1355 8.2605 13.9618C7.91339 13.6147 7.91339 13.052 8.2605 12.7049L12.9654 7.99994H0.888895C0.398225 7.99994 -4.76837e-07 7.60172 -4.76837e-07 7.11105C-4.76837e-07 6.62038 0.398225 6.22215 0.888895 6.22215H12.9654L8.2605 1.51723C7.91339 1.17012 7.91339 0.607449 8.2605 0.260335C8.60762 -0.0867784 9.17029 -0.0867784 9.5174 0.260335L15.7397 6.4826C16.0868 6.82971 16.0868 7.39238 15.7397 7.7395L9.5174 13.9618Z"
                                  fill="#FDFDFE"/>
                        </svg>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>

    <?php if (!empty($lstCurrentWidget->getText())) : ?>
        <h2 class="listivo-categories-v2__heading">
            <?php echo esc_html($lstCurrentWidget->getText()); ?>

            <svg xmlns="http://www.w3.org/2000/svg" width="51" height="26" viewBox="0 0 51 26" fill="none">
                <path d="M1 12.2703C3.97507 14.3493 6.6109 17.0536 9.92521 18.5074C24.5141 24.9068 39.7041 16.5979 46.6058 2.99016"
                      stroke="#FF5722" stroke-dasharray="3 3"/>
                <path d="M41.7308 3.29806C49.4849 1.3592 47.435 -0.801337 48.5731 6.52182" stroke="#FF5722"/>
            </svg>
        </h2>
    <?php endif; ?>
</div>
