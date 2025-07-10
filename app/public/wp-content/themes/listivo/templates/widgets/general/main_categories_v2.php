<?php
/* @var \Tangibledesign\Listivo\Widgets\General\MainCategoriesWidget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-main-categories-wrapper">
    <div class="listivo-main-categories">
        <?php foreach ($lstCurrentWidget->getCategories() as $lstCategory) :
            /* @var \Tangibledesign\Framework\Models\Term\Term $lstTerm */
            $lstTerm = $lstCategory['term'];
            ?>
            <div class="listivo-main-category-wrapper">
                <a
                        class="listivo-main-category"
                        href="<?php echo esc_url($lstTerm->getUrl()); ?>"
                >
                    <div class="listivo-main-category__top">
                        <svg
                                class="listivo-main-category__overlay"
                                viewBox="0 0 106 103"
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                style="fill: <?php echo esc_attr($lstCategory['background_color']); ?>;"
                        >
                            <path d="M84.691,87.939 L98.877,82.282 C105.491,79.644 109.050,71.015 106.801,63.070 L93.034,14.436 C91.748,9.894 88.392,6.662 84.431,6.152 L40.018,0.434 C34.771,-0.242 29.638,2.599 26.645,7.835 L1.510,51.812 C-0.246,54.884 0.274,59.071 2.701,61.388 L43.983,100.805 C45.536,102.288 47.605,102.729 49.486,101.979 L74.379,92.051 L79.831,89.854 L84.691,87.939 Z"/>
                        </svg>

                        <div class="listivo-main-category__icon">
                            <?php if (!empty($lstCategory['icon'])) : ?>
                                <?php if ($lstCategory['icon']['library'] === 'svg') : ?>
                                    <?php echo tdf_load_icon($lstCategory['icon']['value']['url']); ?>
                                <?php else : ?>
                                    <i class="<?php echo esc_attr($lstCategory['icon']['value']); ?>"></i>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>

                        <?php if (!empty($lstCategory['icon_class'])) : ?>
                            <svg
                                    class="listivo-main-category__icon-m <?php echo esc_attr($lstCategory['icon_class']); ?>"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="38"
                                    height="42"
                                    viewBox="0 0 135 150"
                                    style="fill: <?php echo esc_attr($lstCategory['background_color']); ?>;"
                            >
                                <path d="M273.286,876.269L256.2,859.3l17.09-16.967a5.486,5.486,0,0,0,0-7.795,5.576,5.576,0,0,0-7.847,0l-17.09,16.971-17.09-16.971a5.576,5.576,0,0,0-7.847,0,5.486,5.486,0,0,0,0,7.795L240.5,859.3l-17.09,16.973a5.482,5.482,0,0,0,0,7.792,5.576,5.576,0,0,0,7.847,0l17.09-16.97,17.09,16.97a5.576,5.576,0,0,0,7.847,0A5.482,5.482,0,0,0,273.286,876.269Zm-92.152,86.182a20.616,20.616,0,1,1-20.615-20.47A20.543,20.543,0,0,1,181.134,962.451Z"
                                      transform="translate(-139.906 -832.938)"/>
                            </svg>
                        <?php endif; ?>
                    </div>

                    <div class="listivo-main-category__bottom">
                        <span><?php echo esc_html($lstTerm->getName()); ?></span>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
