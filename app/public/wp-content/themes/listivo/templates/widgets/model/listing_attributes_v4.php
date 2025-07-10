<?php

use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Listivo\Widgets\Listing\ListingAttributesV4Widget;

/* @var ListingAttributesV4Widget $lstCurrentWidget */
global $lstCurrentWidget;

$lstModel = $lstCurrentWidget->getModel();
if (!$lstModel instanceof Model) {
    return;
}

$lstAttributes = $lstCurrentWidget->getValues($lstModel);
if ($lstAttributes->isEmpty()) {
    return;
}
?>
<div class="listivo-listing-attributes-v4">
    <?php if (!empty($lstCurrentWidget->getLabel())) : ?>
        <h3 class="listivo-listing-attributes-v4__label">
            <?php echo esc_html($lstCurrentWidget->getLabel()); ?>
        </h3>
    <?php endif; ?>

    <div class="listivo-listing-attributes-v4__list">
        <?php foreach ($lstAttributes as $lstAttribute): ?>
            <div class="listivo-listing-attribute-v4">
                <div class="listivo-listing-attribute-v4__label">
                    <?php echo esc_html($lstAttribute['name']); ?>:
                </div>

                <div class="listivo-listing-attribute-v4__value">
                    <?php echo esc_html(implode(', ', $lstAttribute['value'])); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>