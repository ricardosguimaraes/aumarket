<?php
if (
    !class_exists(\Tangibledesign\Framework\Core\App::class)
    || !class_exists(\Elementor\Plugin::class)
    || !tdf_app('current_template')
) :
    get_template_part('templates/blog/header');
endif;

if (!is_front_page()) : ?>
    <?php if (is_search()) : ?>
        <h1 class="listivo-blog-title">
            <?php echo sprintf(esc_html__('Search: %s', 'listivo'), get_query_var('s')); ?>
        </h1>
    <?php else : ?>
        <h1 class="listivo-blog-title">
            <?php the_archive_title(); ?>
        </h1>
    <?php endif; ?>
<?php endif; ?>

    <div class="listivo-wrapper">
        <div class="listivo-layout <?php if (!is_active_sidebar('listivo-sidebar')) : ?> listivo-layout--no-sidebar<?php endif; ?>">

            <div class="listivo-layout__content">
                <?php if (have_posts()) : ?>
                    <div class="listivo-posts listivo-grid listivo-posts--archive">
                        <?php while (have_posts()) :the_post(); ?>
                            <div class="listivo-blog-card-wrapper">
                                <article <?php post_class('listivo-blog-card'); ?>>
                                    <?php if (has_post_thumbnail()) : ?>
                                        <a
                                                href="<?php echo esc_url(get_the_permalink()); ?>"
                                                title="<?php the_title_attribute(); ?>"
                                                class="listivo-blog-card__image-static"
                                        >
                                            <img
                                                    src="<?php the_post_thumbnail_url('large'); ?>"
                                                    alt="<?php the_title_attribute(); ?>"
                                            >
                                        </a>
                                    <?php endif; ?>

                                    <div class="listivo-blog-card__content">
                                        <?php if (!empty(get_the_title())) : ?>
                                            <h3 class="listivo-blog-card__title">
                                                <a
                                                        href="<?php echo esc_url(get_the_permalink()); ?>"
                                                        title="<?php the_title_attribute() ?>"
                                                >
                                                    <?php the_title(); ?>
                                                </a>
                                            </h3>
                                        <?php endif; ?>

                                        <div class="listivo-blog-card__meta listivo-blog-card__meta--top">
                                            <div class="listivo-blog-card__author">
                                                <a
                                                        href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"
                                                        title="<?php echo esc_attr(get_the_author()); ?>"
                                                        class="listivo-blog-card__author-avatar-link"
                                                >
                                                    <img
                                                            src="<?php echo esc_url(get_avatar_url(get_the_ID())); ?>"
                                                            alt="<?php echo esc_attr(get_the_author()); ?>"
                                                    >
                                                </a>

                                                <?php the_author_posts_link(); ?>
                                            </div>

                                            <div class="listivo-blog-card__date">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 63 72">
                                                    <path class="cls-1"
                                                          d="M326.5,907v-7.312A1.491,1.491,0,0,0,324.812,898h-1.124A1.491,1.491,0,0,0,322,899.688V907H295v-7.312A1.491,1.491,0,0,0,293.312,898h-1.124a1.491,1.491,0,0,0-1.688,1.688V907h-6.75a6.723,6.723,0,0,0-6.75,6.75v49.5a6.723,6.723,0,0,0,6.75,6.75h49.5a6.723,6.723,0,0,0,6.75-6.75v-49.5a6.723,6.723,0,0,0-6.75-6.75H326.5Zm6.75,4.5a2.167,2.167,0,0,1,2.25,2.25v6.75h-54v-6.75a2.167,2.167,0,0,1,2.25-2.25h49.5Zm-49.5,54a2.167,2.167,0,0,1-2.25-2.25V925h54v38.25a2.167,2.167,0,0,1-2.25,2.25h-49.5Zm15.75-24.188v-5.624A1.491,1.491,0,0,0,297.812,934h-5.624a1.491,1.491,0,0,0-1.688,1.688v5.624A1.491,1.491,0,0,0,292.188,943h5.624a1.491,1.491,0,0,0,1.688-1.688h0Zm13.5,0v-5.624A1.491,1.491,0,0,0,311.312,934h-5.624A1.491,1.491,0,0,0,304,935.688v5.624A1.491,1.491,0,0,0,305.688,943h5.624A1.491,1.491,0,0,0,313,941.312h0Zm13.5,0v-5.624A1.491,1.491,0,0,0,324.812,934h-5.624a1.491,1.491,0,0,0-1.688,1.688v5.624A1.491,1.491,0,0,0,319.188,943h5.624a1.491,1.491,0,0,0,1.688-1.688h0Zm-13.5,13.5v-5.624a1.491,1.491,0,0,0-1.688-1.688h-5.624A1.491,1.491,0,0,0,304,949.188v5.624a1.491,1.491,0,0,0,1.688,1.688h5.624A1.491,1.491,0,0,0,313,954.812h0Zm-13.5,0v-5.624a1.491,1.491,0,0,0-1.688-1.688h-5.624a1.491,1.491,0,0,0-1.688,1.688v5.624a1.491,1.491,0,0,0,1.688,1.688h5.624a1.491,1.491,0,0,0,1.688-1.688h0Zm27,0v-5.624a1.491,1.491,0,0,0-1.688-1.688h-5.624a1.491,1.491,0,0,0-1.688,1.688v5.624a1.491,1.491,0,0,0,1.688,1.688h5.624a1.491,1.491,0,0,0,1.688-1.688h0Z"
                                                          transform="translate(-277 -898)"/>
                                                </svg>

                                                <span>
                                                    <?php echo esc_html(get_the_date()); ?>
                                                </span>
                                            </div>
                                        </div>

                                        <?php if (!empty(get_the_excerpt())) : ?>
                                            <div class="listivo-blog-card__excerpt">
                                                <?php the_excerpt(); ?>
                                            </div>
                                        <?php endif; ?>

                                        <div class="listivo-blog-card__bottom">
                                            <div class="listivo-blog-card__meta listivo-blog-card__meta--bottom">
                                                <div class="listivo-blog-card__author">
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

                                                    <?php the_author_posts_link(); ?>
                                                </div>

                                                <span class="listivo-blog-card__dot"></span>

                                                <div class="listivo-blog-card__date">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 63 72">
                                                        <path class="cls-1"
                                                              d="M326.5,907v-7.312A1.491,1.491,0,0,0,324.812,898h-1.124A1.491,1.491,0,0,0,322,899.688V907H295v-7.312A1.491,1.491,0,0,0,293.312,898h-1.124a1.491,1.491,0,0,0-1.688,1.688V907h-6.75a6.723,6.723,0,0,0-6.75,6.75v49.5a6.723,6.723,0,0,0,6.75,6.75h49.5a6.723,6.723,0,0,0,6.75-6.75v-49.5a6.723,6.723,0,0,0-6.75-6.75H326.5Zm6.75,4.5a2.167,2.167,0,0,1,2.25,2.25v6.75h-54v-6.75a2.167,2.167,0,0,1,2.25-2.25h49.5Zm-49.5,54a2.167,2.167,0,0,1-2.25-2.25V925h54v38.25a2.167,2.167,0,0,1-2.25,2.25h-49.5Zm15.75-24.188v-5.624A1.491,1.491,0,0,0,297.812,934h-5.624a1.491,1.491,0,0,0-1.688,1.688v5.624A1.491,1.491,0,0,0,292.188,943h5.624a1.491,1.491,0,0,0,1.688-1.688h0Zm13.5,0v-5.624A1.491,1.491,0,0,0,311.312,934h-5.624A1.491,1.491,0,0,0,304,935.688v5.624A1.491,1.491,0,0,0,305.688,943h5.624A1.491,1.491,0,0,0,313,941.312h0Zm13.5,0v-5.624A1.491,1.491,0,0,0,324.812,934h-5.624a1.491,1.491,0,0,0-1.688,1.688v5.624A1.491,1.491,0,0,0,319.188,943h5.624a1.491,1.491,0,0,0,1.688-1.688h0Zm-13.5,13.5v-5.624a1.491,1.491,0,0,0-1.688-1.688h-5.624A1.491,1.491,0,0,0,304,949.188v5.624a1.491,1.491,0,0,0,1.688,1.688h5.624A1.491,1.491,0,0,0,313,954.812h0Zm-13.5,0v-5.624a1.491,1.491,0,0,0-1.688-1.688h-5.624a1.491,1.491,0,0,0-1.688,1.688v5.624a1.491,1.491,0,0,0,1.688,1.688h5.624a1.491,1.491,0,0,0,1.688-1.688h0Zm27,0v-5.624a1.491,1.491,0,0,0-1.688-1.688h-5.624a1.491,1.491,0,0,0-1.688,1.688v5.624a1.491,1.491,0,0,0,1.688,1.688h5.624a1.491,1.491,0,0,0,1.688-1.688h0Z"
                                                              transform="translate(-277 -898)"/>
                                                    </svg>

                                                    <span>
                                                        <?php echo esc_html(get_the_date()); ?>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="listivo-blog-card__bottom-button">
                                                <a
                                                        class="listivo-button-outline listivo-button-outline--v3"
                                                        href="<?php echo esc_url(get_the_permalink()); ?>"
                                                        title="<?php the_title_attribute(); ?>"
                                                >
                                                    <?php esc_html_e('Read More', 'listivo'); ?>

                                                    <span class="listivo-button-outline__icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="11"
                                                             viewBox="0 0 9 14">
                                                            <g>
                                                                <g>
                                                                    <path d="M8.32 6.57L2.023.245c-.284-.327-.587-.327-.907 0L.742.627c-.284.29-.284.6 0 .927l5.443 5.452-5.443 5.452c-.32.327-.32.637 0 .927l.374.381c.32.328.623.328.907 0L8.32 7.442c.285-.29.285-.58 0-.872z"/>
                                                                </g>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        <?php endwhile; ?>
                    </div>

                    <?php
                    global $wp_query;

                    if ($wp_query->max_num_pages > 1) :
                        $listivoCurrentPage = (get_query_var('paged')) ? get_query_var('paged') : 1;
                        ?>
                        <div class="listivo-pagination listivo-pagination--blog">
                            <div class="listivo-pagination-mobile">
                                <a
                                        href="<?php echo esc_url(get_pagenum_link($listivoCurrentPage - 1)); ?>"
                                    <?php if ($listivoCurrentPage > 1) : ?>
                                        class="listivo-pagination-mobile__arrow listivo-pagination-mobile__arrow--left"
                                    <?php else : ?>
                                        class="listivo-pagination___mobile__arrow listivo-pagination-mobile__arrow--disabled listivo-pagination-mobile__arrow--left"
                                    <?php endif; ?>
                                >
                                    <i class="fa fa-chevron-left"></i>
                                </a>

                                <span class="listivo-pagination-mobile__start"><?php echo esc_html($listivoCurrentPage); ?></span>

                                <span class="listivo-pagination-mobile__middle">/</span>

                                <span class="listivo-pagination-mobile__end"><?php echo esc_html($wp_query->max_num_pages); ?></span>

                                <a
                                        href="<?php echo esc_url(get_pagenum_link($listivoCurrentPage + 1)); ?>"
                                    <?php if ($listivoCurrentPage < $wp_query->max_num_pages) : ?>
                                        class="listivo-pagination-mobile__arrow listivo-pagination-mobile__arrow--right"
                                    <?php else : ?>
                                        class="listivo-pagination-mobile__arrow listivo-pagination-mobile__arrow--disabled listivo-pagination-mobile__arrow--right"
                                    <?php endif; ?>
                                >
                                    <i class="fa fa-chevron-right"></i>
                                </a>
                            </div>

                            <div class="listivo-pagination-desktop">
                                <div class="listivo-pagination-desktop__inner">
                                    <?php if ($listivoCurrentPage > 1) : ?>
                                        <a href="<?php echo esc_url(get_pagenum_link($listivoCurrentPage - 1)); ?>">
                                            <span class="listivo-pagination-desktop__arrow listivo-pagination-desktop__arrow--left">
                                                <i class="fa fa-chevron-left"></i>
                                            </span>
                                        </a>
                                    <?php endif; ?>

                                    <?php
                                    $lstDots = false;
                                    $lstEndsCount = 1;
                                    $lstMidCount = 3;

                                    for ($i = 1; $i <= $wp_query->max_num_pages; $i++) :
                                        if ($i === $listivoCurrentPage) : ?>
                                        <a
                                                class="listivo-pagination-desktop__page listivo-pagination-desktop__page--active"
                                                href="<?php echo esc_url(get_pagenum_link($i)); ?>"
                                        >
                                            <?php echo esc_html($i); ?>
                                            </a><?php
                                            $lstDots = true;
                                        else :
                                            if ($i <= $lstEndsCount || ($listivoCurrentPage && $i >= $listivoCurrentPage - $lstMidCount && $i <= $listivoCurrentPage + $lstMidCount) || $i > $wp_query->max_num_pages - $lstEndsCount) : ?>
                                                <a
                                                        class="listivo-pagination-desktop__page"
                                                        href="<?php echo esc_url(get_pagenum_link($i)); ?>"
                                                >
                                                    <?php echo esc_html($i); ?>
                                                </a>
                                                <?php
                                                $lstDots = true;
                                            elseif ($lstDots) :?>
                                                <div class="listivo-pagination-desktop__page listivo-pagination-desktop__page--dots">...</div><?php
                                                $lstDots = false;
                                            endif;
                                        endif;
                                        ?>
                                    <?php endfor; ?>

                                    <?php if ($listivoCurrentPage < $wp_query->max_num_pages) : ?>
                                        <a href="<?php echo esc_url(get_pagenum_link($listivoCurrentPage + 1)); ?>">
                                            <span class="listivo-pagination-desktop__arrow listivo-pagination-desktop__arrow--right">
                                                <i class="fa fa-chevron-right"></i>
                                            </span>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php else : ?>
                    <div class="listivo-blog-search-no-results">
                        <h3><?php esc_html_e("Couldn't find what you're looking for!", 'listivo'); ?></h3>

                        <h4><?php esc_html_e('If you want to rephrase your query, here is your chance:', 'listivo'); ?></h4>

                        <?php get_search_form(); ?>
                    </div>
                <?php
                endif; ?>
            </div>

            <?php if (is_active_sidebar('listivo-sidebar')) : ?>
                <div class="listivo-layout__sidebar">
                    <?php dynamic_sidebar('listivo-sidebar'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php
get_template_part('templates/blog/footer'); ?>