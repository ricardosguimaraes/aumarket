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
$lstLocation = $lstCurrentListing->getAddress();

if (tdf_settings()->showUserOnCard()) {
    $lstCurrentListingUser = $lstCurrentListing->getUser();
    if ($lstCurrentListingUser) {
        $lstUserImage = $lstCurrentListingUser->getImageUrl('thumbnail');
    } else {
        $lstUserImage = false;
    }
} else {
    $lstCurrentListingUser = false;
    $lstUserImage = false;
}

$lstModelClass = ['listivo-listing-card'];

if (!$lstUserImage) {
    $lstModelClass[] = 'listivo-listing-no-user';
}

if (!$lstImage) {
    $lstModelClass[] = 'listivo-listing-no-image';
}

if ($lstCurrentListing->isFeatured()) {
    $lstModelClass[] = 'listivo-listing-featured';
}
?>
    <div
            class="<?php echo esc_attr(implode(' ', $lstModelClass)); ?>"
            data-id="<?php echo esc_attr($lstCurrentListing->getId()); ?>"
    >
        <div class="listivo-listing-card__inner">
            <a class="listivo-listing-card__link" href="<?php echo esc_url($lstCurrentListing->getUrl()); ?>"></a>

            <div>
                <div class="listivo-listing-card__top">
                    <?php if ($lstCurrentListingUser) : ?>
                        <div class="listivo-listing-card__user">
                            <div class="listivo-listing-card__user-image">
                                <?php if ($lstUserImage) : ?>
                                    <img
                                            class="lazyload"
                                            data-src="<?php echo esc_url($lstUserImage); ?>"
                                            alt="<?php echo esc_attr($lstCurrentListingUser->getDisplayName()); ?>"
                                    >
                                <?php else : ?>
                                    <div class="listivo-user-image-placeholder">
                                        <i class="fa fa-user"></i>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <span class="listivo-listing-card__user-name">
                                <?php echo esc_html($lstCurrentListingUser->getDisplayName()) ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <?php if ($lstImage) :
                        $lstImageSrcset = $lstImage->getSrcset(tdf_settings()->getListingCardImageSize());
                        ?>
                        <img
                            <?php if (!empty($lstImageSrcset)) : ?>
                                class="lazyload listivo-listing-card__preview"
                                data-srcset="<?php echo esc_attr($lstImageSrcset); ?>"
                                data-sizes="auto"
                            <?php else : ?>
                                class="listivo-listing-card__preview lazyload"
                                data-src="<?php echo esc_url($lstImage->getImageUrl()); ?>"
                            <?php endif; ?>
                                alt="<?php echo esc_attr($lstCurrentListing->getName()); ?>"
                        >
                    <?php else : ?>
                        <div class="listivo-card-image-placeholder">
                            <i class="fa fa-image"></i>
                        </div>
                    <?php endif; ?>

                    <div class="listivo-listing-card__labels">
                        <?php foreach (tdf_app('card_label_fields') as $lstLabelOption) : ?>
                            <?php if ($lstLabelOption === 'featured' && $lstModelCard->showFeatured() && $lstCurrentListing->isFeatured()) : ?>
                                <div class="listivo-listing-card__label">
                                    <?php echo esc_html(tdf_string('featured')); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($lstLabelOption instanceof \Tangibledesign\Framework\Models\Field\TaxonomyField) : ?>
                                <?php foreach ($lstLabelOption->getValue($lstCurrentListing) as $lstModelTerm) : ?>
                                    <?php if ($lstModelTerm->showLabel()) : ?>
                                        <div
                                                class="listivo-listing-card__label"
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
                </div>

                <div class="listivo-listing-card__main">
                    <div class="listivo-listing-card__main-head">
                        <h3 class="listivo-listing-card__name">
                            <?php echo esc_html($lstCurrentListing->getName()); ?>
                        </h3>

                        <?php if (!empty($lstLocation)) : ?>
                            <div class="listivo-listing-card__location">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4"
                                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4"
                                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg> <?php echo esc_html($lstLocation); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($lstMainValue)) : ?>
                            <b class="listivo-listing-card__price">
                                <?php echo esc_html($lstMainValue); ?>
                            </b>
                        <?php endif; ?>

                    </div>
                </div>
            </div>

            <div class="listivo-listing-card__footer">
                <?php if (!empty($lstAttributes)) : ?>
                    <div class="listivo-listing-card__features">
                        <ul>
                            <?php foreach ($lstAttributes as $lstAttribute) : ?>
                                <li><span><?php echo esc_html($lstAttribute); ?></span></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (tdf_settings()->isFavoriteEnabled()) : ?>
                    <lst-favorite :model-id="<?php echo esc_attr($lstCurrentListing->getId()); ?>">
                        <button
                                slot-scope="favorite"
                                @click.prevent="favorite.onClick"
                                class="listivo-listing-card__favorite"
                        >
                            <template>
                                <svg v-if="!favorite.isActive" xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
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
    </div>
<?php
$lstModelCard = false;