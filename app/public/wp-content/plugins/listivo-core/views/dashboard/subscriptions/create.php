<div class="tdf-app wrap">
    <h1 class="wp-heading-inline">
        <?php esc_html_e('Add New Subscription', 'listivo-core'); ?>
    </h1>

    <form
            action="<?php echo esc_url(admin_url('admin-post.php?action=listivo/subscriptions/create')); ?>"
            method="post"
    >
        <input
                type="hidden"
                name="nonce"
                value="<?php echo esc_attr(wp_create_nonce('listivo/subscriptions/create')); ?>"
        >

        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row">
                    <label for="name">
                        <?php esc_html_e('Name', 'listivo-core'); ?>
                    </label>
                </th>

                <td>
                    <input
                            id="name"
                            name="name"
                            class="regular-text"
                            type="text"
                            required
                    >
                </td>
            </tr>
            </tbody>
        </table>

        <button class="button button-primary">
            <?php esc_html_e('Add Subscription', 'listivo-core'); ?>
        </button>
    </form>
</div>