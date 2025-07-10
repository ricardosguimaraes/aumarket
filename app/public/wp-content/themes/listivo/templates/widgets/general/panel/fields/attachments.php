<?php
/* @var \Tangibledesign\Listivo\Widgets\General\PanelWidget $lstCurrentWidget */
/* @var \Tangibledesign\Framework\Models\PanelFields\AttachmentsPanelField $lstPanelField */
global $lstCurrentWidget, $lstPanelField;
/* @var \Tangibledesign\Framework\Models\Field\AttachmentsField $lstAttachmentsField */
$lstAttachmentsField = $lstPanelField->getField();
?>
<lst-attachments-model-field
        class="listivo-panel-form__single-column"
        :model="modelForm.model"
        :field="<?php echo htmlspecialchars(json_encode($lstPanelField->getField())); ?>"
        td-nonce="<?php echo esc_attr(wp_create_nonce('listivo_upload_attachment')); ?>"
        request-url="<?php echo esc_url(tdf_action_url('listivo/attachments/info')); ?>"
        pdf-icon="<?php echo esc_url(get_template_directory_uri() . '/assets/img/pdf.svg'); ?>"
        xls-icon="<?php echo esc_url(get_template_directory_uri() . '/assets/img/xls.svg'); ?>"
        doc-icon="<?php echo esc_url(get_template_directory_uri() . '/assets/img/doc.svg'); ?>"
        jpg-icon="<?php echo esc_url(get_template_directory_uri() . '/assets/img/jpg.svg'); ?>"
        png-icon="<?php echo esc_url(get_template_directory_uri() . '/assets/img/png.svg'); ?>"
        zip-icon="<?php echo esc_url(get_template_directory_uri() . '/assets/img/zip.svg'); ?>"
        other-icon="<?php echo esc_url(get_template_directory_uri() . '/assets/img/other_file_type.svg'); ?>"
        :dependency-terms="modelForm.dependencyTerms"
        :selected-term-ids="modelForm.taxonomyFieldsValueIds"
>
    <div
            class="listivo-panel-form__single-column <?php echo esc_attr($lstPanelField->getKey()); ?>"
            slot-scope="attachmentsField"
            v-if="attachmentsField.isVisible"
            :class="{'listivo-has-error': modelForm.showErrors && attachmentsField.hasError}"
    >
        <div class="listivo-panel-form-label listivo-panel-form-label--margin-bottom listivo-panel-form-label--small-margin-top">
            <h3 class="listivo-panel-form-label__text">
                <?php echo esc_html($lstPanelField->getLabel()); ?>

                <?php if ($lstPanelField->isRequired()): ?>
                    <span>*</span>
                <?php endif; ?>

                <?php if (!empty($lstPanelField->getField()->getHint())): ?>
                    <div class="listivo-field-hint">
                        <div class="listivo-field-hint__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                                <path d="M6.5 0C2.91592 0 0 2.91592 0 6.5C0 10.0841 2.91592 13 6.5 13C10.0841 13 13 10.0841 13 6.5C13 2.91592 10.0841 0 6.5 0ZM6.5 0.975C9.55715 0.975 12.025 3.44285 12.025 6.5C12.025 9.55715 9.55715 12.025 6.5 12.025C3.44285 12.025 0.975 9.55715 0.975 6.5C0.975 3.44285 3.44285 0.975 6.5 0.975ZM6.5 3.25C6.32761 3.25 6.16228 3.31848 6.04038 3.44038C5.91848 3.56228 5.85 3.72761 5.85 3.9C5.85 4.07239 5.91848 4.23772 6.04038 4.35962C6.16228 4.48152 6.32761 4.55 6.5 4.55C6.67239 4.55 6.83772 4.48152 6.95962 4.35962C7.08152 4.23772 7.15 4.07239 7.15 3.9C7.15 3.72761 7.08152 3.56228 6.95962 3.44038C6.83772 3.31848 6.67239 3.25 6.5 3.25ZM6.49238 5.51802C6.3632 5.52004 6.2401 5.57325 6.15012 5.66596C6.06015 5.75868 6.01065 5.88332 6.0125 6.0125V9.5875C6.01159 9.6521 6.02352 9.71624 6.04761 9.77619C6.0717 9.83613 6.10746 9.89069 6.15282 9.9367C6.19818 9.9827 6.25223 10.0192 6.31183 10.0442C6.37143 10.0691 6.43539 10.0819 6.5 10.0819C6.56461 10.0819 6.62857 10.0691 6.68817 10.0442C6.74777 10.0192 6.80182 9.9827 6.84718 9.9367C6.89254 9.89069 6.9283 9.83613 6.95239 9.77619C6.97648 9.71624 6.98841 9.6521 6.9875 9.5875V6.0125C6.98844 5.94725 6.97626 5.88248 6.9517 5.82202C6.92715 5.76156 6.8907 5.70665 6.84453 5.66054C6.79836 5.61442 6.7434 5.57805 6.68291 5.55357C6.62242 5.52909 6.55763 5.517 6.49238 5.51802Z"
                                      fill="#9CCC65"/>
                            </svg>
                        </div>

                        <div class="listivo-field-hint__text">
                            <?php echo esc_html($lstPanelField->getField()->getHint()); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </h3>

            <div class="listivo-panel-form-label__line"></div>

            <div class="listivo-panel-form-label__icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="12" viewBox="0 0 11 12"
                     fill="none">
                    <path d="M0.195669 7.13805C0.0653349 7.00772 0.00033474 6.83738 0.00033474 6.66671C0.00033474 6.49604 0.0653349 6.32571 0.195669 6.19538C0.456004 5.93504 0.878008 5.93504 1.13834 6.19538L4.66703 9.72407L4.66703 0.666672C4.66703 0.298669 4.9657 0 5.3337 0C5.70171 0 6.00038 0.298669 6.00038 0.666672L6.00038 9.72407L9.52907 6.19538C9.7894 5.93504 10.2114 5.93504 10.4717 6.19538C10.7321 6.45571 10.7321 6.87771 10.4717 7.13805L5.80504 11.8047C5.54471 12.0651 5.1227 12.0651 4.86237 11.8047L0.195669 7.13805Z"
                          fill="#D5E3EE"/>
                </svg>
            </div>
        </div>

        <div class="listivo-upload-area listivo-upload-area--files">
            <lst-dropzone
                    id="<?php echo esc_attr($lstPanelField->getKey()); ?>"
                    :options="<?php echo htmlspecialchars(json_encode($lstPanelField->getDropZoneConfig())); ?>"
                    @vdropzone-sending="attachmentsField.onSending"
                    @vdropzone-thumbnail="attachmentsField.onAddedFile"
                    @vdropzone-success="attachmentsField.onSuccess"
                    @vdropzone-file-added="attachmentsField.onAddedFile"
                    @vdropzone-removed-file="attachmentsField.onRemove"
                    @vdropzone-complete="attachmentsField.onComplete"
                    :use-custom-slot="true"
            >
                <div class="listivo-upload-area__inner">
                    <div class="listivo-upload-area__content">
                        <div class="listivo-upload-area__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="38" height="40" viewBox="0 0 38 40"
                                 fill="none">
                                <path d="M4.28571 0C1.93571 0 0 1.93571 0 4.28571V33.8095C0 36.1595 1.93571 38.0952 4.28571 38.0952H24.2857H26.1905C26.6943 38.0952 27.1705 37.993 27.619 37.833V34.2857H27.5316C27.3345 34.839 26.8105 35.2381 26.1905 35.2381H24.2857H4.28571C3.47952 35.2381 2.85714 34.6157 2.85714 33.8095V4.28571C2.85714 3.47952 3.47952 2.85714 4.28571 2.85714H15.2381V10.9524C15.2381 13.3024 17.1738 15.2381 19.5238 15.2381H27.619V19.5238V23.8579L28.5956 22.8813C29.1089 22.368 29.7781 22.0632 30.4762 21.968V18.5714V13.8095C30.4761 13.4307 30.3256 13.0674 30.0577 12.7995L30.0428 12.7846L17.6767 0.418527C17.4088 0.150618 17.0455 7.28842e-05 16.6667 0H4.28571ZM18.0952 4.87723L25.599 12.381H19.5238C18.7176 12.381 18.0952 11.7586 18.0952 10.9524V4.87723ZM30.9524 23.8095C30.5867 23.8095 30.2214 23.949 29.9423 24.2281L25.1804 28.99C24.6233 29.548 24.6233 30.452 25.1804 31.01C25.7385 31.5681 26.6424 31.5681 27.2005 31.01L29.5238 28.6868V38.5714C29.5238 39.361 30.1629 40 30.9524 40C31.7419 40 32.381 39.361 32.381 38.5714V28.6868L34.7042 31.01C35.2623 31.5681 36.1662 31.5681 36.7243 31.01C37.2824 30.4529 37.2824 29.5471 36.7243 28.99L31.9624 24.2281C31.6843 23.949 31.3181 23.8095 30.9524 23.8095Z"
                                      fill="#D5E3EE"/>
                            </svg>
                        </div>

                        <div class="listivo-upload-area__label listivo-upload-area__label--desktop">
                            <span><?php echo esc_html(tdf_string('choose_files')); ?></span> <?php echo esc_html(tdf_string('or_drag_it_here')); ?>

                        </div>

                        <div class="listivo-upload-area__label listivo-upload-area__label--mobile">
                            <span><?php echo esc_html(tdf_string('choose_files')); ?></span>
                        </div>
                    </div>
                </div>
            </lst-dropzone>

            <template>
                <div
                        class="listivo-upload-area__bottom"
                        @click.prevent="attachmentsField.onOpen"
                >
                    <div>
                        {{ attachmentsField.value.length
                        }} / <?php echo esc_html($lstAttachmentsField->getMaxFileNumber()); ?>
                    </div>

                    <div
                            v-if="attachmentsField.value.length < <?php echo esc_attr($lstAttachmentsField->getMaxFileNumber()); ?> && attachmentsField.value.length > 0"
                            class="listivo-upload-area__add-more"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="20" viewBox="0 0 19 20" fill="none">
                            <path d="M2.14286 0C0.967857 0 0 0.967857 0 2.14286V16.9048C0 18.0798 0.967857 19.0476 2.14286 19.0476H12.1429H13.0952C13.3471 19.0476 13.5852 18.9965 13.8095 18.9165V17.1429H13.7658C13.6672 17.4195 13.4052 17.619 13.0952 17.619H12.1429H2.14286C1.73976 17.619 1.42857 17.3079 1.42857 16.9048V2.14286C1.42857 1.73976 1.73976 1.42857 2.14286 1.42857H7.61905V5.47619C7.61905 6.65119 8.5869 7.61905 9.76191 7.61905H13.8095V9.7619V11.9289L14.2978 11.4407C14.5545 11.184 14.889 11.0316 15.2381 10.984V9.28571V6.90476C15.2381 6.71533 15.1628 6.53368 15.0288 6.39974L15.0214 6.3923L8.83836 0.209263C8.70442 0.0753089 8.52276 3.64421e-05 8.33333 0H2.14286ZM9.04762 2.43862L12.7995 6.19048H9.76191C9.35881 6.19048 9.04762 5.87929 9.04762 5.47619V2.43862ZM15.4762 11.9048C15.2933 11.9048 15.1107 11.9745 14.9712 12.114L12.5902 14.495C12.3116 14.774 12.3116 15.226 12.5902 15.505C12.8693 15.7841 13.3212 15.7841 13.6003 15.505L14.7619 14.3434V19.2857C14.7619 19.6805 15.0814 20 15.4762 20C15.871 20 16.1905 19.6805 16.1905 19.2857V14.3434L17.3521 15.505C17.6312 15.7841 18.0831 15.7841 18.3622 15.505C18.6412 15.2265 18.6412 14.7735 18.3622 14.495L15.9812 12.114C15.8422 11.9745 15.659 11.9048 15.4762 11.9048Z"
                                  fill="#D5E3EE"/>
                        </svg> <?php echo esc_attr(tdf_string('add_more_attachments')); ?>
                    </div>
                </div>
            </template>
        </div>
    </div>
</lst-attachments-model-field>