<?php if (is_search()) : ?>
    <h1 class="listivo-blog-title-widget">
        <?php echo tdf_string('search') . ': ' . get_query_var('s'); ?>
    </h1>
<?php else : ?>
    <h1 class="listivo-blog-title-widget">
        <?php the_archive_title(); ?>
    </h1>
<?php endif; ?>