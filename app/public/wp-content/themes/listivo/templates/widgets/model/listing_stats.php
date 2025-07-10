<?php

use Tangibledesign\Listivo\Widgets\Listing\ListingStatsWidget;

/* @var ListingStatsWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstCurrentListing = $lstCurrentWidget->getModel();
if (!$lstCurrentListing) {
    return;
}
?>
<div class="listivo-listing-stats">
    <?php if ($lstCurrentWidget->showAccountType()) :
        $lstUser = $lstCurrentListing->getUser();
        if ($lstUser) : ?>
            <div class="listivo-listing-stat">
                <div class="listivo-listing-stat__icon">
                    <i class="far fa-user"></i>
                </div>

                <?php echo esc_html($lstCurrentListing->getUser()->getDisplayAccountType()); ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($lstCurrentWidget->showAccountType()) : ?>
        <?php if ($lstCurrentWidget->showPublishDate() || $lstCurrentWidget->showViewsCount()) : ?>
            <div class="listivo-listing-stats__container">
                <?php if ($lstCurrentWidget->showPublishDate()) : ?>
                    <div class="listivo-listing-stat">
                        <div class="listivo-listing-stat__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
                                 fill="none">
                                <path d="M6 0C2.6934 0 0 2.6934 0 6C0 9.3066 2.6934 12 6 12C9.3066 12 12 9.3066 12 6C12 2.6934 9.3066 0 6 0ZM6 1.2C8.65807 1.2 10.8 3.34193 10.8 6C10.8 8.65807 8.65807 10.8 6 10.8C3.34193 10.8 1.2 8.65807 1.2 6C1.2 3.34193 3.34193 1.2 6 1.2ZM5.4 2.4V6.24844L7.97578 8.82422L8.82422 7.97578L6.6 5.75156V2.4H5.4Z"
                                      fill="#374B5C"/>
                            </svg>
                        </div>

                        <?php echo esc_html($lstCurrentListing->getPublishDateDiff()); ?>
                    </div>
                <?php endif; ?>

                <?php if ($lstCurrentWidget->showViewsCount()) : ?>
                    <div class="listivo-listing-stat">
                        <div class="listivo-listing-stat__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="9" viewBox="0 0 12 9"
                                 fill="none">
                                <path d="M6 0C1.63636 0 0 4.36364 0 4.36364C0 4.36364 1.63636 8.72727 6 8.72727C10.3636 8.72727 12 4.36364 12 4.36364C12 4.36364 10.3636 0 6 0ZM6 1.09091C8.87782 1.09091 10.3334 3.41841 10.8047 4.36151C10.3329 5.29805 8.86636 7.63636 6 7.63636C3.12218 7.63636 1.66659 5.30886 1.19531 4.36577C1.66768 3.42922 3.13364 1.09091 6 1.09091ZM6 2.18182C4.79509 2.18182 3.81818 3.15873 3.81818 4.36364C3.81818 5.56854 4.79509 6.54545 6 6.54545C7.20491 6.54545 8.18182 5.56854 8.18182 4.36364C8.18182 3.15873 7.20491 2.18182 6 2.18182ZM6 3.27273C6.60273 3.27273 7.09091 3.76091 7.09091 4.36364C7.09091 4.96636 6.60273 5.45455 6 5.45455C5.39727 5.45455 4.90909 4.96636 4.90909 4.36364C4.90909 3.76091 5.39727 3.27273 6 3.27273Z"
                                      fill="#374B5C"/>
                            </svg>
                        </div>

                        <?php echo esc_html($lstCurrentListing->getViews() . ' ' . tdf_string('views')); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php else : ?>
        <?php if ($lstCurrentWidget->showPublishDate()) : ?>
            <div class="listivo-listing-stat">
                <div class="listivo-listing-stat__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                        <path d="M6 0C2.6934 0 0 2.6934 0 6C0 9.3066 2.6934 12 6 12C9.3066 12 12 9.3066 12 6C12 2.6934 9.3066 0 6 0ZM6 1.2C8.65807 1.2 10.8 3.34193 10.8 6C10.8 8.65807 8.65807 10.8 6 10.8C3.34193 10.8 1.2 8.65807 1.2 6C1.2 3.34193 3.34193 1.2 6 1.2ZM5.4 2.4V6.24844L7.97578 8.82422L8.82422 7.97578L6.6 5.75156V2.4H5.4Z"
                              fill="#374B5C"/>
                    </svg>
                </div>

                <?php echo esc_html($lstCurrentListing->getPublishDateDiff()); ?>
            </div>
        <?php endif; ?>

        <?php if ($lstCurrentWidget->showViewsCount()) : ?>
            <div class="listivo-listing-stat">
                <div class="listivo-listing-stat__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="9" viewBox="0 0 12 9" fill="none">
                        <path d="M6 0C1.63636 0 0 4.36364 0 4.36364C0 4.36364 1.63636 8.72727 6 8.72727C10.3636 8.72727 12 4.36364 12 4.36364C12 4.36364 10.3636 0 6 0ZM6 1.09091C8.87782 1.09091 10.3334 3.41841 10.8047 4.36151C10.3329 5.29805 8.86636 7.63636 6 7.63636C3.12218 7.63636 1.66659 5.30886 1.19531 4.36577C1.66768 3.42922 3.13364 1.09091 6 1.09091ZM6 2.18182C4.79509 2.18182 3.81818 3.15873 3.81818 4.36364C3.81818 5.56854 4.79509 6.54545 6 6.54545C7.20491 6.54545 8.18182 5.56854 8.18182 4.36364C8.18182 3.15873 7.20491 2.18182 6 2.18182ZM6 3.27273C6.60273 3.27273 7.09091 3.76091 7.09091 4.36364C7.09091 4.96636 6.60273 5.45455 6 5.45455C5.39727 5.45455 4.90909 4.96636 4.90909 4.36364C4.90909 3.76091 5.39727 3.27273 6 3.27273Z"
                              fill="#374B5C"/>
                    </svg>
                </div>

                <?php echo esc_html($lstCurrentListing->getViews() . ' ' . tdf_string('views')); ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>