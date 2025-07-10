<?php

use Tangibledesign\Framework\Core\Notification;

foreach (tdf_app('notifications') as $notification) : /* @var Notification $notification */
    ?>
    <h3><?php echo esc_html($notification->label); ?></h3>

    <?php if (!empty($notification->description)) : ?>
    <p class="listivo-backend-description">
        <?php echo esc_html($notification->description); ?>
    </p>

    <p><?php echo sprintf(esc_html__('Available variables: %s', 'listivo-core'),
            $notification->getAvailableVarsString()); ?></p>
<?php endif; ?>

    <table class="form-table">
        <tbody>
        <?php if ($notification->optional) : ?>
            <tr>
                <th scope="row">
                    <label for="<?php echo esc_attr($notification->key); ?>-enabled">
                        <?php esc_html_e('Enabled', 'listivo-core'); ?>
                    </label>
                </th>

                <td>
                    <label for="<?php echo esc_attr($notification->key); ?>-enabled">
                        <input
                                id="<?php echo esc_attr($notification->key); ?>-enabled"
                                type="checkbox"
                                value="1"
                                name="notifications[<?php echo esc_attr($notification->key); ?>][enabled]"
                            <?php if ($notification->isEnabled()) : ?>
                                checked
                            <?php endif; ?>
                        >
                    </label>
                </td>
            </tr>
        <?php endif; ?>

        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr($notification->key); ?>-title">
                    <?php esc_html_e('Title', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                <label for="<?php echo esc_attr($notification->key); ?>-title">
                    <input
                            id="<?php echo esc_attr($notification->key); ?>-title"
                            name="notifications[<?php echo esc_attr($notification->key); ?>][title]"
                            class="regular-text"
                            value="<?php echo esc_attr($notification->title); ?>"
                            type="text"
                    >
                </label>
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr($notification->key); ?>-text">
                    <?php esc_html_e('Message', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                    <textarea
                            id="<?php echo esc_attr($notification->key); ?>-text"
                            name="notifications[<?php echo esc_attr($notification->key); ?>][message]"
                            class="listivo-backend-text-area"
                            rows="5"
                            cols="30"
                    ><?php echo wp_kses_post($notification->message); ?></textarea>
            </td>
        </tr>
        </tbody>
    </table>

    <p class="submit">
        <button class="button button-primary">
            <?php esc_html_e('Save Changes', 'listivo-core'); ?>
        </button>
    </p>

<?php
endforeach;