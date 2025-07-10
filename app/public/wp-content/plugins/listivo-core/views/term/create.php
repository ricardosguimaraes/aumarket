<?php

use Tangibledesign\Framework\Models\Template\ModelSingleTemplate;
use Tangibledesign\Framework\Models\Term\CustomTerm;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Queries\QueryTerms;

/* @var TaxonomyField $lstTaxonomyField */
global $lstTaxonomyField;
?>
    <input
            type="hidden"
            name="nonce"
            value="<?php echo esc_attr(wp_create_nonce('tdf/term/update')); ?>"
    >
<?php
if (in_array($lstTaxonomyField->getId(), tdf_settings()->getListingCardLabel(), true)):?>
    <div>
        <label for="<?php echo esc_attr(CustomTerm::CARD_HIDE); ?>">
            <?php esc_html_e('Do not show as card label', 'listivo-core'); ?>
        </label>

        <input
                id="<?php echo esc_attr(CustomTerm::CARD_HIDE); ?>"
                name="<?php echo esc_attr(CustomTerm::CARD_HIDE); ?>"
                type="checkbox"
                value="1"
        >
    </div>

    <div class="tdf-app">
        <template>
            <div>
                <?php esc_html_e('Card Label Text Color', 'listivo-core'); ?>
            </div>

            <div class="tdf-colors">
                <div class="tdf-color-picker-wrapper">
                    <lst-set-color
                            type="labelColor"
                            initial-color=""
                            picker-class="tdf-color-picker"
                    >
                        <div slot-scope="props">
                            <div
                                    @click="props.onShowPicker"
                                    class="tdf-color-picker-circle"
                                    :style="{'background-color': props.currentColor}"
                            ></div>

                            <div
                                    v-if="props.showPicker"
                                    @click.prevent
                                    class="tdf-color-picker"
                            >
                                <lst-chrome-picker
                                        :disable-alpha="true"
                                        :value="props.currentColor"
                                        @input="props.setCurrentColor"
                                ></lst-chrome-picker>

                                <div class="tdf-color-picker__buttons">
                                    <div class="tdf-color-picker__buttons-inner">
                                        <button class="tdf-button-add" @click.prevent="props.onSave">
                                            <?php esc_html_e('Apply', 'listivo-core'); ?>
                                        </button>

                                        <button class="tdf-button-cancel" @click.prevent="props.onCancel">
                                            <?php esc_html_e('Cancel', 'listivo-core'); ?>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <input
                                    name="<?php echo esc_attr(CustomTerm::LABEL_COLOR); ?>"
                                    :value="props.color"
                                    type="hidden"
                            >
                        </div>
                    </lst-set-color>
                </div>
            </div>

            <div>
                <?php esc_html_e('Card Label Background Color', 'listivo-core'); ?>
            </div>

            <div class="tdf-colors">
                <div class="tdf-color-picker-wrapper">
                    <lst-set-color
                            type="labelBg"
                            initial-color=""
                            picker-class="tdf-color-picker"
                    >
                        <div slot-scope="props">
                            <div
                                    @click="props.onShowPicker"
                                    class="tdf-color-picker-circle"
                                    :style="{'background-color': props.currentColor}"
                            ></div>

                            <div
                                    v-if="props.showPicker"
                                    @click.prevent
                                    class="tdf-color-picker"
                            >
                                <lst-chrome-picker
                                        :disable-alpha="true"
                                        :value="props.currentColor"
                                        @input="props.setCurrentColor"
                                ></lst-chrome-picker>

                                <div class="tdf-color-picker__buttons">
                                    <div class="tdf-color-picker__buttons-inner">
                                        <button class="tdf-button-add" @click.prevent="props.onSave">
                                            <?php esc_html_e('Apply', 'listivo-core'); ?>
                                        </button>

                                        <button class="tdf-button-cancel" @click.prevent="props.onCancel">
                                            <?php esc_html_e('Cancel', 'listivo-core'); ?>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <input
                                    name="<?php echo esc_attr(CustomTerm::LABEL_BG_COLOR); ?>"
                                    :value="props.color"
                                    type="hidden"
                            >
                        </div>
                    </lst-set-color>
                </div>
            </div>
        </template>
    </div>
<?php
endif;

if ($lstTaxonomyField->isMultilevel()) :?>
    <div>
        <label for="<?php echo esc_attr(CustomTerm::SEARCH_FORM_PLACEHOLDER); ?>">
            <?php esc_html_e('Search Form Placeholder', 'listivo-core'); ?>
        </label>

        <input
                id="<?php echo esc_attr(CustomTerm::SEARCH_FORM_PLACEHOLDER); ?>"
                name="<?php echo esc_attr(CustomTerm::SEARCH_FORM_PLACEHOLDER); ?>"
                type="text"
        >
    </div>
<?php endif; ?>
    <div>
        <label for="<?php echo esc_attr(CustomTerm::CUSTOM_MODEL_TEMPLATE); ?>">
            <?php esc_html_e('Custom Listing Template', 'listivo-core'); ?>
        </label>

        <select
                name="<?php echo esc_attr(CustomTerm::CUSTOM_MODEL_TEMPLATE); ?>"
                id="<?php echo esc_attr(CustomTerm::CUSTOM_MODEL_TEMPLATE); ?>"
                class="tdf-selectize tdf-selectize-init"
                placeholder="<?php esc_attr_e('Not set', 'listivo-core'); ?>"
        >
            <option value="0">
                <?php esc_html_e('Not Set', 'listivo-core'); ?>
            </option>

            <?php foreach (tdf_app('templates') as $lstTemplate) :
                if (!$lstTemplate instanceof ModelSingleTemplate) {
                    continue;
                }
                ?>
                <option value="<?php echo esc_attr($lstTemplate->getId()); ?>">
                    <?php echo esc_html($lstTemplate->getName()); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
<?php foreach ($lstTaxonomyField->getParentTaxonomyFields() as $lstParentTaxonomyField) : ?>
    <div>
        <label for="<?php echo esc_attr(CustomTerm::PARENT_TERMS); ?>">
            <?php echo sprintf(esc_html__('Parent %s', 'listivo-core'), $lstParentTaxonomyField->getName()); ?>
        </label>

        <select
                name="<?php echo esc_attr(CustomTerm::PARENT_TERMS); ?>[]"
                id="<?php echo esc_attr(CustomTerm::PARENT_TERMS); ?>"
                class="tdf-selectize tdf-selectize-init"
                placeholder="<?php esc_attr_e('Not set', 'listivo-core'); ?>"
                multiple
        >
            <?php foreach (tdf_query_terms()->setTaxonomy($lstParentTaxonomyField->getKey())->get() as $term) :
                /* @var CustomTerm $term */
                ?>
                <option value="<?php echo esc_attr($term->getId()); ?>">
                    <?php echo esc_html($term->getName()); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
<?php
endforeach;

if ($lstTaxonomyField->fieldDependency()) : ?>
    <div
        <?php if (!$lstTaxonomyField->showFieldDependencyOnTermPage()) : ?>
            style="display: none;"
        <?php endif; ?>
    >
        <?php foreach (tdf_fields() as $lstField) :
            if ($lstField->getId() === $lstTaxonomyField->getId()) {
                continue;
            }
            ?>
            <div>
                <label for="<?php echo esc_attr(CustomTerm::FIELD_DEPENDENCIES); ?>_<?php echo esc_attr($lstField->getKey()); ?>">
                    <?php echo esc_html($lstField->getName()); ?>
                </label>

                <div>
                    <input
                            id="<?php echo esc_attr(CustomTerm::FIELD_DEPENDENCIES); ?>_<?php echo esc_attr($lstField->getKey()); ?>"
                            name="<?php echo esc_attr(CustomTerm::FIELD_DEPENDENCIES); ?>[]"
                            type="checkbox"
                            value="<?php echo esc_attr($lstField->getId()); ?>"
                    >
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php
endif;