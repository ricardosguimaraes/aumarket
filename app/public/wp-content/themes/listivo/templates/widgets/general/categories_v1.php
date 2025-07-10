<?php


use Tangibledesign\Listivo\Widgets\General\CategoriesV1Widget;

/* @var CategoriesV1Widget $lstCurrentWidget */
global $lstCurrentWidget;
$lstCategories = $lstCurrentWidget->getCategories();
$lstCategoryCount = count($lstCategories) - 1;
?>
<div class="listivo-categories-v1">
    <?php foreach ($lstCategories as $lstIndex => $lstCategory) : ?>
        <a
            <?php if ($lstIndex === $lstCategoryCount && $lstCurrentWidget->showViewAll()) : ?>
                class="listivo-category-v1 listivo-category-v1--last"
            <?php else : ?>
                class="listivo-category-v1"
            <?php endif; ?>
                href="<?php echo esc_url($lstCategory['url']); ?>"
        >
            <div class="listivo-category-v1__image">
                <?php if (!empty($lstCategory['label'])) : ?>
                    <div class="listivo-category-v1__label">
                        <?php echo esc_html($lstCategory['label']); ?>
                    </div>
                <?php endif; ?>

                <div class="listivo-category-v1__arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" viewBox="0 0 16 15" fill="none">
                        <path d="M9.5174 13.9618C9.34362 14.1355 9.11651 14.2222 8.88895 14.2222C8.66139 14.2222 8.43428 14.1355 8.2605 13.9618C7.91339 13.6147 7.91339 13.052 8.2605 12.7049L12.9654 7.99994H0.888895C0.398225 7.99994 0 7.60172 0 7.11105C0 6.62038 0.398225 6.22215 0.888895 6.22215H12.9654L8.2605 1.51723C7.91339 1.17012 7.91339 0.607449 8.2605 0.260335C8.60761 -0.0867784 9.17029 -0.0867784 9.5174 0.260335L15.7397 6.4826C16.0868 6.82971 16.0868 7.39239 15.7397 7.7395L9.5174 13.9618Z"
                              fill="#FDFDFE"/>
                    </svg>
                </div>

                <img
                        class="lazyload"
                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                        alt="<?php echo esc_attr($lstCategory['name']); ?>"
                    <?php if (!empty($lstCategory['image'])) : ?>
                        data-src="<?php echo esc_url($lstCategory['image']); ?>"
                    <?php endif; ?>
                >
            </div>

            <div class="listivo-category-v1__name">
                <?php echo esc_html($lstCategory['name']); ?>
            </div>
        </a>
    <?php endforeach; ?>

    <?php if ($lstCurrentWidget->showViewAll()) : ?>
        <a
            <?php if ($lstCurrentWidget->isViewStyle2()) : ?>
                class="listivo-category-v1 listivo-category-v1--view-all listivo-category-v1--view-all-style-2"
            <?php elseif ($lstCurrentWidget->isViewStyle3()) : ?>
                class="listivo-category-v1 listivo-category-v1--view-all listivo-category-v1--view-all-style-3"
            <?php else : ?>
                class="listivo-category-v1 listivo-category-v1--view-all"
            <?php endif; ?>
                href="<?php echo esc_url(get_post_type_archive_link(tdf_model_post_type())); ?>"
        >
            <?php if (!empty($lstCurrentWidget->getViewAllImage())) : ?>
                <img
                        class="lazyload"
                        data-src="<?php echo esc_url($lstCurrentWidget->getViewAllImage()); ?>"
                        alt="<?php echo esc_attr($lstCurrentWidget->getViewAllText()); ?>"
                >
            <?php endif; ?>

            <?php if ($lstCurrentWidget->isViewStyle2()) : ?>
                <div class="listivo-category-v1__circle listivo-category-v1__circle--first"></div>

                <div class="listivo-category-v1__circle listivo-category-v1__circle--second"></div>

                <div class="listivo-category-v1__plus">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="23" viewBox="0 0 28 23" fill="none">
                        <path d="M0.43225 11.184L0.43225 6L27.5683 6V11.184H0.43225ZM11.3763 -5.648L16.6883 -5.648V22.832H11.3763L11.3763 -5.648Z"
                              fill="#FDFDFE" fill-opacity="0.95"/>
                    </svg>
                </div>

                <div class="listivo-category-v1__x">
                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 31 31" fill="none">
                        <path d="M9.76705 24.1579L7.01782 21.4086L21.4089 7.0176L24.1581 9.76684L9.76705 24.1579ZM6.64446 9.42742L9.46158 6.61031L24.5654 21.7141L21.7483 24.5312L6.64446 9.42742Z"
                              fill="#FDFDFE" fill-opacity="0.95"/>
                    </svg>
                </div>
            <?php endif; ?>

            <div class="listivo-category-v1__view-all">
                <?php if (!empty($lstCurrentWidget->getViewAllText())) : ?>
                    <?php echo wp_kses_post(nl2br($lstCurrentWidget->getViewAllText())); ?>
                <?php endif; ?>

                <div class="listivo-category-v1__button">
                    <button
                        <?php if ($lstCurrentWidget->isViewStyle2() || $lstCurrentWidget->isViewStyle3()) : ?>
                            class="listivo-button listivo-button--primary-1"
                        <?php else : ?>
                            class="listivo-button listivo-button--primary-2"
                        <?php endif; ?>
                    >
                        <span>
                            <?php echo esc_html(tdf_string('view_all')); ?>

                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                 fill="none">
                                <path d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49605 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455586 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z"
                                      fill="#FDFDFE"/>
                            </svg>
                        </span>
                    </button>
                </div>
            </div>
        </a>
    <?php endif; ?>
</div>
