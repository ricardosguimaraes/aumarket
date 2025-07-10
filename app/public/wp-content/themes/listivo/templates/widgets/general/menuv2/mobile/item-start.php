<?php
/* @var \Tangibledesign\Framework\Core\Menu\MenuElement $lstMenuElement */
global $lstMenuElement;
?>
<div
        id="listivo-menu-mobile-v2__item--<?php echo esc_attr($lstMenuElement->getElementId()); ?>"
        class="<?php echo esc_attr($lstMenuElement->getClass()); ?>"
>
    <a
            href="<?php echo esc_url($lstMenuElement->getLink()); ?>"
            title="<?php echo esc_attr($lstMenuElement->getName()); ?>"
        <?php if ($lstMenuElement->isTargetBlank()) : ?>
            target="_blank"
        <?php endif; ?>
    >
        <?php echo esc_html($lstMenuElement->getName()); ?>

        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none">
            <path d="M3.5 2.56775L5.87477 0.192978C6.13207 -0.0643244 6.54972 -0.0643244 6.80702 0.192978C7.06433 0.450281 7.06433 0.867931 6.80702 1.12523L3.9394 3.99285C3.6964 4.23586 3.30298 4.23586 3.0606 3.99285L0.192977 1.12523C-0.0643257 0.867931 -0.0643257 0.450281 0.192977 0.192978C0.45028 -0.0643244 0.86793 -0.0643244 1.12523 0.192978L3.5 2.56775Z"
                  fill="#D5E3F0"/>
        </svg>
    </a>
