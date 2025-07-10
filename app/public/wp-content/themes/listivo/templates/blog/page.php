<?php
if (
    !class_exists(\Tangibledesign\Framework\Core\App::class)
    || !class_exists(\Elementor\Plugin::class)
    || !tdf_app('current_template')
) :
    get_template_part('templates/blog/header');
endif;
?>
    <div class="listivo-wrapper">
        <?php while (have_posts()):the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h1 class="listivo-blog-title"><?php the_title(); ?></h1>

                <div class="listivo-layout">
                    <div class="listivo-layout__content listivo-layout__content--no-sidebar">
                        <div class="listivo-post">
                            <div class="listivo-post-inner">
                                <?php the_content(); ?>
                            </div>

                            <?php wp_link_pages(); ?>
                        </div>

                        <?php if (comments_open() || get_comments_number()) : ?>
                            <?php comments_template(); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </article>
        <?php endwhile; ?>
    </div>

<?php
get_template_part('templates/blog/footer');