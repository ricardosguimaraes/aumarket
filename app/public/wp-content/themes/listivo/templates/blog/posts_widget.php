<?php
/* @var array $args */
?>
<section class="widget listivo-widget-posts">
    <h3 class="listivo-widget-title"><?php echo esc_html($args['title']); ?></h3>
    <?php

    global $post;
    foreach ($args['posts'] as $post) : setup_postdata($post); ?>
        <div class="listivo-widget-posts__row">
            <div class="listivo-widget-posts__image">
                <a
                        href="<?php echo esc_url(get_the_permalink()); ?>"
                        title="<?php the_title_attribute(); ?>"
                >
                    <img
                            src="<?php echo esc_url(apply_filters('listivo/wp/widgets/posts/image', get_the_post_thumbnail_url(null,'thumbnail'), get_the_ID())); ?>"
                            alt="<?php the_title_attribute(); ?>"
                    >
                </a>
            </div>

            <div>
                <a
                        href="<?php echo esc_url(get_the_permalink()); ?>"
                        title="<?php the_title_attribute(); ?>"
                        class="listivo-widget-posts__title"
                >
                    <?php the_title(); ?>
                </a>

                <div class="listivo-widget-posts__date">
                    <?php echo esc_html(get_the_date()); ?>
                </div>
            </div>
        </div>
    <?php
    endforeach;
    wp_reset_postdata();
    ?>
</section>
