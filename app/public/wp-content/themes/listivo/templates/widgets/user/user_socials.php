<?php

use Tangibledesign\Listivo\Widgets\User\UserSocialsWidget;

/* @var UserSocialsWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstUser = $lstCurrentWidget->getUser();
if (!$lstUser) {
    return;
}
?>
<div class="listivo-social-icons-wrapper">
    <div class="listivo-social-icons">
        <?php if (!empty($lstUser->getFacebookProfile()))  : ?>
            <a
                    class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                    href="<?php echo esc_url($lstUser->getFacebookProfile()); ?>"
                    target="_blank"
            >
                <i class="fab fa-facebook-f"></i>
            </a>
        <?php endif; ?>

        <?php if (!empty($lstUser->getTwitterProfile()))  : ?>
            <a
                    class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                    href="<?php echo esc_url($lstUser->getTwitterProfile()); ?>"
                    target="_blank"
            >
                <i class="fab fa-twitter"></i>
            </a>
        <?php endif; ?>

        <?php if (!empty($lstUser->getLinkedInProfile()))  : ?>
            <a
                    class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                    href="<?php echo esc_url($lstUser->getLinkedInProfile()); ?>"
                    target="_blank"
            >
                <i class="fab fa-linkedin-in"></i>
            </a>
        <?php endif; ?>

        <?php if (!empty($lstUser->getInstagramProfile()))  : ?>
            <a
                    class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                    href="<?php echo esc_url($lstUser->getInstagramProfile()); ?>"
                    target="_blank"
            >
                <i class="fab fa-instagram"></i>
            </a>
        <?php endif; ?>

        <?php if (!empty($lstUser->getYouTubeProfile()))  : ?>
            <a
                    class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                    href="<?php echo esc_url($lstUser->getYouTubeProfile()); ?>"
                    target="_blank"
            >
                <i class="fab fa-youtube"></i>
            </a>
        <?php endif; ?>

        <?php if (!empty($lstUser->getTiktokProfile()))  : ?>
            <a
                    class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                    href="<?php echo esc_url($lstUser->getTiktokProfile()); ?>"
                    target="_blank"
            >
                <i class="fab fa-tiktok"></i>
            </a>
        <?php endif; ?>

        <?php if (!empty($lstUser->getTelegramProfile()))  : ?>
            <a
                    class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                    href="<?php echo esc_url($lstUser->getTelegramProfile()); ?>"
                    target="_blank"
            >
                <i class="fab fa-telegram"></i>
            </a>
        <?php endif; ?>
    </div>
</div>