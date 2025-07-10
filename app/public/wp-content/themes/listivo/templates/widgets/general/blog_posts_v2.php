<?php

use Tangibledesign\Framework\Models\BlogPost;
use Tangibledesign\Listivo\Widgets\General\BlogPostsV2Widget;

/* @var BlogPostsV2Widget $lstCurrentWidget */
global $lstCurrentWidget;
$lstPosts = $lstCurrentWidget->getPosts();
$lstMainPost = $lstPosts->first();
$lstList = $lstPosts->slice(1, 3);
$lstListPlaceholderCount = 3 - $lstList->count();
?>
<div class="listivo-blog-posts-v2">
    <div class="listivo-blog-posts-v2__top">
        <div class="listivo-blog-posts-v2__heading">
            <div class="listivo-heading-v2 listivo-heading-v2--left listivo-heading-v2--tablet-center">
                <?php if ($lstCurrentWidget->hasSmallHeading())  : ?>
                    <h3 class="listivo-heading-v2__small-text">
                        <?php echo esc_html($lstCurrentWidget->getSmallHeading()); ?>
                    </h3>
                <?php endif; ?>

                <h2 class="listivo-heading-v2__text">
                    <?php echo esc_html($lstCurrentWidget->getHeading()); ?>
                </h2>
            </div>
        </div>

        <div class="listivo-blog-posts-v2__button">
            <a
                    class="listivo-button listivo-button--primary-1"
                    href="<?php echo esc_url(get_post_type_archive_link('post')); ?>"
            >
                <span>
                    <?php echo esc_html(tdf_string('view_all')); ?>

                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11" fill="none">
                        <path d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49605 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455586 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z"
                              fill="#FDFDFE"/>
                    </svg>
                </span>
            </a>
        </div>
    </div>

    <div class="listivo-blog-posts-v2__list">
        <?php
        global $lstCurrentPost;
        $lstCurrentPost = $lstMainPost;
        get_template_part('templates/partials/post_card_v4');
        ?>

        <?php foreach ($lstList as $lstCurrentPost) :/* @var BlogPost $lstCurrentPost */ ?>
            <a
                    href="<?php echo esc_url($lstCurrentPost->getUrl()); ?>"
                    class="listivo-blog-post-mini-card"
            >
                <div class="listivo-blog-post-mini-card__image">
                    <?php
                    $lstPostImage = $lstCurrentPost->getImage();
                    if ($lstPostImage) :?>
                        <img
                                class="lazyload"
                                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                                data-src="<?php echo esc_url($lstCurrentPost->getImageUrl('listivo_360_240')); ?>"
                                alt="<?php echo esc_attr($lstCurrentPost->getName()); ?>"
                        >
                    <?php endif; ?>
                </div>

                <div class="listivo-blog-post-mini-card__content">
                    <div class="listivo-blog-post-mini-card__heading-wrapper">
                        <h3 class="listivo-blog-post-mini-card__heading listivo-blog-post-card-heading-selector">
                            <?php echo esc_html($lstCurrentPost->getName()); ?>
                        </h3>
                    </div>

                    <div class="listivo-blog-post-mini-card__meta">
                        <?php
                        $lstPostUser = $lstCurrentPost->getUser();
                        if ($lstPostUser) :?>
                            <div class="listivo-blog-post-mini-card__meta-value listivo-blog-post-card-meta-selector">
                                <?php if ($lstPostUser->hasImageUrl('listivo_100_100')) : ?>
                                    <div class="listivo-blog-post-mini-card__avatar">
                                        <img
                                                class="lazyload"
                                                data-src="<?php echo esc_url($lstPostUser->getImageUrl('listivo_100_100')); ?>"
                                                alt="<?php echo esc_attr($lstPostUser->getDisplayName()); ?>"
                                        >
                                    </div>
                                <?php endif; ?>

                                <?php echo esc_html($lstPostUser->getDisplayName()); ?>
                            </div>
                        <?php endif; ?>

                        <div class="listivo-blog-post-mini-card__meta-value">
                            <div class="listivo-blog-post-mini-card__icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="12" viewBox="0 0 10 12"
                                     fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M1.66667 0V1.11111H1.11111C0.5 1.11111 0 1.61111 0 2.22222V10C0 10.6111 0.5 11.1111 1.11111 11.1111H8.88889C9.5 11.1111 10 10.6111 10 10V2.22222C10 1.61111 9.5 1.11111 8.88889 1.11111H8.33333V0H7.22222V1.11111H2.77778V0H1.66667ZM1.11111 2.22222H1.66667H2.77778H7.22222H8.33333H8.88889V3.33333H1.11111V2.22222ZM8.88886 4.44434H1.11108V9.99989H8.88886V4.44434Z"
                                          fill="#FDFDFE"/>
                                </svg>
                            </div>

                            <?php echo esc_html($lstCurrentPost->getPublishDate()); ?>
                        </div>
                    </div>

                    <div class="listivo-blog-post-mini-card__text-wrapper">
                        <div class="listivo-blog-post-mini-card__text listivo-blog-post-card-text-selector">
                            <?php echo wp_kses_post($lstCurrentPost->getExcerpt()); ?>
                        </div>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>

        <?php for ($i = 0; $i < $lstListPlaceholderCount; $i++) : ?>
            <div></div>
        <?php endfor; ?>
    </div>

    <div class="listivo-blog-posts-v2__mobile-button">
        <a
                class="listivo-button listivo-button--primary-1"
                href="<?php echo esc_url(get_post_type_archive_link('post')); ?>"
        >
            <span>
                <?php echo esc_html(tdf_string('view_all')); ?>

                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11" fill="none">
                    <path d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49605 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455586 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z"
                          fill="#FDFDFE"/>
                </svg>
            </span>
        </a>
    </div>
</div>
