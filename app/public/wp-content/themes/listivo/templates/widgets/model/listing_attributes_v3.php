<?php

use Tangibledesign\Listivo\Widgets\Listing\ListingAttributesV3Widget;

/* @var ListingAttributesV3Widget $lstCurrentWidget */
global $lstCurrentWidget;

$lstAttributes = $lstCurrentWidget->getAttributes();
if ($lstAttributes->isEmpty()) {
    return;
}
?>
<div class="listivo-listing-attributes-v3">
    <?php foreach ($lstCurrentWidget->getAttributes() as $lstAttribute) : ?>
        <?php foreach ($lstAttribute['value'] as $lstValue) : ?>
            <div class="listivo-listing-attribute-v3">
                <?php if (!empty($lstAttribute['icon']['value'])) : ?>
                    <div class="listivo-listing-attribute-v3__icon">
                        <?php if ($lstAttribute['icon']['library'] === 'svg') : ?>
                            <?php echo tdf_load_icon($lstAttribute['icon']['value']['url']); ?>
                        <?php else : ?>
                            <i class="<?php echo esc_attr($lstAttribute['icon']['value']); ?>"></i>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($lstAttribute['show_label'])) : ?>
                    <?php echo esc_html($lstAttribute['label']); ?>:
                <?php endif; ?>

                <?php echo esc_html($lstValue); ?>
            </div>
        <?php endforeach; ?>
    <?php endforeach; ?>
</div>
