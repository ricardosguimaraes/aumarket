<?php

use Tangibledesign\Framework\Models\BlogPost;

/*  @var BlogPost $lstCurrentPost */
global $lstCurrentPost;
if (!$lstCurrentPost instanceof BlogPost) {
    return;
}
?>
<a
        class="listivo-blog-post-card-v4"
        href="<?php echo esc_url($lstCurrentPost->getUrl()); ?>"
>
    <div class="listivo-blog-post-card-v4__image">
        <?php
        $lstImage = $lstCurrentPost->getImage();
        if ($lstImage) :
            ?>
            <img
                    class="lazyload"
                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                    data-src="<?php echo esc_url($lstImage->getImageUrl('listivo_750_500')); ?>"
                    alt="<?php echo esc_attr($lstCurrentPost->getName()); ?>"
            >
        <?php endif; ?>
    </div>

    <div class="listivo-blog-post-card-v4__content">
        <h3 class="listivo-blog-post-card-v4__heading listivo-blog-post-card-heading-selector">
            <?php echo esc_html($lstCurrentPost->getName()); ?>
        </h3>

        <?php if (!tdf_app('blog_card_hide_user') || !tdf_app('blog_card_hide_publish_date')) : ?>
            <div class="listivo-blog-post-card-v4__meta">
                <?php
                $lstPostUser = $lstCurrentPost->getUser();
                if ($lstPostUser && !tdf_app('blog_card_hide_user')) :?>
                    <div class="listivo-blog-post-card-v4__meta-value listivo-blog-post-card-meta-selector">
                        <?php if ($lstPostUser->hasImageUrl('listivo_100_100')) : ?>
                            <div class="listivo-blog-post-card-v4__avatar">
                                <img
                                        class="lazyload"
                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                                        data-src="<?php echo esc_url($lstPostUser->getImageUrl('listivo_100_100')); ?>"
                                        alt="<?php echo esc_attr($lstPostUser->getDisplayName()); ?>"
                                >
                            </div>
                        <?php endif; ?>

                        <?php echo esc_html($lstPostUser->getDisplayName()); ?>
                    </div>
                <?php endif; ?>

                <?php if (!tdf_app('blog_card_hide_publish_date')) : ?>
                    <div class="listivo-blog-post-card-v4__meta-value">
                        <div class="listivo-blog-post-card-v4__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="12" viewBox="0 0 10 12"
                                 fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M1.66667 0V1.11111H1.11111C0.5 1.11111 0 1.61111 0 2.22222V10C0 10.6111 0.5 11.1111 1.11111 11.1111H8.88889C9.5 11.1111 10 10.6111 10 10V2.22222C10 1.61111 9.5 1.11111 8.88889 1.11111H8.33333V0H7.22222V1.11111H2.77778V0H1.66667ZM1.11111 2.22222H1.66667H2.77778H7.22222H8.33333H8.88889V3.33333H1.11111V2.22222ZM8.88886 4.44434H1.11108V9.99989H8.88886V4.44434Z"
                                      fill="#FDFDFE"/>
                            </svg>
                        </div>

                        <?php echo esc_html($lstCurrentPost->getPublishDate()); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="listivo-blog-post-card-v4__text listivo-blog-post-card-text-selector">
            <?php echo wp_kses_post($lstCurrentPost->getExcerpt()); ?>
        </div>
    </div>
</a>
