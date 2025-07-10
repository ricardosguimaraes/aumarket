<?php

use Tangibledesign\Listivo\Widgets\General\BadgeWidget;

/* @var BadgeWidget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-badge">
    <div class="listivo-badge__background">
        <svg xmlns="http://www.w3.org/2000/svg" width="217" height="217" viewBox="0 0 217 217" fill="none">
            <g filter="url(#filter0_d_6253_7955)">
                <path d="M125.48 17.0621C130.497 13.9775 137.08 15.8752 139.685 21.1571L144.914 31.7576C146.643 35.2614 150.253 37.4378 154.159 37.3299L165.974 37.0034C171.862 36.8407 176.614 41.7756 176.229 47.6525L175.458 59.4473C175.202 63.3459 177.241 67.0361 180.677 68.8954L191.073 74.5203C196.253 77.3231 197.901 83.9729 194.63 88.8702L188.064 98.6989C185.894 101.948 185.814 106.163 187.86 109.491L194.051 119.56C197.135 124.578 195.238 131.161 189.956 133.766L179.355 138.995C175.851 140.723 173.675 144.334 173.783 148.239L174.11 160.055C174.272 165.942 169.337 170.694 163.46 170.31L151.666 169.538C147.767 169.283 144.077 171.322 142.218 174.758L136.593 185.154C133.79 190.334 127.14 191.982 122.243 188.71L112.414 182.144C109.165 179.974 104.95 179.895 101.622 181.941L91.5526 188.131C86.5354 191.216 79.9524 189.318 77.347 184.036L72.118 173.436C70.3896 169.932 66.7789 167.756 62.8735 167.864L51.0579 168.19C45.1707 168.353 40.4185 163.418 40.803 157.541L41.5748 145.746C41.8299 141.847 39.7912 138.157 36.355 136.298L25.9592 130.673C20.7793 127.87 19.1312 121.221 22.4028 116.323L28.9686 106.495C31.1388 103.246 31.2183 99.0306 29.1721 95.7024L22.9815 85.6331C19.897 80.6159 21.7947 74.0329 27.0765 71.4275L37.677 66.1985C41.1809 64.4701 43.3573 60.8595 43.2494 56.954L42.9228 45.1385C42.7601 39.2512 47.695 34.499 53.572 34.8836L65.3668 35.6554C69.2654 35.9105 72.9556 33.8717 74.8148 30.4355L80.4398 20.0397C83.2425 14.8599 89.8924 13.2118 94.7897 16.4833L104.618 23.0491C107.867 25.2193 112.082 25.2988 115.411 23.2526L125.48 17.0621Z"
                      fill="#374B5C"/>
            </g>
            <defs>
                <filter id="filter0_d_6253_7955" x="0.716125" y="0.796875" width="215.6" height="215.6"
                        filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                                   result="hardAlpha"/>
                    <feOffset dy="6"/>
                    <feGaussianBlur stdDeviation="10"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix"
                                   values="0 0 0 0 0.164706 0 0 0 0 0.223529 0 0 0 0 0.27451 0 0 0 0.1 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_6253_7955"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_6253_7955" result="shape"/>
                </filter>
            </defs>
        </svg>
    </div>

    <div class="listivo-badge__content">
        <?php if (!empty($lstCurrentWidget->getImageUrl())) : ?>
            <div class="listivo-badge__image">
                <img
                        class="lazyload"
                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                        data-src="<?php echo esc_url($lstCurrentWidget->getImageUrl()); ?>"
                        alt="<?php echo esc_attr($lstCurrentWidget->getLabel()); ?>"
                >
            </div>
        <?php endif; ?>

        <?php if (!empty($lstCurrentWidget->getValue())) : ?>
            <div class="listivo-badge__value">
                <?php echo esc_html($lstCurrentWidget->getValue()); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($lstCurrentWidget->getLabel())) : ?>
            <div class="listivo-badge__label">
                <?php echo esc_html($lstCurrentWidget->getLabel()); ?>
            </div>
        <?php endif; ?>
    </div>
</div>