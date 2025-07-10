<?php

use Tangibledesign\Framework\Models\Notification\Notification;

$notifications = tdf_query_notifications()->get();
?>
<div class="listivo-backend-content">
    <p class="listivo-backend-description">
        <a
                href="https://support.listivotheme.com/support/solutions/articles/101000465888-notifications"
                target="_blank"
        >
            <?php esc_html_e('Learn more about notifications', 'listivo-core'); ?>
        </a>
    </p>

    <p class="listivo-backend-description listivo-backend-description--wide">
        <?php esc_html_e('Due to WordPress technology, it is not possible to perform certain tasks in a cyclical manner, e.g. regularly every 5 minutes. However, it is possible to easily solve this problem by appropriate configuration.',
            'listivo-core'); ?>

        <strong>
            <a
                    href="https://support.listivotheme.com/support/solutions/articles/101000466117-wp-cron-system"
                    target="_blank"
            >
                <?php esc_html_e('Learn how to set up cron jobs', 'listivo-core'); ?>
            </a>
        </strong>
    </p>

    <table class="wp-list-table widefat fixed striped posts listivo-backend-table listivo-backend-table--compact">
        <thead>
        <tr>
            <th class="listivo-backend-table__col listivo-backend-table__col--primary">
                <span><?php esc_html_e('Name', 'listivo-core'); ?></span>
            </th>

            <th class="listivo-backend-table__col listivo-backend-table__col--trigger">
                <span><?php esc_html_e('Trigger', 'listivo-core'); ?></span>
            </th>

            <th class="listivo-backend-table__col">
                <span><?php esc_html_e('Types', 'listivo-core'); ?></span>
            </th>

            <th class="listivo-backend-table__col listivo-backend-table__col--actions">
                <?php esc_html_e('Actions', 'listivo-core'); ?>
            </th>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($notifications as $notification) : /* @var Notification $notification */ ?>
            <tr>
                <td class="listivo-backend-table__cell listivo-backend-table__cell--primary">
                    <?php echo esc_html($notification->getName()); ?>
                </td>

                <td class="listivo-backend-table__cell">
                    <?php echo esc_html($notification->getFormattedTrigger()); ?>
                </td>

                <td class="listivo-backend-table__cell">
                    <?php echo esc_html(implode(', ', $notification->getFormattedTypes())); ?>
                </td>

                <td class="listivo-backend-table__cell">
                    <a
                            class="button button-small button-primary"
                            href="<?php echo esc_url($notification->getEditUrl()); ?>"
                    >
                        <?php esc_html_e('Edit', 'listivo-core'); ?>
                    </a>

                    <lst-delete-notification
                            request-url="<?php echo esc_url(tdf_action_url('listivo/notifications/delete')); ?>"
                            delete-nonce="<?php echo esc_attr(wp_create_nonce('listivo/notifications/delete')); ?>"
                            :notification-id="<?php echo esc_attr($notification->getId()); ?>"
                            delete-title-text="<?php esc_attr_e('Are you sure?', 'listivo-core'); ?>"
                            confirm-button-text="<?php esc_attr_e('Confirm', 'listivo-core'); ?>"
                            cancel-button-text="<?php esc_attr_e('Cancel', 'listivo-core'); ?>"
                    >
                        <button
                                class="button button-small button-secondary"
                                slot-scope="deleteNotification"
                                @click.stop.prevent="deleteNotification.onClick"
                        >
                            <?php esc_html_e('Delete', 'listivo-core'); ?>
                        </button>
                    </lst-delete-notification>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
