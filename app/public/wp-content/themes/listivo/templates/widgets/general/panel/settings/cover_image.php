<?php

use Tangibledesign\Framework\Models\User\User;
use Tangibledesign\Listivo\Widgets\General\PanelWidget;

/* @var PanelWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstCurrentUser = tdf_current_user();
if (!$lstCurrentUser instanceof User) {
    return;
}
?>
<lst-user-image
        class="listivo-panel-accordions__item listivo-panel-accordion"
    <?php if ($lstCurrentUser->getCoverImage()) : ?>
        :initial-image="<?php echo esc_attr(json_encode($lstCurrentWidget->getUserCoverImageData($lstCurrentUser))); ?>"
    <?php endif; ?>
        delete-request-url="<?php echo esc_url(tdf_action_url('listivo/user/cover_image/delete')); ?>"
        delete-nonce="<?php echo esc_attr(wp_create_nonce('listivo_delete_user_cover_image')); ?>"
        upload-nonce="<?php echo esc_attr(wp_create_nonce('listivo_save_user_cover_image')); ?>"
        delete-message-string="<?php echo esc_attr(tdf_string('are_you_sure')); ?>"
        delete-success-string="<?php echo esc_attr(tdf_string('deleted')); ?>"
        success-string="<?php echo esc_attr(tdf_string('success')); ?>"
        confirm-string="<?php echo esc_attr(tdf_string('confirm')); ?>"
        cancel-string="<?php echo esc_attr(tdf_string('cancel')); ?>"
        in-progress-string="<?php echo esc_attr(tdf_string('in_progress')); ?>"
>
    <div
            slot-scope="props"
            class="listivo-panel-accordions__item listivo-panel-accordion"
            :class="{'listivo-panel-accordion--active': accordions.open === 'user_cover_image'}"
    >
        <div
                class="listivo-panel-accordion__top"
                @click="accordions.onOpen('user_cover_image')"
        >
            <div class="listivo-panel-accordion__label">
                <?php echo esc_html(tdf_string('cover_image')) ?>
            </div>

            <div class="listivo-panel-accordion__icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14"
                     viewBox="0 0 16 14"
                     fill="none">
                    <path d="M6.0872 0.243733C6.25012 0.0808152 6.46304 -0.000435034 6.67637 -0.000435034C6.88971 -0.000435034 7.10263 0.0808152 7.26554 0.243733C7.59096 0.569152 7.59096 1.09666 7.26554 1.42208L2.85468 5.83294L14.1764 5.83294C14.6364 5.83294 15.0098 6.20627 15.0098 6.66628C15.0098 7.12628 14.6364 7.49962 14.1764 7.49962L2.85468 7.49962L7.26554 11.9105C7.59096 12.2359 7.59096 12.7634 7.26554 13.0888C6.94013 13.4142 6.41262 13.4142 6.0872 13.0888L0.25383 7.25545C-0.0715891 6.93003 -0.0715891 6.40253 0.25383 6.07711L6.0872 0.243733Z"
                          fill="#2A3946"/>
                </svg>
            </div>
        </div>

        <div class="listivo-panel-accordion__content-wrapper listivo-panel-accordion__content-wrapper--user_cover_image">
            <div class="listivo-panel-accordion__content">
                <lst-dropzone
                        v-show="false"
                        id="listivo-panel-user-cover-image"
                        :options="<?php echo htmlspecialchars(json_encode($lstCurrentWidget->getUserCoverImageDropZoneConfig())); ?>"
                        @vdropzone-sending="props.onSending"
                        @vdropzone-success="props.onSuccess"
                        @vdropzone-error="props.onError"
                        @vdropzone-canceled="props.onError"
                >
                </lst-dropzone>

                <div class="listivo-panel-user-image">
                    <div v-if="props.image" class="listivo-panel-user-image__image">
                        <img :src="props.image.url">
                        <div
                                class="listivo-panel-user-image__close"
                                @click.stop.prevent="props.onDelete"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11"
                                 viewBox="0 0 11 11" fill="none">
                                <path d="M1.61169 0.500482C1.39146 0.500755 1.1763 0.566706 0.993713 0.68991C0.811124 0.813114 0.66939 0.987978 0.586617 1.19216C0.503843 1.39635 0.483789 1.62059 0.529015 1.83623C0.574241 2.05188 0.682695 2.24914 0.840521 2.40281L3.93386 5.49762L0.840521 8.59243C0.734227 8.69453 0.649364 8.81683 0.590902 8.95216C0.532441 9.08748 0.501556 9.23312 0.500057 9.38054C0.498558 9.52796 0.526475 9.67419 0.582173 9.81068C0.63787 9.94717 0.720229 10.0712 0.824425 10.1754C0.928621 10.2797 1.05256 10.3621 1.18898 10.4178C1.32541 10.4735 1.47158 10.5014 1.61892 10.4999C1.76627 10.4984 1.91184 10.4675 2.0471 10.409C2.18237 10.3506 2.3046 10.2657 2.40666 10.1593L5.5 7.0645L8.59334 10.1593C8.69539 10.2657 8.81763 10.3506 8.95289 10.4091C9.08815 10.4675 9.23372 10.4984 9.38107 10.4999C9.52842 10.5014 9.67459 10.4735 9.81101 10.4178C9.94744 10.3621 10.0714 10.2797 10.1756 10.1754C10.2798 10.0712 10.3621 9.94718 10.4178 9.81069C10.4735 9.6742 10.5014 9.52796 10.4999 9.38054C10.4984 9.23312 10.4676 9.08748 10.4091 8.95216C10.3506 8.81683 10.2658 8.69453 10.1595 8.59243L7.06613 5.49762L10.1595 2.40281C10.3195 2.24717 10.4288 2.04679 10.4731 1.82792C10.5173 1.60906 10.4945 1.38192 10.4075 1.17628C10.3205 0.970635 10.1734 0.796081 9.9856 0.675491C9.79775 0.5549 9.57787 0.493899 9.35477 0.500482C9.06703 0.509059 8.79393 0.629373 8.59334 0.835933L5.5 3.93074L2.40666 0.835933C2.30332 0.729655 2.17971 0.645206 2.04316 0.587585C1.90661 0.529965 1.75989 0.500346 1.61169 0.500482Z"
                                      fill="#FDFDFE"/>
                            </svg>
                        </div>
                    </div>

                    <div
                            class="listivo-panel-user-image__image listivo-panel-user-image__image--placeholder"
                            @click.prevent="props.onOpen"
                    >
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="18"
                                 viewBox="0 0 16 18" fill="none">
                                <path d="M6.09903 17.356V11.02H0.195031V7.312H6.09903V0.975998H9.91503V7.312H15.819V11.02H9.91503V17.356H6.09903Z"
                                      fill="#D5E3EE"/>
                            </svg>
                        </div>
                        <?php echo esc_html(tdf_string('upload_cover_photo')); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</lst-user-image> 