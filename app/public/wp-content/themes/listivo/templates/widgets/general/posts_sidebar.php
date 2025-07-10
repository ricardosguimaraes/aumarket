<?php

use Tangibledesign\Listivo\Widgets\General\PostsSidebarWidget;

/* @var PostsSidebarWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstPosts = $lstCurrentWidget->getPosts();
if ($lstPosts->isEmpty()) {
    return;
}
?>
<div class="listivo-sidebar-widget">
    <h3 class="listivo-sidebar-widget__label">
        <?php echo esc_html($lstCurrentWidget->getLabel()); ?>
    </h3>

    <div class="listivo-sidebar-widget__content">
        <div class="listivo-sidebar-posts">
            <?php
            global $post;
            foreach ($lstPosts as $lstPost) :
                $post = $lstPost->getPost();
                setup_postdata($post); ?>
                <div class="listivo-sidebar-posts__item">
                    <a
                            class="listivo-sidebar-posts__image"
                            href="<?php echo esc_url(get_the_permalink()); ?>"
                            title="<?php the_title_attribute(); ?>"
                    >
                        <img
                                class="lazyload"
                                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                                data-src="<?php echo esc_url(apply_filters('listivo/wp/widgets/posts/image', get_the_post_thumbnail_url(null, 'listivo_360_240'), get_the_ID())); ?>"
                                alt="<?php the_title_attribute(); ?>"
                        >
                    </a>

                    <div class="listivo-sidebar-posts__content">
                        <a
                                class="listivo-sidebar-posts__label"
                                href="<?php echo esc_url(get_the_permalink()); ?>"
                                title="<?php the_title_attribute(); ?>"
                        >
                            <?php the_title(); ?>
                        </a>

                        <?php if (!$lstCurrentWidget->hidePublishDate()) : ?>
                            <div class="listivo-sidebar-posts__date">
                                <div class="listivo-sidebar-posts__icon">
                                    <span class="listivo-small-icon listivo-small-icon--circle listivo-small-icon--primary-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="12"
                                             viewBox="0 0 10 12"
                                             fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M1.66667 0V1.11111H1.11111C0.5 1.11111 0 1.61111 0 2.22222V10C0 10.6111 0.5 11.1111 1.11111 11.1111H8.88889C9.5 11.1111 10 10.6111 10 10V2.22222C10 1.61111 9.5 1.11111 8.88889 1.11111H8.33333V0H7.22222V1.11111H2.77778V0H1.66667ZM1.11133 2.22217H1.66688H2.77799H7.22244H8.33355H8.88911V3.33328H1.11133V2.22217ZM8.88911 4.44434H1.11133V9.99989H8.88911V4.44434Z"
                                                  fill="#FDFDFE"/>
                                        </svg>
                                    </span>
                                </div>

                                <?php echo esc_html(get_the_date()); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php
            endforeach;
            wp_reset_postdata();
            ?>
        </div>
    </div>
</div>