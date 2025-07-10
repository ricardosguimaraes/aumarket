<?php use Tangibledesign\Framework\Core\Settings\SettingKey; ?>
<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::ENABLE_PAYMENTS); ?>">
                <?php esc_html_e('Enabled', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::ENABLE_PAYMENTS); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::ENABLE_PAYMENTS); ?>"
                        id="<?php echo esc_attr(SettingKey::ENABLE_PAYMENTS); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->paymentsEnabled()) : ?>
                        checked
                    <?php endif; ?>
                >
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::ENABLE_SUBSCRIPTIONS); ?>">
                <?php esc_html_e('Subscriptions', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::ENABLE_SUBSCRIPTIONS); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::ENABLE_SUBSCRIPTIONS); ?>"
                        id="<?php echo esc_attr(SettingKey::ENABLE_SUBSCRIPTIONS); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->subscriptionsEnabled()) : ?>
                        checked
                    <?php endif; ?>
                >
            </label>

            <p class="description listivo-backend-description">
                <?php esc_html_e('By checking this box, you will enable the subscription module. Please ensure you also configure Stripe correctly.', 'listivo-core'); ?>
                <a
                        href="https://support.listivotheme.com/support/solutions/articles/101000475616-subscriptions-membership-how-to-configure"
                        target="_blank"
                >
                    <?php esc_html_e('See Stripe Configuration Documentation.', 'listivo-core'); ?>
                </a>
            </p>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::SUBSCRIPTION_RENEWAL_POLICY); ?>">
                <?php esc_html_e('Subscription Renewal Policy', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::SUBSCRIPTION_RENEWAL_POLICY); ?>">
                <select
                        name="<?php echo esc_attr(SettingKey::SUBSCRIPTION_RENEWAL_POLICY); ?>"
                        id="<?php echo esc_attr(SettingKey::SUBSCRIPTION_RENEWAL_POLICY); ?>"
                >
                    <option
                            value="<?php echo esc_attr(SettingKey::SUBSCRIPTION_RENEWAL_POLICY_ACCUMULATE); ?>"
                        <?php if (tdf_settings()->getSubscriptionRenewalPolicy() === SettingKey::SUBSCRIPTION_RENEWAL_POLICY_ACCUMULATE) : ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php esc_html_e('Accumulate', 'listivo-core'); ?>
                    </option>

                    <option
                            value="<?php echo esc_attr(SettingKey::SUBSCRIPTION_RENEWAL_POLICY_RESET); ?>"
                        <?php if (tdf_settings()->getSubscriptionRenewalPolicy() === SettingKey::SUBSCRIPTION_RENEWAL_POLICY_RESET) : ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php esc_html_e('Reset', 'listivo-core'); ?>
                    </option>
                </select>
            </label>

            <p class="description listivo-backend-description">
                <strong><?php esc_html_e('Accumulate:', 'listivo-core'); ?></strong> <?php esc_html_e('If this option is selected, when a user\'s subscription is renewed, their package allowances will accumulate. This means that any unused allowances from the previous subscription period will be added to the allowances for the new subscription period.', 'listivo-core'); ?>
            </p>

            <p class="description listivo-backend-description">
                <strong><?php esc_html_e('Reset:', 'listivo-core'); ?></strong> <?php esc_html_e('If this option is selected, when a user\'s subscription is renewed, their package allowances will reset. This means that any unused allowances from the previous subscription period will not carry over to the new subscription period. Instead, the allowances for the new subscription period will start from the base amount as defined by the subscription package.', 'listivo-core'); ?>
            </p>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::ENABLE_BUMPS); ?>">
                <?php esc_html_e('Bump Up', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::ENABLE_BUMPS); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::ENABLE_BUMPS); ?>"
                        id="<?php echo esc_attr(SettingKey::ENABLE_BUMPS); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->bumpsEnabled()) : ?>
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