<?php
/* @var \Tangibledesign\Listivo\Widgets\General\TestimonialsWidget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-app">
    <lst-testimonials
            prefix="listivo"
            :config="<?php echo htmlspecialchars(json_encode($lstCurrentWidget->getSwiperConfig())); ?>"
            pagination-selector=".listivo-swiper-pagination"
    >
        <div slot-scope="props">
            <div class="listivo-testimonials">
                <div class="listivo-testimonials__inner">
                    <div class="listivo-swiper-container">
                        <div class="listivo-swiper-wrapper">
                            <?php foreach ($lstCurrentWidget->getTestimonials() as $lstTestimonial) : ?>
                                <div class="listivo-swiper-slide">
                                    <div class="listivo-testimonial">
                                        <div class="listivo-testimonial__top">
                                            <div class="listivo-testimonial__image">
                                                <?php if (!empty($lstTestimonial['image'])) : ?>
                                                    <img
                                                            class="lazyload"
                                                            data-src="<?php echo esc_url($lstTestimonial['image']->getImageUrl('listivo_100_100')); ?>"
                                                            alt="<?php echo esc_attr($lstTestimonial['name']); ?>"
                                                    >
                                                <?php endif; ?>
                                            </div>

                                            <div class="listivo-testimonial__top-content">
                                                <span class="listivo-testimonial__top-content__name">
                                                    <?php echo esc_html($lstTestimonial['name']); ?>
                                                </span>

                                                <?php if (!empty($lstTestimonial['job_title'])) : ?>
                                                    <span class="listivo-testimonial__top-content__title">
                                                        <?php echo esc_html($lstTestimonial['job_title']); ?>
                                                    </span>
                                                <?php endif; ?>

                                                <div class=listivo-testimonial__stars>
                                                    <div class="listivo-testimonial__star">
                                                        <i class="fas fa-star"></i>
                                                    </div>

                                                    <div class="listivo-testimonial__star">
                                                        <i class="fas fa-star"></i>
                                                    </div>

                                                    <div class="listivo-testimonial__star">
                                                        <i class="fas fa-star"></i>
                                                    </div>

                                                    <div class="listivo-testimonial__star">
                                                        <i class="fas fa-star"></i>
                                                    </div>

                                                    <div class="listivo-testimonial__star">
                                                        <i class="fas fa-star"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="listivo-testimonial__icon">
                                                <i class="fas fa-quote-right"></i>
                                            </div>
                                        </div>

                                        <div class="listivo-testimonial__bottom">
                                            <p class="listivo-testimonial__text">
                                                <?php echo wp_kses_post($lstTestimonial['text']); ?>
                                            </p>

                                            <?php if (!empty($lstTestimonial['via'])) : ?>
                                                <?php if (empty($lstTestimonial['via_url'])) : ?>
                                                    <div
                                                        <?php if (!empty($lstTestimonial['via_icon'])) : ?>
                                                            class="listivo-testimonial__via listivo-testimonial__via--with-icon"
                                                        <?php else : ?>
                                                            class="listivo-testimonial__via"
                                                        <?php endif; ?>
                                                    >
                                                        <?php echo esc_html($lstTestimonial['via']); ?>

                                                        <?php if (!empty($lstTestimonial['via_icon'])) : ?>
                                                            <div class="listivo-testimonial__via-icon">
                                                                <i class="<?php echo esc_attr($lstTestimonial['via_icon']); ?>"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php else : ?>
                                                    <a
                                                            href="<?php echo esc_url($lstTestimonial['via_url']); ?>"
                                                            target="_blank"
                                                        <?php if (!empty($lstTestimonial['via_icon'])) : ?>
                                                            class="listivo-testimonial__via listivo-testimonial__via--with-icon"
                                                        <?php else : ?>
                                                            class="listivo-testimonial__via"
                                                        <?php endif; ?>
                                                    >
                                                        <?php echo esc_html($lstTestimonial['via']); ?>

                                                        <?php if (!empty($lstTestimonial['via_icon'])) : ?>
                                                            <div class="listivo-testimonial__via-icon">
                                                                <i class="<?php echo esc_attr($lstTestimonial['via_icon']); ?>"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="listivo-swiper-pagination"></div>
                    </div>

                    <div class="listivo-testimonials__arrows">
                        <button
                                class="listivo-arrow listivo-testimonials__arrow-prev"
                                type="button"
                                @click.prevent="props.prev"
                        >
                            <i class="fas fa-chevron-left"></i>
                        </button>

                        <button
                                class="listivo-arrow listivo-testimonials__arrow-next"
                                type="button"
                                @click.prevent="props.next"
                        >
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div
        </div>
    </lst-testimonials>
</div>