<?php

use Tangibledesign\Listivo\Widgets\General\TitleWithBreadcrumbsWidget;

/* @var TitleWithBreadcrumbsWidget $lstCurrentWidget */
global $lstCurrentWidget;
$lstBreadcrumbs = $lstCurrentWidget->getBreadcrumbs();
$lstBreadcrumbsNumber = count($lstBreadcrumbs) - 1;
$lstBackgroundImage = $lstCurrentWidget->getBackgroundImage();
?>
<div
    <?php if ($lstCurrentWidget->isFullWidth()) : ?>
        class="listivo-title-with-breadcrumbs listivo-title-with-breadcrumbs--full-width"
    <?php else : ?>
        class="listivo-title-with-breadcrumbs"
    <?php endif; ?>
>
    <div
            class="listivo-title-with-breadcrumbs__container"
        <?php if (!empty($lstBackgroundImage)) : ?>
            style="background-image: url('<?php echo esc_url($lstBackgroundImage); ?>');"
        <?php endif; ?>
    >
        <div class="listivo-container">
            <h1 class="listivo-title-with-breadcrumbs__title">
                <?php echo wp_kses_post($lstCurrentWidget->getTitle()); ?>
            </h1>
        </div>

        <div class="listivo-title-with-breadcrumbs__breadcrumbs">
            <div class="listivo-container">
                <div class="listivo-breadcrumbs-wrapper-v2">
                    <div class="listivo-breadcrumbs-v2 listivo-breadcrumbs-v2--v2">
                        <?php foreach ($lstBreadcrumbs as $lstIndex => $lstBreadcrumb) : ?>
                            <?php if ($lstIndex < $lstBreadcrumbsNumber) : ?>
                                <a
                                        class="listivo-breadcrumbs-v2__item"
                                        href="<?php echo esc_url($lstBreadcrumb['url']); ?>"
                                        title="<?php echo esc_attr($lstBreadcrumb['name']); ?>"
                                >
                                    <?php echo esc_html($lstBreadcrumb['name']); ?>
                                </a>

                                <span class="listivo-breadcrumbs-v2__separator">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="5" height="7" viewBox="0 0 5 7"
                                         fill="none">
                                        <path d="M2.56744 3.5L0.192673 1.12523C-0.0646296 0.86793 -0.0646296 0.45028 0.192673 0.192977C0.449976 -0.0643258 0.867626 -0.0643258 1.12493 0.192977L3.99255 3.0606C4.23556 3.3036 4.23556 3.69702 3.99255 3.9394L1.12493 6.80702C0.867626 7.06433 0.449976 7.06433 0.192673 6.80702C-0.0646296 6.54972 -0.0646296 6.13207 0.192673 5.87477L2.56744 3.5Z"
                                              fill="#F09965"/>
                                    </svg>
                                </span>
                            <?php else : ?>
                                <span class="listivo-breadcrumbs-v2__item">
                                    <?php echo esc_html($lstBreadcrumb['name']); ?>
                                </span>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>