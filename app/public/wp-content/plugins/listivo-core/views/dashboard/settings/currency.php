<div class="listivo-backend-content">
    <lst-currencies
            delete-currency-request-url="<?php echo esc_url(admin_url('admin-post.php?action=listivo/currency/delete')); ?>"
            delete-nonce="<?php echo esc_attr(wp_create_nonce('listivo/currency/delete')); ?>"
            delete-title-text="<?php esc_attr_e('Are you sure?', 'listivo-core'); ?>"
            confirm-button-text="<?php esc_attr_e('Confirm', 'listivo-core'); ?>"
            cancel-button-text="<?php esc_attr_e('Cancel', 'listivo-core'); ?>"
        <?php if (!tdf_currencies()->isEmpty()) : ?>
            :initial-currencies="<?php echo htmlspecialchars(json_encode(tdf_currencies()->values())); ?>"
        <?php endif; ?>
    >
        <div slot-scope="props">
            <table class="wp-list-table widefat fixed striped posts listivo-backend-table listivo-backend-table--compact">
                <thead>
                <tr>
                    <th class="listivo-backend-table__col listivo-backend-table__col--primary">
                        <?php esc_html_e('Name', 'listivo-core'); ?>
                    </th>

                    <th class="listivo-backend-table__col">
                        <?php esc_html_e('Sign', 'listivo-core'); ?>
                    </th>

                    <th class="listivo-backend-table__col">
                        <?php esc_html_e('Sign Position', 'listivo-core'); ?>
                    </th>

                    <th class="listivo-backend-table__col">
                        <?php esc_html_e('Format', 'listivo-core'); ?>
                    </th>

                    <th class="listivo-backend-table__col">
                        <?php esc_html_e('Actions', 'listivo-core'); ?>
                    </th>
                </tr>

                <tbody>
                <tr v-for="(currency, index) in props.currencies" :key="index">
                    <th class="listivo-backend-table__cell listivo-backend-table__cell--primary">
                        {{ currency.name }}
                    </th>

                    <td class="listivo-backend-table__cell">
                        {{ currency.sign }}
                    </td>

                    <td class="listivo-backend-table__cell">
                        {{ currency.sign_position }}
                    </td>

                    <td class="listivo-backend-table__cell">
                        {{ currency.format }}
                    </td>

                    <td class="listivo-backend-table__cell">
                        <a
                                class="button button-secondary"
                                :href="'<?php echo esc_url(admin_url('admin.php?page=listivo-edit-currency&currencyId=')); ?>' + currency.id"
                        >
                            <?php esc_html_e('Edit', 'listivo-core'); ?>
                        </a>

                        <button
                                v-if="props.currencies.length > 1"
                                @click.prevent="props.onDelete(currency.id)"
                                class="button button-secondary"
                        >
                            <?php esc_html_e('Delete', 'listivo-core'); ?>
                        </button>
                    </td>
                </tr>
                </tbody>
                </thead>
            </table>
        </div>
    </lst-currencies>
</div>

<a
        class="button button-secondary"
        href="<?php echo esc_url(admin_url('admin.php?page=listivo-add-new-currency')); ?>"
>
    <?php esc_html_e('Add New Currency', 'listivo-core'); ?>
</a>