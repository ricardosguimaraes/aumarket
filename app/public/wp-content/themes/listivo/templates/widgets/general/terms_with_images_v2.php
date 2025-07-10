<?php

use Tangibledesign\Framework\Models\Image;
use Tangibledesign\Framework\Models\Term\CustomTerm;
use Tangibledesign\Listivo\Widgets\General\TermsWithImagesWidget;

/* @var TermsWithImagesWidget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-images-with-terms-v2">
    <?php foreach ($lstCurrentWidget->getTermList() as $lstIndex => $lstItem) :
        /* @var Image $lstImage */
        $lstImage = $lstItem['image'];
        /* @var CustomTerm $lstTerm */
        $lstTerm = $lstItem['term'];
        ?>
        <a
                class="listivo-images-with-terms-v2__term"
                href="<?php echo esc_url($lstTerm->getUrl()); ?>"
        >
            <img
                    class="listivo-images-with-terms-v2__image lazyload"
                    data-src="<?php echo esc_url($lstImage->getImageUrl($lstCurrentWidget->getImageSize())); ?>"
                    alt="<?php echo esc_attr($lstTerm->getName()); ?>"
            >

            <h3 class="listivo-images-with-terms-v2__label">
                <?php echo esc_html($lstTerm->getName()); ?>
            </h3>

            <div class="listivo-images-with-terms-v2__count">
                <span><?php echo esc_html($lstTerm->getCount() . ' ' . tdf_string('listings')); ?></span>
            </div>

            <div class="listivo-images-with-terms-v2__mask"></div>
            <div class="listivo-images-with-terms-v2__dark-mask"></div>
        </a>
    <?php endforeach; ?>
</div>