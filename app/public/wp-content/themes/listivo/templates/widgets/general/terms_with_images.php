<?php
/* @var \Tangibledesign\Listivo\Widgets\General\TermsWithImagesWidget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<section>
    <div class="listivo-terms">
        <?php foreach ($lstCurrentWidget->getTermList() as $lstIndex => $lstItem) :
            /* @var \Tangibledesign\Framework\Models\Image $lstImage */
            $lstImage = $lstItem['image'];
            /* @var \Tangibledesign\Framework\Models\Term\CustomTerm $lstTerm */
            $lstTerm = $lstItem['term'];
            ?>
            <div class="listivo-term-single-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <clipPath
                            id="listivo-term-with-image-<?php echo esc_attr($lstIndex); ?>"
                            clipPathUnits="objectBoundingBox"
                    >
                        <path d="M0.214,0.86 L0.082,0.804 C0.02,0.778,-0.013,0.694,0.008,0.616 L0.136,0.139 C0.148,0.095,0.18,0.063,0.217,0.058 L0.632,0.002 C0.681,-0.005,0.729,0.023,0.757,0.074 L0.992,0.506 C1,0.536,1,0.577,0.981,0.599 L0.595,0.986 C0.58,1,0.561,1,0.543,0.997 L0.311,0.9 L0.26,0.879 L0.214,0.86"></path>
                    </clipPath>
                </svg>

                <div class="listivo-term-container">
                    <a
                            class="listivo-term-single"
                            href="<?php echo esc_url($lstTerm->getUrl()); ?>"
                            style="clip-path: url(#listivo-term-with-image-<?php echo esc_attr($lstIndex); ?>);"
                    >
                        <img
                                class="listivo-term-single__image lazyload"
                                data-src="<?php echo esc_url($lstImage->getImageUrl($lstCurrentWidget->getImageSize())); ?>"
                                alt="<?php echo esc_attr($lstTerm->getName()); ?>"
                        >

                        <span class="listivo-term-single__name"><?php echo esc_html($lstTerm->getName()); ?></span>

                        <div class="listivo-term-single__count">
                            <span><?php echo esc_html($lstTerm->getCount() . ' ' . tdf_string('listings')); ?></span>
                        </div>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>