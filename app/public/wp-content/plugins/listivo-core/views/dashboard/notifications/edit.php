<?php

use Tangibledesign\Framework\Models\Notification\ModelExpireNotification;
use Tangibledesign\Framework\Models\Notification\Notification;
use Tangibledesign\Framework\Models\Notification\NotificationType;
use Tangibledesign\Framework\Models\Notification\SendToGroups;

$notification = tdf_notification_factory()->create((int)($_GET['notificationId'] ?? 0));
if (!$notification) {
    return;
}
?>
<div class="tdf-app wrap">
    <h1 class="wp-heading-inline">
        <?php esc_html_e('Edit Notification', 'listivo-core'); ?>
    </h1>

    <p class="listivo-backend-description">
        <?php echo esc_html($notification->getHint()); ?>
    </p>

    <?php if ($notification->sendToUser()) : ?>
        <p class="listivo-backend-description">
            <strong>
                <?php esc_html_e('This notification will be sent to the ad owner.', 'listivo-core'); ?>
            </strong>
        </p>
    <?php endif; ?>

    <p class="listivo-backend-description">
        <strong><?php esc_html_e('Tags:', 'listivo-core'); ?></strong>

        <?php echo esc_html($notification->getAllowedTagsFormatted()); ?>
    </p>

    <lst-edit-notification
        <?php if (!empty($notification->getTypes())) : ?>
            :initial-types="<?php echo htmlspecialchars(json_encode($notification->getTypes())); ?>"
        <?php endif; ?>
    >
        <div slot-scope="editNotification">
            <template>
                <form
                        action="<?php echo esc_url(tdf_action_url('listivo/notifications/update')); ?>"
                        method="post"
                >
                    <input
                            type="hidden"
                            name="nonce"
                            value="<?php echo esc_attr(wp_create_nonce('listivo/notifications/update')); ?>"
                    >

                    <input
                            type="hidden"
                            name="notificationId"
                            value="<?php echo esc_attr($notification->getId()); ?>"
                    >

                    <input
                            type="hidden"
                            name="<?php echo esc_attr(Notification::TRIGGER); ?>"
                            value="<?php echo esc_attr($notification->getTrigger()); ?>"
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
                                        value="<?php echo esc_attr($notification->getName()); ?>"
                                        required
                                >
                            </td>
                        </tr>

                        <?php if ($notification->sendToGroup()) : ?>
                            <tr>
                                <th scope="row">
                                    <label for="<?php echo esc_attr(Notification::SEND_TO_GROUPS); ?>">
                                        <?php esc_html_e('Send To', 'listivo-core'); ?>
                                    </label>
                                </th>

                                <td>
                                    <select
                                            name="<?php echo esc_attr(Notification::SEND_TO_GROUPS); ?>[]"
                                            id="<?php echo esc_attr(Notification::SEND_TO_GROUPS); ?>"
                                            class="tdf-selectize-init"
                                            multiple
                                    >
                                        <?php foreach (SendToGroups::getListWithNames() as $group => $name) : ?>
                                            <option
                                                    value="<?php echo esc_attr($group); ?>"
                                                <?php if (in_array($group, $notification->getSendToGroups(), true)) : ?>
                                                    selected
                                                <?php endif; ?>
                                            >
                                                <?php echo esc_html($name); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                        <?php endif; ?>

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
                                        class="tdf-selectize"
                                        multiple
                                >
                                    <?php foreach (NotificationType::getListWithNames() as $notificationType => $notificationTypeName) : ?>
                                        <option
                                                value="<?php echo esc_attr($notificationType); ?>"
                                            <?php if (in_array($notificationType, $notification->getTypes(), true)) : ?>
                                                selected
                                            <?php endif; ?>
                                        >
                                            <?php echo esc_html($notificationTypeName); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>

                        <tr v-show="editNotification.showMailSettings">
                            <th scope="row">
                                <label for="<?php echo esc_attr(Notification::MAIL_TITLE); ?>">
                                    <?php esc_html_e('Mail Title', 'listivo-core'); ?>
                                </label>
                            </th>

                            <td>
                                <input
                                        id="<?php echo esc_attr(Notification::MAIL_TITLE); ?>"
                                        name="<?php echo esc_attr(Notification::MAIL_TITLE); ?>"
                                        class="regular-text"
                                        type="text"
                                        value="<?php echo esc_attr($notification->getMailTitle()); ?>"
                                >
                            </td>
                        </tr>

                        <tr v-show="editNotification.showMailSettings">
                            <th scope="row">
                                <label for="<?php echo esc_attr(Notification::MAIL_TEXT); ?>">
                                    <?php esc_html_e('Mail Body', 'listivo-core'); ?>
                                </label>
                            </th>

                            <td>
                                <textarea
                                        id="<?php echo esc_attr(Notification::MAIL_TEXT); ?>"
                                        name="<?php echo esc_attr(Notification::MAIL_TEXT); ?>"
                                        class="listivo-backend-text-area"
                                        rows="10"
                                        cols="30"
                                ><?php echo wp_kses_post($notification->getMailText()); ?></textarea>
                            </td>
                        </tr>

                        <tr v-show="editNotification.showSmsSettings">
                            <th scope="row">
                                <label for="<?php echo esc_attr(Notification::SMS_TEXT); ?>">
                                    <?php esc_html_e('SMS', 'listivo-core'); ?>
                                </label>
                            </th>

                            <td>
                                <textarea
                                        id="<?php echo esc_attr(Notification::SMS_TEXT); ?>"
                                        name="<?php echo esc_attr(Notification::SMS_TEXT); ?>"
                                        class="listivo-backend-text-area"
                                        rows="5"
                                        cols="30"
                                ><?php echo wp_kses_post($notification->getSmsText()); ?></textarea>
                            </td>
                        </tr>

                        <?php if ($notification instanceof ModelExpireNotification) : ?>
                            <tr>
                                <th scope="row">
                                    <label for="<?php echo esc_attr(ModelExpireNotification::HOURS); ?>">
                                        <?php esc_html_e('Number of hours before expiration', 'listivo-core'); ?>
                                    </label>
                                </th>

                                <td>
                                    <input
                                            id="<?php echo esc_attr(ModelExpireNotification::HOURS); ?>"
                                            name="<?php echo esc_attr(ModelExpireNotification::HOURS); ?>"
                                            class="regular-text"
                                            type="text"
                                        <?php if (!empty($notification->getHours())) : ?>
                                            value="<?php echo esc_attr($notification->getHours()); ?>"
                                        <?php endif; ?>
                                    >
                                </td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>

                    <button class="button button-primary">
                        <?php esc_html_e('Save Changes', 'listivo-core'); ?>
                    </button>
                </form>
            </template>
        </div>
    </lst-edit-notification>
</div>
