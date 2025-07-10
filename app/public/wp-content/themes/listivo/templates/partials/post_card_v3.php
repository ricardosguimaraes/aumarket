<?php
/* @var \Tangibledesign\Framework\Models\BlogPost $lstCurrentBlogPost */
/* @var \Tangibledesign\Listivo\Widgets\General\BlogPostsV1Widget $lstCurrentWidget */
global $lstCurrentBlogPost, $lstCurrentWidget;
$lstBlogPostImage = $lstCurrentBlogPost->getImage();
?>
<div class="listivo-blog-card-v3">
    <a
            class="listivo-blog-card-v3__image"
            href="<?php echo esc_url($lstCurrentBlogPost->getUrl()); ?>"
    >
        <?php if ($lstBlogPostImage) : ?>
            <img
                    class="lazyload"
                    data-src="<?php echo esc_url($lstBlogPostImage->getImageUrl('large')); ?>"
                    alt="<?php echo esc_attr($lstCurrentBlogPost->getName()); ?>"
            >
        <?php endif; ?>
    </a>

    <?php if ($lstCurrentWidget->showCategories() && $lstCurrentBlogPost->hasCategories()) : ?>
        <div class="listivo-blog-card-v3__categories">
            <?php foreach ($lstCurrentBlogPost->getCategories() as $lstIndex => $lstCategory) :
                if (!empty($lstIndex)) { ?>, <?php }
                ?>
                <div class="listivo-blog-card-v3__category">
                    <?php echo esc_html($lstCategory->getName()); ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <h3 class="listivo-blog-card-v3__label">
        <a href="<?php echo esc_url($lstCurrentBlogPost->getUrl()); ?>">
            <?php echo esc_html($lstCurrentBlogPost->getName()); ?>
        </a>
    </h3>

    <div class="listivo-blog-card-v3__metas">
        <?php
        $lstUser = $lstCurrentBlogPost->getUser();

        if ($lstUser && $lstCurrentWidget->showUser()) :
            ?>
            <a
                    href="<?php echo esc_url($lstUser->getUrl()); ?>"
                    class="listivo-blog-card-v3__meta"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>

                <?php echo esc_html($lstUser->getDisplayName()); ?>
            </a>
        <?php endif; ?>

        <?php if ($lstCurrentWidget->showPublishDate()) : ?>
            <div class="listivo-blog-card-v3__meta">
                <?php echo esc_html($lstCurrentBlogPost->getPublishDate()); ?>
            </div>
        <?php endif; ?>
    </div>
</div>