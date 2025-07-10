<?php

use Tangibledesign\Framework\Models\Payments\BasePaymentPackage;
use Tangibledesign\Framework\Models\Payments\BaseUserPaymentPackage;
use Tangibledesign\Framework\Models\Payments\BumpPaymentPackage;
use Tangibledesign\Framework\Models\Payments\BumpUserPaymentPackage;
use Tangibledesign\Framework\Models\Payments\PaymentPackage;
use Tangibledesign\Framework\Models\Payments\RegularUserPaymentPackage;

/* @var BaseUserPaymentPackage $userPaymentPackage */

$mainCategory = tdf_settings()->getMainCategory()
?>
<div class="tdf-app wrap">
    <h1 class="wp-heading-inline">
        <?php echo sprintf(esc_html__('Edit: %s (%s)', 'listivo-core'), $userPaymentPackage->getName(), $userPaymentPackage->getUser()->getDisplayName()); ?>
    </h1>

    <form
            action="<?php echo esc_url(tdf_action_url(tdf_prefix() . '/user-payment-packages/update')); ?>"
            method="post"
    >
        <input
                type="hidden"
                name="id"
                value="<?php echo esc_attr($userPaymentPackage->getId()); ?>"
        >

        <table class="form-table">
            <?php if ($mainCategory) : ?>
                <tr>
                    <th scope="row">
                        <label for="<?php echo esc_attr(BasePaymentPackage::CATEGORIES); ?>">
                            <?php esc_html_e('Categories', 'listivo-core'); ?>
                        </label>
                    </th>

                    <td>
                        <select
                                id="<?php echo esc_attr(BasePaymentPackage::CATEGORIES); ?>"
                                name="package[<?php echo esc_attr(BasePaymentPackage::CATEGORIES); ?>][]"
                                class="tdf-selectize-init"
                                placeholder="<?php esc_attr_e('All Categories', 'listivo-core'); ?>"
                                multiple
                        >
                            <?php foreach ($mainCategory->getTerms() as $term) : ?>
                                <option
                                        value="<?php echo esc_attr($term->getId()); ?>"
                                    <?php if (in_array($term->getId(), $userPaymentPackage->getCategoryIds(), true)) : ?>
                                        selected
                                    <?php endif; ?>
                                >
                                    <?php echo esc_html($term->getName()); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
            <?php endif; ?>

            <?php if ($userPaymentPackage instanceof RegularUserPaymentPackage) : ?>

                <tr>
                    <th scope="row">
                        <label for="<?php echo esc_attr(PaymentPackage::NUMBER); ?>">
                            <?php esc_html_e('Ads Number', 'listivo-core'); ?>
                        </label>
                    </th>

                    <td>
                        <input
                                id="<?php echo esc_attr(PaymentPackage::NUMBER); ?>"
                                name="package[<?php echo esc_attr(PaymentPackage::NUMBER); ?>]"
                                class="regular-text"
                                type="text"
                                value="<?php echo esc_attr($userPaymentPackage->getNumber()); ?>"
                        >
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="<?php echo esc_attr(PaymentPackage::EXPIRE); ?>">
                            <?php esc_html_e('Duration (days)', 'listivo-core'); ?>
                        </label>
                    </th>

                    <td>
                        <input
                                id="<?php echo esc_attr(PaymentPackage::EXPIRE); ?>"
                                name="package[<?php echo esc_attr(PaymentPackage::EXPIRE); ?>]"
                                class="regular-text"
                                type="text"
                                value="<?php echo esc_attr($userPaymentPackage->getExpire()); ?>"
                        >
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="<?php echo esc_attr(PaymentPackage::FEATURED_EXPIRE); ?>">
                            <?php esc_html_e('Featured (days)', 'listivo-core'); ?>
                        </label>
                    </th>

                    <td>
                        <input
                                id="<?php echo esc_attr(PaymentPackage::FEATURED_EXPIRE); ?>"
                                name="package[<?php echo esc_attr(PaymentPackage::FEATURED_EXPIRE); ?>]"
                                class="regular-text"
                                type="text"
                                value="<?php echo esc_attr($userPaymentPackage->getFeaturedExpire()); ?>"
                        >
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="<?php echo esc_attr(PaymentPackage::BUMPS_NUMBER); ?>">
                            <?php esc_html_e('Bumps Number', 'listivo-core'); ?>
                        </label>
                    </th>

                    <td>
                        <input
                                id="<?php echo esc_attr(PaymentPackage::BUMPS_NUMBER); ?>"
                                name="package[<?php echo esc_attr(PaymentPackage::BUMPS_NUMBER); ?>]"
                                class="regular-text"
                                type="text"
                                value="<?php echo esc_attr($userPaymentPackage->getBumpsNumber()); ?>"
                        >
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="<?php echo esc_attr(PaymentPackage::BUMPS_INTERVAL); ?>">
                            <?php esc_html_e('Bumps Interval (days)', 'listivo-core'); ?>
                        </label>
                    </th>

                    <td>
                        <input
                                id="<?php echo esc_attr(PaymentPackage::BUMPS_INTERVAL); ?>"
                                name="package[<?php echo esc_attr(PaymentPackage::BUMPS_INTERVAL); ?>]"
                                class="regular-text"
                                type="text"
                                value="<?php echo esc_attr($userPaymentPackage->getBumpsInterval()); ?>"
                        >
                    </td>
                </tr>
            <?php elseif ($userPaymentPackage instanceof BumpUserPaymentPackage) : ?>
                <tr>
                    <th scope="row">
                        <label for="<?php echo esc_attr(BumpPaymentPackage::BUMPS_NUMBER); ?>">
                            <?php esc_html_e('Bumps Number', 'listivo-core'); ?>
                        </label>
                    </th>

                    <td>
                        <input
                                id="<?php echo esc_attr(BumpPaymentPackage::BUMPS_NUMBER); ?>"
                                name="package[<?php echo esc_attr(BumpPaymentPackage::BUMPS_NUMBER); ?>]"
                                class="regular-text"
                                type="number"
                                value="<?php echo esc_attr($userPaymentPackage->getBumpsNumber()); ?>"
                        >
                    </td>
                </tr>
            <?php endif; ?>
        </table>

        <p class="submit">
            <button class="button button-primary">
                <?php esc_html_e('Save', 'listivo-core'); ?>
            </button>
        </p>
    </form>
</div>