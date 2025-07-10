<?php

use Tangibledesign\Framework\Models\User\User;

/* @var User $lstTempUser */
/* @var string $lstImageSize */
/* @var string $lstPlaceholderType */
global $lstTempUser, $lstImageSize, $lstPlaceholderType;

if ($lstTempUser->hasSocialImage()) : ?>
    <img
            class="lazyload"
            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
            data-src="<?php echo esc_url($lstTempUser->getSocialImage()); ?>"
            alt="<?php echo esc_attr($lstTempUser->getDisplayName()); ?>"
    >
<?php else :
    $lstTempUserImage = $lstTempUser->getImage();
    if ($lstTempUserImage):
        $lstTempUserImageSrcset = $lstTempUserImage->getSrcset($lstImageSize);
        ?>
        <img
                class="lazyload"
                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                alt="<?php echo esc_attr($lstTempUser->getDisplayName()); ?>"
            <?php if (!empty($lstTempUserImageSrcset)) : ?>
                data-srcset="<?php echo esc_attr($lstTempUserImageSrcset); ?>"
                data-sizes="auto"
            <?php else : ?>
                data-src="<?php echo esc_url($lstTempUserImage->getImageUrl($lstImageSize)); ?>"
            <?php endif; ?>
        >
    <?php else : ?>
        <img
                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                alt="<?php echo esc_attr($lstTempUser->getDisplayName()); ?>"
        >

        <div
            <?php if ($lstPlaceholderType === 'circle') : ?>
                class="listivo-user-image-placeholder listivo-user-image-placeholder--circle"
            <?php else : ?>
                class="listivo-user-image-placeholder"
        >
            <?php endif; ?>
            <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 132 148"
                    fill="none"
            >
                <path d="M6 141.5C6 120.789 32.8629 104 66 104C99.1371 104 126 120.789 126 141.5M103.5 44.0001C103.5 64.7108 86.7107 81.5002 66 81.5002C45.2893 81.5002 28.5 64.7108 28.5 44.0001C28.5 23.2894 45.2893 6.5 66 6.5C86.7107 6.5 103.5 23.2894 103.5 44.0001Z"
                      stroke="#D5E3EE" stroke-width="12" stroke-linecap="round"
                      stroke-linejoin="round"/>
            </svg>
        </div>
    <?php endif; ?>
<?php endif;