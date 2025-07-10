<?php

use Tangibledesign\Listivo\Widgets\User\UserListingsWidget;

/* @var UserListingsWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstUser = $lstCurrentWidget->getUser();
if (!$lstUser) {
    return;
}
$lstModels = $lstCurrentWidget->getListings();
if ($lstModels->isEmpty()) {
    return;
}
?>
<div class="listivo-app <?php echo esc_attr($lstCurrentWidget->getFeaturedLabelClasses()); ?>">
    <?php if ($lstCurrentWidget->showLabel()) : ?>
        <div class="listivo-user-listings__label">
            <?php echo esc_html($lstCurrentWidget->getLabel()); ?>

            <div class="listivo-user-listings__count">
                <?php echo esc_html($lstUser->getPublishedModelNumber()); ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="listivo-user-listings__list">
        <div class="listivo-listing-grid">
            <?php
            global $lstCurrentListing;
            foreach ($lstModels as $lstCurrentListing) : ?>
                <?php $lstCurrentWidget->loadCardTemplate(); ?>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="listivo-user-listings__pagination">
        <?php
        global $lstPagination;
        $lstPagination = $lstCurrentWidget->getPaginator();

        get_template_part('templates/partials/pagination');
        ?>
    </div>

    <div class="listivo-user-listings__mobile-pagination">
        <?php
        global $lstPagination;
        $lstPagination = $lstCurrentWidget->getPaginator(3);
        get_template_part('templates/partials/pagination');
        ?>
    </div>
</div>