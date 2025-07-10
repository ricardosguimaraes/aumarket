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
        <div class="listivo-layout <?php if (!is_active_sidebar('listivo-sidebar')) : ?> listivo-layout--no-sidebar<?php endif; ?>">
            <?php while (have_posts()) :the_post(); ?>
                <div class="listivo-layout__content">
                    <article class="listivo-post">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="listivo-post-image">
                                <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title_attribute(); ?>">
                            </div>
                        <?php endif; ?>

                        <div class="listivo-post-meta">
                            <div class="listivo-post-meta__single listivo-post-meta__single--user">
                                <div class="listivo-post-author">
                                    <a
                                            class="listivo-post-author-image"
                                            href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"
                                            title="<?php echo esc_attr(get_the_author()); ?>"
                                    >
                                        <img
                                                src="<?php echo esc_url(get_avatar_url(get_the_ID())); ?>"
                                                alt="<?php echo esc_attr(get_the_author()); ?>"
                                        >
                                    </a>

                                    <div>
                                        <?php the_author_posts_link(); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="listivo-post-meta__single listivo-post-meta__single--date">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 63 72">
                                    <path class="cls-1"
                                          d="M326.5,907v-7.312A1.491,1.491,0,0,0,324.812,898h-1.124A1.491,1.491,0,0,0,322,899.688V907H295v-7.312A1.491,1.491,0,0,0,293.312,898h-1.124a1.491,1.491,0,0,0-1.688,1.688V907h-6.75a6.723,6.723,0,0,0-6.75,6.75v49.5a6.723,6.723,0,0,0,6.75,6.75h49.5a6.723,6.723,0,0,0,6.75-6.75v-49.5a6.723,6.723,0,0,0-6.75-6.75H326.5Zm6.75,4.5a2.167,2.167,0,0,1,2.25,2.25v6.75h-54v-6.75a2.167,2.167,0,0,1,2.25-2.25h49.5Zm-49.5,54a2.167,2.167,0,0,1-2.25-2.25V925h54v38.25a2.167,2.167,0,0,1-2.25,2.25h-49.5Zm15.75-24.188v-5.624A1.491,1.491,0,0,0,297.812,934h-5.624a1.491,1.491,0,0,0-1.688,1.688v5.624A1.491,1.491,0,0,0,292.188,943h5.624a1.491,1.491,0,0,0,1.688-1.688h0Zm13.5,0v-5.624A1.491,1.491,0,0,0,311.312,934h-5.624A1.491,1.491,0,0,0,304,935.688v5.624A1.491,1.491,0,0,0,305.688,943h5.624A1.491,1.491,0,0,0,313,941.312h0Zm13.5,0v-5.624A1.491,1.491,0,0,0,324.812,934h-5.624a1.491,1.491,0,0,0-1.688,1.688v5.624A1.491,1.491,0,0,0,319.188,943h5.624a1.491,1.491,0,0,0,1.688-1.688h0Zm-13.5,13.5v-5.624a1.491,1.491,0,0,0-1.688-1.688h-5.624A1.491,1.491,0,0,0,304,949.188v5.624a1.491,1.491,0,0,0,1.688,1.688h5.624A1.491,1.491,0,0,0,313,954.812h0Zm-13.5,0v-5.624a1.491,1.491,0,0,0-1.688-1.688h-5.624a1.491,1.491,0,0,0-1.688,1.688v5.624a1.491,1.491,0,0,0,1.688,1.688h5.624a1.491,1.491,0,0,0,1.688-1.688h0Zm27,0v-5.624a1.491,1.491,0,0,0-1.688-1.688h-5.624a1.491,1.491,0,0,0-1.688,1.688v5.624a1.491,1.491,0,0,0,1.688,1.688h5.624a1.491,1.491,0,0,0,1.688-1.688h0Z"
                                          transform="translate(-277 -898)"/>
                                </svg>
                                <span><?php echo esc_html(get_the_date()); ?></span>
                            </div>

                            <div class="listivo-post-meta__single  listivo-post-meta__single--comments">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72.031 63">
                                    <path class="cls-1"
                                          d="M264.641,835.75q0,10.266-9.211,17.508T233.141,860.5a37.505,37.505,0,0,1-11.672-1.828l-2.11-.7-1.828,1.406a30,30,0,0,1-14.484,5.484,36.72,36.72,0,0,0,5.765-9.7l0.985-2.672-1.969-2.109a20.611,20.611,0,0,1-6.187-14.625q0-10.263,9.211-17.508T233.141,811q13.077,0,22.289,7.242T264.641,835.75Zm-67.5,0q0,9.844,7.453,17.719a31.278,31.278,0,0,1-2.6,5.133,30.017,30.017,0,0,1-2.672,3.8q-1.055,1.2-1.336,1.477a3.151,3.151,0,0,0-.562,3.586,3.082,3.082,0,0,0,3.094,2.039,33.235,33.235,0,0,0,19.546-6.469A44.635,44.635,0,0,0,233.141,865q14.9,0,25.453-8.578t10.547-20.672q0-12.093-10.547-20.672T233.141,806.5q-14.908,0-25.453,8.578T197.141,835.75h0Z"
                                          transform="translate(-197.125 -806.5)"/>
                                </svg>

                                <span><?php comments_number(); ?></span>
                            </div>

                            <div class="listivo-post-meta__single listivo-post-meta__single--categories">
                                <i class="far fa-folder-open"></i>

                                <span><?php the_category(', '); ?></span>
                            </div>
                        </div>

                        <h1 class="listivo-post-title">
                            <?php the_title(); ?>
                        </h1>

                        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <div class="listivo-post-content">
                                <div class="listivo-post-inner">
                                    <?php the_content(); ?>
                                </div>

                                <?php the_posts_navigation(); ?>

                                <?php wp_link_pages(); ?>

                                <div class="listivo-post-content-end">
                                    <?php if (has_tag()) : ?>
                                        <div class="listivo-post-tags">
                                            <div class="listivo-post-tags__inner">
                                                <?php the_tags('', ' '); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!is_page() && class_exists(\Tangibledesign\Framework\Core\App::class)) : ?>
                                        <div class="listivo-post-social-share">
                                            <div class="listivo-social-share">
                                                <a
                                                        href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url(get_the_permalink()); ?>"
                                                        target="_blank"
                                                        class="listivo-social-share__single"
                                                >
                                                    <i class="fab fa-facebook-f"></i>
                                                </a>

                                                <a
                                                        href="https://twitter.com/share?url=<?php echo esc_url(get_the_permalink()); ?>"
                                                        target="_blank"
                                                        class="listivo-social-share__single"
                                                >
                                                    <i class="fab fa-twitter"></i>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </article>

                    <?php comments_template(); ?>
                </div>
            <?php endwhile; ?>

            <?php if (is_active_sidebar('listivo-sidebar')) : ?>
                <div class="listivo-layout__sidebar">
                    <?php dynamic_sidebar('listivo-sidebar'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php get_template_part('templates/blog/footer');