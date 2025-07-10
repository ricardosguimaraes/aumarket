<?php

use Tangibledesign\Framework\Widgets\General\TagsCloudWidget;

/* @var TagsCloudWidget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-sidebar-widget">
    <h3 class="listivo-sidebar-widget__label">
        <?php echo esc_html($lstCurrentWidget->getLabel()); ?>
    </h3>

    <div class="listivo-sidebar-widget__content">
        <div class="listivo-sidebar-tags">
            <?php wp_tag_cloud($lstCurrentWidget->getArgs()); ?>
        </div>
    </div>
</div>