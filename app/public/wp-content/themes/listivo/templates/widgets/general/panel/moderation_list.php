<?php


global $lstModels;

use Tangibledesign\Framework\Models\Model;

$lstMainCategory = tdf_settings()->getMainCategory();

foreach ($lstModels as $lstModel) : /* @var Model $lstModel */
    if ($lstMainCategory) :
        $lstMainCategoryValue = $lstMainCategory->getMultilevelValue($lstModel);
    else :
        $lstMainCategoryValue = tdf_collect();
    endif;

    $lstUser = $lstModel->getUser();
    ?>
    <div class="listivo-moderation__row">
        <div class="listivo-moderation__column listivo-moderation__column--listing">
            <a
                    class="listivo-moderation__image"
                    href="<?php echo esc_url($lstModel->getUrl()); ?>"
                    target="_blank"
            >
                <div class="listivo-moderation__status listivo-moderation__status--mobile listivo-moderation__status--<?php echo esc_attr($lstModel->getStatus()); ?>">
                    <?php echo esc_html($lstModel->getStatusLabel()); ?>
                </div>

                <?php

                $lstImage = $lstModel->getMainImage();
                if (!empty($lstImage)) :
                    $lstImageSrcset = $lstImage->getSrcset('listivo_400_400');
                    ?>
                    <img
                        <?php if (!empty($lstImageSrcset)) : ?>
                            class="lazyload"
                            src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                            data-srcset="<?php echo esc_attr($lstImageSrcset); ?>"
                            data-sizes="auto"
                        <?php else : ?>
                            src="<?php echo esc_url($lstImage->getImageUrl()); ?>"
                        <?php endif; ?>
                            alt="<?php echo esc_attr($lstModel->getName()); ?>"
                    >
                <?php else : ?>
                    <img
                            src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                            alt="<?php echo esc_attr($lstModel->getName()); ?>"
                    >

                    <?php get_template_part('templates/partials/image_placeholder'); ?>
                <?php endif; ?>
            </a>

            <div class="listivo-moderation__info">
                <a
                        class="listivo-moderation__label"
                        href="<?php echo esc_url($lstModel->getUrl()); ?>"
                        target="_blank"
                >
                    <?php echo esc_html($lstModel->getName()); ?>
                </a>

                <div class="listivo-moderation__data">
                    <?php if ($lstModel->hasAssignedPackage()) : ?>
                        <div class="listivo-package-name">
                            <div class="listivo-package-name-inner">
                                <?php echo esc_html($lstModel->getAssignedPackage()->getName()); ?>
                            </div>
                        </div>
                    <?php
                    endif;

                    $lstCategoryTerm = $lstMainCategoryValue->first();
                    if ($lstCategoryTerm) :?>
                        <div class="listivo-moderation__meta">
                            <span><?php echo esc_html(tdf_string('category')); ?>:</span>

                            <a href="<?php echo esc_url($lstCategoryTerm->getUrl()); ?>" target="_blank">
                                <?php echo esc_html($lstCategoryTerm->getName()); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if (tdf_settings()->paymentsEnabled() || !empty(tdf_settings()->getListingExpireAfter())) : ?>
                        <div class="listivo-moderation__meta">
                            <span><?php echo esc_html(tdf_string('added')); ?>:</span>

                            <?php echo esc_html($lstModel->getPublishDate()); ?>
                        </div>

                        <?php if ($lstModel->isPublished()) : ?>
                            <div class="listivo-moderation__meta">
                                <span><?php echo esc_html(tdf_string('expires')); ?>:</span>

                                <?php echo esc_html($lstModel->getExpireDateText()); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($lstModel->hasFeaturedExpireDate()) : ?>
                            <div class="listivo-moderation__meta">
                                <span><?php echo esc_html(tdf_string('featured_expires')); ?>:</span>

                                <?php echo esc_html($lstModel->getFeaturedExpireDateText()); ?>
                            </div>
                        <?php endif; ?>
                    <?php else : ?>
                        <div class="listivo-moderation__meta">
                            <span><?php echo esc_html(tdf_string('added')); ?>:</span>

                            <?php echo esc_html($lstModel->getPublishDate()); ?>
                        </div>

                        <?php if ($lstModel->getPublishDate() !== $lstModel->getModifiedDate()) : ?>
                            <div class="listivo-moderation__meta">
                                <span><?php echo esc_html(tdf_string('modified')); ?>:</span>

                                <?php echo esc_html($lstModel->getModifiedDate()); ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php foreach (tdf_settings()->getModerationPageCustomFields() as $lstField) :
                        /* @var \Tangibledesign\Framework\Models\Field\Helpers\SimpleTextValue $lstField */
                        $lstValue = $lstField->getSimpleTextValue($lstModel);
                        if (!$lstValue) {
                            continue;
                        }
                        ?>
                        <div class="listivo-moderation__meta">
                            <span><?php echo esc_html($lstField->getName()); ?>:</span>

                            <?php echo esc_html(implode(', ', $lstValue)); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="listivo-moderation__column">
            <?php if ($lstUser) : ?>
                <div class="listivo-moderation__user">
                    <a
                            class="listivo-moderation__avatar"
                            href="<?php echo esc_url($lstUser->getUrl()); ?>"
                            target="_blank"
                    >
                        <?php
                        $lstUserImage = $lstUser->getImageUrl();
                        if ($lstUserImage) :?>
                            <img
                                    src="<?php echo esc_attr($lstUserImage); ?>"
                                    alt="<?php echo esc_attr($lstUser->getDisplayName()); ?>"
                            >
                        <?php else : ?>
                            <div class="listivo-user-image-placeholder listivo-user-image-placeholder--circle">
                                <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="20"
                                        height="20"
                                        viewBox="0 0 132 148"
                                        fill="none"
                                >
                                    <path d="M6 141.5C6 120.789 32.8629 104 66 104C99.1371 104 126 120.789 126 141.5M103.5 44.0001C103.5 64.7108 86.7107 81.5002 66 81.5002C45.2893 81.5002 28.5 64.7108 28.5 44.0001C28.5 23.2894 45.2893 6.5 66 6.5C86.7107 6.5 103.5 23.2894 103.5 44.0001Z"
                                          stroke="#D5E3EE" stroke-width="12" stroke-linecap="round"
                                          stroke-linejoin="round"/>
                                </svg>
                            </div>
                        <?php endif; ?>
                    </a>

                    <a
                            href="<?php echo esc_url($lstUser->getUrl()); ?>"
                            target="_blank"
                    >
                        <?php echo esc_html($lstUser->getDisplayName()); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <div class="listivo-moderation__column">
            <div class="listivo-moderation__status listivo-moderation__status--<?php echo esc_attr($lstModel->getStatus()); ?>">
                <?php echo esc_html($lstModel->getStatusLabel()); ?>
            </div>
        </div>

        <div class="listivo-moderation__column">
            <lst-model-moderation-actions
                    td-nonce="<?php echo esc_attr(wp_create_nonce('listivo_moderation_' . $lstModel->getId())); ?>"
                    :model-id="<?php echo esc_attr($lstModel->getId()); ?>"
                    approve-request-url="<?php echo esc_url(tdf_action_url('listivo/panel/moderation/approve')); ?>"
                    decline-request-url="<?php echo esc_url(tdf_action_url('listivo/panel/moderation/decline')); ?>"
                    publish-request-url="<?php echo esc_url(tdf_action_url('listivo/panel/moderation/publish')); ?>"
                    draft-request-url="<?php echo esc_url(tdf_action_url('listivo/panel/moderation/draft')); ?>"
                    delete-request-url="<?php echo esc_url(tdf_action_url('listivo/panel/moderation/delete')); ?>"
                    in-progress-text="<?php echo esc_attr(tdf_string('in_progress')); ?>"
                    decline-text="<?php echo esc_attr(tdf_string('decline')); ?>"
                    delete-text="<?php echo esc_attr(tdf_string('delete')); ?>"
                    cancel-text="<?php echo esc_attr(tdf_string('cancel')); ?>"
                    confirm-delete-text="<?php echo esc_attr(tdf_string('are_you_sure')); ?>"
                    decline-title="<?php echo esc_attr(tdf_string('decline')); ?>"
                    decline-reason-text="<?php echo esc_attr(tdf_string('decline_reason_text')); ?>"
                    ok-text="<?php echo esc_attr(tdf_string('ok')); ?>"
            >
                <div
                        class="listivo-moderation__action-wrapper"
                        slot-scope="actions"
                >
                    <div class="listivo-moderation-action-button-wrapper listivo-panel-actions-button-wrapper">
                        <div class="listivo-moderation__action">
                            <?php echo esc_html(tdf_string('actions')); ?>

                            <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none">
                                <path d="M3.5 2.56768L5.87477 0.192917C6.13207 -0.0643854 6.54972 -0.0643854 6.80702 0.192917C7.06433 0.45022 7.06433 0.86787 6.80702 1.12517L3.9394 3.99279C3.6964 4.2358 3.30298 4.2358 3.0606 3.99279L0.192977 1.12517C-0.0643257 0.86787 -0.0643257 0.45022 0.192977 0.192917C0.45028 -0.0643854 0.86793 -0.0643854 1.12523 0.192917L3.5 2.56768Z"
                                      fill="#2A3946"/>
                            </svg>
                        </div>

                        <div class="listivo-panel-actions listivo-panel-actions--hidden">
                            <?php if ($lstModel->isPending()) : ?>
                                <div
                                        class="listivo-panel-actions__action"
                                        @click="actions.onApprove"
                                >
                                    <?php echo esc_html(tdf_string('approve')); ?>
                                </div>

                                <div
                                        class="listivo-panel-actions__action"
                                        @click="actions.onDecline"
                                >
                                    <?php echo esc_html(tdf_string('decline')); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($lstModel->isDraft()) : ?>
                                <div
                                        class="listivo-panel-actions__action"
                                        @click="actions.onPublish"
                                >
                                    <?php echo esc_html(tdf_string('publish')); ?>
                                </div>
                            <?php endif; ?>

                            <a
                                    class="listivo-panel-actions__action"
                                    href="<?php echo esc_url($lstModel->getEditUrl('moderation')); ?>"
                            >
                                <?php echo esc_html(tdf_string('edit')); ?>
                            </a>

                            <?php if ($lstModel->isPublished()) : ?>
                                <div
                                        class="listivo-panel-actions__action"
                                        @click="actions.onDraft"
                                >
                                    <?php echo esc_html(tdf_string('switch_to_draft')); ?>
                                </div>
                            <?php endif; ?>

                            <div
                                    class="listivo-panel-actions__action"
                                    @click="actions.onDelete"
                            >
                                <?php echo esc_html(tdf_string('delete')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </lst-model-moderation-actions>
        </div>
    </div>
<?php endforeach; ?>