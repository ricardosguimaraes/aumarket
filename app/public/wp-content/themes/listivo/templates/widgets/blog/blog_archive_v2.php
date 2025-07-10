<?php

use Tangibledesign\Listivo\Widgets\BlogArchive\BlogArchiveV2Widget;

/* @var BlogArchiveV2Widget $lstCurrentWidget */
global $lstCurrentWidget;
$lstPosts = $lstCurrentWidget->getPosts();
?>
<div class="listivo-blog-archive-v2">
    <div
        <?php if ($lstCurrentWidget->isFirstPostFeatured()) : ?>
            class="listivo-blog-archive-v2__grid listivo-blog-archive-v2__grid--first-featured"
        <?php else : ?>
            class="listivo-blog-archive-v2__grid"
        <?php endif; ?>
    >
        <?php
        global $lstCurrentPost;
        foreach ($lstPosts as $lstIndex => $lstCurrentPost) :
            if ($lstIndex || !$lstCurrentWidget->isFirstPostFeatured()) :
                get_template_part('templates/partials/post_card_v5');
            else :
                get_template_part('templates/partials/post_card_v4');
            endif;
        endforeach;
        ?>
    </div>

    <?php
    global $lstPagination;
    $lstPagination = $lstCurrentWidget->getPaginator();
    if ($lstPagination) :
        if (count($lstPagination->getPages())) : ?>
            <div class="listivo-blog-archive-v2__pagination">
                <?php get_template_part('templates/partials/pagination'); ?>
            </div>
        <?php
        endif;

        $lstPagination = $lstCurrentWidget->getPaginator(3);
        if (count($lstPagination->getPages())) : ?>
            <div class="listivo-blog-archive-v2__mobile-pagination">
                <?php get_template_part('templates/partials/pagination'); ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
