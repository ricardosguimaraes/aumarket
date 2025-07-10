<?php

use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Listivo\Widgets\Helpers\Presentation\AdQuickPreview;

/* @var Model $lstCurrentListing , */
global $lstCurrentListing;

$lstModelPreview = new AdQuickPreview($lstCurrentListing);
$lstMainValue = $lstModelPreview->getMainValue();
$lstAddress = $lstCurrentListing->getAddress();
$lstCategories = $lstModelPreview->getCategories();
$lstAttributes = $lstModelPreview->getAttributes();
$lstImageSize = tdf_app('listing_card_image_size');
$lstImages = $lstCurrentListing->getImages(tdf_app('card_max_number_of_images'));
?>
<div class="listivo-app listivo-quick-view-wrapper">
    <div class="listivo-quick-view-wrapper__container">
        <div class="listivo-quick-view" @click.stop>
            <button class="listivo-quick-view__close">
                <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" viewBox="0 0 8 8" fill="none">
                    <path d="M0.889354 0.000385399C0.713166 0.000603672 0.541042 0.0533645 0.394971 0.151928C0.248899 0.250491 0.135512 0.390383 0.0692934 0.553731C0.00307477 0.71708 -0.0129688 0.89647 0.0232121 1.06899C0.059393 1.2415 0.146156 1.39931 0.272417 1.52225L2.74709 3.9981L0.272417 6.47394C0.187381 6.55563 0.119491 6.65346 0.0727219 6.76173C0.0259528 6.86999 0.00124506 6.9865 4.58543e-05 7.10443C-0.00115335 7.22237 0.0211801 7.33935 0.0657381 7.44855C0.110296 7.55774 0.176183 7.65694 0.25954 7.74033C0.342897 7.82373 0.442049 7.88965 0.551188 7.93423C0.660327 7.97881 0.77726 8.00115 0.895139 7.99995C1.01302 7.99875 1.12947 7.97403 1.23768 7.92724C1.34589 7.88045 1.44368 7.81252 1.52533 7.72745L4 5.2516L6.47467 7.72745C6.55631 7.81253 6.6541 7.88045 6.76231 7.92724C6.87052 7.97403 6.98698 7.99875 7.10486 7.99995C7.22274 8.00115 7.33967 7.97881 7.44881 7.93423C7.55795 7.88965 7.6571 7.82373 7.74046 7.74034C7.82382 7.65694 7.88971 7.55774 7.93426 7.44855C7.97882 7.33936 8.00115 7.22237 7.99995 7.10443C7.99875 6.9865 7.97405 6.86999 7.92728 6.76173C7.88051 6.65346 7.81261 6.55563 7.72758 6.47394L5.25291 3.9981L7.72758 1.52225C7.85561 1.39774 7.94306 1.23743 7.97847 1.06234C8.01387 0.887245 7.99558 0.705535 7.92599 0.541021C7.8564 0.376508 7.73876 0.236865 7.58848 0.140392C7.4382 0.0439203 7.26229 -0.00488048 7.08382 0.000385399C6.85363 0.00724757 6.63515 0.103498 6.47467 0.268746L4 2.74459L1.52533 0.268746C1.44266 0.183724 1.34377 0.116165 1.23453 0.0700682C1.12529 0.023972 1.00791 0.000276521 0.889354 0.000385399Z"
                          fill="#FDFDFE"/>
                </svg>
            </button>

            <div class="listivo-quick-view__gallery">
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
                                <div class="listivo-quick-view__pagination">
                                    <div class="listivo-swiper-pagination"></div>
                                </div>

                                <div
                                        class="listivo-quick-view__prev-holder"
                                        @click.stop.prevent
                                ></div>

                                <div
                                        class="listivo-quick-view__next-holder"
                                        @click.stop.prevent
                                ></div>

                                <div
                                        @click.prevent="gallery.prevSlide"
                                        class="listivo-quick-view__prev"
                                        :class="{'listivo-quick-view__prev--active': !gallery.swiper.isBeginning}"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14" viewBox="0 0 16 14"
                                         fill="none">
                                        <path d="M15.509 7.19858C15.5064 7.03297 15.4382 6.87515 15.3193 6.75979C15.2004 6.64443 15.0406 6.58097 14.875 6.58335L2.63379 6.58335L7.40023 1.81691C7.46021 1.75932 7.5081 1.69034 7.54109 1.61401C7.57408 1.53768 7.59151 1.45553 7.59235 1.37238C7.5932 1.28923 7.57745 1.20675 7.54602 1.12977C7.51458 1.05278 7.46811 0.982842 7.40931 0.924043C7.35051 0.865245 7.28057 0.818769 7.20359 0.787338C7.1266 0.755907 7.04412 0.740154 6.96097 0.740999C6.87782 0.741844 6.79568 0.759272 6.71935 0.792261C6.64301 0.825251 6.57403 0.873139 6.51644 0.933121L0.68311 6.76646C0.565944 6.88367 0.500125 7.04262 0.500125 7.20835C0.500125 7.37408 0.565944 7.53303 0.68311 7.65024L6.51644 13.4836C6.57403 13.5436 6.64301 13.5914 6.71935 13.6244C6.79568 13.6574 6.87782 13.6749 6.96097 13.6757C7.04412 13.6765 7.1266 13.6608 7.20359 13.6294C7.28057 13.5979 7.35051 13.5515 7.40931 13.4927C7.46811 13.4339 7.51458 13.3639 7.54601 13.2869C7.57745 13.2099 7.5932 13.1275 7.59235 13.0443C7.59151 12.9612 7.57408 12.879 7.54109 12.8027C7.5081 12.7264 7.46021 12.6574 7.40023 12.5998L2.63379 7.83335L14.875 7.83335C14.9587 7.83455 15.0417 7.81894 15.1192 7.78746C15.1967 7.75597 15.2671 7.70925 15.3262 7.65005C15.3854 7.59086 15.432 7.5204 15.4634 7.44285C15.4948 7.3653 15.5103 7.28223 15.509 7.19858Z"
                                              fill="#2A3946"/>
                                    </svg>
                                </div>

                                <div
                                        @click.prevent="gallery.nextSlide"
                                        class="listivo-quick-view__next"
                                        :class="{'listivo-quick-view__next--active': !gallery.swiper.isEnd}"
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
            </div>

            <div class="listivo-quick-view__content">
                <div class="listivo-quick-view__body">
                    <div class="listivo-quick-view__top">
                        <div class="listivo-quick-view__meta">
                            <div class="listivo-quick-view__meta-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
                                     fill="none">
                                    <path d="M6 0C2.6934 0 0 2.6934 0 6C0 9.3066 2.6934 12 6 12C9.3066 12 12 9.3066 12 6C12 2.6934 9.3066 0 6 0ZM6 1.2C8.65807 1.2 10.8 3.34193 10.8 6C10.8 8.65807 8.65807 10.8 6 10.8C3.34193 10.8 1.2 8.65807 1.2 6C1.2 3.34193 3.34193 1.2 6 1.2ZM5.4 2.4V6.24844L7.97578 8.82422L8.82422 7.97578L6.6 5.75156V2.4H5.4Z"
                                          fill="#374B5C"/>
                                </svg>
                            </div>

                            <?php echo esc_html($lstCurrentListing->getPublishDateDiff()); ?>
                        </div>

                        <div class="listivo-quick-view__meta">
                            <div class="listivo-quick-view__meta-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="9" viewBox="0 0 12 9"
                                     fill="none">
                                    <path d="M6 0C1.63636 0 0 4.36364 0 4.36364C0 4.36364 1.63636 8.72727 6 8.72727C10.3636 8.72727 12 4.36364 12 4.36364C12 4.36364 10.3636 0 6 0ZM6 1.09091C8.87782 1.09091 10.3334 3.41841 10.8047 4.36151C10.3329 5.29805 8.86636 7.63636 6 7.63636C3.12218 7.63636 1.66659 5.30886 1.19531 4.36577C1.66768 3.42922 3.13364 1.09091 6 1.09091ZM6 2.18182C4.79509 2.18182 3.81818 3.15873 3.81818 4.36364C3.81818 5.56854 4.79509 6.54545 6 6.54545C7.20491 6.54545 8.18182 5.56854 8.18182 4.36364C8.18182 3.15873 7.20491 2.18182 6 2.18182ZM6 3.27273C6.60273 3.27273 7.09091 3.76091 7.09091 4.36364C7.09091 4.96636 6.60273 5.45455 6 5.45455C5.39727 5.45455 4.90909 4.96636 4.90909 4.36364C4.90909 3.76091 5.39727 3.27273 6 3.27273Z"
                                          fill="#374B5C"/>
                                </svg>
                            </div>

                            <?php echo sprintf(esc_html('%s %s'), $lstCurrentListing->getViews(), tdf_string('views')); ?>
                        </div>
                    </div>

                    <a
                            class="listivo-quick-view__heading"
                            href="<?php echo esc_url($lstCurrentListing->getUrl()); ?>"
                    >
                        <?php echo esc_html($lstCurrentListing->getName()) ?>
                    </a>

                    <?php if (!empty($lstCategories)) : ?>
                        <div class="listivo-quick-view__categories">
                            <?php foreach ($lstCategories as $lstCategory) : ?>
                                <div class="listivo-quick-view__category">
                                    <?php echo esc_html($lstCategory); ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($lstAddress)) : ?>
                        <div class="listivo-quick-view__address">
                            <div class="listivo-quick-view__address-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="14" viewBox="0 0 10 14"
                                     fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M5 0C2.24609 0 0 2.27981 0 5.07505C0 5.8601 0.316406 6.72048 0.753906 7.62843C1.19141 8.54036 1.76172 9.49193 2.33594 10.3602C3.4729 12.0952 4.60597 13.5072 4.61325 13.5162C4.61347 13.5165 4.61339 13.5164 4.61362 13.5167C4.81166 13.7644 5.18835 13.7644 5.38638 13.5167C5.38661 13.5164 5.38653 13.5165 5.38675 13.5162C5.39402 13.5072 6.52712 12.0952 7.66797 10.3602C8.23828 9.49193 8.80859 8.54036 9.24609 7.62843C9.68359 6.72048 10 5.8601 10 5.07505C10 2.27981 7.75391 0 5 0ZM5 1.01514C7.21484 1.01514 9 2.82709 9 5.07518C9 5.55096 8.75391 6.33997 8.34766 7.18449C7.94141 8.03298 7.38672 8.95283 6.83594 9.80132C5.99563 11.0789 5.40082 11.8315 5.08146 12.2356C5.03992 12.2882 4.96008 12.2883 4.91854 12.2356C4.59919 11.8315 4.00437 11.0789 3.16406 9.80132C2.61328 8.95283 2.05859 8.03298 1.65234 7.18449C1.24609 6.33997 1 5.55096 1 5.07518C1 2.82709 2.78516 1.01514 5 1.01514ZM4.00002 5.06006C4.00002 4.50928 4.44924 4.06006 5.00002 4.06006C5.5508 4.06006 6.00002 4.50928 6.00002 5.06006C6.00002 5.61084 5.5508 6.06006 5.00002 6.06006C4.44924 6.06006 4.00002 5.61084 4.00002 5.06006Z"
                                          fill="#374B5C"/>
                                </svg>
                            </div>

                            <?php echo esc_html($lstAddress); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($lstMainValue)) : ?>
                        <div class="listivo-quick-view__price">
                            <?php echo esc_html($lstMainValue); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($lstAttributes)) : ?>
                        <div class="listivo-quick-view__attributes">
                            <?php foreach ($lstAttributes as $lstAttribute) : ?>
                                <div class="listivo-quick-view__attribute">
                                    <?php if (isset($lstAttribute['icon']['library']) && $lstAttribute['icon']['library'] === 'svg' && !empty($lstAttribute['icon']['value']['url'])) : ?>
                                        <span class="listivo-quick-view__attribute-icon">
                                            <?php echo tdf_load_icon($lstAttribute['icon']['value']['url']); ?>
                                        </span>
                                    <?php elseif (!empty($lstAttribute['icon']['value'])) : ?>
                                        <span class="listivo-quick-view__attribute-icon">
                                            <i class="<?php echo esc_attr($lstAttribute['icon']['value']); ?>"></i>
                                        </span>
                                    <?php endif; ?>

                                    <?php echo esc_html($lstAttribute['value']); ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="listivo-quick-view__bottom">
                    <a
                            class="listivo-button listivo-button--primary-1"
                            href="<?php echo esc_url($lstCurrentListing->getUrl()); ?>"
                    >
                        <span>
                            <?php echo esc_html(tdf_string('view_more')); ?>

                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                 fill="none">
                                <path d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49605 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455586 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z"
                                      fill="#FDFDFE"/>
                            </svg>
                        </span>
                    </a>

                    <div class="listivo-quick-view__icons">
                        <?php if (tdf_settings()->isCompareModelsEnabled()) : ?>
                            <lst-compare :model-id="<?php echo esc_attr($lstCurrentListing->getId()); ?>">
                                <div
                                        slot-scope="compare"
                                        class="listivo-quick-view__icon listivo-quick-view__icon--primary-1"
                                        :class="{'listivo-quick-view__icon--active': compare.isActive}"
                                        @click.prevent="compare.onClick"
                                >
                                    <div class="listivo-quick-view__icon-label">
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
                                        class="listivo-quick-view__icon listivo-quick-view__icon--primary-2"
                                        :class="{'listivo-quick-view__icon--active': favorite.isActive}"
                                        @click.prevent="favorite.onClick"
                                >
                                    <div class="listivo-quick-view__icon-label">
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
            </div>
        </div>
    </div>
</div>