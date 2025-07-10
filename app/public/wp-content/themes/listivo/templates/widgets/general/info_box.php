<?php

use Tangibledesign\Listivo\Widgets\General\InfoBoxWidget;

/* @var InfoBoxWidget $lstCurrentWidget */
global $lstCurrentWidget;
$lstIcon = $lstCurrentWidget->getIcon();
?>
<div class="listivo-contact-button listivo-contact-button--background-color-5 listivo-contact-button--regular-cursor">
    <div class="listivo-contact-button__inner">
        <div class="listivo-contact-button__icon">
            <?php if ($lstIcon['library'] === 'svg') : ?>
                <?php echo tdf_load_icon($lstIcon['value']['url']); ?>
            <?php endif ?>
        </div>

        <div class="listivo-contact-button__text">
            <?php echo esc_html($lstCurrentWidget->getText()); ?>
        </div>
    </div>
</div>
