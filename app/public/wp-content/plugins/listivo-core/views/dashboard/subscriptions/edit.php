<?php

use Tangibledesign\Framework\Models\Payments\Subscription;
use Tangibledesign\Framework\Models\User\Helpers\UserSettingKey;

$subscription = tdf_subscription_factory()->create((int)($_GET['subscription_id'] ?? 0));
if (!$subscription instanceof Subscription) {
    return;
}
?>
<div class="tdf-app wrap">
    <h1 class="wp-heading-inline">
        <?php esc_html_e('Edit Subscription', 'listivo-core'); ?>
    </h1>

    <form
            action="<?php echo esc_url(admin_url('admin-post.php?action=listivo/subscriptions/update')); ?>"
            method="post"
    >
        <input
                type="hidden"
                name="nonce"
                value="<?php echo esc_attr(wp_create_nonce('listivo/subscriptions/update')); ?>"
        >

        <input
                type="hidden"
                name="subscription_id"
                value="<?php echo esc_attr($subscription->getId()); ?>"
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
                            name="subscription[name]"
                            class="regular-text"
                            type="text"
                            value="<?php echo esc_attr($subscription->getName()); ?>"
                            required
                    >
                </td>
            </tr>

            <?php if (tdf_settings()->isAccountTypeEnabled()) : ?>
                <tr>
                    <th scope="row">
                        <label for="user_account_type">
                            <?php esc_html_e('User Account Type', 'listivo-core'); ?>
                        </label>
                    </th>

                    <td>
                        <select
                                id="user_account_type"
                                name="subscription[user_account_type]"
                        >
                            <option
                                    value="any"
                                <?php if ($subscription->getUserAccountType() === 'any') : ?>
                                    selected
                                <?php endif; ?>
                            >
                                <?php esc_html_e('Any', 'listivo-core'); ?>
                            </option>

                            <option
                                    value="<?php echo esc_attr(UserSettingKey::ACCOUNT_TYPE_PRIVATE); ?>"
                                <?php if ($subscription->getUserAccountType() === UserSettingKey::ACCOUNT_TYPE_PRIVATE) : ?>
                                    selected
                                <?php endif; ?>
                            >
                                <?php esc_html_e('Private', 'listivo-core'); ?>
                            </option>

                            <option
                                    value="<?php echo esc_attr(UserSettingKey::ACCOUNT_TYPE_BUSINESS); ?>"
                                <?php if ($subscription->getUserAccountType() === UserSettingKey::ACCOUNT_TYPE_BUSINESS) : ?>
                                    selected
                                <?php endif; ?>
                            >
                                <?php esc_html_e('Business', 'listivo-core'); ?>
                            </option>
                        </select>
                    </td>
                </tr>
            <?php endif; ?>

            <tr>
                <th scope="row">
                    <label for="number">
                        <?php esc_html_e('Ads Number', 'listivo-core'); ?>
                    </label>
                </th>

                <td>
                    <input
                            id="number"
                            name="subscription[number]"
                            class="regular-text"
                            type="text"
                            value="<?php echo esc_attr($subscription->getNumber()); ?>"
                    >
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="expire">
                        <?php esc_html_e('Duration (days)', 'listivo-core'); ?>
                    </label>
                </th>

                <td>
                    <input
                            id="expire"
                            name="subscription[expire]"
                            class="regular-text"
                            type="text"
                            value="<?php echo esc_attr($subscription->getExpire()); ?>"
                    >

                    <p class="description">
                        <?php esc_html_e('0 means unlimited', 'listivo-core'); ?>
                    </p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="featured_expire">
                        <?php esc_html_e('Featured (days)', 'listivo-core'); ?>
                    </label>
                </th>

                <td>
                    <input
                            id="featured_expire"
                            name="subscription[featured_expire]"
                            class="regular-text"
                            type="text"
                            value="<?php echo esc_attr($subscription->getFeaturedExpire()); ?>"
                    >
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="bumps_number">
                        <?php esc_html_e('Bumps Number', 'listivo-core'); ?>
                    </label>
                </th>

                <td>
                    <input
                            id="bumps_number"
                            name="subscription[bumps_number]"
                            class="regular-text"
                            type="text"
                            value="<?php echo esc_attr($subscription->getBumpsNumber()); ?>"
                    >
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="bumps_interval">
                        <?php esc_html_e('Bumps Interval (days)', 'listivo-core'); ?>
                    </label>
                </th>

                <td>
                    <input
                            id="bumps_interval"
                            name="subscription[bumps_interval]"
                            class="regular-text"
                            type="text"
                            value="<?php echo esc_attr($subscription->getBumpsInterval()); ?>"
                    >
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="display_price">
                        <?php esc_html_e('Display Price', 'listivo-core'); ?>
                    </label>
                </th>

                <td>
                    <input
                            id="display_price"
                            name="subscription[display_price]"
                            class="regular-text"
                            type="text"
                            value="<?php echo esc_attr($subscription->getDisplayPrice()); ?>"
                    >
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="text">
                        <?php esc_html_e('Text', 'listivo-core'); ?>
                    </label>
                </th>

                <td>
                    <input
                            id="text"
                            name="subscription[text]"
                            class="regular-text"
                            type="text"
                            value="<?php echo esc_attr($subscription->getText()); ?>"
                    >
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="label">
                        <?php esc_html_e('Label', 'listivo-core'); ?>
                    </label>
                </th>

                <td>
                    <input
                            id="label"
                            name="subscription[label]"
                            class="regular-text"
                            type="text"
                            value="<?php echo esc_attr($subscription->getLabel()); ?>"
                    >
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="featured">
                        <?php esc_html_e('Is Featured', 'listivo-core'); ?>
                    </label>
                </th>

                <td>
                    <input
                            id="featured"
                            name="subscription[featured]"
                            type="checkbox"
                            value="1"
                        <?php if ($subscription->isFeatured()) : ?>
                            checked
                        <?php endif; ?>
                    >
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="stripe_price">
                        <?php esc_html_e('Stripe Price', 'listivo-core'); ?>
                    </label>
                </th>

                <td>
                    <input
                            id="stripe_price"
                            name="subscription[stripe_price]"
                            class="regular-text"
                            type="text"
                            value="<?php echo esc_attr($subscription->getStripePrice()); ?>"
                    >
                </td>
            </tr>
            </tbody>
        </table>

        <button class="button button-primary">
            <?php esc_html_e('Save Changes', 'listivo-core'); ?>
        </button>
    </form>
</div>