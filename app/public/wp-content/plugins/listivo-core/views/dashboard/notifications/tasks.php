<?php

use Tangibledesign\Framework\Models\Notification\Tasks\NotificationTask;

$perPage = 15;
$currentPage = (int)($_GET['pagination'] ?? 1);
$query = tdf_query_notification_tasks();

$notificationTasks = $query
    ->take($perPage)
    ->setPage($currentPage)
    ->orderByNewest()
    ->get();

$maxResults = $query->getResultsNumber();
$maxPage = (int)ceil($maxResults / $perPage);
?>
<div class="listivo-backend-content">
    <table class="wp-list-table widefat fixed striped posts listivo-backend-table listivo-backend-table--medium">
        <thead>
        <tr>
            <th class="listivo-backend-table__col listivo-backend-table__col--primary">
                <span><?php esc_html_e('Name', 'listivo-core'); ?></span>
            </th>

            <th class="listivo-backend-table__col">
                <span><?php esc_html_e('Recipient', 'listivo-core'); ?></span>
            </th>

            <th class="listivo-backend-table__col listivo-backend-table__col--date">
                <span><?php esc_html_e('Created', 'listivo-core'); ?></span>
            </th>

            <th class="listivo-backend-table__col">
                <span><?php esc_html_e('Type', 'listivo-core'); ?></span>
            </th>

            <th class="listivo-backend-table__col">
                <span><?php esc_html_e('Status', 'listivo-core'); ?></span>
            </th>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($notificationTasks as $notificationTask) : /*  @var NotificationTask $notificationTask */
            $notification = $notificationTask->getNotification();
            if (!$notification) {
                continue;
            }
            ?>
            <tr>
                <td class="listivo-backend-table__cell listivo-backend-table__cell--primary">
                    <?php echo esc_html($notification->getName()); ?>
                </td>

                <td class="listivo-backend-table__cell">
                    <?php
                    $userTo = $notificationTask->getUserTo();
                    if ($userTo) :?>
                        <a href="<?php echo esc_url($userTo->getBackendEditUrl()); ?>">
                            <?php echo esc_html($userTo->getDisplayName()); ?>
                        </a>
                    <?php endif; ?>
                </td>

                <td class="listivo-backend-table__cell">
                    <?php echo esc_html($notificationTask->getPublishTime().', '.$notificationTask->getPublishDate()); ?>
                </td>

                <td class="listivo-backend-table__cell">
                    <?php echo esc_html($notificationTask->getTypeFormatted()); ?>
                </td>

                <td class="listivo-backend-table__cell">
                    <?php echo esc_html($notificationTask->getStatusFormatted()); ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php if ($maxPage > 1) : ?>
        <div class="listivo-backend-content__pagination">
            <div class="listivo-backend-pagination">
                <span class="displaying-num"><?php echo esc_html($query->getResultsNumber()) ?> items</span>

                <?php if ($currentPage === 1) : ?>
                    <span class="button disabled">«</span>
                    <span class="button disabled">‹</span>
                <?php else : ?>
                    <a
                            class="button"
                            href="<?php echo esc_url(admin_url('admin.php?page=listivo_notifications&tab=logs&pagination=1')); ?>"
                    >
                        <span>«</span>
                    </a>

                    <a
                            class="button"
                            href="<?php echo esc_url(admin_url('admin.php?page=listivo_notifications&tab=logs&pagination='.($currentPage - 1))); ?>"
                    >
                        <span>‹</span>
                    </a>
                <?php endif; ?>

                <?php echo esc_html($currentPage); ?> of <?php echo esc_html($maxPage); ?>

                <?php if ($maxPage === $currentPage) : ?>
                    <span class="button disabled">›</span>

                    <span class="button disabled">››</span>
                <?php else : ?>
                    <a
                            class="button"
                            href="<?php echo esc_url(admin_url('admin.php?page=listivo_notifications&tab=logs&pagination='.($currentPage + 1))); ?>"
                    >
                        <span>›</span>
                    </a>

                    <a
                            class="button"
                            href="<?php echo esc_url(admin_url('admin.php?page=listivo_notifications&tab=logs&pagination='.$maxPage)); ?>"
                    >
                        <span>»</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>