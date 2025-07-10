<?php

use Tangibledesign\Listivo\Widgets\General\LinksSidebarWidget;

/* @var LinksSidebarWidget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-sidebar-widget">
    <h3 class="listivo-sidebar-widget__label">
        <?php echo esc_html($lstCurrentWidget->getLabel()); ?>
    </h3>

    <div class="listivo-sidebar-widget__content">
        <div class="listivo-sidebar-list">
            <?php foreach ($lstCurrentWidget->getLinks() as $lstLink) : ?>
                <a
                        class="listivo-sidebar-list__item"
                        href="<?php echo esc_url($lstLink['url']); ?>"
                >
                    <span class="listivo-sidebar-list__label">
                        <?php echo esc_html($lstLink['label']); ?>
                    </span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>
