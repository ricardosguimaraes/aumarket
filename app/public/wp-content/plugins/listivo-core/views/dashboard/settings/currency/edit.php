<?php

use Tangibledesign\Framework\Models\Currency;

$currencyId = (int) $_GET['currencyId'];
if (empty($currencyId)) {
    return;
}

$currency = tdf_currencies()->find(static function ($currency) use ($currencyId) {
    /* @var Currency $currency */
    return $currency->getId() === $currencyId;
});

if (!$currency instanceof Currency) {
    return;
}
?>
<div class="tdf-app wrap">
    <h1 class="wp-heading-inline">
        <?php esc_html_e('Edit Currency'); ?>
    </h1>

    <form action="<?php echo esc_url(admin_url('admin-post.php?action=listivo/currency/update')); ?>" method="post">
        <input
                type="hidden"
                name="nonce"
                value="<?php echo esc_attr(wp_create_nonce('listivo/currency/update')); ?>"
        >

        <input
                type="hidden"
                name="currencyId"
                value="<?php echo esc_attr($currency->getId()); ?>"
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
                            value="<?php echo esc_attr($currency->getName()); ?>"
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
                            value="<?php echo esc_attr($currency->getSign()); ?>"
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
                        <option
                                value="<?php echo esc_attr(Currency::SIGN_POSITION_BEFORE); ?>"
                            <?php if ($currency->getSignPosition() === Currency::SIGN_POSITION_BEFORE) : ?>
                                selected
                            <?php endif; ?>
                        >
                            <?php esc_html_e('Before', 'listivo-core'); ?>
                        </option>

                        <option
                                value="<?php echo esc_attr(Currency::SIGN_POSITION_AFTER); ?>"
                            <?php if ($currency->getSignPosition() === Currency::SIGN_POSITION_AFTER) : ?>
                                selected
                            <?php endif; ?>
                        >
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
                                <?php if ($currency->getFormat() === $lstCurrencyFormatKey) : ?>
                                    selected
                                <?php endif; ?>
                            >
                                <?php echo esc_html($lstCurrencyFormatLabel); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="<?php echo esc_attr(Currency::DYNAMIC_DECIMAL); ?>">
                        <?php esc_html_e('Show decimal places only when needed', 'listivo-core'); ?>
                    </label>
                </th>

                <td>
                    <label for="<?php echo esc_attr(Currency::DYNAMIC_DECIMAL); ?>">
                        <input
                                id="<?php echo esc_attr(Currency::DYNAMIC_DECIMAL); ?>"
                                name="<?php echo esc_attr(Currency::DYNAMIC_DECIMAL); ?>"
                                type="checkbox"
                                value="1"
                            <?php if ($currency->dynamicDecimal()) : ?>
                                checked
                            <?php endif; ?>
                        >

                        <?php esc_html_e('If the number in the decimal part has only zeros, they will not be shown.',
                            'listivo-core'); ?>
                    </label>
                </td>
            </tr>
            </tbody>
        </table>

        <button class="button button-primary">
            <?php esc_html_e('Save Changes', 'listivo-core'); ?>
        </button>
    </form>
</div>