<?php

use Tangibledesign\Framework\Widgets\General\UserProfileWidget;

/* @var UserProfileWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstUser = $lstCurrentWidget->getUser();
if (!$lstUser) {
    return;
}

$lstUserImage = $lstUser->getImage();
?>
<div class="listivo-profile listivo-profile--single">
    <a
            class="listivo-profile__link-profile"
            href="<?php echo esc_url($lstUser->getUrl()); ?>"
    ></a>

    <div class="listivo-profile__image-wrapper">
        <?php if ($lstUserImage) : ?>
            <img
                    src="<?php echo esc_url($lstUserImage->getImageUrl()); ?>"
                    alt="<?php echo esc_attr($lstUser->getDisplayName()); ?>"
            >
        <?php endif; ?>
    </div>

    <div class="listivo-profile__details">
        <div class="listivo-profile__hidden">
            <?php if ($lstUser->hasSocialProfiles()) : ?>
                <div class="listivo-profile__social-icon">
                    <div class="listivo-social-profiles">
                        <?php if (!empty($lstUser->getFacebookProfile())) : ?>
                            <a
                                    class="listivo-social-profiles__single"
                                    href="<?php echo esc_url($lstUser->getFacebookProfile()); ?>"
                                    target="_blank"
                            >
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($lstUser->getTwitterProfile())) : ?>
                            <a
                                    class="listivo-social-profiles__single"
                                    href="<?php echo esc_url($lstUser->getTwitterProfile()); ?>"
                                    target="_blank"
                            >
                                <i class="fab fa-twitter"></i>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($lstUser->getLinkedInProfile())) : ?>
                            <a
                                    class="listivo-social-profiles__single"
                                    href="<?php echo esc_url($lstUser->getLinkedInProfile()); ?>"
                                    target="_blank"
                            >
                                <i class="fab fa-linkedin"></i>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($lstUser->getInstagramProfile())) : ?>
                            <a
                                    class="listivo-social-profiles__single"
                                    href="<?php echo esc_url($lstUser->getInstagramProfile()); ?>"
                                    target="_blank"
                            >
                                <i class="fab fa-instagram"></i>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($lstUser->getYouTubeProfile())) : ?>
                            <a
                                    class="listivo-social-profiles__single"
                                    href="<?php echo esc_url($lstUser->getYouTubeProfile()); ?>"
                                    target="_blank"
                            >
                                <i class="fab fa-youtube"></i>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($lstUser->getTiktokProfile())) : ?>
                            <a
                                    class="listivo-social-profiles__single"
                                    href="<?php echo esc_url($lstUser->getTiktokProfile()); ?>"
                                    target="_blank"
                            >
                                <i class="fab fa-youtube"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
