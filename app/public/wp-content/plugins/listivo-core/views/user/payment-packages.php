<?php

use Tangibledesign\Framework\Models\User\User;

/* @var User $user */
$userPaymentPackages = $user->getAllPackages();
?>
<h2><?php esc_html_e('User Payment Packages', 'listivo-core'); ?></h2>

<div>
    <a
            class="button button-primary"
            href="<?php echo esc_url(admin_url('admin.php?page=tdf-user-payment-packages-apply&user=' . $user->getId())); ?>"
    >
        <?php esc_html_e('Apply Payment Package', 'listivo-core'); ?>
    </a>
</div>

<?php
if ($userPaymentPackages->isEmpty()) {
    return;
}
?>

<table class="form-table tdf-app">
    <?php foreach ($userPaymentPackages as $userPaymentPackage) : ?>
        <tr id="user-payment-package-<?php echo esc_attr($userPaymentPackage->getId()); ?>">
            <th>
                <?php echo esc_html($userPaymentPackage->getName()); ?>
            </th>

            <td>
                <a
                        class="button button-secondary"
                        href="<?php echo esc_url($userPaymentPackage->getEditUrl()); ?>"
                >
                    <?php esc_html_e('Edit', 'listivo-core'); ?>
                </a>

                <lst-delete-user-payment-package
                        :user-payment-package-id="<?php echo esc_attr($userPaymentPackage->getId()); ?>"
                        request-url="<?php echo esc_url(tdf_action_url(tdf_prefix() . '/user-payment-packages/remove')); ?>"
                >
                    <button
                            class="button"
                            slot-scope="props"
                            @click.stop.prevent="props.deleteUserPaymentPackage"
                    >
                        <?php esc_html_e('Delete', 'listivo-core'); ?>
                    </button>
                </lst-delete-user-payment-package>
            </td>
        </tr>
    <?php endforeach; ?>
</table>