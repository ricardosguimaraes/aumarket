<?php
/* @var \Tangibledesign\Listivo\Widgets\General\CallToActionSectionWidget $lstCurrentWidget */
global $lstCurrentWidget;
$lstMainImage = $lstCurrentWidget->getMainImage();
$lstFirstImage = $lstCurrentWidget->getFirstImage();
$lstSecondImage = $lstCurrentWidget->getSecondImage();
$lstActionUrl = $lstCurrentWidget->getActionUrl();
?>
<div class="listivo-cta">
    <?php if ($lstMainImage) : ?>
        <img
                class="listivo-cta__background lazyload"
                data-src="<?php echo esc_url($lstMainImage->getUrl()) ?>"
                alt="cta"
        >
    <?php endif; ?>

    <div class="listivo-cta__inner">
        <div class="listivo-cta__arrow">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 545.000000 711.000000"
                 preserveAspectRatio="xMidYMid meet">
                <g transform="translate(0.000000,711.000000) scale(0.100000,-0.100000)" stroke="none">
                    <path d="M28 7098 c-25 -9 -28 -14 -28 -57 l0 -48 48 -7 c26 -3 87 -9 135 -13 71 -5 91 -3 98 8 13 21 11 85 -4 97 -9 8 -211 36 -221 31 0 0 -13 -5 -28 -11z"></path>
                    <path d="M574 6965 c-27 -28 -31 -66 -9 -89 9 -9 35 -21 58 -27 23 -6 53 -17 67 -24 14 -8 39 -18 57 -24 27 -8 35 -6 57 14 48 44 30 93 -41 115 -21 7 -43 17 -50 22 -7 5 -35 16 -64 23 -49 13 -52 13 -75 -10z"></path>
                    <path d="M1079 6727 c-46 -58 -46 -71 6 -103 25 -16 68 -46 95 -66 60 -46 89 -48 118 -8 31 41 28 64 -10 88 -18 12 -55 37 -83 56 -27 20 -54 36 -59 36 -5 0 -17 7 -26 15 -14 13 -18 11 -41 -18z"></path>
                    <path d="M1509 6369 c-16 -17 -29 -36 -29 -43 1 -6 38 -51 84 -99 l84 -88 29 14 c15 8 36 24 46 35 16 17 17 24 6 44 -22 41 -152 168 -172 168 -10 0 -32 -14 -48 -31z"></path>
                    <path d="M1857 5942 c-32 -33 -33 -42 -8 -73 10 -13 33 -51 50 -84 18 -33 41 -67 53 -76 19 -15 23 -14 59 5 23 12 39 28 39 39 0 21 -21 69 -50 112 -11 17 -29 47 -40 68 -26 47 -63 50 -103 9z"></path>
                    <path d="M2100 5450 c-24 -24 -25 -56 -4 -110 9 -22 21 -64 28 -92 11 -53 12 -53 52 -56 28 -2 47 2 58 13 20 21 21 75 1 123 -9 20 -21 57 -26 82 -6 24 -15 48 -22 52 -22 14 -67 8 -87 -12z"></path>
                    <path d="M2224 4916 c-16 -12 -19 -25 -17 -93 5 -135 12 -170 36 -177 39 -10 74 -6 87 9 15 18 5 242 -12 263 -14 16 -70 15 -94 -2z"></path>
                    <path d="M2257 4352 c-14 -15 -17 -40 -17 -128 0 -122 5 -134 58 -134 68 0 72 8 72 130 0 97 -2 112 -20 130 -25 25 -72 26 -93 2z"></path>
                    <path d="M2252 3794 c-21 -14 -22 -23 -22 -129 0 -125 8 -145 59 -145 50 0 61 25 68 153 l6 116 -27 11 c-38 14 -58 13 -84 -6z"></path>
                    <path d="M2239 3233 c-17 -19 -14 -230 3 -250 13 -16 72 -17 99 -3 18 10 19 18 13 123 -4 62 -11 120 -16 130 -12 23 -80 23 -99 0z"></path>
                    <path d="M2283 2680 c-16 -7 -23 -18 -23 -37 0 -33 35 -207 45 -223 7 -11 67 -4 98 12 20 10 19 30 -4 143 -22 105 -28 115 -62 114 -18 0 -42 -4 -54 -9z"></path>
                    <path d="M2425 2145 c-37 -11 -40 -15 -39 -46 2 -42 37 -138 69 -189 l25 -39 45 15 c41 15 45 19 45 49 0 19 -4 36 -9 39 -5 3 -12 18 -15 33 -12 49 -60 153 -71 152 -5 -1 -28 -7 -50 -14z"></path>
                    <path d="M2658 1647 c-16 -13 -28 -30 -28 -40 0 -9 19 -45 42 -79 23 -35 53 -80 66 -100 14 -21 29 -38 34 -38 16 0 88 54 88 66 0 7 -15 34 -33 60 -18 27 -48 70 -66 97 -18 26 -36 47 -41 47 -5 0 -14 2 -22 5 -7 2 -25 -6 -40 -18z"></path>
                    <path d="M3023 1223 c-45 -40 -49 -64 -16 -94 159 -138 173 -145 214 -97 15 18 28 38 29 45 0 6 -25 33 -56 59 -31 27 -72 63 -92 81 -20 18 -39 33 -42 33 -3 0 -20 -12 -37 -27z"></path>
                    <path d="M4817 903 l-28 -38 34 -30 c18 -16 73 -55 122 -85 49 -30 111 -69 139 -87 62 -38 116 -84 111 -93 -3 -4 -30 -10 -60 -13 -75 -8 -88 -19 -79 -71 3 -23 8 -43 11 -46 2 -3 30 -7 61 -10 36 -3 57 -10 57 -17 0 -12 -34 -58 -184 -250 -67 -86 -73 -97 -62 -119 14 -31 58 -49 87 -35 12 5 50 46 85 91 35 45 89 115 120 154 232 298 244 320 197 344 -40 20 -80 45 -168 103 -157 103 -229 149 -234 149 -3 0 -31 18 -63 40 -32 22 -72 42 -88 45 -26 5 -34 0 -58 -32z"></path>
                    <path d="M3446 874 l-30 -47 30 -23 c16 -13 61 -40 99 -60 39 -19 78 -41 88 -47 14 -10 21 -7 42 17 50 58 39 88 -50 132 -16 8 -55 28 -85 44 -30 16 -57 29 -60 29 -3 1 -18 -20 -34 -45z"></path>
                    <path d="M3959 653 c-6 -16 -12 -41 -13 -58 -1 -24 4 -31 29 -38 17 -6 50 -18 75 -27 25 -10 68 -21 96 -25 47 -6 51 -5 62 20 29 62 6 99 -68 111 -25 4 -63 15 -85 25 -58 27 -83 24 -96 -8z"></path>
                    <path d="M4508 544 c-15 -25 -18 -91 -5 -102 7 -6 63 -14 123 -18 130 -8 154 0 154 49 0 62 -13 68 -147 74 -66 3 -122 2 -125 -3z"></path>
                </g>
            </svg>
        </div>

        <div class="listivo-cta__left">
            <?php if (!empty($lstCurrentWidget->getSmallText())) : ?>
                <div>
                    <div class="listivo-cta__top">
                        <h3 class="listivo-cta__small-text">
                            <?php echo esc_html($lstCurrentWidget->getSmallText()); ?>
                        </h3>

                        <div class="listivo-cta__triangle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13px" viewBox="0 0 121.000000 121.000000"
                                 preserveAspectRatio="xMidYMid meet">
                                <g transform="translate(0.000000,121.000000) scale(0.100000,-0.100000)"
                                   stroke="none">
                                    <path d="M1127 1196 c-3 -8 -23 -18 -44 -21 -21 -3 -67 -14 -103 -25 -124 -35 -185 -51 -240 -64 -30 -7 -71 -18 -90 -24 -40 -13 -128 -37 -210 -56 -30 -7 -77 -21 -103 -30 -26 -9 -57 -16 -67 -16 -11 0 -46 -9 -77 -19 -32 -11 -76 -22 -98 -26 -46 -8 -65 -21 -65 -44 0 -21 820 -841 841 -841 23 0 36 19 44 65 4 22 15 66 26 98 10 31 19 66 19 77 0 10 7 41 16 67 9 26 23 73 30 103 19 82 43 170 56 210 6 19 17 60 24 90 13 55 29 116 64 240 11 36 22 82 25 103 3 21 13 41 21 44 9 3 14 19 14 44 0 39 0 39 -39 39 -25 0 -41 -5 -44 -14z m-78 -149 c11 -14 -1 -90 -32 -192 -19 -65 -35 -126 -51 -195 -7 -30 -20 -77 -29 -105 -20 -63 -44 -151 -62 -234 -15 -64 -38 -111 -55 -111 -12 0 -610 598 -610 610 0 17 47 40 111 55 83 18 171 42 234 62 28 9 75 22 105 29 70 16 131 32 195 52 48 14 148 38 171 41 6 0 17 -5 23 -12z"></path>
                                </g>
                            </svg>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($lstCurrentWidget->getText())) : ?>
                <h2 class="listivo-cta__text">
                    <?php echo nl2br(wp_kses_post($lstCurrentWidget->getText())); ?>
                </h2>
            <?php endif; ?>

            <?php if (!empty($lstActionUrl)):
                $lstActionIcon = $lstCurrentWidget->getActionIcon();
                ?>
                <div class="listivo-cta__button">
                    <a
                            class="listivo-button listivo-button--primary-1"
                            href="<?php echo esc_url($lstActionUrl); ?>"
                    >
                        <span>
                            <?php echo esc_html($lstCurrentWidget->getActionLabel()); ?>

                            <?php if (!empty($lstActionIcon)) : ?>
                                <?php if ($lstCurrentWidget->isSvgIcon()) : ?>
                                    <img
                                            src="<?php echo esc_url($lstActionIcon); ?>"
                                            alt="<?php echo esc_attr($lstCurrentWidget->getActionLabel()); ?>"
                                    >
                                <?php else : ?>
                                    <i class="<?php echo esc_attr($lstActionIcon); ?>"></i>
                                <?php endif; ?>
                            <?php else : ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11" fill="none">
                                    <path d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49605 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455586 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z" fill="#FDFDFE"/>
                                </svg>
                            <?php endif; ?>
                        </span>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <div class="listivo-cta__first-image">
            <?php if ($lstFirstImage) : ?>
                <div class="listivo-cta__inner-image">
                    <img
                            class="lazyload"
                            data-src="<?php echo esc_attr($lstFirstImage->getImageUrl('medium')); ?>"
                            alt="<?php echo esc_attr($lstFirstImage->getAlt()); ?>"
                    >
                </div>
            <?php endif; ?>
        </div>

        <div class="listivo-cta__second-image">
            <?php if ($lstSecondImage) : ?>
                <img
                        class="lazyload"
                        data-src="<?php echo esc_attr($lstSecondImage->getImageUrl('medium')); ?>"
                        alt="<?php echo esc_attr($lstSecondImage->getAlt()); ?>"
                >
            <?php endif; ?>
        </div>
    </div>
</div>