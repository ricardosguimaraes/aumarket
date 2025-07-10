<?php

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Payments\BasePaymentPackage;
use Tangibledesign\Framework\Models\User\User;

/* @var Collection|BasePaymentPackage[] $paymentPackages */
/* @var User $user */
?>
<h1><?php echo sprintf(esc_html__('Apply to %s', 'listivo-core'), $user->getDisplayName()); ?></h1>

<form
        action="<?php echo esc_url(admin_url('admin-post.php?action=' . tdf_prefix() . '/user-payment-packages/apply')); ?>"
        method="post"
>
    <input name="user" type="hidden" value="<?php echo esc_attr($user->getId()); ?>">

    <table class="form-table">
        <tr>
            <th>
                <label for="payment_package_id">
                    <?php esc_html_e('Payment Package', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                <select
                        id="payment_package_id"
                        name="payment_package_id"
                >
                    <?php foreach ($paymentPackages as $paymentPackage) : ?>
                        <option value="<?php echo esc_attr($paymentPackage->getId()); ?>">
                            <?php echo esc_html($paymentPackage->getName()); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
    </table>

    <div>
        <button type="submit" class="button button-primary">
            <?php esc_html_e('Apply', 'listivo-core'); ?>
        </button>
    </div>
</form>