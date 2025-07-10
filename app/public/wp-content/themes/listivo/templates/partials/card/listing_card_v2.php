<?php

use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Listivo\Widgets\Helpers\Presentation\AdCard;

/* @var Model $lstCurrentListing */
/* @var AdCard $lstModelCard */
global $lstCurrentListing, $lstModelCard;

if (!$lstModelCard) {
    $lstModelCard = new AdCard($lstCurrentListing);
}

$lstMainValue = $lstModelCard->getMainValue();
$lstImage = $lstCurrentListing->getMainImage();
$lstAttributes = $lstModelCard->getAttributes();
?>
    <a
        <?php if ($lstCurrentListing->isFeatured()) : ?>
            class="listivo-listing-card-v2"
        <?php else : ?>
            class="listivo-listing-card-v2 listivo-listing-featured"
        <?php endif; ?>
            href="<?php echo esc_url($lstCurrentListing->getUrl()); ?>"
    >
        <div class="listivo-listing-card-v2__image">
            <div class="listivo-listing-card-v2__labels">
                <?php foreach (tdf_app('card_label_fields') as $lstLabelOption) : ?>
                    <?php if ($lstLabelOption === 'featured' && $lstModelCard->showFeatured() && $lstCurrentListing->isFeatured()) : ?>
                        <div class="listivo-listing-card-v2__label">
                            <?php echo esc_html(tdf_string('featured')); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($lstLabelOption instanceof \Tangibledesign\Framework\Models\Field\TaxonomyField) : ?>
                        <?php foreach ($lstLabelOption->getValue($lstCurrentListing) as $lstModelTerm) : ?>
                            <?php if ($lstModelTerm->showLabel()) : ?>
                                <div
                                        class="listivo-listing-card-v2__label"
                                        style="
                                        <?php if (!empty($lstModelTerm->getLabelColor())) : ?>
                                                color: <?php echo esc_html($lstModelTerm->getLabelColor()); ?>;
                                                <?php endif; ?>
                                        <?php if (!empty($lstModelTerm->getLabelBgColor())) : ?>
                                                background-color: <?php echo esc_html($lstModelTerm->getLabelBgColor()); ?>;
                                                <?php endif; ?>
                                                "
                                >
                                    <?php echo esc_html($lstModelTerm->getName()); ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <?php if ($lstImage) :
                $lstImageSrcset = $lstImage->getSrcset(tdf_settings()->getListingCardImageSize());
                ?>
                <img
                        class="lazyload"
                    <?php if ($lstImageSrcset) : ?>
                        data-sizes="auto"
                        data-srcset="<?php echo esc_attr($lstImageSrcset); ?>"
                    <?php else : ?>
                        data-src="<?php echo esc_url($lstImage->getImageUrl()); ?>"
                    <?php endif; ?>
                        alt="<?php echo esc_attr($lstImage->getAlt()); ?>"
                >
            <?php endif; ?>
        </div>

        <div class="listivo-listing-card-v2__content">
            <h3 class="listivo-listing-card-v2__name">
                <?php echo esc_html($lstCurrentListing->getName()); ?>
            </h3>

            <div class="listivo-listing-card-v2__bottom">
                <?php if (!empty($lstMainValue)) : ?>
                    <div class="listivo-listing-card-v2__price">
                        <?php echo esc_html($lstMainValue); ?>
                    </div>
                <?php endif; ?>

                <?php if (tdf_settings()->isFavoriteEnabled()) : ?>
                    <lst-favorite :model-id="<?php echo esc_attr($lstCurrentListing->getId()); ?>">
                        <button
                                slot-scope="favorite"
                                @click.prevent="favorite.onClick"
                                class="listivo-listing-card-v2__favorite"
                        >
                            <template>
                                <svg v-if="!favorite.isActive" xmlns="http://www.w3.org/2000/svg"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4"
                                          d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>

                                <svg v-if="favorite.isActive" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                     fill="currentColor">
                                    <path fill-rule="evenodd"
                                          d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </template>
                        </button>
                    </lst-favorite>
                <?php endif; ?>
            </div>
        </div>
    </a>
<?php
$lstModelCard = false;
