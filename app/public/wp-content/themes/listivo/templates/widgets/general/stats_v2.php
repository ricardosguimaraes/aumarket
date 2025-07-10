<?php

use Tangibledesign\Listivo\Widgets\General\StatsV2Widget;

/* @var StatsV2Widget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-stats-v2">
    <?php foreach ($lstCurrentWidget->getAttributes() as $lstAttribute) : ?>
        <div class="listivo-stats-v2__item">
            <div class="listivo-stats-v2__value">
                <?php echo esc_html($lstAttribute['value']); ?>
            </div>

            <div class="listivo-stats-v2__label">
                <?php echo nl2br(wp_kses_post($lstAttribute['label'])); ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
