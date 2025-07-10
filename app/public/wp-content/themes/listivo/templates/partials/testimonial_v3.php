<?php
global $lstTestimonial;
?>
<div class="listivo-testimonial-v3">
    <div class="listivo-testimonial-v3__head">
        <div class="listivo-testimonial-v3__avatar">
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

        <div class="listivo-testimonial-v3__author">
            <div class="listivo-testimonial-v3__name">
                <?php echo esc_html($lstTestimonial['author']); ?>
            </div>

            <?php if (!empty($lstTestimonial['job_title'])) : ?>
                <div class="listivo-testimonial-v3__job-title">
                    <?php echo esc_html($lstTestimonial['job_title']); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="listivo-testimonial-v3__content">
        <div class="listivo-testimonial-v3__icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="16"
                 viewBox="0 0 20 16" fill="none">
                <path d="M13.3333 0C12.1188 0 11.1111 1.00771 11.1111 2.22222V6.66667C11.1111 7.88118 12.1188 8.88889 13.3333 8.88889H16.6775L11.6905 15.5881H14.4618L20 8.1467V5.55773V2.22222C20 1.00771 18.9923 0 17.7778 0H13.3333ZM2.22222 0.0325521C1.00771 0.0325521 0 1.04026 0 2.25477V6.69922C0 7.91373 1.00771 8.92144 2.22222 8.92144H5.56641L0.603299 15.5881H3.3724L8.88889 8.17708V7.81033V5.58811V2.25477C8.88889 1.04026 7.88118 0.0325521 6.66667 0.0325521H2.22222ZM13.3333 2.22222H17.7778V6.66667H13.3333V2.22222ZM2.22222 2.25477H6.66667V5.58811V6.69922H2.22222V2.25477Z"
                      fill="#537CD9"/>
            </svg>
        </div>

        <div class="listivo-testimonial-v3__stars">
            <div class="listivo-testimonial-v3__star">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17"
                     viewBox="0 0 18 17"
                     fill="none">
                    <path d="M9 14.0758L13.1408 16.575C13.7942 16.9692 14.6 16.3833 14.4267 15.6408L13.3275 10.93L16.9867 7.76001C17.5633 7.26084 17.255 6.31334 16.495 6.24918L11.6783 5.84084L9.79417 1.39501C9.49667 0.694176 8.50334 0.694176 8.20584 1.39501L6.32167 5.84084L1.505 6.24918C0.745002 6.31334 0.436669 7.26084 1.01334 7.76001L4.6725 10.93L3.57334 15.6408C3.4 16.3833 4.20584 16.9692 4.85917 16.575L9 14.0758Z"
                          fill="#E9E017"/>
                </svg>
            </div>

            <div class="listivo-testimonial-v3__star">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17"
                     viewBox="0 0 18 17"
                     fill="none">
                    <path d="M9 14.0758L13.1408 16.575C13.7942 16.9692 14.6 16.3833 14.4267 15.6408L13.3275 10.93L16.9867 7.76001C17.5633 7.26084 17.255 6.31334 16.495 6.24918L11.6783 5.84084L9.79417 1.39501C9.49667 0.694176 8.50334 0.694176 8.20584 1.39501L6.32167 5.84084L1.505 6.24918C0.745002 6.31334 0.436669 7.26084 1.01334 7.76001L4.6725 10.93L3.57334 15.6408C3.4 16.3833 4.20584 16.9692 4.85917 16.575L9 14.0758Z"
                          fill="#E9E017"/>
                </svg>
            </div>

            <div class="listivo-testimonial-v3__star">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17"
                     viewBox="0 0 18 17"
                     fill="none">
                    <path d="M9 14.0758L13.1408 16.575C13.7942 16.9692 14.6 16.3833 14.4267 15.6408L13.3275 10.93L16.9867 7.76001C17.5633 7.26084 17.255 6.31334 16.495 6.24918L11.6783 5.84084L9.79417 1.39501C9.49667 0.694176 8.50334 0.694176 8.20584 1.39501L6.32167 5.84084L1.505 6.24918C0.745002 6.31334 0.436669 7.26084 1.01334 7.76001L4.6725 10.93L3.57334 15.6408C3.4 16.3833 4.20584 16.9692 4.85917 16.575L9 14.0758Z"
                          fill="#E9E017"/>
                </svg>
            </div>

            <div class="listivo-testimonial-v3__star">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17"
                     viewBox="0 0 18 17"
                     fill="none">
                    <path d="M9 14.0758L13.1408 16.575C13.7942 16.9692 14.6 16.3833 14.4267 15.6408L13.3275 10.93L16.9867 7.76001C17.5633 7.26084 17.255 6.31334 16.495 6.24918L11.6783 5.84084L9.79417 1.39501C9.49667 0.694176 8.50334 0.694176 8.20584 1.39501L6.32167 5.84084L1.505 6.24918C0.745002 6.31334 0.436669 7.26084 1.01334 7.76001L4.6725 10.93L3.57334 15.6408C3.4 16.3833 4.20584 16.9692 4.85917 16.575L9 14.0758Z"
                          fill="#E9E017"/>
                </svg>
            </div>

            <div class="listivo-testimonial-v3__star">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17"
                     viewBox="0 0 18 17"
                     fill="none">
                    <path d="M9 14.0758L13.1408 16.575C13.7942 16.9692 14.6 16.3833 14.4267 15.6408L13.3275 10.93L16.9867 7.76001C17.5633 7.26084 17.255 6.31334 16.495 6.24918L11.6783 5.84084L9.79417 1.39501C9.49667 0.694176 8.50334 0.694176 8.20584 1.39501L6.32167 5.84084L1.505 6.24918C0.745002 6.31334 0.436669 7.26084 1.01334 7.76001L4.6725 10.93L3.57334 15.6408C3.4 16.3833 4.20584 16.9692 4.85917 16.575L9 14.0758Z"
                          fill="#E9E017"/>
                </svg>
            </div>
        </div>

        <div class="listivo-testimonial-v3__text">
            <?php echo nl2br(wp_kses_post($lstTestimonial['text'])); ?>
        </div>
    </div>
</div>