<?php

use Tangibledesign\Framework\Widgets\General\BaseSimpleMenuWidget;

/* @var BaseSimpleMenuWidget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-vertical-link-list">
    <?php $lstCurrentWidget->displayMenu(); ?>
</div>