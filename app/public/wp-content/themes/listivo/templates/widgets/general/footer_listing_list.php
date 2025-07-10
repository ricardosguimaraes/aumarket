<?php

use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Listivo\Widgets\General\FooterListingListWidget;

/* @var FooterListingListWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstPriceFields = $lstCurrentWidget->getPriceFields();
$lstTaxonomyField = $lstCurrentWidget->getTaxonomyField();
?>
<div class="listivo-mini-listings">
    <?php foreach ($lstCurrentWidget->getListings() as $lstModel) :
        /* @var Model $lstModel */
        $lstModelImage = $lstModel->getMainImage();
        $lstModelPrice = '';

        foreach ($lstPriceFields as $lstPriceField) {
            $lstTempListingPrice = $lstPriceField->getValueByCurrency($lstModel);
            if (!empty($lstTempListingPrice)) {
                $lstModelPrice = $lstTempListingPrice;
            }
        }
        ?>
        <div class="listivo-mini-listings__item">
            <div class="listivo-mini-listing">
                <a
                        class="listivo-mini-listing__image"
                        href="<?php echo esc_url($lstModel->getUrl()); ?>"
                        title="<?php echo esc_attr($lstModel->getName()); ?>"
                >
                    <?php if ($lstModelImage) : ?>
                        <img
                                class="lazyload"
                                data-src="<?php echo esc_url($lstModelImage->getImageUrl('listivo_100_100')); ?>"
                                alt="<?php echo esc_attr($lstModel->getName()); ?>"
                        >
                    <?php endif; ?>
                </a>

                <div class="listivo-mini-listing__content">
                    <a
                            class="listivo-mini-listing__label"
                            href="<?php echo esc_url($lstModel->getUrl()); ?>"
                            title="<?php echo esc_attr($lstModel->getName()); ?>"
                    >
                        <?php echo esc_html($lstModel->getName()); ?>
                    </a>

                    <div class="listivo-mini-listing__value">
                        <?php if (!empty($lstModelPrice)) : ?>
                            <?php echo esc_html($lstModelPrice); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
