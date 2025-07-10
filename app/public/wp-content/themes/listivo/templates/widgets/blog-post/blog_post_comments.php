<?php
/* @var \Tangibledesign\Framework\Widgets\BlogPost\BlogPostCommentsWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstBlogPost = $lstCurrentWidget->getBlogPost();
if (!$lstBlogPost) {
    return;
}

global $post;
$post = $lstBlogPost->getPost();
setup_postdata($post);

comments_template();

wp_reset_postdata();