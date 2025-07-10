<?php

use Tangibledesign\Listivo\Widgets\General\StatsV1Widget;

/* @var StatsV1Widget $lstCurrentWidget */
global $lstCurrentWidget;
$lstAttributes = $lstCurrentWidget->getAttributes();
if ($lstAttributes->isEmpty()) {
    return;
}
?>
<div class="listivo-attributes-v3 listivo-stats-v1">
    <?php foreach ($lstAttributes as $lstAttribute) : ?>
        <div class="listivo-attributes-v3__attribute listivo-stats-v1__item">
            <div class="listivo-attributes-v3__value listivo-attributes-v3__value--center">
                <?php echo esc_html($lstAttribute['value']); ?>

                <?php if (!empty($lstAttribute['after_value'])): ?>
                    <div class="listivo-attributes-v3__after-value">
                        <?php echo esc_html($lstAttribute['after_value']); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="listivo-attributes-v3__label">
                <?php echo esc_html($lstAttribute['label']); ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
