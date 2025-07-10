<div>
    <?php foreach (tdf_app('notifications') as $notification) :
        /* @var \Tangibledesign\Framework\Core\Notification $notification */
        ?>
        <div class="tdf-content-section">
            <div class="tdf-content-section__left">
                <h2>
                    <?php echo esc_html($notification->label); ?>
                </h2>

                <?php if (!empty($notification->description)) : ?>
                    <div class="tdf-margin-bottom-big">
                        <?php echo esc_html($notification->description); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($notification->vars)) : ?>
                    <div>
                        <div class="tdf-margin-bottom-small">
                            <strong><?php esc_html_e('Available variables:', 'listivo-core'); ?></strong>
                        </div>

                        <div>
                            <?php foreach ($notification->vars as $variable) : ?>
                                <div>
                                    {<?php echo esc_html($variable); ?>}
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="tdf-content-section__right">
                <?php if ($notification->optional) : ?>
                    <div class="tdf-checkbox">
                        <input
                                id="<?php echo esc_attr($notification->key); ?>-enable"
                                type="checkbox"
                                value="1"
                                name="notifications[<?php echo esc_attr($notification->key); ?>][enabled]"
                            <?php if ($notification->isEnabled()) : ?>
                                checked
                            <?php endif; ?>
                        >
                        <label for="<?php echo esc_attr($notification->key); ?>-enable">
                            <?php esc_html_e('Enable', 'listivo-core'); ?>
                        </label>
                    </div>
                <?php endif; ?>


                <div class="tdf-field">
                    <label for="<?php echo esc_attr($notification->key); ?>-title">
                        <?php esc_html_e('Email Title', 'listivo-core'); ?>
                    </label>

                    <input
                            id="<?php echo esc_attr($notification->key); ?>-title"
                            name="notifications[<?php echo esc_attr($notification->key); ?>][title]"
                            value="<?php echo esc_attr($notification->title); ?>"
                            type="text"
                    >
                </div>

                <div class="tdf-field">
                    <label for="<?php echo esc_attr($notification->key); ?>-text">
                        <?php esc_html_e('Message', 'listivo-core'); ?>
                    </label>

                    <textarea
                            id="<?php echo esc_attr($notification->key); ?>-text"
                            name="notifications[<?php echo esc_attr($notification->key); ?>][message]"
                    ><?php echo wp_kses_post($notification->message); ?></textarea>
                </div>

                <?php tdf_load_view('dashboard/partials/save_changes_button'); ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>