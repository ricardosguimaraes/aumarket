<?php

use Tangibledesign\Framework\Models\Term\CustomTerm;
use Tangibledesign\Listivo\Widgets\General\CategoriesV4Widget;

/* @var CategoriesV4Widget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-categories-v4">
    <?php foreach ($lstCurrentWidget->getCategories() as $lstCategory) :
        /* @var CustomTerm $lstTerm */
        $lstTerm = $lstCategory['term'];
        ?>
        <div class="listivo-category-v4">
            <div class="listivo-category-v4__left">
                <div class="listivo-category-v4__top">
                    <?php if (!empty($lstCategory['icon']['url'])) : ?>
                        <div class="listivo-category-v4__image">
                            <img
                                    class="lazyload"
                                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                                    data-src="<?php echo esc_url($lstCategory['icon']['url']); ?>"
                                    alt="<?php echo esc_attr($lstTerm->getName()); ?>"
                            >
                        </div>
                    <?php endif; ?>

                    <h3 class="listivo-category-v4__heading">
                        <?php echo esc_html($lstTerm->getName()); ?>
                    </h3>
                </div>

                <a
                        class="listivo-category-v4__button listivo-button-border-radius-selector listivo-category-v4__button--hide-mobile"
                        href="<?php echo esc_url($lstTerm->getUrl()); ?>"
                >
                    <?php echo esc_html(tdf_string('view_all')); ?>
                </a>
            </div>

            <div class="listivo-category-v4__list">
                <?php foreach ($lstTerm->getMultilevelChildren($lstCurrentWidget->getLimit(), 'count') as $lstItem) : ?>
                    <a
                            class="listivo-category-v4__item"
                            href="<?php echo esc_url($lstItem->getUrl()); ?>"
                    >
                        <h4 class="listivo-category-v4__label">
                            <?php echo esc_html($lstItem->getName()); ?>
                        </h4>

                        <div class="listivo-category-v4__count">
                            <?php echo esc_html($lstItem->getCount()); ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <div class="listivo-category-v4__mobile-button">
                <a
                        class="listivo-category-v4__button listivo-button-border-radius-selector"
                        href="<?php echo esc_url($lstTerm->getUrl()); ?>"
                >
                    <?php echo esc_html(tdf_string('view_all')); ?>
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>