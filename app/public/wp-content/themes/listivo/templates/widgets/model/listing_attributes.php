<?php

use Tangibledesign\Listivo\Widgets\Listing\ListingAttributesWidget;

/* @var ListingAttributesWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstAttributes = $lstCurrentWidget->getAttributes();
if ($lstAttributes->isEmpty()) {
    return;
}
?>
<div class="listivo-listing-attributes">
    <?php if (!empty($lstCurrentWidget->getLabel())) : ?>
        <h3 class="listivo-listing-attributes__label">
            <?php echo esc_html($lstCurrentWidget->getLabel()); ?>
        </h3>
    <?php endif; ?>

    <div class="listivo-tags">
        <?php
        foreach ($lstAttributes as $lstAttribute) :
            foreach ($lstAttribute['value'] as $lstValue) :?>
                <div class="listivo-tag">
                    <?php if (!empty($lstAttribute['icon']['value'])) : ?>
                        <div class="listivo-tag__icon">
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
            <?php
            endforeach;
        endforeach;
        ?>
    </div>
</div>