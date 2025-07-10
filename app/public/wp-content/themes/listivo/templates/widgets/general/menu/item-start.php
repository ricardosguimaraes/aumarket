<?php
/* @var \Tangibledesign\Framework\Core\Menu\MenuElement $lstMenuElement */
global $lstMenuElement;
?>
<div
        id="listivo-menu-element-<?php echo esc_attr($lstMenuElement->getElementId()); ?>"
        class="<?php echo esc_attr($lstMenuElement->getClass()); ?>"
>
    <a
            href="<?php echo esc_url($lstMenuElement->getLink()); ?>"
            title="<?php echo esc_attr($lstMenuElement->getName()); ?>"
            class="listivo-menu__link"
        <?php if ($lstMenuElement->isTargetBlank()) : ?>
            target="_blank"
        <?php endif; ?>
    >
        <?php echo esc_html($lstMenuElement->getName()); ?>
    </a>
