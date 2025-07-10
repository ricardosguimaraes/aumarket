<?php
/* @var \Tangibledesign\Framework\Widgets\General\MenuWidget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<header class="<?php echo esc_attr($lstCurrentWidget->getClass()); ?>">
    <div class="listivo-header__container">
        <div class="listivo-header__inner">
            <div class="listivo-hide-mobile listivo-hide-tablet">
                <?php get_template_part('templates/widgets/general/menu/menu-desktop'); ?>
            </div>

            <div class="listivo-hide-desktop">
                <?php get_template_part('templates/widgets/general/menu/menu-mobile'); ?>
            </div>
        </div>
    </div>
</header>