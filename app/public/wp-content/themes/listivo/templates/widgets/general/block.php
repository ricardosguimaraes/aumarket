<?php

use Tangibledesign\Listivo\Widgets\General\BlockWidget;

/* @var BlockWidget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div
        class="listivo-block"
    <?php if (!empty($lstCurrentWidget->getBackgroundImage())) : ?>
        style="background-image: url('<?php echo esc_url($lstCurrentWidget->getBackgroundImage()); ?>')"
    <?php endif; ?>
></div>