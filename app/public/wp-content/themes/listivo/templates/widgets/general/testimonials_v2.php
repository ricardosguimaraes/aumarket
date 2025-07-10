<?php

use Tangibledesign\Listivo\Widgets\General\TestimonialsV2Widget;

/* @var TestimonialsV2Widget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-app">
    <lst-testimonials-v2 prefix="listivo">
        <div slot-scope="props" class="listivo-testimonials-v2">
            <div class="listivo-testimonials-v2__content">
                <div class="listivo-testimonials-v2__heading">
                    <div class="listivo-heading-v2 listivo-heading-v2--left">
                        <?php if (!empty($lstCurrentWidget->getSmallHeading())) : ?>
                            <h3 class="listivo-heading-v2__small-text">
                                <?php echo esc_html($lstCurrentWidget->getSmallHeading()); ?>
                            </h3>
                        <?php endif; ?>

                        <h2 class="listivo-heading-v2__text">
                            <?php echo nl2br(wp_kses_post($lstCurrentWidget->getHeading())); ?>
                        </h2>
                    </div>
                </div>

                <?php if (!empty($lstCurrentWidget->getText())) : ?>
                    <div class="listivo-testimonials-v2__text">
                        <?php echo nl2br(wp_kses_post($lstCurrentWidget->getText())); ?>
                    </div>
                <?php endif; ?>

                <div class="listivo-testimonials-v2__navigation listivo-box-arrows">
                    <div
                            @click.prevent="props.prevSlide"
                            class="listivo-box-arrow"
                            :class="{'listivo-box-arrow--disabled': props.swiper.isBeginning}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                             fill="none">
                            <path d="M4.86195 10.4713C4.99228 10.6017 5.16262 10.6667 5.33329 10.6667C5.50395 10.6667 5.67429 10.6017 5.80462 10.4713C6.06496 10.211 6.06496 9.78898 5.80462 9.52865L2.27593 5.99996H11.3333C11.7013 5.99996 12 5.70129 12 5.33329C12 4.96528 11.7013 4.66662 11.3333 4.66662H2.27593L5.80462 1.13792C6.06496 0.877589 6.06496 0.455586 5.80462 0.195251C5.54429 -0.0650838 5.12229 -0.0650838 4.86195 0.195251L0.195251 4.86195C-0.0650838 5.12229 -0.0650838 5.54429 0.195251 5.80462L4.86195 10.4713Z"/>
                        </svg>
                    </div>

                    <div
                            @click.prevent="props.nextSlide"
                            class="listivo-box-arrow"
                            :class="{'listivo-box-arrow--disabled': props.swiper.isEnd}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                             fill="none">
                            <path d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49604 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455587 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="listivo-testimonials-v2__list">
                <div class="listivo-swiper-container">
                    <div class="listivo-swiper-wrapper">
                        <?php foreach ($lstCurrentWidget->getTestimonials() as $lstTestimonial): ?>
                            <div class="listivo-swiper-slide">
                                <div class="listivo-testimonial-v2">
                                    <div class="listivo-testimonial-v2__content">
                                        <h3 class="listivo-testimonial-v2__heading">
                                            <?php echo esc_html($lstTestimonial['heading']); ?>
                                        </h3>

                                        <div class="listivo-testimonial-v2__stars">
                                            <div class="listivo-testimonial-v2__star">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17"
                                                     viewBox="0 0 18 17"
                                                     fill="none">
                                                    <path d="M9 14.0758L13.1408 16.575C13.7942 16.9692 14.6 16.3833 14.4267 15.6408L13.3275 10.93L16.9867 7.76001C17.5633 7.26084 17.255 6.31334 16.495 6.24918L11.6783 5.84084L9.79417 1.39501C9.49667 0.694176 8.50334 0.694176 8.20584 1.39501L6.32167 5.84084L1.505 6.24918C0.745002 6.31334 0.436669 7.26084 1.01334 7.76001L4.6725 10.93L3.57334 15.6408C3.4 16.3833 4.20584 16.9692 4.85917 16.575L9 14.0758Z"
                                                          fill="#E9E017"/>
                                                </svg>
                                            </div>

                                            <div class="listivo-testimonial-v2__star">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17"
                                                     viewBox="0 0 18 17"
                                                     fill="none">
                                                    <path d="M9 14.0758L13.1408 16.575C13.7942 16.9692 14.6 16.3833 14.4267 15.6408L13.3275 10.93L16.9867 7.76001C17.5633 7.26084 17.255 6.31334 16.495 6.24918L11.6783 5.84084L9.79417 1.39501C9.49667 0.694176 8.50334 0.694176 8.20584 1.39501L6.32167 5.84084L1.505 6.24918C0.745002 6.31334 0.436669 7.26084 1.01334 7.76001L4.6725 10.93L3.57334 15.6408C3.4 16.3833 4.20584 16.9692 4.85917 16.575L9 14.0758Z"
                                                          fill="#E9E017"/>
                                                </svg>
                                            </div>

                                            <div class="listivo-testimonial-v2__star">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17"
                                                     viewBox="0 0 18 17"
                                                     fill="none">
                                                    <path d="M9 14.0758L13.1408 16.575C13.7942 16.9692 14.6 16.3833 14.4267 15.6408L13.3275 10.93L16.9867 7.76001C17.5633 7.26084 17.255 6.31334 16.495 6.24918L11.6783 5.84084L9.79417 1.39501C9.49667 0.694176 8.50334 0.694176 8.20584 1.39501L6.32167 5.84084L1.505 6.24918C0.745002 6.31334 0.436669 7.26084 1.01334 7.76001L4.6725 10.93L3.57334 15.6408C3.4 16.3833 4.20584 16.9692 4.85917 16.575L9 14.0758Z"
                                                          fill="#E9E017"/>
                                                </svg>
                                            </div>

                                            <div class="listivo-testimonial-v2__star">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17"
                                                     viewBox="0 0 18 17"
                                                     fill="none">
                                                    <path d="M9 14.0758L13.1408 16.575C13.7942 16.9692 14.6 16.3833 14.4267 15.6408L13.3275 10.93L16.9867 7.76001C17.5633 7.26084 17.255 6.31334 16.495 6.24918L11.6783 5.84084L9.79417 1.39501C9.49667 0.694176 8.50334 0.694176 8.20584 1.39501L6.32167 5.84084L1.505 6.24918C0.745002 6.31334 0.436669 7.26084 1.01334 7.76001L4.6725 10.93L3.57334 15.6408C3.4 16.3833 4.20584 16.9692 4.85917 16.575L9 14.0758Z"
                                                          fill="#E9E017"/>
                                                </svg>
                                            </div>

                                            <div class="listivo-testimonial-v2__star">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17"
                                                     viewBox="0 0 18 17"
                                                     fill="none">
                                                    <path d="M9 14.0758L13.1408 16.575C13.7942 16.9692 14.6 16.3833 14.4267 15.6408L13.3275 10.93L16.9867 7.76001C17.5633 7.26084 17.255 6.31334 16.495 6.24918L11.6783 5.84084L9.79417 1.39501C9.49667 0.694176 8.50334 0.694176 8.20584 1.39501L6.32167 5.84084L1.505 6.24918C0.745002 6.31334 0.436669 7.26084 1.01334 7.76001L4.6725 10.93L3.57334 15.6408C3.4 16.3833 4.20584 16.9692 4.85917 16.575L9 14.0758Z"
                                                          fill="#E9E017"/>
                                                </svg>
                                            </div>
                                        </div>

                                        <div class="listivo-testimonial-v2__text">
                                            <?php echo nl2br(wp_kses_post($lstTestimonial['text'])); ?>
                                        </div>
                                    </div>

                                    <div class="listivo-testimonial-v2__bottom">
                                        <div class="listivo-testimonial-v2__icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="16"
                                                 viewBox="0 0 20 16" fill="none">
                                                <path d="M13.3333 0C12.1188 0 11.1111 1.00771 11.1111 2.22222V6.66667C11.1111 7.88118 12.1188 8.88889 13.3333 8.88889H16.6775L11.6905 15.5881H14.4618L20 8.1467V5.55773V2.22222C20 1.00771 18.9923 0 17.7778 0H13.3333ZM2.22222 0.0325521C1.00771 0.0325521 0 1.04026 0 2.25477V6.69922C0 7.91373 1.00771 8.92144 2.22222 8.92144H5.56641L0.603299 15.5881H3.3724L8.88889 8.17708V7.81033V5.58811V2.25477C8.88889 1.04026 7.88118 0.0325521 6.66667 0.0325521H2.22222ZM13.3333 2.22222H17.7778V6.66667H13.3333V2.22222ZM2.22222 2.25477H6.66667V5.58811V6.69922H2.22222V2.25477Z"
                                                      fill="#537CD9"/>
                                            </svg>
                                        </div>

                                        <div class="listivo-testimonial-v2__avatar">
                                            <?php if (!empty($lstTestimonial['avatar']['id'])) : ?>
                                                <img
                                                        class="lazyload"
                                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                                                        data-src="<?php echo esc_url(wp_get_attachment_image_url($lstTestimonial['avatar']['id'], 'listivo_100_100')); ?>"
                                                        alt="<?php echo esc_attr($lstTestimonial['author']); ?>"
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

                                        <div class="listivo-testimonial-v2__author">
                                            <div class="listivo-testimonial-v2__name">
                                                <?php echo esc_html($lstTestimonial['author']); ?>
                                            </div>

                                            <?php if (!empty($lstTestimonial['job_title'])) : ?>
                                                <div class="listivo-testimonial-v2__job-title">
                                                    <?php echo esc_html($lstTestimonial['job_title']); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="listivo-testimonials-v2__mobile-navigation listivo-box-arrows">
                <div
                        @click.prevent="props.prevSlide"
                        class="listivo-box-arrow"
                        :class="{'listivo-box-arrow--disabled': props.swiper.isBeginning}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                         fill="none">
                        <path d="M4.86195 10.4713C4.99228 10.6017 5.16262 10.6667 5.33329 10.6667C5.50395 10.6667 5.67429 10.6017 5.80462 10.4713C6.06496 10.211 6.06496 9.78898 5.80462 9.52865L2.27593 5.99996H11.3333C11.7013 5.99996 12 5.70129 12 5.33329C12 4.96528 11.7013 4.66662 11.3333 4.66662H2.27593L5.80462 1.13792C6.06496 0.877589 6.06496 0.455586 5.80462 0.195251C5.54429 -0.0650838 5.12229 -0.0650838 4.86195 0.195251L0.195251 4.86195C-0.0650838 5.12229 -0.0650838 5.54429 0.195251 5.80462L4.86195 10.4713Z"/>
                    </svg>
                </div>

                <div
                        @click.prevent="props.nextSlide"
                        class="listivo-box-arrow"
                        :class="{'listivo-box-arrow--disabled': props.swiper.isEnd}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                         fill="none">
                        <path d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49604 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455587 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z"/>
                    </svg>
                </div>
            </div>
        </div>
    </lst-testimonials-v2>
</div>