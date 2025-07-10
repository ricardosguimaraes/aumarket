<?php

use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Listivo\Widgets\General\PanelWidget;

/* @var PanelWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstModelData = $lstCurrentWidget->getInitialModel();
$lstModel = tdf_post_factory()->create((int)$lstModelData['id']);
if (!$lstModel instanceof Model) {
    return;
}

$lstCurrentUser = tdf_current_user();

if (!$lstCurrentUser->isModerator() && $lstModel->getUserId() !== $lstCurrentUser->getId()) {
    return;
}

get_template_part('templates/widgets/general/panel/header');

$lstNameRequired = tdf_settings()->getAutoGenerateModelTitleFields()->isEmpty() && tdf_settings()->nameRequired();
?>
<div class="listivo-panel-section">
    <lst-panel-model-form
            request-url="<?php echo esc_url(tdf_action_url('listivo/listings/update')); ?>"
            :initial-model="<?php echo htmlspecialchars(json_encode($lstModelData)); ?>"
            :dependency-terms="<?php echo htmlspecialchars(json_encode(tdf_app('dependency_terms'))); ?>"
            error-title-text="<?php echo esc_attr(tdf_string('required_field_is_empty')); ?>"
            error-message-text="<?php echo esc_attr(tdf_string('complete_all_required_fields')); ?>"
            confirm-button-text="<?php echo esc_attr(tdf_string('ok')); ?>"
            success-title="<?php echo esc_attr(tdf_string('listing_has_been_updated')); ?>"
            error-title="<?php echo esc_attr(tdf_string('something_went_wrong')); ?>"
            error-selector=".listivo-has-error, .listivo-field-error"
            name-too-long-title="<?php echo esc_attr(tdf_string('name_too_long')); ?>"
            name-too-long-message="<?php echo esc_attr(tdf_string('name_too_long_message')); ?>"
            :max-name-length="<?php echo esc_attr(tdf_settings()->getNameLength()); ?>"
            :name-required="<?php echo esc_attr($lstNameRequired ? 'true' : 'false'); ?>"
            :description-required="<?php echo esc_attr(tdf_settings()->descriptionRequired() ? 'true' : 'false'); ?>"
            redirect-url="<?php echo esc_url($lstCurrentWidget->getUpdateModelFormRedirectUrl($lstModel)); ?>"
            td-nonce="<?php echo esc_attr(wp_create_nonce(tdf_prefix() . '_update_model')); ?>"
    >
        <div class="listivo-container" slot-scope="modelForm">
            <div class="listivo-panel-section__top">
                <h1 class="listivo-panel-section__label">
                    <?php echo esc_html(tdf_string('edit_model')); ?>
                </h1>

                <?php get_template_part('templates/widgets/general/panel/packages_bar'); ?>
            </div>

            <template>
                <div class="listivo-panel-section__form listivo-panel-form">
                    <div class="listivo-add-listing-section listivo-add-listing-section--top">
                        <div class="listivo-panel-form__fields">
                            <?php get_template_part('templates/widgets/general/panel/form_fields'); ?>
                        </div>

                        <div class="listivo-panel-form__bottom">
                            <?php if (tdf_current_user() && tdf_current_user()->isModerator()) : ?>
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
                                        :edit-model-page="true"
                                        moderation-page-url="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_MODERATION)); ?>"
                                >
                                    <div
                                            class="listivo-panel-form__actions-wrapper"
                                            slot-scope="actions"
                                    >
                                        <div class="listivo-moderation-action-button-wrapper listivo-panel-actions-button-wrapper">
                                            <button
                                                    class="listivo-panel-actions-button listivo-panel-actions-button--height-50"
                                                    @click.stop.prevent
                                            >
                                                <?php echo esc_html(tdf_string('actions')); ?>

                                                <svg xmlns="http://www.w3.org/2000/svg" width="7" height="4"
                                                     viewBox="0 0 7 4" fill="none">
                                                    <path d="M3.5 2.46005L5.87477 0.184884C6.13207 -0.0616274 6.54972 -0.0616274 6.80702 0.184884C7.06433 0.431395 7.06433 0.831528 6.80702 1.07804L3.9394 3.82539C3.6964 4.0582 3.30298 4.0582 3.0606 3.82539L0.192977 1.07804C-0.0643257 0.831528 -0.0643257 0.431395 0.192977 0.184884C0.45028 -0.0616274 0.86793 -0.0616274 1.12523 0.184884L3.5 2.46005Z"
                                                          fill="#374B5C"/>
                                                </svg>
                                            </button>

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
                            <?php endif; ?>

                            <button
                                    class="listivo-button listivo-button--primary-1"
                                    :class="{'listivo-button--loading': modelForm.isDisabled}"
                                    :disabled="modelForm.isDisabled"
                                    @click.prevent="modelForm.onSubmit"
                            >
                                <span>
                                    <?php echo esc_html(tdf_string('save_listing')); ?>

                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="10"
                                         viewBox="0 0 14 10" fill="none">
                                        <rect x="12.2676" y="0.646447" width="1.53602" height="11.5509"
                                              rx="0.768011" transform="rotate(45 12.2676 0.646447)" fill="#FDFDFE"
                                              stroke="#FDFDFE" stroke-width="0.5"/>
                                        <path d="M1.19345 4.98437C0.891119 5.2867 0.897654 5.77885 1.20791 6.07304L4.70642 9.39049C4.94829 9.61984 5.32032 9.6413 5.58696 9.44129C5.91859 9.19252 5.95423 8.70819 5.66258 8.41356L2.27076 4.98711C1.97447 4.68779 1.49125 4.68657 1.19345 4.98437Z"
                                              fill="#FDFDFE" stroke="#FDFDFE" stroke-width="0.5"/>
                                    </svg>
                                </span>

                                <template>
                                    <svg
                                            width='40'
                                            height='10'
                                            viewBox='0 0 120 30'
                                            xmlns='http://www.w3.org/2000/svg'
                                            fill='#fff'
                                            class="listivo-button__loading"
                                    >
                                        <circle cx='15' cy='15' r='15'>
                                            <animate attributeName='r' from='15' to='15' begin='0s' dur='0.8s'
                                                     values='15;9;15'
                                                     calcMode='linear' repeatCount='indefinite'/>
                                            <animate attributeName='fill-opacity' from='1' to='1' begin='0s' dur='0.8s'
                                                     values='1;.5;1'
                                                     calcMode='linear' repeatCount='indefinite'/>
                                        </circle>

                                        <circle cx='60' cy='15' r='9' fill-opacity='0.3'>
                                            <animate attributeName='r' from='9' to='9' begin='0s' dur='0.8s'
                                                     values='9;15;9'
                                                     calcMode='linear' repeatCount='indefinite'/>
                                            <animate attributeName='fill-opacity' from='0.5' to='0.5' begin='0s'
                                                     dur='0.8s'
                                                     values='.5;1;.5' calcMode='linear' repeatCount='indefinite'/>
                                        </circle>

                                        <circle cx='105' cy='15' r='15'>
                                            <animate attributeName='r' from='15' to='15' begin='0s' dur='0.8s'
                                                     values='15;9;15'
                                                     calcMode='linear' repeatCount='indefinite'/>
                                            <animate attributeName='fill-opacity' from='1' to='1' begin='0s' dur='0.8s'
                                                     values='1;.5;1'
                                                     calcMode='linear' repeatCount='indefinite'/>
                                        </circle>
                                    </svg>
                                </template>
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </lst-panel-model-form>
</div>