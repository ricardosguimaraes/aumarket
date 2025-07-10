<?php

use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\User\User;
use Tangibledesign\Listivo\Widgets\PrintModel\PrintUserWidget;

/* @var PrintUserWidget $lstCurrentWidget */
global $lstCurrentWidget;
$lstModel = $lstCurrentWidget->getModel();
if (!$lstModel instanceof Model) {
    return;
}

$lstUser = $lstModel->getUser();
if (!$lstUser instanceof User) {
    return;
}
?>
<div class="listivo-print-user-wrapper">
    <?php if (!empty($lstCurrentWidget->getLabel())) : ?>
        <h3 class="listivo-print-label listivo-print-label--margin-bottom">
            <?php echo esc_html($lstCurrentWidget->getLabel()); ?>
        </h3>
    <?php endif; ?>

    <div class="listivo-print-user">
        <div class="listivo-print-user__avatar">
            <?php if ($lstUser->hasImageUrl('listivo_100_100')) : ?>
                <img
                        src="<?php echo esc_url($lstUser->getImageUrl('listivo_100_100')); ?>"
                        alt="<?php echo esc_attr($lstUser->getDisplayName()); ?>"
                >
            <?php else : ?>
                <div class="listivo-user-image-placeholder listivo-user-image-placeholder--circle">
                    <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 132 148"
                            fill="none"
                    >
                        <path d="M6 141.5C6 120.789 32.8629 104 66 104C99.1371 104 126 120.789 126 141.5M103.5 44.0001C103.5 64.7108 86.7107 81.5002 66 81.5002C45.2893 81.5002 28.5 64.7108 28.5 44.0001C28.5 23.2894 45.2893 6.5 66 6.5C86.7107 6.5 103.5 23.2894 103.5 44.0001Z"
                              stroke="#D5E3EE" stroke-width="12" stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                </div>
            <?php endif; ?>
        </div>

        <div class="listivo-print-user__info">
            <div class="listivo-print-user__name">
                <?php echo esc_html($lstUser->getDisplayName()); ?>
            </div>

            <?php if ($lstUser->hasPhone()) : ?>
                <div class="listivo-print-user__data">
                    <div class="listivo-print-user__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="15" viewBox="0 0 10 15" fill="none">
                            <path d="M2.37505 0.399902C1.51142 0.399902 0.800049 1.11128 0.800049 1.9749V12.8249C0.800049 13.6885 1.51142 14.3999 2.37505 14.3999H7.62505C8.48867 14.3999 9.20005 13.6885 9.20005 12.8249V1.9749C9.20005 1.11128 8.48867 0.399902 7.62505 0.399902H2.37505ZM2.37505 1.4499H7.62505C7.92132 1.4499 8.15005 1.67863 8.15005 1.9749V12.8249C8.15005 13.1212 7.92132 13.3499 7.62505 13.3499H2.37505C2.07877 13.3499 1.85005 13.1212 1.85005 12.8249V1.9749C1.85005 1.67863 2.07877 1.4499 2.37505 1.4499ZM5.00005 2.4999C4.86081 2.4999 4.72727 2.55521 4.62882 2.65367C4.53036 2.75213 4.47505 2.88566 4.47505 3.0249C4.47505 3.16414 4.53036 3.29768 4.62882 3.39613C4.72727 3.49459 4.86081 3.5499 5.00005 3.5499C5.13929 3.5499 5.27282 3.49459 5.37128 3.39613C5.46974 3.29768 5.52505 3.16414 5.52505 3.0249C5.52505 2.88566 5.46974 2.75213 5.37128 2.65367C5.27282 2.55521 5.13929 2.4999 5.00005 2.4999ZM4.12505 11.2499C4.05548 11.2489 3.98641 11.2618 3.92185 11.2877C3.85729 11.3137 3.79853 11.3522 3.74899 11.401C3.69945 11.4499 3.6601 11.5081 3.63325 11.5723C3.6064 11.6364 3.59257 11.7053 3.59257 11.7749C3.59257 11.8445 3.6064 11.9134 3.63325 11.9775C3.6601 12.0417 3.69945 12.0999 3.74899 12.1488C3.79853 12.1976 3.85729 12.2361 3.92185 12.2621C3.98641 12.288 4.05548 12.3009 4.12505 12.2999H5.87505C5.94462 12.3009 6.01369 12.288 6.07825 12.2621C6.1428 12.2361 6.20156 12.1976 6.25111 12.1488C6.30065 12.0999 6.33999 12.0417 6.36685 11.9775C6.3937 11.9134 6.40753 11.8445 6.40753 11.7749C6.40753 11.7053 6.3937 11.6364 6.36685 11.5723C6.33999 11.5081 6.30065 11.4499 6.25111 11.401C6.20156 11.3522 6.1428 11.3137 6.07825 11.2877C6.01369 11.2618 5.94462 11.2489 5.87505 11.2499H4.12505Z"
                                  fill="#537CD9"/>
                        </svg>
                    </div>

                    <?php echo esc_html($lstUser->getPhone()); ?>
                </div>
            <?php endif; ?>

            <div class="listivo-print-user__data">
                <div class="listivo-print-user__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="10" viewBox="0 0 12 10" fill="none">
                        <path d="M1.2 0.200195C0.537 0.200195 0 0.718888 0 1.35929V2.3633L0.6 2.72665L1.2 3.09L6 5.99565L10.8 3.10924L11.4 2.74816L12 2.38821V1.35929C12 0.718888 11.463 0.200195 10.8 0.200195H1.2ZM1.2 1.35929H10.8V1.80526L6 4.69054L1.2 1.78489V1.35929ZM0 3.73067V8.31383C0 8.95423 0.537 9.47292 1.2 9.47292H10.8C11.463 9.47292 12 8.95423 12 8.31383V3.75331L10.8 4.47434V8.31383H1.2V4.45736L0 3.73067Z"
                              fill="#537CD9"/>
                    </svg>
                </div>

                <?php echo esc_html($lstUser->getMail()); ?>
            </div>
        </div>
    </div>
</div>