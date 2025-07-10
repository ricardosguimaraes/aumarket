<div class="listivo-mobile-menu__wrapper listivo-mobile-menu__wrapper--mobile-simple-menu listivo-hide-desktop">
    <div class="listivo-mobile-menu__hamburger">
        <lst-mobile-menu prefix="listivo">
            <div slot-scope="menu">
                <div class="listivo-menu-icon-wrapper" @click.prevent="menu.onShow"><svg fill="#222" xmlns="http://www.w3.org/2000/svg" width="25" height="16" viewBox="0 0 25 16"><g><g><path d="M1.125 6.875H20.75a1.125 1.125 0 1 1 0 2.25H1.125a1.125 1.125 0 1 1 0-2.25zm.012 6.844h22.726c.628 0 1.137.509 1.137 1.137v.007C25 15.49 24.49 16 23.863 16H1.137C.51 16 0 15.49 0 14.863v-.007c0-.628.51-1.137 1.137-1.137zM1.137 0h16.476c.628 0 1.137.51 1.137 1.137v.007c0 .628-.51 1.137-1.137 1.137H1.137C.51 2.281 0 1.772 0 1.144v-.007C0 .51.51 0 1.137 0z"></path></g></g></svg></div>

                <template>
                    <div :class="{'listivo-active': menu.show}" class="listivo-mobile-menu__open">
                        <div class="listivo-mobile-menu__open__content">
                            <div class="listivo-mobile-menu__open__top">
                                <div class="listivo-mobile-menu__open__top__x">
                                    <svg @click="menu.onShow" xmlns="http://www.w3.org/2000/svg" width="21" height="19" viewBox="0 0 21 19"><g><g><path fill="#fff" d="M.602 18.781h2.443c.335 0 .574-.106.766-.284l6.178-6.615a.216.216 0 0 1 .336 0l6.13 6.615c.192.178.431.284.766.284h2.347c.48 0 .67-.284.383-.569L12.05 9.89a.176.176 0 0 1 0-.213l7.902-8.322c.288-.284.096-.569-.383-.569H17.03c-.336 0-.575.107-.767.285l-6.13 6.614a.215.215 0 0 1-.335 0l-6.13-6.614C3.475.893 3.235.786 2.9.786H.6c-.478 0-.67.285-.382.57l7.855 8.321a.177.177 0 0 1 0 .213L.219 18.212c-.288.285-.096.57.383.57z"/></g></g></svg>
                                </div>
                            </div>

                            <div class="listivo-mobile-menu__nav">
                                <?php
                                if (has_nav_menu('listivo-primary')) :
                                    wp_nav_menu([
                                        'theme_location' => 'listivo-primary',
                                        'container' => 'div',
                                        'container_class' => 'listivo-menu',
                                        'container_id' => 'listivo-menu-mobile',
                                        'walker' => new ListivoMenuWalker(),
                                        'items_wrap' => '%3$s',
                                        'depth' => 4,
                                    ]);
                                else :
                                    wp_nav_menu([
                                        'container' => 'div',
                                        'container_class' => 'listivo-menu',
                                        'container_id' => 'listivo-menu-mobile',
                                        'walker' => new ListivoMenuWalker(),
                                        'items_wrap' => '%3$s',
                                        'depth' => 4,
                                    ]);
                                endif;
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="listivo-mobile-menu-mask"></div>
                </template>
            </div>
        </lst-mobile-menu>
    </div>

    <div class="listivo-mobile-menu__logo listivo-mobile-menu__logo--right">
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
    </div>
</div>
