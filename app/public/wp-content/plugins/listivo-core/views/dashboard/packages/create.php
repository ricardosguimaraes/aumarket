<?php

use Tangibledesign\Framework\Models\Payments\BasePaymentPackage;

?>
<div class="tdf-app wrap">
    <h1 class="wp-heading-inline">
        <?php esc_html_e('Add New Package', 'listivo-core'); ?>
    </h1>

    <form
            action="<?php echo esc_url(admin_url('admin-post.php?action=listivo/paymentPackage/create')); ?>"
            method="post"
    >
        <input
                type="hidden"
                name="nonce"
                value="<?php echo esc_attr(wp_create_nonce('listivo/paymentPackage/create')); ?>"
        >

        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row">
                    <label for="<?php echo esc_attr(BasePaymentPackage::NAME); ?>">
                        <?php esc_html_e('Name', 'listivo-core'); ?>
                    </label>
                </th>

                <td>
                    <input
                            id="<?php echo esc_attr(BasePaymentPackage::NAME); ?>"
                            name="<?php echo esc_attr(BasePaymentPackage::NAME); ?>"
                            class="regular-text"
                            type="text"
                            required
                    >
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="<?php echo esc_attr(BasePaymentPackage::TYPE); ?>">
                        <?php esc_html_e('Type', 'listivo-core'); ?>
                    </label>
                </th>

                <td>
                    <select
                            id="<?php echo esc_attr(BasePaymentPackage::TYPE); ?>"
                            name="<?php echo esc_attr(BasePaymentPackage::TYPE); ?>"
                    >
                        <option value="<?php echo esc_attr(BasePaymentPackage::TYPE_REGULAR); ?>">
                            <?php esc_html_e('Normal', 'listivo-core'); ?>
                        </option>

                        <option value="<?php echo esc_attr(BasePaymentPackage::TYPE_BUMP); ?>">
                            <?php esc_html_e('Bump Up', 'listivo-core'); ?>
                        </option>
                    </select>
                </td>
            </tr>
            </tbody>
        </table>

        <button class="button button-primary">
            <?php esc_html_e('Add Package', 'listivo-core'); ?>
        </button>
    </form>
</div>