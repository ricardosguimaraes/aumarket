<?php

use Tangibledesign\Listivo\Widgets\General\DynamicTitleWidget;

/* @var DynamicTitleWidget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<h1 class="listivo-dynamic-title">
    <?php if (is_search()) : ?>
        <?php echo tdf_string('search') . ': ' . esc_html(get_query_var('s')); ?>
    <?php elseif (is_single()) : ?>
        <?php the_title() ?>
    <?php else : ?>
        <?php the_archive_title(); ?>
    <?php endif; ?>
</h1>
