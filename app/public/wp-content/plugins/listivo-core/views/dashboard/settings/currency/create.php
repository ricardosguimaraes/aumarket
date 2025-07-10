<?php

use Tangibledesign\Framework\Models\Currency;

?>
<div class="tdf-app wrap">
    <h1 class="wp-heading-inline">
        <?php esc_html_e('Add New Currency'); ?>
    </h1>

    <form action="<?php echo esc_url(admin_url('admin-post.php?action=listivo/currency/create')); ?>" method="post">
        <input
                type="hidden"
                name="nonce"
                value="<?php echo esc_attr(wp_create_nonce('listivo/currency/create')); ?>"
        >

        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row">
                    <label for="<?php echo esc_attr(Currency::NAME); ?>">
                        <?php esc_html_e('Name', 'listivo-core'); ?>
                    </label>
                </th>

                <td>
                    <input
                            id="<?php echo esc_attr(Currency::NAME); ?>"
                            name="<?php echo esc_attr(Currency::NAME); ?>"
                            class="regular-text"
                            type="text"
                    >
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="<?php echo esc_attr(Currency::SIGN); ?>">
                        <?php esc_html_e('Sign', 'listivo-core'); ?>
                    </label>
                </th>

                <td>
                    <input
                            id="<?php echo esc_attr(Currency::SIGN); ?>"
                            name="<?php echo esc_attr(Currency::SIGN); ?>"
                            class="regular-text"
                            type="text"
                    >
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="<?php echo esc_attr(Currency::SIGN_POSITION); ?>">
                        <?php esc_html_e('Sign Position', 'listivo-core'); ?>
                    </label>
                </th>

                <td>
                    <select
                            name="<?php echo esc_attr(Currency::SIGN_POSITION); ?>"
                            id="<?php echo esc_attr(Currency::SIGN_POSITION); ?>"
                    >
                        <option value="<?php echo esc_attr(Currency::SIGN_POSITION_BEFORE); ?>">
                            <?php esc_html_e('Before', 'listivo-core'); ?>
                        </option>

                        <option value="<?php echo esc_attr(Currency::SIGN_POSITION_AFTER); ?>">
                            <?php esc_html_e('After', 'listivo-core'); ?>
                        </option>
                    </select>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="<?php echo esc_attr(Currency::FORMAT); ?>">
                        <?php esc_html_e('Format', 'listivo-core'); ?>
                    </label>
                </th>

                <td>
                    <select
                            id="<?php echo esc_attr(Currency::FORMAT); ?>"
                            name="<?php echo esc_attr(Currency::FORMAT); ?>"
                    >
                        <?php foreach (Currency::getFormats() as $lstCurrencyFormatKey => $lstCurrencyFormatLabel) : ?>
                            <option
                                    value="<?php echo esc_attr($lstCurrencyFormatKey); ?>"
                            >
                                <?php echo esc_html($lstCurrencyFormatLabel); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            </tbody>
        </table>

        <button class="button button-primary">
            <?php esc_html_e('Add Currency', 'listivo-core'); ?>
        </button>
    </form>
</div>