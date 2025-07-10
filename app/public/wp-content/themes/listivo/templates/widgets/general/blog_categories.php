<?php
/* @var \Tangibledesign\Listivo\Widgets\General\BlogCategoriesWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstCategories = $lstCurrentWidget->getCategories();
if ($lstCategories->isEmpty()) {
    return;
}
?>
<div class="listivo-sidebar-widget">
    <h3 class="listivo-sidebar-widget__label">
        <?php echo esc_html(tdf_string('categories')); ?>
    </h3>

    <div class="listivo-sidebar-widget__content">
        <div class="listivo-sidebar-list">
            <?php foreach ($lstCategories as $lstCategory) : ?>
                <a
                        class="listivo-sidebar-list__item"
                        href="<?php echo esc_url($lstCategory->getUrl()); ?>"
                >
                    <span class="listivo-sidebar-list__label">
                        <?php echo esc_html($lstCategory->getName()); ?>
                    </span>

                    <span class="listivo-sidebar-list__count">
                        <?php echo esc_html($lstCategory->getCount()); ?>
                    </span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>