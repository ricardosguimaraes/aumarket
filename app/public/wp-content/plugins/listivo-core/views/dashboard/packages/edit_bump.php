<?php

use Tangibledesign\Framework\Models\Payments\BumpPaymentPackage;
use Tangibledesign\Framework\Models\Payments\BasePaymentPackage;

/* @var BumpPaymentPackage $package */
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
                value="<?php echo esc_attr($package->getBumpsNumber()); ?>"
        >
    </td>
</tr>