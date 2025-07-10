<?php
if (!class_exists(\Tangibledesign\Framework\Core\App::class)) :
    get_template_part('templates/blog/header');
endif;
?>

    <div class="listivo-wrapper">
        <div class="listivo-layout <?php if (!is_active_sidebar('listivo-sidebar')) : ?> listivo-layout--no-sidebar<?php endif; ?>">
            <div class="listivo-404">
                <img
                        class="listivo-404-img"
                        src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/404.png'); ?>"
                        alt="<?php esc_attr_e('Oops! That page can’t be found.', 'listivo'); ?>"
                >

                <h1 class="listivo-404-title">
                    <?php esc_html_e('404', 'listivo'); ?>
                </h1>

                <div class="listivo-shape">
                    <div class="listivo-shape-line">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 913.000000 42.000000" preserveAspectRatio="xMidYMid meet">
                            <g transform="translate(0.000000,42.000000) scale(0.100000,-0.100000)" stroke="none">
                                <path d="M7962 404 c-11 -12 -33 -14 -100 -12 -48 1 -240 -1 -427 -5 -187 -4 -506 -10 -710 -13 -354 -5 -415 -7 -603 -19 -185 -11 -867 -23 -1392 -25 -124 -1 -360 -6 -525 -11 -385 -14 -451 -15 -1170 -23 -411 -5 -646 -12 -745 -22 -86 -9 -301 -17 -530 -20 -244 -3 -422 -10 -485 -19 -90 -13 -202 -18 -640 -30 -77 -2 -189 -11 -250 -19 -60 -9 -151 -16 -202 -16 -50 0 -103 -4 -116 -9 -33 -13 -40 -47 -21 -109 l17 -52 193 0 c123 0 194 4 194 10 0 6 14 10 30 10 17 0 30 -4 30 -10 0 -15 107 -13 112 2 5 13 100 18 562 32 115 4 263 11 330 16 67 5 312 14 546 20 234 5 529 14 655 20 234 10 529 16 1255 25 637 8 931 14 1270 25 173 5 506 15 740 21 675 17 689 17 820 28 69 5 217 10 330 11 271 1 727 18 815 30 39 5 254 9 478 10 452 0 580 9 635 46 l32 22 -32 23 c-20 14 -50 24 -77 26 -26 1 -111 7 -191 13 -80 5 -187 10 -238 11 -65 0 -96 5 -106 15 -17 16 -106 19 -106 4 0 -5 -9 -10 -20 -10 -11 0 -20 5 -20 10 0 6 -61 10 -162 10 -133 -1 -165 -4 -176 -16z"></path>
                            </g>
                        </svg>
                    </div>
                </div>

                <h2 class="listivo-404-subtitle">
                    <?php esc_html_e('Oops! That page can’t be found.', 'listivo'); ?>
                </h2>

                <a class="listivo-primary-button listivo-primary-button--icon" href="<?php echo esc_url(home_url()); ?>">
                    <span class="listivo-primary-button__text"><?php esc_html_e('Back to homepage', 'listivo'); ?></span>

                    <span class="listivo-primary-button__icon"><i class="fas fa-home"></i></span>
                </a>
            </div>
        </div>
    </div>

<?php get_template_part('templates/blog/footer');