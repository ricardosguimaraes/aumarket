<?php
/* @var \Tangibledesign\Framework\Widgets\BlogPost\RelatedBlogPostsWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstRelatedBlogPosts = $lstCurrentWidget->getRelatedBlogPosts();
if ($lstRelatedBlogPosts->isEmpty()) {
    return;
}
?>
<div class="listivo-related-blog-posts">
    <h3 class="listivo-related-blog-posts__label">
        <?php echo esc_html(tdf_string('related_posts')); ?>
    </h3>

    <div class="listivo-related-blog-posts__list">
        <?php
        global $lstBlogPost;
        foreach ($lstRelatedBlogPosts as $lstBlogPost) : ?>
            <?php get_template_part('templates/partials/post_card'); ?>
        <?php endforeach; ?>
    </div>
</div>
