<?php

use Tangibledesign\Framework\Models\Payments\BasePaymentPackage;
use Tangibledesign\Framework\Models\Payments\BumpPaymentPackage;
use Tangibledesign\Framework\Models\Payments\PaymentPackage;
use Tangibledesign\Framework\Models\Payments\PaymentPackageInterface;
use Tangibledesign\Framework\Models\User\Helpers\UserSettingKey;

$packageId = (int)($_GET['packageId'] ?? 0);

global $package;
$package = tdf_post_factory()->create($packageId);
if (!$package instanceof PaymentPackageInterface) {
    return;
}
?>
<div class="tdf-app wrap">
    <h1 class="wp-heading-inline">
        <?php esc_html_e('Edit Package', 'listivo-core'); ?>
    </h1>

    <template>
        <form
                action="<?php echo esc_url(admin_url('admin-post.php?action=listivo/paymentPackage/update')); ?>"
                method="post"
        >
            <input
                    type="hidden"
                    name="nonce"
                    value="<?php echo esc_attr(wp_create_nonce('listivo/paymentPackage/update')); ?>"
            >

            <input
                    type="hidden"
                    name="packageId"
                    value="<?php echo esc_attr($package->getId()); ?>"
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
                                name="package[<?php echo esc_attr(BasePaymentPackage::NAME); ?>]"
                                class="regular-text"
                                type="text"
                                value="<?php echo esc_attr($package->getName()); ?>"
                        >
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="<?php echo esc_attr(BasePaymentPackage::DISPLAY_PRICE); ?>">
                            <?php esc_html_e('Display Price(e.g. $10.00)', 'listivo-core'); ?>
                        </label>
                    </th>

                    <td>
                        <input
                                id="<?php echo esc_attr(BasePaymentPackage::DISPLAY_PRICE); ?>"
                                name="package[<?php echo esc_attr(BasePaymentPackage::DISPLAY_PRICE); ?>]"
                                class="regular-text"
                                type="text"
                                value="<?php echo esc_attr($package->getDisplayPrice()); ?>"
                                placeholder="$10"
                        >
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="<?php echo esc_attr(BasePaymentPackage::PRICE); ?>">
                            <?php esc_html_e('Price (integer e.g. 10)', 'listivo-core'); ?>
                        </label>
                    </th>

                    <td>
                        <input
                                id="<?php echo esc_attr(BasePaymentPackage::PRICE); ?>"
                                name="package[<?php echo esc_attr(BasePaymentPackage::PRICE); ?>]"
                                class="regular-text"
                                type="text"
                                value="<?php echo esc_attr($package->getPrice()); ?>"
                                placeholder="10"
                        >
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="<?php echo esc_attr(BasePaymentPackage::LABEL); ?>">
                            <?php esc_html_e('Label', 'listivo-core'); ?>
                        </label>
                    </th>

                    <td>
                        <input
                                id="<?php echo esc_attr(BasePaymentPackage::LABEL); ?>"
                                name="package[<?php echo esc_attr(BasePaymentPackage::LABEL); ?>]"
                                class="regular-text"
                                type="text"
                                value="<?php echo esc_attr($package->getLabel()); ?>"
                        >
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="<?php echo esc_attr(BasePaymentPackage::TEXT); ?>">
                            <?php esc_html_e('Text', 'listivo-core'); ?>
                        </label>
                    </th>

                    <td>
                        <input
                                id="<?php echo esc_attr(BasePaymentPackage::TEXT); ?>"
                                name="package[<?php echo esc_attr(BasePaymentPackage::TEXT); ?>]"
                                class="regular-text"
                                type="text"
                                value="<?php echo esc_attr($package->getText()); ?>"
                        >
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="<?php echo esc_attr(BasePaymentPackage::FEATURED); ?>">
                            <?php esc_html_e('Highlight on Pricing Table', 'listivo-core'); ?>
                        </label>
                    </th>

                    <td>
                        <input
                                id="<?php echo esc_attr(BasePaymentPackage::FEATURED); ?>"
                                name="package[<?php echo esc_attr(BasePaymentPackage::FEATURED); ?>]"
                                type="checkbox"
                                value="1"
                            <?php if ($package->isFeatured()) : ?>
                                checked
                            <?php endif; ?>
                        >

                        <p class="description listivo-backend-description">
                            <?php esc_html_e('When multiple bump up packages are available, this option will highlight one specific offer.', 'listivo-core'); ?>
                        </p>
                    </td>
                </tr>

                <?php
                if ($package instanceof PaymentPackage) :
                    tdf_load_view('dashboard/packages/edit_normal');
                elseif ($package instanceof BumpPaymentPackage) :
                    tdf_load_view('dashboard/packages/edit_bump');
                endif;
                ?>

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
                                    name="package[user_account_type]"
                            >
                                <option
                                        value="any"
                                    <?php if ($package->getUserAccountType() === 'any') : ?>
                                        selected
                                    <?php endif; ?>
                                >
                                    <?php esc_html_e('Any', 'listivo-core'); ?>
                                </option>

                                <option
                                        value="<?php echo esc_attr(UserSettingKey::ACCOUNT_TYPE_PRIVATE); ?>"
                                    <?php if ($package->getUserAccountType() === UserSettingKey::ACCOUNT_TYPE_PRIVATE) : ?>
                                        selected
                                    <?php endif; ?>
                                >
                                    <?php esc_html_e('Private', 'listivo-core'); ?>
                                </option>

                                <option
                                        value="<?php echo esc_attr(UserSettingKey::ACCOUNT_TYPE_BUSINESS); ?>"
                                    <?php if ($package->getUserAccountType() === UserSettingKey::ACCOUNT_TYPE_BUSINESS) : ?>
                                        selected
                                    <?php endif; ?>
                                >
                                    <?php esc_html_e('Business', 'listivo-core'); ?>
                                </option>
                            </select>
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>

            <button class="button button-primary">
                <?php esc_html_e('Save Changes', 'listivo-core'); ?>
            </button>
        </form>
    </template>
</div>