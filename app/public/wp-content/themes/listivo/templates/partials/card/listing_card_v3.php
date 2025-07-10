<?php

use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Field\TextField;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Listivo\Widgets\Helpers\Presentation\AdCard;

/* @var Model $lstCurrentListing */
/* @var AdCard $lstModelCard */
global $lstCurrentListing, $lstModelCard;

if (!$lstModelCard) {
    $lstModelCard = new AdCard($lstCurrentListing);
}

$lstMainValue = $lstModelCard->getMainValue();
$lstAddress = $lstCurrentListing->getAddress();
$lstAttributes = $lstModelCard->getAttributes();
$lstImageSize = tdf_app('listing_card_image_size');
$lstImages = $lstCurrentListing->getImages(tdf_app('card_max_number_of_images'));
$lstUser = $lstCurrentListing->getUser();
?>
    <a
        <?php if ($lstCurrentListing->isFeatured()) : ?>
            class="listivo-listing-card-v3 listivo-listing-card-v3--featured"
        <?php else : ?>
            class="listivo-listing-card-v3"
        <?php endif; ?>
            href="<?php echo esc_url($lstCurrentListing->getUrl()); ?>"
    >
        <div class="listivo-listing-card-v3__gallery listivo-listing-card-v3__gallery--image-count-<?php echo esc_attr($lstImages->count()); ?>">
            <?php if (tdf_app('listing_card_featured_only')) : ?>
                <?php if ($lstCurrentListing->isFeatured()) : ?>
                    <div class="listivo-listing-card-v3__featured">
                        <?php echo esc_html(tdf_string('featured')); ?>
                    </div>
                <?php endif; ?>
            <?php else : ?>
                <div class="listivo-listing-card-v3__labels">
                    <?php foreach (tdf_app('card_label_fields') as $lstLabelOption) : ?>
                        <?php if ($lstLabelOption === 'featured' && $lstModelCard->showFeatured() && $lstCurrentListing->isFeatured()) : ?>
                            <div class="listivo-listing-card-v3__label listivo-listing-card-v3__label--featured">
                                <?php echo esc_html(tdf_string('featured')); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($lstLabelOption instanceof TaxonomyField) : ?>
                            <?php foreach ($lstLabelOption->getValue($lstCurrentListing) as $lstModelTerm) : ?>
                                <?php if ($lstModelTerm->showLabel()) : ?>
                                    <div
                                            class="listivo-listing-card-v3__label"
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

                        <?php if ($lstLabelOption instanceof TextField && !empty($lstLabelOption->getValue($lstCurrentListing))) : ?>
                            <div class="listivo-listing-card-v3__label">
                                <?php echo esc_html($lstLabelOption->getValue($lstCurrentListing)); ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (tdf_app('card_gallery')) : ?>
                <lst-card-gallery prefix="listivo">
                    <div slot-scope="gallery">
                        <div class="listivo-swiper-container">
                            <div class="listivo-swiper-wrapper">
                                <?php
                                if ($lstImages->isNotEmpty()) :
                                    foreach ($lstImages as $lstImage) :
                                        $lstImageSrcset = $lstImage->getSrcset($lstImageSize['key']);
                                        ?>
                                        <div class="listivo-swiper-slide">
                                            <img
                                                    class="lazyload"
                                                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                                                    alt="<?php echo esc_attr($lstImage->getAlt()); ?>"
                                                <?php if (!empty($lstImageSrcset)) : ?>
                                                    data-srcset="<?php echo esc_attr($lstImageSrcset); ?>"
                                                    data-sizes="auto"
                                                <?php else : ?>
                                                    data-src="<?php echo esc_url($lstImage->getImageUrl($lstImageSize['key'])); ?>"
                                                <?php endif; ?>
                                            >
                                        </div>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <div class="listivo-swiper-slide">
                                        <img
                                                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                                                alt="<?php echo esc_attr($lstCurrentListing->getName()); ?>"
                                        >

                                        <?php get_template_part('templates/partials/image_placeholder'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <?php if ($lstImages->isNotEmpty()) : ?>
                                <div class="listivo-listing-card-v3__pagination">
                                    <div class="listivo-swiper-pagination"></div>
                                </div>

                                <div
                                        class="listivo-listing-card-v3__prev-holder"
                                        @click.stop.prevent
                                ></div>

                                <div
                                        class="listivo-listing-card-v3__next-holder"
                                        @click.stop.prevent
                                ></div>

                                <div
                                        @click.prevent="gallery.prevSlide"
                                        class="listivo-listing-card-v3__prev"
                                        :class="{'listivo-listing-card-v3__prev--active': !gallery.swiper.isBeginning}"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14" viewBox="0 0 16 14"
                                         fill="none">
                                        <path d="M15.509 7.19858C15.5064 7.03297 15.4382 6.87515 15.3193 6.75979C15.2004 6.64443 15.0406 6.58097 14.875 6.58335L2.63379 6.58335L7.40023 1.81691C7.46021 1.75932 7.5081 1.69034 7.54109 1.61401C7.57408 1.53768 7.59151 1.45553 7.59235 1.37238C7.5932 1.28923 7.57745 1.20675 7.54602 1.12977C7.51458 1.05278 7.46811 0.982842 7.40931 0.924043C7.35051 0.865245 7.28057 0.818769 7.20359 0.787338C7.1266 0.755907 7.04412 0.740154 6.96097 0.740999C6.87782 0.741844 6.79568 0.759272 6.71935 0.792261C6.64301 0.825251 6.57403 0.873139 6.51644 0.933121L0.68311 6.76646C0.565944 6.88367 0.500125 7.04262 0.500125 7.20835C0.500125 7.37408 0.565944 7.53303 0.68311 7.65024L6.51644 13.4836C6.57403 13.5436 6.64301 13.5914 6.71935 13.6244C6.79568 13.6574 6.87782 13.6749 6.96097 13.6757C7.04412 13.6765 7.1266 13.6608 7.20359 13.6294C7.28057 13.5979 7.35051 13.5515 7.40931 13.4927C7.46811 13.4339 7.51458 13.3639 7.54601 13.2869C7.57745 13.2099 7.5932 13.1275 7.59235 13.0443C7.59151 12.9612 7.57408 12.879 7.54109 12.8027C7.5081 12.7264 7.46021 12.6574 7.40023 12.5998L2.63379 7.83335L14.875 7.83335C14.9587 7.83455 15.0417 7.81894 15.1192 7.78746C15.1967 7.75597 15.2671 7.70925 15.3262 7.65005C15.3854 7.59086 15.432 7.5204 15.4634 7.44285C15.4948 7.3653 15.5103 7.28223 15.509 7.19858Z"
                                              fill="#2A3946"/>
                                    </svg>
                                </div>

                                <div
                                        @click.prevent="gallery.nextSlide"
                                        class="listivo-listing-card-v3__next"
                                        :class="{'listivo-listing-card-v3__next--active': !gallery.swiper.isEnd}"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14" viewBox="0 0 16 14"
                                         fill="none">
                                        <path d="M0.491043 6.80142C0.493631 6.96703 0.561849 7.12485 0.680715 7.24021C0.799581 7.35557 0.959374 7.41903 1.12499 7.41665L13.3662 7.41665L8.59977 12.1831C8.53979 12.2407 8.4919 12.3097 8.45891 12.386C8.42592 12.4623 8.40849 12.5445 8.40765 12.6276C8.4068 12.7108 8.42255 12.7932 8.45398 12.8702C8.48542 12.9472 8.53189 13.0172 8.59069 13.076C8.64949 13.1348 8.71943 13.1812 8.79641 13.2127C8.8734 13.2441 8.95588 13.2598 9.03903 13.259C9.12218 13.2582 9.20432 13.2407 9.28065 13.2077C9.35699 13.1747 9.42597 13.1269 9.48356 13.0669L15.3169 7.23354C15.4341 7.11633 15.4999 6.95738 15.4999 6.79165C15.4999 6.62592 15.4341 6.46697 15.3169 6.34976L9.48356 0.51642C9.42597 0.456439 9.35699 0.408551 9.28065 0.375562C9.20432 0.342572 9.12218 0.325145 9.03903 0.3243C8.95588 0.323455 8.8734 0.339209 8.79641 0.370639C8.71943 0.40207 8.64949 0.448545 8.59069 0.507343C8.53189 0.566142 8.48542 0.636082 8.45399 0.713067C8.42255 0.790051 8.4068 0.872534 8.40765 0.955684C8.40849 1.03883 8.42592 1.12098 8.45891 1.19731C8.4919 1.27364 8.53979 1.34262 8.59977 1.40021L13.3662 6.16665L1.12499 6.16665C1.04134 6.16545 0.958301 6.18106 0.88079 6.21254C0.80328 6.24403 0.732879 6.29075 0.67376 6.34995C0.614641 6.40914 0.568006 6.4796 0.53662 6.55715C0.505234 6.6347 0.489736 6.71777 0.491043 6.80142Z"
                                              fill="#2A3946"/>
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </lst-card-gallery>
            <?php else : ?>
                <?php
                $lstImage = $lstCurrentListing->getMainImage();
                if ($lstImage) :
                    $lstImageSrcset = $lstImage->getSrcset($lstImageSize['key']);
                    ?>
                    <img
                            class="lazyload"
                            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                            alt="<?php echo esc_attr($lstImage->getAlt()); ?>"
                        <?php if (!empty($lstImageSrcset)) : ?>
                            data-sizes="auto"
                            data-srcset="<?php echo esc_attr($lstImageSrcset); ?>"
                        <?php else : ?>
                            data-src="<?php echo esc_url($lstImage->getImageUrl()); ?>"
                        <?php endif; ?>
                    >
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="listivo-listing-card-v3__body">
            <div class="listivo-listing-card-v3__inner">
                <div class="listivo-listing-card-v3__content">
                    <h3 class="listivo-listing-card-v3__name">
                        <?php echo esc_html($lstCurrentListing->getName()); ?>
                    </h3>

                    <?php if ($lstUser && $lstUser->hasPhone() && tdf_app('card_show_user_phone')) : ?>
                        <?php if (tdf_app('card_hide_user_phone_at_start')) : ?>
                            <lst-phone
                                    :user-id="<?php echo esc_attr($lstUser->getId()); ?>"
                                    request-url="<?php echo esc_url(admin_url('admin-post.php?action=listivo/phone')); ?>"
                                    phone-nonce="<?php echo esc_attr(wp_create_nonce('phone_' . $lstUser->getId())) ?>"
                                <?php if ($lstCurrentListing) : ?>
                                    :model-id="<?php echo esc_attr($lstCurrentListing->getId()); ?>"
                                <?php endif; ?>
                                    class="listivo-listing-card-v3__user-phone"
                            >
                                <div slot-scope="props" class="listivo-listing-card-v3__user-phone">
                                    <button
                                            class="listivo-simple-button listivo-simple-button--full-width listivo-simple-button--height-45 listivo-simple-button--background-primary-1"
                                            v-if="!props.phone"
                                            @click.prevent="props.onShow"
                                    >
                                        <span class="listivo-simple-button__icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="24"
                                                 viewBox="0 0 14 24"
                                                 fill="none">
                                                <path d="M2.625 0C1.18562 0 0 1.18562 0 2.625V20.7083C0 22.1477 1.18562 23.3333 2.625 23.3333H11.375C12.8144 23.3333 14 22.1477 14 20.7083V2.625C14 1.18562 12.8144 0 11.375 0H2.625ZM2.625 1.75H11.375C11.8688 1.75 12.25 2.13121 12.25 2.625V20.7083C12.25 21.2021 11.8688 21.5833 11.375 21.5833H2.625C2.13121 21.5833 1.75 21.2021 1.75 20.7083V2.625C1.75 2.13121 2.13121 1.75 2.625 1.75ZM7 3.5C6.76794 3.5 6.54538 3.59219 6.38128 3.75628C6.21719 3.92038 6.125 4.14294 6.125 4.375C6.125 4.60706 6.21719 4.82962 6.38128 4.99372C6.54538 5.15781 6.76794 5.25 7 5.25C7.23206 5.25 7.45462 5.15781 7.61872 4.99372C7.78281 4.82962 7.875 4.60706 7.875 4.375C7.875 4.14294 7.78281 3.92038 7.61872 3.75628C7.45462 3.59219 7.23206 3.5 7 3.5ZM5.54167 18.0833C5.42572 18.0817 5.3106 18.1031 5.203 18.1464C5.09541 18.1896 4.99748 18.2538 4.9149 18.3352C4.83233 18.4166 4.76676 18.5136 4.722 18.6206C4.67725 18.7276 4.6542 18.8424 4.6542 18.9583C4.6542 19.0743 4.67725 19.1891 4.722 19.2961C4.76676 19.403 4.83233 19.5001 4.9149 19.5815C4.99748 19.6629 5.09541 19.7271 5.203 19.7703C5.3106 19.8136 5.42572 19.835 5.54167 19.8333H8.45833C8.57428 19.835 8.6894 19.8136 8.797 19.7703C8.90459 19.7271 9.00252 19.6629 9.0851 19.5815C9.16767 19.5001 9.23324 19.403 9.278 19.2961C9.32275 19.1891 9.3458 19.0743 9.3458 18.9583C9.3458 18.8424 9.32275 18.7276 9.278 18.6206C9.23324 18.5136 9.16767 18.4166 9.0851 18.3352C9.00252 18.2538 8.90459 18.1896 8.797 18.1464C8.6894 18.1031 8.57428 18.0817 8.45833 18.0833H5.54167Z"
                                                      fill="#2A3946"/>
                                            </svg>
                                        </span>

                                        <?php echo wp_kses_post($lstUser->getPhonePlaceholder()); ?>
                                    </button>

                                    <template>
                                        <button
                                                class="listivo-simple-button listivo-simple-button--full-width listivo-simple-button--height-45 listivo-simple-button--background-primary-1"
                                                v-if="props.phone"
                                                @click.prevent="props.makeCall"
                                        >
                                            <span class="listivo-simple-button__icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="24"
                                                     viewBox="0 0 14 24"
                                                     fill="none">
                                                    <path d="M2.625 0C1.18562 0 0 1.18562 0 2.625V20.7083C0 22.1477 1.18562 23.3333 2.625 23.3333H11.375C12.8144 23.3333 14 22.1477 14 20.7083V2.625C14 1.18562 12.8144 0 11.375 0H2.625ZM2.625 1.75H11.375C11.8688 1.75 12.25 2.13121 12.25 2.625V20.7083C12.25 21.2021 11.8688 21.5833 11.375 21.5833H2.625C2.13121 21.5833 1.75 21.2021 1.75 20.7083V2.625C1.75 2.13121 2.13121 1.75 2.625 1.75ZM7 3.5C6.76794 3.5 6.54538 3.59219 6.38128 3.75628C6.21719 3.92038 6.125 4.14294 6.125 4.375C6.125 4.60706 6.21719 4.82962 6.38128 4.99372C6.54538 5.15781 6.76794 5.25 7 5.25C7.23206 5.25 7.45462 5.15781 7.61872 4.99372C7.78281 4.82962 7.875 4.60706 7.875 4.375C7.875 4.14294 7.78281 3.92038 7.61872 3.75628C7.45462 3.59219 7.23206 3.5 7 3.5ZM5.54167 18.0833C5.42572 18.0817 5.3106 18.1031 5.203 18.1464C5.09541 18.1896 4.99748 18.2538 4.9149 18.3352C4.83233 18.4166 4.76676 18.5136 4.722 18.6206C4.67725 18.7276 4.6542 18.8424 4.6542 18.9583C4.6542 19.0743 4.67725 19.1891 4.722 19.2961C4.76676 19.403 4.83233 19.5001 4.9149 19.5815C4.99748 19.6629 5.09541 19.7271 5.203 19.7703C5.3106 19.8136 5.42572 19.835 5.54167 19.8333H8.45833C8.57428 19.835 8.6894 19.8136 8.797 19.7703C8.90459 19.7271 9.00252 19.6629 9.0851 19.5815C9.16767 19.5001 9.23324 19.403 9.278 19.2961C9.32275 19.1891 9.3458 19.0743 9.3458 18.9583C9.3458 18.8424 9.32275 18.7276 9.278 18.6206C9.23324 18.5136 9.16767 18.4166 9.0851 18.3352C9.00252 18.2538 8.90459 18.1896 8.797 18.1464C8.6894 18.1031 8.57428 18.0817 8.45833 18.0833H5.54167Z"
                                                          fill="#2A3946"/>
                                                </svg>
                                            </span>

                                            {{ props.phone.label }}
                                        </button>
                                    </template>
                                </div>
                            </lst-phone>
                        <?php else : ?>
                            <lst-phone
                                    :user-id="<?php echo esc_attr($lstUser->getId()); ?>"
                                    request-url="<?php echo esc_url(admin_url('admin-post.php?action=listivo/phone')); ?>"
                                    :initial-phone="<?php echo htmlspecialchars(json_encode([
                                        'label' => $lstUser->getPhone(),
                                        'url' => $lstUser->getPhoneUrl(),
                                    ])); ?>"
                                    phone-nonce="<?php echo esc_attr(wp_create_nonce('phone_' . $lstUser->getId())) ?>"
                                <?php if ($lstCurrentListing) : ?>
                                    :model-id="<?php echo esc_attr($lstCurrentListing->getId()); ?>"
                                <?php endif; ?>
                                    class="listivo-listing-card-v3__user-phone"
                            >
                                <div slot-scope="props" class="listivo-listing-card-v3__user-phone">
                                    <button
                                            class="listivo-simple-button listivo-simple-button--full-width listivo-simple-button--height-45 listivo-simple-button--background-primary-1"
                                            @click.prevent="props.makeCall"
                                    >
                                        <span class="listivo-simple-button__icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="24"
                                                 viewBox="0 0 14 24"
                                                 fill="none">
                                                <path d="M2.625 0C1.18562 0 0 1.18562 0 2.625V20.7083C0 22.1477 1.18562 23.3333 2.625 23.3333H11.375C12.8144 23.3333 14 22.1477 14 20.7083V2.625C14 1.18562 12.8144 0 11.375 0H2.625ZM2.625 1.75H11.375C11.8688 1.75 12.25 2.13121 12.25 2.625V20.7083C12.25 21.2021 11.8688 21.5833 11.375 21.5833H2.625C2.13121 21.5833 1.75 21.2021 1.75 20.7083V2.625C1.75 2.13121 2.13121 1.75 2.625 1.75ZM7 3.5C6.76794 3.5 6.54538 3.59219 6.38128 3.75628C6.21719 3.92038 6.125 4.14294 6.125 4.375C6.125 4.60706 6.21719 4.82962 6.38128 4.99372C6.54538 5.15781 6.76794 5.25 7 5.25C7.23206 5.25 7.45462 5.15781 7.61872 4.99372C7.78281 4.82962 7.875 4.60706 7.875 4.375C7.875 4.14294 7.78281 3.92038 7.61872 3.75628C7.45462 3.59219 7.23206 3.5 7 3.5ZM5.54167 18.0833C5.42572 18.0817 5.3106 18.1031 5.203 18.1464C5.09541 18.1896 4.99748 18.2538 4.9149 18.3352C4.83233 18.4166 4.76676 18.5136 4.722 18.6206C4.67725 18.7276 4.6542 18.8424 4.6542 18.9583C4.6542 19.0743 4.67725 19.1891 4.722 19.2961C4.76676 19.403 4.83233 19.5001 4.9149 19.5815C4.99748 19.6629 5.09541 19.7271 5.203 19.7703C5.3106 19.8136 5.42572 19.835 5.54167 19.8333H8.45833C8.57428 19.835 8.6894 19.8136 8.797 19.7703C8.90459 19.7271 9.00252 19.6629 9.0851 19.5815C9.16767 19.5001 9.23324 19.403 9.278 19.2961C9.32275 19.1891 9.3458 19.0743 9.3458 18.9583C9.3458 18.8424 9.32275 18.7276 9.278 18.6206C9.23324 18.5136 9.16767 18.4166 9.0851 18.3352C9.00252 18.2538 8.90459 18.1896 8.797 18.1464C8.6894 18.1031 8.57428 18.0817 8.45833 18.0833H5.54167Z"
                                                      fill="#2A3946"/>
                                            </svg>
                                        </span>

                                        <?php echo esc_html($lstUser->getDisplayPhone()); ?>
                                    </button>
                                </div>
                            </lst-phone>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if (!empty($lstAddress))  : ?>
                        <div class="listivo-listing-card-v3__address">
                            <div class="listivo-listing-card-v3__address-icon-wrapper">
                                <span class="listivo-listing-card-v3__address-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="14" viewBox="0 0 10 14"
                                         fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M5 0C2.24609 0 0 2.27981 0 5.07505C0 5.8601 0.316406 6.72048 0.753906 7.62843C1.19141 8.54036 1.76172 9.49193 2.33594 10.3602C3.47656 12.1008 4.61328 13.5163 4.61328 13.5163L5 14L5.38672 13.5163C5.38672 13.5163 6.52344 12.1008 7.66797 10.3602C8.23828 9.49193 8.80859 8.54036 9.24609 7.62843C9.68359 6.72048 10 5.8601 10 5.07505C10 2.27981 7.75391 0 5 0ZM5 1.01514C7.21484 1.01514 9 2.82709 9 5.07518C9 5.55096 8.75391 6.33997 8.34766 7.18449C7.94141 8.03298 7.38672 8.95283 6.83594 9.80132C5.99563 11.0789 5.40082 11.8315 5.08146 12.2356L5 12.3388L4.91854 12.2356C4.59919 11.8315 4.00437 11.0789 3.16406 9.80132C2.61328 8.95283 2.05859 8.03298 1.65234 7.18449C1.24609 6.33997 1 5.55096 1 5.07518C1 2.82709 2.78516 1.01514 5 1.01514ZM4.00002 5.06006C4.00002 4.50928 4.44924 4.06006 5.00002 4.06006C5.5508 4.06006 6.00002 4.50928 6.00002 5.06006C6.00002 5.61084 5.5508 6.06006 5.00002 6.06006C4.44924 6.06006 4.00002 5.61084 4.00002 5.06006Z"
                                              fill="#FDFDFE"/>
                                    </svg>
                                </span>
                            </div>

                            <span class="listivo-listing-card-v3__address-text listivo-listing-card-address-selector">
                                <?php echo esc_html($lstAddress); ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($lstMainValue)) : ?>
                        <div class="listivo-listing-card-v3__value listivo-listing-card-value-selector">
                            <?php echo wp_kses_post($lstMainValue); ?>
                        </div>
                    <?php elseif (!empty(tdf_app('card_main_value_text_when_empty'))) : ?>
                        <div class="listivo-listing-card-v3__value listivo-listing-card-value-selector">
                            <?php echo esc_html(tdf_app('card_main_value_text_when_empty')); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($lstAttributes)) : ?>
                        <div class="listivo-listing-card-v3__attributes">
                            <?php foreach ($lstAttributes as $lstAttribute) : ?>
                                <?php foreach ($lstAttribute['values'] as $value) : ?>
                                    <div class="listivo-listing-card-v3__attribute">
                                        <?php if (isset($lstAttribute['icon']['library']) && $lstAttribute['icon']['library'] === 'svg' && !empty($lstAttribute['icon']['value']['url'])) : ?>
                                            <span class="listivo-listing-card-v3__attribute-icon">
                                                <?php echo tdf_load_icon($lstAttribute['icon']['value']['url']) ?>
                                            </span>
                                        <?php elseif (!empty($lstAttribute['icon']['value'])) : ?>
                                            <span class="listivo-listing-card-v3__attribute-icon">
                                                <i class="<?php echo esc_attr($lstAttribute['icon']['value']); ?>"></i>
                                            </span>
                                        <?php endif; ?>

                                        <?php echo esc_html($value); ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if (tdf_settings()->showUserOnCard() || tdf_settings()->isCompareModelsEnabled() || tdf_settings()->isFavoriteEnabled()): ?>
                    <div class="listivo-listing-card-v3__bottom">
                        <?php
                        if (tdf_settings()->showUserOnCard()) :
                            $lstUser = $lstCurrentListing->getUser();
                            if ($lstUser) : ?>
                                <div class="listivo-listing-card-v3__user listivo-listing-card-user-selector">
                                    <?php
                                    $lstUserImageUrl = $lstUser->getImageUrl('listivo_100_100');
                                    ?>
                                    <div class="listivo-listing-card-v3__avatar">
                                        <?php if (!empty($lstUserImageUrl)) : ?>
                                            <img
                                                    class="lazyload"
                                                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                                                    data-src="<?php echo esc_url($lstUserImageUrl); ?>"
                                                    alt="<?php echo esc_attr($lstUser->getDisplayName()); ?>"
                                            >
                                        <?php else : ?>
                                            <div class="listivo-user-image-placeholder listivo-user-image-placeholder--circle">
                                                <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        width="20"
                                                        height="20"
                                                        viewBox="0 0 132 148"
                                                        fill="none"
                                                >
                                                    <path d="M6 141.5C6 120.789 32.8629 104 66 104C99.1371 104 126 120.789 126 141.5M103.5 44.0001C103.5 64.7108 86.7107 81.5002 66 81.5002C45.2893 81.5002 28.5 64.7108 28.5 44.0001C28.5 23.2894 45.2893 6.5 66 6.5C86.7107 6.5 103.5 23.2894 103.5 44.0001Z"
                                                          stroke="#D5E3EE" stroke-width="12" stroke-linecap="round"
                                                          stroke-linejoin="round"/>
                                                </svg>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <span><?php echo esc_html($lstUser->getDisplayName()); ?></span>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                        <div class="listivo-listing-card-v3__icons">
                            <?php if (tdf_settings()->isCompareModelsEnabled()) : ?>
                                <lst-compare :model-id="<?php echo esc_attr($lstCurrentListing->getId()); ?>">
                                    <div
                                            slot-scope="compare"
                                            class="listivo-listing-card-v3__icon"
                                            :class="{'listivo-listing-card-v3__icon--active': compare.isActive}"
                                            @click.prevent="compare.onClick"
                                    >
                                        <div class="listivo-listing-card-v3__icon-label">
                                            <?php echo esc_html(tdf_string('add_to_compare')); ?>
                                        </div>

                                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17"
                                             viewBox="0 0 17 17"
                                             fill="none">
                                            <g clip-path="url(#clip0_53_5823)">
                                                <path d="M0.169868 8.60556L3.01378 11.4283L5.83649 8.58436L3.56984 8.59284L3.55924 5.75953C3.5557 4.81318 4.30653 4.05672 5.25287 4.05318L11.5924 4.02946C11.8311 4.6848 12.4573 5.15956 13.1904 5.15682C14.1226 5.15333 14.8875 4.38264 14.884 3.45047C14.8805 2.5183 14.1098 1.75335 13.1777 1.75684C12.4446 1.75959 11.822 2.23902 11.5882 2.89613L5.24863 2.91985C3.69032 2.92568 2.42009 4.20546 2.42592 5.76377L2.43652 8.59708L0.169868 8.60556ZM1.32228 13.7013C1.32576 14.6335 2.09646 15.3984 3.02863 15.3949C3.76171 15.3922 4.3843 14.9127 4.61812 14.2556L10.9577 14.2319C12.516 14.2261 13.7862 12.9463 13.7804 11.388L13.7698 8.55468L16.0364 8.54619L13.1925 5.72348L10.3698 8.5674L12.6364 8.55892L12.647 11.3922C12.6506 12.3386 11.8998 13.095 10.9534 13.0986L4.61388 13.1223C4.37515 12.467 3.74898 11.9922 3.0159 11.9949C2.08374 11.9984 1.31879 12.7691 1.32228 13.7013ZM2.4556 13.697C2.45441 13.3774 2.70047 13.1295 3.02014 13.1283C3.33982 13.1271 3.58773 13.3731 3.58893 13.6928C3.59012 14.0125 3.34406 14.2604 3.02439 14.2616C2.70471 14.2628 2.4568 14.0167 2.4556 13.697ZM12.6174 3.45895C12.6162 3.13928 12.8622 2.89136 13.1819 2.89017C13.5016 2.88897 13.7495 3.13504 13.7507 3.45471C13.7519 3.77438 13.5058 4.0223 13.1861 4.02349C12.8665 4.02469 12.6186 3.77862 12.6174 3.45895Z"
                                                      fill="#283948"/>
                                            </g>

                                            <defs>
                                                <clipPath id="clip0_53_5823">
                                                    <rect width="16" height="16" fill="white"
                                                          transform="translate(0.205078 16.2061) rotate(-90.2144)"/>
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </div>
                                </lst-compare>
                            <?php endif; ?>

                            <?php if (tdf_settings()->isFavoriteEnabled()) : ?>
                                <lst-favorite :model-id="<?php echo esc_attr($lstCurrentListing->getId()); ?>">
                                    <div
                                            slot-scope="favorite"
                                            class="listivo-listing-card-v3__icon"
                                            :class="{'listivo-listing-card-v3__icon--active': favorite.isActive}"
                                            @click.prevent="favorite.onClick"
                                    >
                                        <div class="listivo-listing-card-v3__icon-label">
                                            <?php echo esc_html(tdf_string('add_to_favorites')); ?>
                                        </div>

                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15"
                                             viewBox="0 0 16 15"
                                             fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M0 5.12585C0 2.63358 1.97698 0.600098 4.4 0.600098C5.79057 0.600098 7.00127 1.36803 8 2.67253C8.99873 1.36803 10.2094 0.600098 11.6 0.600098C14.023 0.600098 16 2.63358 16 5.12585C16 6.81114 14.7649 8.39793 13.2594 10.0253C12.3953 10.9592 11.4168 11.9 10.4607 12.8192C9.75083 13.5017 9.05333 14.1723 8.42422 14.8194C8.1899 15.0603 7.8101 15.0603 7.57578 14.8194C6.94667 14.1723 6.24917 13.5017 5.5393 12.8192C4.5832 11.9 3.60467 10.9592 2.74062 10.0253C1.23506 8.39793 0 6.81114 0 5.12585ZM7.49292 4.01531C6.54647 2.47557 5.57138 1.8344 4.39995 1.8344C2.62537 1.8344 1.19995 3.30056 1.19995 5.12585C1.19995 6.11487 2.16489 7.61383 3.60933 9.17508C4.43297 10.0653 5.38179 10.9805 6.32832 11.8935C6.89549 12.4405 7.46184 12.9868 7.99995 13.5265C8.53806 12.9868 9.10441 12.4405 9.67159 11.8935C10.6181 10.9805 11.5669 10.0653 12.3906 9.17508C13.835 7.61383 14.8 6.11487 14.8 5.12585C14.8 3.30056 13.3745 1.8344 11.6 1.8344C10.4285 1.8344 9.45343 2.47557 8.50698 4.01531C8.39698 4.19407 8.20563 4.30243 7.99995 4.30243C7.79427 4.30243 7.60292 4.19407 7.49292 4.01531Z"
                                                  fill="#283948"/>
                                        </svg>
                                    </div>
                                </lst-favorite>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </a>
<?php
$lstModelCard = false;
