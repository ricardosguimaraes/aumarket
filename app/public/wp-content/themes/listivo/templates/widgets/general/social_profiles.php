<?php

use Tangibledesign\Listivo\Widgets\General\SocialProfilesWidget;

/* @var SocialProfilesWidget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-social-profiles">
    <?php if (!empty(tdf_settings()->getFacebookProfile()))  : ?>
        <a
                class="listivo-social-profiles__single"
                href="<?php echo esc_url(tdf_settings()->getFacebookProfile()); ?>"
        >
            <i class="fab fa-facebook-f"></i>
        </a>
    <?php endif; ?>

    <?php if (!empty(tdf_settings()->getTwitterProfile()))  : ?>
        <a
                class="listivo-social-profiles__single"
                href="<?php echo esc_url(tdf_settings()->getTwitterProfile()); ?>"
        >
            <i class="fab fa-twitter"></i>
        </a>
    <?php endif; ?>

    <?php if (!empty(tdf_settings()->getLinkedInProfile()))  : ?>
        <a
                class="listivo-social-profiles__single"
                href="<?php echo esc_url(tdf_settings()->getLinkedInProfile()); ?>"
        >
            <i class="fab fa-linkedin"></i>
        </a>
    <?php endif; ?>

    <?php if (!empty(tdf_settings()->getInstagramProfile()))  : ?>
        <a
                class="listivo-social-profiles__single"
                href="<?php echo esc_url(tdf_settings()->getInstagramProfile()); ?>"
        >
            <i class="fab fa-instagram"></i>
        </a>
    <?php endif; ?>

    <?php if (!empty(tdf_settings()->getYouTubeProfile()))  : ?>
        <a href="<?php echo esc_url(tdf_settings()->getYouTubeProfile()); ?>"
           class="listivo-social-profiles__single">
            <i class="fab fa-youtube"></i>
        </a>
    <?php endif; ?>

    <?php if (!empty(tdf_settings()->getTiktokProfile()))  : ?>
        <a
                class="listivo-social-profiles__single"
                href="<?php echo esc_url(tdf_settings()->getTiktokProfile()); ?>"
        >
            <i class="fab fa-tiktok"></i>
        </a>
    <?php endif; ?>

    <?php if (!empty(tdf_settings()->getTelegramProfile()))  : ?>
        <a
                class="listivo-social-profiles__single"
                href="<?php echo esc_url(tdf_settings()->getTelegramProfile()); ?>"
        >
            <i class="fab fa-telegram"></i>
        </a>
    <?php endif; ?>
</div>