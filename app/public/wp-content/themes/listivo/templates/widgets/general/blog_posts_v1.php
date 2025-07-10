<?php
/* @var \Tangibledesign\Listivo\Widgets\General\BlogPostsV1Widget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-blog-posts-v1">
    <div class="listivo-blog-posts-v1__top">
        <div class="listivo-blog-posts-v1__left">
            <div class="listivo-heading listivo-heading--left">
                <?php if (!empty($lstCurrentWidget->getSmallText())) : ?>
                    <div class="listivo-heading__small-text">
                        <div class="listivo-heading__small-text-content">
                            <?php echo esc_html($lstCurrentWidget->getSmallText()); ?>
                        </div>

                        <div class="listivo-heading__small-text__svg-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="1" viewBox="0 0 25 1">
                                <g>
                                    <g>
                                        <path d="M10 0h15v1H10z"/>
                                    </g>
                                    <g>
                                        <path d="M0 0h5v1H0z"/>
                                    </g>
                                </g>
                            </svg>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="listivo-heading__main">
                    <div class="listivo-heading__text">
                        <h2><?php echo nl2br(esc_html($lstCurrentWidget->getText())); ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="listivo-blog-posts-v1__button">
            <a
                    class="listivo-button-outline"
                    href="<?php echo esc_url($lstCurrentWidget->getButtonUrl()); ?>"
                    title="<?php echo esc_attr($lstCurrentWidget->getButtonText()); ?>"
            >
                <?php echo esc_html($lstCurrentWidget->getButtonText()); ?>

                <span class="listivo-button-outline__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 7 11">
                        <g>
                            <g>
                                <path
                                        d="M6.80074,5.18264v0l-5.0703,-4.98448c-0.229,-0.25762 -0.47276,-0.25762 -0.73048,0l-0.30087,0.30094c-0.22888,0.229 -0.22888,0.47269 0,0.73068l4.38286,4.29673v0l-4.38286,4.29673c-0.25772,0.25762 -0.25772,0.50131 0,0.73031l0.30087,0.30094c0.25772,0.25762 0.50148,0.25762 0.73048,0l5.0703,-4.98485c0.22957,-0.22862 0.22957,-0.45762 0,-0.68699z"
                                        fill="#ffffff"
                                        fill-opacity="1"
                                ></path>
                            </g>
                        </g>
                    </svg>
                </span>
            </a>
        </div>
    </div>

    <div class="listivo-blog-posts-v1__content">
        <?php
        global $lstCurrentBlogPost;
        foreach ($lstCurrentWidget->getPosts() as $lstCurrentBlogPost) :
            get_template_part('templates/partials/post_card_v3');
        endforeach;
        ?>
    </div>

    <div class="listivo-blog-posts-v1__button-mobile">
        <a
                class="listivo-button-outline"
                href="<?php echo esc_url($lstCurrentWidget->getButtonUrl()); ?>"
                title="<?php echo esc_attr($lstCurrentWidget->getButtonText()); ?>"
        >
            <?php echo esc_html($lstCurrentWidget->getButtonText()); ?>

            <span class="listivo-button-outline__icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 7 11">
                    <g>
                        <g>
                            <path
                                    d="M6.80074,5.18264v0l-5.0703,-4.98448c-0.229,-0.25762 -0.47276,-0.25762 -0.73048,0l-0.30087,0.30094c-0.22888,0.229 -0.22888,0.47269 0,0.73068l4.38286,4.29673v0l-4.38286,4.29673c-0.25772,0.25762 -0.25772,0.50131 0,0.73031l0.30087,0.30094c0.25772,0.25762 0.50148,0.25762 0.73048,0l5.0703,-4.98485c0.22957,-0.22862 0.22957,-0.45762 0,-0.68699z"
                                    fill="#ffffff"
                                    fill-opacity="1"
                            ></path>
                        </g>
                    </g>
                </svg>
            </span>
        </a>
    </div>
</div>
