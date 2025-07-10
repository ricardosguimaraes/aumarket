<?php

use Tangibledesign\Framework\Models\Template\ModelSingleTemplate;
use Tangibledesign\Framework\Models\Term\CustomTerm;
use Tangibledesign\Framework\Models\Field\TaxonomyField;

/* @var TaxonomyField $lstTaxonomyField */
/* @var CustomTerm $lstTerm */
global $lstTaxonomyField, $lstTerm;
?>
    <input
            type="hidden"
            name="nonce"
            value="<?php echo esc_attr(wp_create_nonce('tdf/term/update')); ?>"
    >
<?php
if (in_array($lstTaxonomyField->getId(), tdf_app('card_label_fields_ids'), true)): ?>
    <tr class="form-field">
        <th>
            <label for="<?php echo esc_attr(CustomTerm::CARD_HIDE); ?>">
                <?php esc_html_e('Do not show as card label', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(CustomTerm::CARD_HIDE); ?>"
                    name="<?php echo esc_attr(CustomTerm::CARD_HIDE); ?>"
                    type="checkbox"
                    value="1"
                <?php if (!$lstTerm->showLabel()) : ?>
                    checked
                <?php endif; ?>
            >
        </td>
    </tr>

    <tr class="form-field tdf-app">
        <th>
            <label for="<?php echo esc_attr(CustomTerm::LABEL_COLOR); ?>">
                <?php esc_html_e('Card Label Text Color', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <div class="tdf-colors">
                <div class="tdf-color-picker-wrapper">
                    <lst-set-color
                            type="labelColor"
                            initial-color="<?php echo esc_attr($lstTerm->getLabelColor()); ?>"
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
        </td>
    </tr>

    <tr class="form-field tdf-app">
        <th>
            <label for="<?php echo esc_attr(CustomTerm::LABEL_BG_COLOR); ?>">
                <?php esc_html_e('Card Label Background Color', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <div class="tdf-colors">
                <div class="tdf-color-picker-wrapper">
                    <lst-set-color
                            type="labelColor"
                            initial-color="<?php echo esc_attr($lstTerm->getLabelBgColor()); ?>"
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
        </td>
    </tr>
<?php
endif;

if ($lstTaxonomyField->isMultilevel()) :?>
    <tr class="form-field">
        <th scope="row">
            <label for="<?php echo esc_attr(CustomTerm::SEARCH_FORM_PLACEHOLDER); ?>">
                <?php esc_html_e('Search Form Placeholder', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(CustomTerm::SEARCH_FORM_PLACEHOLDER); ?>"
                    name="<?php echo esc_attr(CustomTerm::SEARCH_FORM_PLACEHOLDER); ?>"
                    value="<?php echo esc_attr($lstTerm->getSearchFormPlaceholder()); ?>"
                    type="text"
            >
        </td>
    </tr>
<?php
endif;

foreach ($lstTaxonomyField->getParentTaxonomyFields() as $lstParentTaxonomyField) :?>
    <tr class="form-field">
        <th scope="row">
            <label for="<?php echo esc_attr(CustomTerm::PARENT_TERMS); ?>">
                <?php echo sprintf(esc_html__('Parent %s', 'listivo-core'), $lstParentTaxonomyField->getName()); ?>
            </label>
        </th>

        <td>
            <select
                    name="<?php echo esc_attr(CustomTerm::PARENT_TERMS); ?>[]"
                    id="<?php echo esc_attr(CustomTerm::PARENT_TERMS); ?>"
                    class="tdf-selectize tdf-selectize-init"
                    placeholder="<?php esc_attr_e('Not set', 'listivo-core'); ?>"
                    multiple
            >
                <?php foreach (tdf_query_terms($lstParentTaxonomyField->getKey())->get() as $lstParentTaxonomyTerm) :
                    /* @var CustomTerm $lstParentTaxonomyTerm */
                    ?>
                    <option
                            value="<?php echo esc_attr($lstParentTaxonomyTerm->getId()); ?>"
                        <?php if (in_array($lstParentTaxonomyTerm->getId(), $lstTerm->getParentTermIds(), true)) : ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php echo esc_html($lstParentTaxonomyTerm->getName()); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </td>
    </tr>
<?php endforeach; ?>

    <tr class="form-field">
        <th scope="row">
            <label for="<?php echo esc_attr(CustomTerm::CUSTOM_MODEL_TEMPLATE); ?>">
                <?php esc_html_e('Custom Listing Template', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <select
                    name="<?php echo esc_attr(CustomTerm::CUSTOM_MODEL_TEMPLATE); ?>"
                    id="<?php echo esc_attr(CustomTerm::CUSTOM_MODEL_TEMPLATE); ?>"
                    class="tdf-selectize tdf-selectize-init"
            >
                <option value="0">
                    <?php esc_html_e('Not Set', 'listivo-core'); ?>
                </option>

                <?php foreach (tdf_app('templates') as $lstTemplate) :
                    if (!$lstTemplate instanceof ModelSingleTemplate) {
                        continue;
                    }
                    ?>
                    <option
                            value="<?php echo esc_attr($lstTemplate->getId()); ?>"
                        <?php if ($lstTerm->getCustomTemplateId() === $lstTemplate->getId()) : ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php echo esc_html($lstTemplate->getName()); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </td>
    </tr>

<?php if ($lstTaxonomyField->fieldDependency()) : ?>
    <?php foreach (tdf_fields() as $lstField) :
        if ($lstField->getId() === $lstTaxonomyField->getId()) {
            continue;
        }
        ?>
        <tr
                class="form-field"
            <?php if (!$lstTaxonomyField->showFieldDependencyOnTermPage()) : ?>
                style="display: none;"
            <?php endif; ?>
        >
            <th scope="row">
                <label for="<?php echo esc_attr(CustomTerm::FIELD_DEPENDENCIES); ?>_<?php echo esc_attr($lstField->getKey()); ?>">
                    <?php echo esc_html($lstField->getName()); ?>
                </label>
            </th>

            <td>
                <input
                        id="<?php echo esc_attr(CustomTerm::FIELD_DEPENDENCIES); ?>_<?php echo esc_attr($lstField->getKey()); ?>"
                        name="<?php echo esc_attr(CustomTerm::FIELD_DEPENDENCIES); ?>[]"
                        type="checkbox"
                        value="<?php echo esc_attr($lstField->getId()); ?>"
                    <?php if (in_array($lstField->getId(), $lstTerm->getFieldDependencies(), true)) : ?>
                        checked
                    <?php endif; ?>
                >
            </td>
        </tr>
    <?php endforeach; ?>
<?php
endif;

