<?php

use Tangibledesign\Framework\Models\Payments\PaymentPackage;
use Tangibledesign\Framework\Models\Payments\BasePaymentPackage;

/* @var PaymentPackage $package */
global $package;

$mainCategory = tdf_settings()->getMainCategory();
if ($mainCategory) :?>
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
                <?php foreach ($mainCategory->getMainTerms() as $term) : ?>
                    <option
                            value="<?php echo esc_attr($term->getId()); ?>"
                        <?php if (in_array($term->getId(), $package->getCategoryIds(), true)) : ?>
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
                value="<?php echo esc_attr($package->getNumber()); ?>"
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
                value="<?php echo esc_attr($package->getExpire()); ?>"
        >

        <p class="description">
            <?php esc_html_e('0 means unlimited', 'listivo-core'); ?>
        </p>
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
                value="<?php echo esc_attr($package->getFeaturedExpire()); ?>"
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
                value="<?php echo esc_attr($package->getBumpsNumber()); ?>"
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
                value="<?php echo esc_attr($package->getBumpsInterval()); ?>"
        >
    </td>
</tr>