<?php

use Tangibledesign\Listivo\Widgets\General\StatsV3Widget;

/* @var StatsV3Widget $lstCurrentWidget */
global $lstCurrentWidget;
$lstAttributes = $lstCurrentWidget->getAttributes();
if ($lstAttributes->isEmpty()) {
    return;
}
?>
<div class="listivo-stats-v3 <?php echo esc_attr($lstCurrentWidget->getAlignClasses()); ?>">
    <?php foreach ($lstAttributes as $lstAttribute) : ?>
        <div class="listivo-stats-v3__item">
            <div class="listivo-stats-v3__value">
                <?php echo esc_html($lstAttribute['value']); ?>

                <?php if (!empty($lstAttribute['after_value'])): ?>
                    <div class="listivo-stats-v3__after-value">
                        <?php echo esc_html($lstAttribute['after_value']); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="listivo-stats-v3__label">
                <?php echo esc_html($lstAttribute['label']); ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

