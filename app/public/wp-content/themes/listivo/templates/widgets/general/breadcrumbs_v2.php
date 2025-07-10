<?php

use Tangibledesign\Listivo\Widgets\General\BreadcrumbsV2Widget;

/* @var BreadcrumbsV2Widget $lstCurrentWidget */
global $lstCurrentWidget;

$lstBreadcrumbs = $lstCurrentWidget->getBreadcrumbs();
if (empty($lstBreadcrumbs)) {
    return;
}

$lstBreadcrumbsNumber = count($lstBreadcrumbs) - 1;
?>
<div class="listivo-app listivo-breadcrumbs-widget">
    <lst-breadcrumbs>
        <div slot-scope="props" class="listivo-breadcrumbs-wrapper-v2">
            <div
                    v-if="!props.breadcrumbs"
                <?php if ($lstCurrentWidget->hasBackground()) : ?>
                    class="listivo-breadcrumbs-v2 listivo-breadcrumbs-v2--with-background"
                <?php else : ?>
                    class="listivo-breadcrumbs-v2"
                <?php endif; ?>
            >
                <?php foreach ($lstBreadcrumbs as $lstIndex => $lstBreadcrumb) : ?>
                    <?php if ($lstIndex < $lstBreadcrumbsNumber) : ?>
                        <a
                                class="listivo-breadcrumbs-v2__item"
                                href="<?php echo esc_url($lstBreadcrumb['url']); ?>"
                                title="<?php echo esc_attr($lstBreadcrumb['name']); ?>"
                        >
                            <?php echo esc_html($lstBreadcrumb['name']); ?>
                        </a>

                        <span class="listivo-breadcrumbs-v2__separator">
                            <svg xmlns="http://www.w3.org/2000/svg" width="5" height="7" viewBox="0 0 5 7" fill="none">
                                <path d="M2.56744 3.5L0.192673 1.12523C-0.0646296 0.86793 -0.0646296 0.45028 0.192673 0.192977C0.449976 -0.0643258 0.867626 -0.0643258 1.12493 0.192977L3.99255 3.0606C4.23556 3.3036 4.23556 3.69702 3.99255 3.9394L1.12493 6.80702C0.867626 7.06433 0.449976 7.06433 0.192673 6.80702C-0.0646296 6.54972 -0.0646296 6.13207 0.192673 5.87477L2.56744 3.5Z"
                                      fill="#F09965"/>
                            </svg>
                        </span>
                    <?php else : ?>
                        <span class="listivo-breadcrumbs-v2__item">
                            <?php echo esc_html($lstBreadcrumb['name']); ?>
                        </span>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <template v-if="props.breadcrumbs">
                <div
                    <?php if ($lstCurrentWidget->hasBackground()) : ?>
                        class="listivo-breadcrumbs-v2 listivo-breadcrumbs-v2--with-background"
                    <?php else : ?>
                        class="listivo-breadcrumbs-v2"
                    <?php endif; ?>
                >
                    <div
                            class="listivo-breadcrumbs-v2__element"
                            v-for="(breadcrumb, index) in props.breadcrumbs"
                            :key="breadcrumb.key + '-' + index"
                    >
                        <template v-if="index < props.breadcrumbs.length - 1">
                            <a
                                    class="listivo-breadcrumbs-v2__item"
                                    :href="breadcrumb.url"
                                    v-html="breadcrumb.name"
                            ></a>

                            <span class="listivo-breadcrumbs-v2__separator">
                                <svg xmlns="http://www.w3.org/2000/svg" width="5" height="7" viewBox="0 0 5 7"
                                     fill="none">
                                    <path d="M2.56744 3.5L0.192673 1.12523C-0.0646296 0.86793 -0.0646296 0.45028 0.192673 0.192977C0.449976 -0.0643258 0.867626 -0.0643258 1.12493 0.192977L3.99255 3.0606C4.23556 3.3036 4.23556 3.69702 3.99255 3.9394L1.12493 6.80702C0.867626 7.06433 0.449976 7.06433 0.192673 6.80702C-0.0646296 6.54972 -0.0646296 6.13207 0.192673 5.87477L2.56744 3.5Z"
                                          fill="#F09965"/>
                                </svg>
                            </span>
                        </template>

                        <span
                                class="listivo-breadcrumbs-v2__item"
                                v-if="index === props.breadcrumbs.length - 1"
                                v-html="breadcrumb.name"
                        ></span>
                    </div>
                </div>
            </template>
        </div>
    </lst-breadcrumbs>

    <div class="listivo-breadcrumbs-v2-widget__share">
        <div class="listivo-social-icons listivo-social-icons--no-wrap">
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