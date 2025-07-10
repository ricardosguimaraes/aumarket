<?php
/* @var \Tangibledesign\Listivo\Widgets\User\UserImageWidget $lstCurrentWidget */
global $lstCurrentWidget, $lstUser;

$lstUser = $lstCurrentWidget->getUser();
if (!$lstUser) {
    return;
}

$lstImageUrl = $lstUser->getImageUrl($lstCurrentWidget->getImageSize());
if (!$lstImageUrl) {
    return;
}

if ($lstCurrentWidget->linkUser()) : ?>
    <a
            class="listivo-user-image"
            href="<?php echo esc_url($lstUser->getUrl()); ?>"
    >
        <img
                class="listivo-user-image-control-size"
                src="<?php echo esc_url($lstImageUrl); ?>"
                alt="<?php echo esc_attr($lstUser->getDisplayName()); ?>"
        >
    </a>
<?php else : ?>
    <div class="listivo-user-image listivo-user-image-control-size">
        <img
                src="<?php echo esc_url($lstImageUrl); ?>"
                alt="<?php echo esc_attr($lstUser->getDisplayName()); ?>"
        >
    </div>
<?php
endif;