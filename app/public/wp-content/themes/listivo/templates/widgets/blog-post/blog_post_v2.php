<?php

use Tangibledesign\Framework\Core\Image\RenderUserImage;
use Tangibledesign\Listivo\Widgets\BlogPost\BlogPostV2Widget;

/* @var BlogPostV2Widget $lstCurrentWidget */
global $lstCurrentWidget;

$lstBlogPost = $lstCurrentWidget->getBlogPost();
if (!$lstBlogPost) {
    return;
}
$lstUser = $lstBlogPost->getUser();
$lstImageUrl = !$lstCurrentWidget->hideMainImage() ? $lstBlogPost->getImageUrl() : false;
?>
<article
    <?php if (!empty($lstImageUrl)) : ?>
        class="listivo-single-post"
    <?php else : ?>
        class="listivo-single-post listivo-single-post--no-image"
    <?php endif; ?>
>
    <?php if (!empty($lstImageUrl)) : ?>
        <div class="listivo-single-post__image">
            <img
                    src="<?php echo esc_url($lstImageUrl); ?>"
                    alt="<?php echo esc_attr($lstBlogPost->getName()); ?>"
            >
        </div>
    <?php endif; ?>

    <?php if (!$lstCurrentWidget->hidePublishDate() || !$lstCurrentWidget->hideCommentsNumber()) : ?>
        <div class="listivo-single-post__meta-wrapper">
            <div class="listivo-single-post__meta">
                <?php if (!$lstCurrentWidget->hidePublishDate()) : ?>
                    <div class="listivo-single-post__data">
                        <div class="listivo-single-post__data-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="12" viewBox="0 0 10 12"
                                 fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M1.66667 0V1.11111H1.11111C0.5 1.11111 0 1.61111 0 2.22222V10C0 10.6111 0.5 11.1111 1.11111 11.1111H8.88889C9.5 11.1111 10 10.6111 10 10V2.22222C10 1.61111 9.5 1.11111 8.88889 1.11111H8.33333V0H7.22222V1.11111H2.77778V0H1.66667ZM1.11111 2.22222H1.66667H2.77778H7.22222H8.33333H8.88889V3.33333H1.11111V2.22222ZM8.88886 4.44434H1.11108V9.99989H8.88886V4.44434Z"
                                      fill="#FDFDFE"/>
                            </svg>
                        </div>

                        <?php echo esc_html($lstBlogPost->getPublishDate()); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="listivo-single-post__meta">
                <?php if (!$lstCurrentWidget->hideCommentsNumber()) : ?>
                    <div class="listivo-single-post__data">
                        <div class="listivo-single-post__data-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="10" viewBox="0 0 11 10"
                                 fill="none">
                                <path d="M1.71214 0C0.771271 0 0 0.771271 0 1.71214V6.19006C0 7.13093 0.771271 7.9022 1.71214 7.9022H2.10725V9.35094C2.10725 9.86879 2.74662 10.1883 3.16088 9.87775L5.79495 7.9022H8.82412C9.765 7.9022 10.5363 7.13093 10.5363 6.19006V1.71214C10.5363 0.771271 9.765 0 8.82412 0H1.71214ZM1.71214 0.79022H8.82412C9.33778 0.79022 9.74605 1.19848 9.74605 1.71214V6.19006C9.74605 6.70372 9.33778 7.11198 8.82412 7.11198H5.66324C5.5777 7.11202 5.49447 7.13982 5.42607 7.19121L2.89747 9.08753V7.50709C2.89746 7.4023 2.85583 7.30181 2.78174 7.22772C2.70764 7.15362 2.60715 7.11199 2.50236 7.11198H1.71214C1.19848 7.11198 0.79022 6.70372 0.79022 6.19006V1.71214C0.79022 1.19848 1.19848 0.79022 1.71214 0.79022ZM3.02918 2.63355C2.97682 2.63281 2.92484 2.64248 2.87625 2.66201C2.82767 2.68153 2.78345 2.71052 2.74616 2.74728C2.70887 2.78404 2.67926 2.82785 2.65906 2.87616C2.63885 2.92446 2.62844 2.9763 2.62844 3.02866C2.62844 3.08102 2.63885 3.13286 2.65906 3.18117C2.67926 3.22947 2.70887 3.27328 2.74616 3.31004C2.78345 3.34681 2.82767 3.37579 2.87625 3.39532C2.92484 3.41484 2.97682 3.42451 3.02918 3.42377H7.50709C7.55945 3.42451 7.61143 3.41484 7.66002 3.39532C7.7086 3.37579 7.75282 3.34681 7.79011 3.31004C7.82739 3.27328 7.857 3.22947 7.87721 3.18117C7.89742 3.13286 7.90783 3.08102 7.90783 3.02866C7.90783 2.9763 7.89742 2.92446 7.87721 2.87616C7.857 2.82785 7.82739 2.78404 7.79011 2.74728C7.75282 2.71052 7.7086 2.68153 7.66002 2.66201C7.61143 2.64248 7.55945 2.63281 7.50709 2.63355H3.02918ZM3.02918 4.4774C2.97682 4.47666 2.92484 4.48633 2.87625 4.50586C2.82767 4.52538 2.78345 4.55437 2.74616 4.59113C2.70887 4.62789 2.67926 4.6717 2.65906 4.72C2.63885 4.76831 2.62844 4.82015 2.62844 4.87251C2.62844 4.92487 2.63885 4.97671 2.65906 5.02502C2.67926 5.07332 2.70887 5.11713 2.74616 5.15389C2.78345 5.19065 2.82767 5.21964 2.87625 5.23916C2.92484 5.25869 2.97682 5.26836 3.02918 5.26762H6.45346C6.50582 5.26836 6.5578 5.25869 6.60639 5.23916C6.65497 5.21964 6.6992 5.19065 6.73648 5.15389C6.77377 5.11713 6.80338 5.07332 6.82359 5.02502C6.84379 4.97671 6.8542 4.92487 6.8542 4.87251C6.8542 4.82015 6.84379 4.76831 6.82359 4.72C6.80338 4.6717 6.77377 4.62789 6.73648 4.59113C6.6992 4.55437 6.65497 4.52538 6.60639 4.50586C6.5578 4.48633 6.50582 4.47666 6.45346 4.4774H3.02918Z"
                                      fill="#FDFDFE"/>
                            </svg>
                        </div>

                        <?php echo esc_html($lstBlogPost->getCommentsText()); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="listivo-single-post__main">
        <h1 class="listivo-single-post__title">
            <?php echo esc_html($lstBlogPost->getName()); ?>
        </h1>

        <div class="listivo-single-post__content">
            <?php $lstBlogPost->displayContent(); ?>
        </div>
    </div>

    <?php if ($lstCurrentWidget->showPostFooter()): ?>
        <div class="listivo-single-post__footer">
            <div class="listivo-single-post__footer-top">
                <div class="listivo-single-post__user">
                    <?php if ($lstUser && !$lstCurrentWidget->hideUser()) : ?>
                        <a
                                class="listivo-single-post__user-avatar"
                                href="<?php echo esc_url($lstUser->getUrl()); ?>"
                        >
                            <?php RenderUserImage::render($lstUser, 'listivo_100_100'); ?>
                        </a>

                        <a
                                class="listivo-single-post__user-name"
                                href="<?php echo esc_url($lstUser->getUrl()); ?>"
                        >
                            <?php echo esc_html($lstUser->getDisplayName()); ?>
                        </a>
                    <?php endif; ?>
                </div>

                <div class="listivo-single-post__socials">
                    <div class="listivo-social-icons">
                        <?php if ($lstCurrentWidget->showFacebook()) : ?>
                            <a
                                    class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                                    href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url(tdf_app('current_url')); ?>"
                                    target="_blank"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                    <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path d="M80 299.3V512H196V299.3h86.5l18-97.8H196V166.9c0-51.7 20.3-71.5 72.7-71.5c16.3 0 29.4 .4 37 1.2V7.9C291.4 4 256.4 0 236.2 0C129.3 0 80 50.5 80 159.4v42.1H14v97.8H80z"/>
                                </svg>

                                <div class="listivo-social-icon__notice">
                                    <?php echo esc_html(tdf_string('share_on_facebook')); ?>
                                </div>
                            </a>
                        <?php endif; ?>

                        <?php if ($lstCurrentWidget->showTwitter()) : ?>
                            <a
                                    class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                                    href="https://twitter.com/share?url=<?php echo esc_url(tdf_app('current_url')); ?>"
                                    target="_blank"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
                                </svg>

                                <div class="listivo-social-icon__notice">
                                    <?php echo esc_html(tdf_string('share_on_twitter')); ?>
                                </div>
                            </a>
                        <?php endif; ?>

                        <?php if ($lstCurrentWidget->showWhatsApp()) : ?>
                            <a
                                    class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--mobile listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                                    href="whatsapp://send?text=<?php echo urlencode(tdf_app('current_url')); ?>"
                                    target="_blank"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7 .9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/>
                                </svg>

                                <div class="listivo-social-icon__notice">
                                    <?php echo esc_html(tdf_string('share_on_whats_app')); ?>
                                </div>
                            </a>
                        <?php endif; ?>

                        <?php if ($lstCurrentWidget->showMessenger()) : ?>
                            <a
                                    class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--mobile listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                                    href="fb-messenger://share?link=<?php echo urlencode(tdf_app('current_url')); ?>"
                                    target="_blank"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path d="M256.6 8C116.5 8 8 110.3 8 248.6c0 72.3 29.7 134.8 78.1 177.9 8.4 7.5 6.6 11.9 8.1 58.2A19.9 19.9 0 0 0 122 502.3c52.9-23.3 53.6-25.1 62.6-22.7C337.9 521.8 504 423.7 504 248.6 504 110.3 396.6 8 256.6 8zm149.2 185.1l-73 115.6a37.4 37.4 0 0 1 -53.9 9.9l-58.1-43.5a15 15 0 0 0 -18 0l-78.4 59.4c-10.5 7.9-24.2-4.6-17.1-15.7l73-115.6a37.4 37.4 0 0 1 53.9-9.9l58.1 43.5a15 15 0 0 0 18 0l78.4-59.4c10.4-8 24.1 4.5 17.1 15.6z"/>
                                </svg>

                                <div class="listivo-social-icon__notice">
                                    <?php echo esc_html(tdf_string('share_on_messenger')); ?>
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php if (!$lstCurrentWidget->hideCategory()) : ?>
                <div class="listivo-single-post__categories">
                    <?php foreach ($lstBlogPost->getCategories() as $lstCategory) : ?>
                        <a
                                class="listivo-single-post__category"
                                href="<?php echo esc_url($lstCategory->getUrl()); ?>"
                        >
                            <?php echo esc_html($lstCategory->getName()); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</article>