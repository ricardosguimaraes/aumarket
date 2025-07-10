<?php

use Tangibledesign\Framework\Models\Notification\Notification;
use Tangibledesign\Framework\Models\Notification\NotificationType;
use Tangibledesign\Framework\Models\Notification\Trigger;

?>
<div class="tdf-app wrap">
    <h1 class="wp-heading-inline">
        <?php esc_html_e('Add New Notification', 'listivo-core'); ?>
    </h1>

    <template>
        <form
                action="<?php echo esc_url(admin_url('admin-post.php?action=listivo/notifications/create')); ?>"
                method="post"
        >
            <input
                    type="hidden"
                    name="nonce"
                    value="<?php echo esc_attr(wp_create_nonce('listivo/notifications/create')); ?>"
            >

            <table class="form-table">
                <tbody>
                <tr>
                    <th scope="row">
                        <label for="<?php echo esc_attr(Notification::NAME); ?>">
                            <?php esc_html_e('Name', 'listivo-core'); ?>
                        </label>
                    </th>

                    <td>
                        <input
                                id="<?php echo esc_attr(Notification::NAME); ?>"
                                name="<?php echo esc_attr(Notification::NAME); ?>"
                                class="regular-text"
                                type="text"
                                required
                        >
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="<?php echo esc_attr(Notification::TYPES); ?>">
                            <?php esc_html_e('Type', 'listivo-core'); ?>
                        </label>
                    </th>

                    <td>
                        <select
                                name="<?php echo esc_attr(Notification::TYPES); ?>[]"
                                id="<?php echo esc_attr(Notification::TYPES); ?>"
                                class="tdf-selectize tdf-selectize-init"
                                multiple
                        >
                            <?php foreach (NotificationType::getListWithNames() as $notificationType => $notificationTypeName) : ?>
                                <option value="<?php echo esc_attr($notificationType); ?>">
                                    <?php echo esc_html($notificationTypeName); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="<?php echo esc_attr(Notification::TRIGGER); ?>">
                            <?php esc_html_e('Trigger', 'listivo-core'); ?>
                        </label>
                    </th>

                    <td>
                        <select
                                name="<?php echo esc_attr(Notification::TRIGGER); ?>"
                                id="<?php echo esc_attr(Notification::TRIGGER); ?>"
                        >
                            <?php foreach (Trigger::getListWithNames() as $trigger => $triggerName) : ?>
                                <option value="<?php echo esc_attr($trigger); ?>">
                                    <?php echo esc_html($triggerName); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                </tbody>
            </table>

            <button class="button button-primary">
                <?php esc_html_e('Add Notification', 'listivo-core'); ?>
            </button>
        </form>
    </template>
</div>
