<?php
/* @var \Tangibledesign\Framework\Widgets\General\SocialShareWidget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-social-share">
    <?php if ($lstCurrentWidget->showFacebook()) : ?>
        <a
                href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url(tdf_app('current_url')); ?>"
                target="_blank"
                class="listivo-social-share__single listivo-social-share__single--facebook"
        >
            <i class="fab fa-facebook-f"></i>
        </a>
    <?php endif; ?>

    <?php if ($lstCurrentWidget->showTwitter()) : ?>
        <a
                href="https://twitter.com/share?url=<?php echo esc_url(tdf_app('current_url')); ?>"
                target="_blank"
                class="listivo-social-share__single listivo-social-share__single--twitter"
        >
            <i class="fab fa-twitter"></i>
        </a>
    <?php endif; ?>

    <?php if ($lstCurrentWidget->showWhatsApp()) : ?>
        <a
                href="whatsapp://send?text=<?php echo urlencode(tdf_app('current_url')); ?>"
                target="_blank"
                class="listivo-social-share__single listivo-social-share__single--whatsapp"
        >
            <i class="fab fa-whatsapp"></i>
        </a>
    <?php endif; ?>

    <?php if ($lstCurrentWidget->showMessenger()) : ?>
        <a
                href="fb-messenger://share?link=<?php echo urlencode(tdf_app('current_url')); ?>"
                target="_blank"
                class="listivo-social-share__single listivo-social-share__single--messenger"
        >
            <i class="fab fa-facebook-messenger"></i>
        </a>
    <?php endif; ?>
</div>
