<?php

use Tangibledesign\Framework\Models\Image;
use Tangibledesign\Framework\Widgets\General\LogoWidget;

/* @var LogoWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstLogo = $lstCurrentWidget->getLogo();
if (!$lstLogo instanceof Image) {
    return;
}
?>
<div class="listivo-image-wrapper">
    <?php if ($lstCurrentWidget->isLink()) : ?>
        <a class="listivo-image" href="<?php echo esc_url(site_url()); ?>">
            <img
                    class="lazyload"
                    data-src="<?php echo esc_url($lstLogo->getImageUrl($lstCurrentWidget->getImageSize())); ?>"
                    alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
            >
        </a>
    <?php else: ?>
        <div class="listivo-image">
            <img
                    class="lazyload"
                    data-src="<?php echo esc_url($lstLogo->getImageUrl($lstCurrentWidget->getImageSize())); ?>"
                    alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
            >
        </div>
    <?php endif; ?>
</div>