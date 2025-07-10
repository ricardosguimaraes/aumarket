<div class="listivo-menu__desktop">
    <div class="listivo-menu__wrapper">
        <div class="listivo-menu__left">
            <div class="listivo-logo">
                <a
                        href="<?php echo esc_url(get_site_url()); ?>"
                        title="<?php echo esc_attr(get_bloginfo('name')); ?>"
                >
                    <?php if (has_custom_logo()) : ?>
                        <img
                                src="<?php echo esc_url(wp_get_attachment_image_url(get_theme_mod('custom_logo'))); ?>"
                                alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
                        >
                    <?php else : ?>
                        <?php echo esc_html(get_bloginfo('name')); ?>
                    <?php endif; ?>
                </a>
            </div>

            <div class="listivo-logo listivo-logo--sticky">
                <a
                        href="<?php echo esc_url(get_site_url()); ?>"
                        title="<?php echo esc_attr(get_bloginfo('name')); ?>"
                >
                    <?php if (has_custom_logo()) : ?>
                        <img
                                src="<?php echo esc_url(wp_get_attachment_image_url(get_theme_mod('custom_logo'))); ?>"
                                alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
                        >
                    <?php else : ?>
                        <?php echo esc_html(get_bloginfo('name')); ?>
                    <?php endif; ?>
                </a>
            </div>

            <div class="listivo-menu__container">
                <div class="listivo-menu-hover"></div>

                <?php

                if (has_nav_menu('listivo-primary')) :
                    wp_nav_menu([
                        'theme_location' => 'listivo-primary',
                        'container' => 'div',
                        'container_class' => 'listivo-menu',
                        'container_id' => 'listivo-menu',
                        'walker' => new ListivoMenuWalker(),
                        'items_wrap' => '%3$s',
                        'depth' => 4,
                    ]);
                else :
                    wp_nav_menu([
                        'container' => 'div',
                        'container_class' => 'listivo-menu',
                        'container_id' => 'listivo-menu',
                        'walker' => new ListivoMenuWalker(),
                        'items_wrap' => '%3$s',
                        'depth' => 4,
                    ]);
                endif;
                ?>
            </div>
        </div>
    </div>
</div>