<?php
/* @var \Tangibledesign\Framework\Models\PanelFields\RichTextPanelField $lstPanelField */
global $lstPanelField;
/* @var \Tangibledesign\Framework\Models\Field\RichTextField $lstRichTextField */
$lstRichTextField = $lstPanelField->getField();
?>
<lst-rich-text-model-field
        class="listivo-panel-form__single-column"
        :model="modelForm.model"
        :field="<?php echo htmlspecialchars(json_encode($lstPanelField->getField())); ?>"
        :is-required="<?php echo esc_attr($lstPanelField->isRequired() ? 'true' : 'false'); ?>"
        prefix="listivo"
        :dependency-terms="modelForm.dependencyTerms"
        :selected-term-ids="modelForm.taxonomyFieldsValueIds"
        :simple-editor="<?php echo esc_attr($lstRichTextField->isSimpleEditorEnabled() ? 'true' : 'false'); ?>"
>
    <div
            slot-scope="field"
            v-show="field.isVisible"
            class="listivo-panel-form__single-column <?php echo esc_attr($lstPanelField->getKey()); ?>"
            :class="{'listivo-has-error': modelForm.showErrors && field.hasError}"
    >
        <div class="listivo-panel-form-label listivo-panel-form-label--margin-bottom listivo-panel-form-label--small-margin-top">
            <h3 class="listivo-panel-form-label__text">
                <?php echo esc_html($lstRichTextField->getName()); ?>

                <?php if ($lstPanelField->isRequired()) : ?>
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

        <?php if ($lstRichTextField->isSimpleEditorEnabled()) : ?>
            <div class="listivo-panel-form__textarea">
                <textarea
                        cols="30"
                        rows="10"
                        :value="field.value"
                        @input="field.setValue($event.target.value)"
                ></textarea>
            </div>
        <?php else : ?>
            <?php wp_editor('', 'listivo_' . $lstRichTextField->getId(), $lstPanelField->getEditorConfig()); ?>
        <?php endif; ?>
    </div>
</lst-rich-text-model-field>