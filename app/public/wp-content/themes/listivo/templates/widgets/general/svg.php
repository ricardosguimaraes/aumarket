<?php

use Tangibledesign\Listivo\Widgets\General\SvgWidget;

/* @var SvgWidget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-svg">
    <?php echo tdf_filter($lstCurrentWidget->getSvg()); ?>
</div>
