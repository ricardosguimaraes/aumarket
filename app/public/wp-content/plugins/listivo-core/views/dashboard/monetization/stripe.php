<?php use Tangibledesign\Framework\Core\Settings\SettingKey; ?>
<p class="listivo-backend-description">
    <a
            href="https://support.listivotheme.com/support/solutions/articles/101000475390-stripe-configuration"
            target="_blank"
    >
        <?php esc_html_e('Learn how to configure Stripe', 'listivo-core'); ?>
    </a>
</p>

<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::STRIPE_ENABLED); ?>">
                <?php esc_html_e('Enabled', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::STRIPE_ENABLED); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::STRIPE_ENABLED); ?>"
                        id="<?php echo esc_attr(SettingKey::STRIPE_ENABLED); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->isStripeEnabled()) : ?>
                        checked
                    <?php endif; ?>
                >
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::STRIPE_CURRENCY); ?>">
                <?php esc_html_e('Currency', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <select
                    id="<?php echo esc_attr(SettingKey::STRIPE_CURRENCY); ?>"
                    name="<?php echo esc_attr(SettingKey::STRIPE_CURRENCY); ?>"
            >
                <?php foreach (tdf_app('stripe_currencies') as $currency) : ?>
                    <option
                            value="<?php echo esc_attr($currency); ?>"
                        <?php if (tdf_settings()->getStripeCurrency() === $currency) : ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php echo esc_html($currency); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::STRIPE_PUBLISHABLE_KEY); ?>">
                <?php esc_html_e('Publishable Key', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::STRIPE_PUBLISHABLE_KEY); ?>"
                    name="<?php echo esc_attr(SettingKey::STRIPE_PUBLISHABLE_KEY); ?>"
                    type="text"
                    class="regular-text"
                    value="<?php echo esc_attr(tdf_settings()->getStripePublishableKey()); ?>"
            >
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::STRIPE_SECRET_KEY); ?>">
                <?php esc_html_e('Secret Key', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::STRIPE_SECRET_KEY); ?>"
                    name="<?php echo esc_attr(SettingKey::STRIPE_SECRET_KEY); ?>"
                    type="password"
                    class="regular-text"
                    value="<?php echo esc_attr(tdf_settings()->getStripeSecretKey()); ?>"
            >
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::STRIPE_WEBHOOK_SECRET); ?>">
                <?php esc_html_e('Webhook secret', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::STRIPE_WEBHOOK_SECRET); ?>"
                    name="<?php echo esc_attr(SettingKey::STRIPE_WEBHOOK_SECRET); ?>"
                    type="password"
                    class="regular-text"
                    value="<?php echo esc_attr(tdf_settings()->getStripeWebhookSecret()); ?>"
            >

            <p class="description">
                <?php echo esc_url(admin_url('admin-post.php?action=tdf/stripe/webhook')); ?>
            </p>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::STRIPE_ALLOW_PROMOTION_CODES); ?>">
                <?php esc_html_e('Allow Promotional Codes', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::STRIPE_ALLOW_PROMOTION_CODES); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::STRIPE_ALLOW_PROMOTION_CODES); ?>"
                        id="<?php echo esc_attr(SettingKey::STRIPE_ALLOW_PROMOTION_CODES); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->allowPromotionCodes()) : ?>
                        checked
                    <?php endif; ?>
                >
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::STRIPE_REQUIRE_BILLING_ADDRESS_COLLECTION); ?>">
                <?php esc_html_e('Require billing address collection', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::STRIPE_REQUIRE_BILLING_ADDRESS_COLLECTION); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::STRIPE_REQUIRE_BILLING_ADDRESS_COLLECTION); ?>"
                        id="<?php echo esc_attr(SettingKey::STRIPE_REQUIRE_BILLING_ADDRESS_COLLECTION); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->requireBillingAddressCollection()) : ?>
                        checked
                    <?php endif; ?>
                >
            </label>
        </td>
    </tr>
    </tbody>
</table>

<p class="submit">
    <button class="button button-primary">
        <?php esc_html_e('Save Changes', 'listivo-core'); ?>
    </button>
</p>