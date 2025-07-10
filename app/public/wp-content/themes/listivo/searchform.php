<form
        class="listivo-blog-search"
        method="get"
        action="<?php echo esc_url(home_url()); ?>"
        role="search"
>
    <?php if (class_exists(\Tangibledesign\Framework\Core\App::class)) : ?>
        <span class="screen-reader-text">
            <?php echo esc_html(tdf_string('search_for')); ?>
        </span>
    <?php else : ?>
        <span class="screen-reader-text">
            <?php esc_html_e('Search for:', 'listivo'); ?>
        </span>
    <?php endif; ?>

    <input
            class="listivo-field"
            type="search"
            value="<?php the_search_query(); ?>"
            name="s"
        <?php if (class_exists(\Tangibledesign\Framework\Core\App::class)) : ?>
            placeholder="<?php echo esc_attr(tdf_string('search_dots')); ?>"
        <?php else : ?>
            placeholder="<?php esc_attr_e('Search …', 'listivo'); ?>"
        <?php endif; ?>
    >

    <button class="listivo-blog-search__button-search">
        <svg
                xmlns="http://www.w3.org/2000/svg"
                width="17"
                height="18"
                viewBox="0 0 17 18"
        >
            <g>
                <g>
                    <path fill="#fff"
                          d="M7.636-.004c4.227 0 7.666 3.639 7.666 8.112a8.409 8.409 0 0 1-1.178 4.316l2.346 2.483a1.876 1.876 0 0 1 0 2.549 1.638 1.638 0 0 1-2.41 0l-2.345-2.482a7.322 7.322 0 0 1-4.08 1.247c-4.227 0-7.666-3.64-7.666-8.113 0-4.473 3.439-8.112 7.667-8.112zm0 14.422c3.288 0 5.963-2.83 5.963-6.31 0-3.478-2.675-6.31-5.963-6.31-3.289 0-5.964 2.832-5.964 6.31 0 3.48 2.675 6.31 5.964 6.31z"/>
                </g>
            </g>
        </svg>
    </button>
</form>