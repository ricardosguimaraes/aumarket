<lst-subscriptions
        :initial-subscriptions="<?php echo htmlspecialchars(json_encode(tdf_subscriptions())); ?>"
        delete-request-url="<?php echo esc_url(tdf_action_url(tdf_prefix().'/subscriptions/delete')); ?>"
        update-order-request-url="<?php echo esc_url(tdf_action_url(tdf_prefix().'/subscriptions/updateOrder')); ?>"
>
    <div slot-scope="props">
        <table class="wp-list-table widefat fixed striped posts listivo-backend-table listivo-backend-table--compact">
            <thead>
            <tr>
                <th class="listivo-backend-table__col listivo-backend-table__col--drag"></th>

                <th class="listivo-backend-table__col listivo-backend-table__col--primary">
                    <span><?php esc_html_e('Name', 'listivo-core'); ?></span>
                </th>

                <?php if (tdf_settings()->isAccountTypeEnabled()) : ?>
                    <th class="listivo-backend-table__col">
                        <span><?php esc_html_e('Account Type', 'listivo-core'); ?></span>
                    </th>
                <?php endif; ?>

                <th class="listivo-backend-table__col listivo-backend-table__col--actions">
                    <?php esc_html_e('Actions', 'listivo-core'); ?>
                </th>
            </tr>
            </thead>

            <tbody
                    is="lst-draggable"
                    :list="props.subscriptions"
                    tag="tbody"
                    handle=".listivo-backend-table__cell--drag"
            >
            <tr
                    v-for="subscription in props.subscriptions"
                    :key="subscription.key"
            >
                <th class="listivo-backend-table__cell--drag">
                    <div>
                        <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="8"
                                height="20"
                                viewBox="0 0 8 20"
                        >
                            <g>
                                <g>
                                    <path
                                            fill="#adadad"
                                            d="M.052 1.452c0-.316.113-.586.338-.812.226-.226.497-.339.812-.339.316 0 .586.113.812.339.226.226.339.496.339.812 0 .315-.113.586-.339.812a1.108 1.108 0 0 1-.812.338c-.315 0-.586-.113-.812-.338a1.107 1.107 0 0 1-.338-.812zm5.287 0c0-.316.113-.586.338-.812.226-.226.497-.339.812-.339.316 0 .586.113.812.339.226.226.339.496.339.812 0 .315-.113.586-.339.812a1.108 1.108 0 0 1-.812.338c-.315 0-.586-.113-.812-.338a1.107 1.107 0 0 1-.338-.812zM.052 7.109c0-.316.113-.586.338-.812.226-.226.497-.339.812-.339.316 0 .586.113.812.339.226.226.339.496.339.812 0 .315-.113.585-.339.811a1.108 1.108 0 0 1-.812.34c-.315 0-.586-.114-.812-.34a1.107 1.107 0 0 1-.338-.811zm5.287 0c0-.316.113-.586.338-.812.226-.226.497-.339.812-.339.316 0 .586.113.812.339.226.226.339.496.339.812 0 .315-.113.585-.339.811a1.108 1.108 0 0 1-.812.34c-.315 0-.586-.114-.812-.34a1.107 1.107 0 0 1-.338-.811zM.052 12.765c0-.315.113-.586.338-.811.226-.226.497-.34.812-.34.316 0 .586.114.812.34.226.225.339.496.339.811 0 .316-.113.586-.339.812a1.108 1.108 0 0 1-.812.339c-.315 0-.586-.113-.812-.339a1.107 1.107 0 0 1-.338-.812zm5.287 0c0-.315.113-.586.338-.811.226-.226.497-.34.812-.34.316 0 .586.114.812.34.226.225.339.496.339.811 0 .316-.113.586-.339.812a1.108 1.108 0 0 1-.812.339c-.315 0-.586-.113-.812-.339a1.107 1.107 0 0 1-.338-.812zM.052 18.422c0-.315.113-.586.338-.812.226-.225.497-.338.812-.338.316 0 .586.113.812.338.226.226.339.497.339.812 0 .316-.113.586-.339.812a1.108 1.108 0 0 1-.812.339c-.315 0-.586-.113-.812-.339a1.107 1.107 0 0 1-.338-.812zm5.287 0c0-.315.113-.586.338-.812.226-.225.497-.338.812-.338.316 0 .586.113.812.338.226.226.339.497.339.812 0 .316-.113.586-.339.812a1.108 1.108 0 0 1-.812.339c-.315 0-.586-.113-.812-.339a1.107 1.107 0 0 1-.338-.812z"
                                    />
                                </g>
                            </g>
                        </svg>
                    </div>
                </th>

                <th class="listivo-backend-table__cell listivo-backend-table__cell--primary">
                    {{ subscription.name }}
                </th>

                <?php if (tdf_settings()->isAccountTypeEnabled()) : ?>
                    <th class="listivo-backend-table__cell">
                        <span>{{ subscription.userAccountTypeLabel }}</span>
                    </th>
                <?php endif; ?>

                <td class="listivo-backend-table__cell">
                    <a
                            class="button button-small button-primary"
                            :href="'<?php echo esc_url(admin_url('admin.php?page=listivo-edit-subscription&subscription_id=')); ?>' + subscription.id"
                    >
                        <?php esc_html_e('Edit', 'listivo-core'); ?>
                    </a>

                    <button
                            class="button button-small button-secondary"
                            @click.prevent="props.onDelete(subscription.id)"
                    >
                        <?php esc_html_e('Delete', 'listivo-core'); ?>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</lst-subscriptions>