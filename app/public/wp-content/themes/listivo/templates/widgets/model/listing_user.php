<?php

use Tangibledesign\Framework\Core\Image\RenderUserImage;
use Tangibledesign\Listivo\Widgets\Listing\ListingUserWidget;

/* @var ListingUserWidget $lstCurrentWidget */
global $lstCurrentWidget;
$lstModel = $lstCurrentWidget->getModel();
if (!$lstModel) {
    return;
}

$lstUser = $lstModel->getUser();
if (!$lstUser) {
    return;
}
?>
<div class="listivo-listing-user">
    <a
            class="listivo-listing-user__avatar"
            href="<?php echo esc_url($lstUser->getUrl()); ?>"
    >
        <?php RenderUserImage::render($lstUser, 'listivo_100_100', RenderUserImage::PLACEHOLDER_CIRCLE); ?>
    </a>

    <a
            class="listivo-listing-user__name"
            href="<?php echo esc_url($lstUser->getUrl()); ?>"
    >
        <?php echo esc_html($lstUser->getDisplayName()); ?>
    </a>

    <?php if (!empty($lstUser->getAddress())) : ?>
        <div class="listivo-listing-user__address">
            <div class="listivo-listing-user__address-icon">
                <div class="listivo-small-icon listivo-small-icon--circle listivo-small-icon--primary-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="14" viewBox="0 0 10 14" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M5 0C2.24609 0 0 2.27981 0 5.07505C0 5.8601 0.316406 6.72048 0.753906 7.62843C1.19141 8.54036 1.76172 9.49193 2.33594 10.3602C3.47656 12.1008 4.61328 13.5163 4.61328 13.5163L5 14L5.38672 13.5163C5.38672 13.5163 6.52344 12.1008 7.66797 10.3602C8.23828 9.49193 8.80859 8.54036 9.24609 7.62843C9.68359 6.72048 10 5.8601 10 5.07505C10 2.27981 7.75391 0 5 0ZM5 1.01514C7.21484 1.01514 9 2.82709 9 5.07518C9 5.55096 8.75391 6.33997 8.34766 7.18449C7.94141 8.03298 7.38672 8.95283 6.83594 9.80132C5.99563 11.0789 5.40082 11.8315 5.08146 12.2356L5 12.3388L4.91854 12.2356C4.59919 11.8315 4.00437 11.0789 3.16406 9.80132C2.61328 8.95283 2.05859 8.03298 1.65234 7.18449C1.24609 6.33997 1 5.55096 1 5.07518C1 2.82709 2.78516 1.01514 5 1.01514ZM4.00002 5.06006C4.00002 4.50928 4.44924 4.06006 5.00002 4.06006C5.5508 4.06006 6.00002 4.50928 6.00002 5.06006C6.00002 5.61084 5.5508 6.06006 5.00002 6.06006C4.44924 6.06006 4.00002 5.61084 4.00002 5.06006Z"
                              fill="#FDFDFE"/>
                    </svg>
                </div>
            </div>

            <?php echo esc_html($lstUser->getAddress()); ?>
        </div>
    <?php endif; ?>

    <div class="listivo-listing-user__button">
        <a
                class="listivo-button listivo-button--primary-1"
                href="<?php echo esc_url($lstUser->getUrl()); ?>"
        >
            <span>
                <?php echo esc_html(tdf_string('view_profile')); ?>

                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                     fill="none">
                    <path d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49605 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455586 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z"
                          fill="#FDFDFE"/>
                </svg>
            </span>
        </a>
    </div>
</div>