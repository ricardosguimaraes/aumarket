<?php
/* @var \Tangibledesign\Framework\Models\BlogPost $lstBlogPost */
/* @var \Tangibledesign\Listivo\Widgets\Helpers\Controls\BlogPostCard $lstCurrentWidget */
global $lstBlogPost, $lstCurrentWidget;
$lstBlogPostAuthor = $lstBlogPost->getUser();
$lstBlogPostImage = $lstBlogPost->getImage();
$lstImageSrcset = $lstBlogPostImage ? $lstBlogPostImage->getSrcset('large') : '';
?>
<div class="listivo-blog-card-v2">
    <a
            class="listivo-blog-card-v2__image"
            href="<?php echo esc_url($lstBlogPost->getUrl()); ?>"
    >
        <?php if ($lstBlogPostImage) : ?>
            <img
                    class="lazyload"
                    alt="<?php echo esc_attr($lstBlogPost->getName()); ?>"
                <?php if (!empty($lstImageSrcset))  : ?>
                    data-srcset="<?php echo esc_attr($lstImageSrcset); ?>"
                    data-sizes="auto"
                <?php else : ?>
                    data-src="<?php echo esc_url($lstBlogPostImage->getUrl()); ?>"
                <?php endif; ?>
            >
        <?php endif; ?>
    </a>

    <div class="listivo-blog-card-v2__content">
        <div class="listivo-blog-card-v2__top">
            <div class="listivo-blog-card-v2__head">
                <a
                        class="listivo-blog-card-v2__label"
                        href="<?php echo esc_url($lstBlogPost->getUrl()); ?>"
                >
                    <h3><?php echo esc_html($lstBlogPost->getName()); ?></h3>
                </a>

                <?php if (($lstBlogPostAuthor && $lstCurrentWidget->showUser()) || $lstCurrentWidget->showPublishDate()) : ?>
                    <div class="listivo-blog-card-v2__meta">
                        <?php if ($lstBlogPostAuthor && $lstCurrentWidget->showUser()) : ?>
                            <a
                                    class="listivo-blog-card-v2__value listivo-blog-card-v2__value--link"
                                    href="<?php echo esc_url($lstBlogPostAuthor->getUrl()); ?>"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>

                                <?php echo esc_html($lstBlogPostAuthor->getDisplayName()); ?>
                            </a>
                        <?php endif; ?>

                        <?php if ($lstCurrentWidget->showPublishDate()) : ?>
                            <span class="listivo-blog-card-v2__value">
                                <?php echo esc_html($lstBlogPost->getPublishDate()); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($lstCurrentWidget->showExcerpt()) : ?>
                <div class="listivo-blog-card-v2__text">
                    <?php $lstCurrentWidget->displayExcerpt($lstBlogPost); ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($lstCurrentWidget->showReadMoreButton()) : ?>
            <div class="listivo-blog-card-v2__button">
                <a
                        class="listivo-button-outline listivo-button-outline--v3"
                        href="<?php echo esc_url($lstBlogPost->getUrl()); ?>"
                        title="<?php the_title_attribute(); ?>"
                >
                    <?php echo esc_html(tdf_string('read_more')); ?>

                    <span class="listivo-button-outline__icon">
                        <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="7"
                                height="11"
                                viewBox="0 0 9 14"
                        >
                            <g>
                                <g>
                                    <path d="M8.32 6.57L2.023.245c-.284-.327-.587-.327-.907 0L.742.627c-.284.29-.284.6 0 .927l5.443 5.452-5.443 5.452c-.32.327-.32.637 0 .927l.374.381c.32.328.623.328.907 0L8.32 7.442c.285-.29.285-.58 0-.872z"/>
                                </g>
                            </g>
                        </svg>
                    </span>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
