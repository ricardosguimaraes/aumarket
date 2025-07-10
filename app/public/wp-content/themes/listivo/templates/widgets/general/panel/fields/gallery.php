<?php
/* @var \Tangibledesign\Listivo\Widgets\General\PanelWidget $lstCurrentWidget */
/* @var \Tangibledesign\Framework\Models\PanelFields\GalleryPanelField $lstPanelField */
global $lstCurrentWidget, $lstPanelField;
/* @var \Tangibledesign\Framework\Models\Field\GalleryField $lstGalleryField */
$lstGalleryField = $lstPanelField->getField();
?>
<lst-gallery-model-field
        class="listivo-panel-form__single-column <?php echo esc_attr($lstPanelField->getKey()); ?>"
        :model="modelForm.model"
        :field="<?php echo htmlspecialchars(json_encode($lstGalleryField)); ?>"
        td-nonce="<?php echo esc_attr(wp_create_nonce('listivo_upload_image')); ?>"
        request-url="<?php echo esc_url(tdf_action_url('listivo/images/info')); ?>"
        :dependency-terms="modelForm.dependencyTerms"
        :selected-term-ids="modelForm.taxonomyFieldsValueIds"
>
    <div
            slot-scope="field"
            v-if="field.isVisible"
            class="listivo-panel-form__single-column"
            :class="{'listivo-has-error': modelForm.showErrors && field.hasError}"
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

        <div class="listivo-upload-area">
            <lst-dropzone
                    id="<?php echo esc_attr($lstPanelField->getKey()); ?>"
                    :options="<?php echo htmlspecialchars(json_encode($lstPanelField->getDropZoneConfig())); ?>"
                    @vdropzone-sending="field.onSending"
                    @vdropzone-success="field.onSuccess"
                    @vdropzone-removed-file="field.onRemove"
                    @vdropzone-complete="field.onComplete"
                    :use-custom-slot="true"
            >
                <div class="listivo-upload-area__inner">
                    <div class="listivo-upload-area__content">
                        <div class="listivo-upload-area__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="40" viewBox="0 0 32 40"
                                 fill="none">
                                <path d="M4.5 0C2.0325 0 0 2.0325 0 4.5V35.5C0 37.9675 2.0325 40 4.5 40H27.5C29.9675 40 32 37.9675 32 35.5V14.5C31.9999 14.1022 31.8419 13.7207 31.5605 13.4395L31.5449 13.4238L18.5605 0.439453C18.2793 0.158149 17.8978 7.65285e-05 17.5 0H4.5ZM4.5 3H16V11.5C16 13.9675 18.0325 16 20.5 16H29V35.5C29 35.8965 28.8527 36.2472 28.6133 36.5117L18.8359 27.1406C18.0485 26.3868 17.0224 26.0097 15.998 26.0098C14.9737 26.0098 13.9512 26.3864 13.1641 27.1406L3.38477 36.5117C3.14581 36.2473 3 35.8961 3 35.5V4.5C3 3.6535 3.6535 3 4.5 3ZM19 5.12109L26.8789 13H20.5C19.6535 13 19 12.3465 19 11.5V5.12109ZM21.5 19C20.119 19 19 20.119 19 21.5C19 22.881 20.119 24 21.5 24C22.881 24 24 22.881 24 21.5C24 20.119 22.881 19 21.5 19ZM16 28.9922C16.2717 28.9921 16.5432 29.0974 16.7617 29.3066L24.7891 37H7.21094L15.2383 29.3066C15.4562 29.0978 15.7283 28.9923 16 28.9922Z"
                                      fill="#D5E3EE"/>
                            </svg>
                        </div>

                        <div class="listivo-upload-area__label listivo-upload-area__label--desktop">
                            <span><?php echo esc_html(tdf_string('choose_images')); ?></span> <?php echo esc_html(tdf_string('or_drag_it_here')); ?>
                        </div>

                        <div class="listivo-upload-area__label listivo-upload-area__label--mobile">
                            <span><?php echo esc_html(tdf_string('choose_images')); ?></span>
                        </div>
                    </div>
                </div>
            </lst-dropzone>

            <template>
                <div
                        class="listivo-upload-area__bottom"
                        @click.prevent="field.onOpen"
                >
                    <div>
                        {{ field.value.length
                        }} / <?php echo esc_html($lstGalleryField->getMaxImageNumber()); ?>
                    </div>

                    <div
                            v-if="field.value.length < <?php echo esc_attr($lstGalleryField->getMaxImageNumber()); ?> && field.value.length > 0"
                            class="listivo-upload-area__add-more"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="20" viewBox="0 0 16 20" fill="none">
                            <path d="M2.25 0C1.01625 0 0 1.01625 0 2.25V17.75C0 18.9838 1.01625 20 2.25 20H13.75C14.9838 20 16 18.9838 16 17.75V7.25C16 7.0511 15.9209 6.86036 15.7803 6.71973L15.7725 6.71191L9.28027 0.219727C9.13964 0.0790744 8.9489 3.82642e-05 8.75 0H2.25ZM2.25 1.5H8V5.75C8 6.98375 9.01625 8 10.25 8H14.5V17.75C14.5 17.9483 14.4264 18.1236 14.3066 18.2559L9.41797 13.5703C9.02425 13.1934 8.51121 13.0049 7.99902 13.0049C7.48684 13.0049 6.97558 13.1932 6.58203 13.5703L1.69238 18.2559C1.57291 18.1237 1.5 17.948 1.5 17.75V2.25C1.5 1.82675 1.82675 1.5 2.25 1.5ZM9.5 2.56055L13.4395 6.5H10.25C9.82675 6.5 9.5 6.17325 9.5 5.75V2.56055ZM10.75 9.5C10.0595 9.5 9.5 10.0595 9.5 10.75C9.5 11.4405 10.0595 12 10.75 12C11.4405 12 12 11.4405 12 10.75C12 10.0595 11.4405 9.5 10.75 9.5ZM8 14.4961C8.13587 14.496 8.27158 14.5487 8.38086 14.6533L12.3945 18.5H3.60547L7.61914 14.6533C7.72809 14.5489 7.86413 14.4961 8 14.4961Z"
                                  fill="#D5E3EE"/>
                        </svg> <?php echo esc_attr(tdf_string('add_more_images')); ?>
                    </div>
                </div>
            </template>
        </div>
    </div>
</lst-gallery-model-field>