<?php

use Tangibledesign\Framework\Models\Field\TaxonomyField;

/* @var TaxonomyField $field */
global $field;
?>
<tr>
    <th scope="row">
        <label for="<?php echo esc_attr(TaxonomyField::MULTILEVEL); ?>">
            <?php esc_html_e('Multilevel', 'listivo-core'); ?>
        </label>
    </th>

    <td>
        <label for="<?php echo esc_attr(TaxonomyField::MULTILEVEL); ?>">
            <input
                    name="<?php echo esc_attr(TaxonomyField::MULTILEVEL); ?>"
                    id="<?php echo esc_attr(TaxonomyField::MULTILEVEL); ?>"
                    type="checkbox"
                    value="1"
                <?php if ($field->isMultilevel()) : ?>
                    checked
                <?php endif; ?>
            >

            <?php esc_html_e('Allows you to create a multi-level hierarchy of terms.', 'listivo-core'); ?>
        </label>
    </td>
</tr>

<?php if ($field->isMultilevel()) : ?>
    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(TaxonomyField::MULTILEVEL_FRONTEND_PANEL_MULTIPLE_VALUES); ?>">
                <?php esc_html_e('Multiple Values on Frontend Panel (with Multilevel)', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(TaxonomyField::MULTILEVEL_FRONTEND_PANEL_MULTIPLE_VALUES); ?>">
                <input
                        name="<?php echo esc_attr(TaxonomyField::MULTILEVEL_FRONTEND_PANEL_MULTIPLE_VALUES); ?>"
                        id="<?php echo esc_attr(TaxonomyField::MULTILEVEL_FRONTEND_PANEL_MULTIPLE_VALUES); ?>"
                        type="checkbox"
                        value="1"
                    <?php if ($field->multilevelFrontendPanelMultipleValues()) : ?>
                        checked
                    <?php endif; ?>
                >

                <?php esc_html_e('Allows you to select multiple values for the multilevel taxonomy on the frontend panel.', 'listivo-core'); ?>
            </label>
        </td>
    </tr>
<?php endif; ?>

<tr>
    <th scope="row">
        <label for="<?php echo esc_attr(TaxonomyField::SEARCH_LOGIC); ?>">
            <?php esc_html_e('Search Logic', 'listivo-core'); ?>
        </label>
    </th>

    <td>
        <select
                name="<?php echo esc_attr(TaxonomyField::SEARCH_LOGIC); ?>"
                id="<?php echo esc_attr(TaxonomyField::SEARCH_LOGIC); ?>"
                class="tdf-selectize-init"
            <?php if ($field->isMultilevel()) : ?>
                disabled
            <?php endif; ?>
        >
            <option
                    value="<?php echo esc_attr(TaxonomyField::SEARCH_LOGIC_AND); ?>"
                <?php if ($field->getSearchLogic() === TaxonomyField::SEARCH_LOGIC_AND) : ?>
                    selected
                <?php endif; ?>
            >
                <?php esc_html_e('AND', 'listivo-core'); ?>
            </option>

            <option
                    value="<?php echo esc_attr(TaxonomyField::SEARCH_LOGIC_OR); ?>"
                <?php if ($field->getSearchLogic() === TaxonomyField::SEARCH_LOGIC_OR) : ?>
                    selected
                <?php endif; ?>
            >
                <?php esc_html_e('OR', 'listivo-core'); ?>
            </option>
        </select>

        <?php if ($field->isMultilevel()) : ?>
            <p class="description">
                <?php esc_html_e('Always "and" for multilevel taxonomy.', 'listivo-core'); ?>
            </p>
        <?php endif; ?>
    </td>
</tr>

<tr>
    <th scope="row">
        <label for="<?php echo esc_attr(TaxonomyField::MULTIPLE_VALUES); ?>">
            <?php esc_html_e('Allow Multiple Values', 'listivo-core'); ?>
        </label>
    </th>

    <td>
        <label for="<?php echo esc_attr(TaxonomyField::MULTIPLE_VALUES); ?>">
            <input
                    name="<?php echo esc_attr(TaxonomyField::MULTIPLE_VALUES); ?>"
                    id="<?php echo esc_attr(TaxonomyField::MULTIPLE_VALUES); ?>"
                    type="checkbox"
                    value="1"
                <?php if ($field->isMultilevel()) : ?>
                    disabled
                <?php endif; ?>
                <?php if ($field->multipleValues()) : ?>
                    checked
                <?php endif; ?>
            >

            <?php if ($field->isMultilevel()) : ?>

                <?php esc_html_e('Always enabled for multilevel taxonomy.', 'listivo-core'); ?>
            <?php endif; ?>
        </label>
    </td>
</tr>

<tr>
    <th scope="row">
        <label for="<?php echo esc_attr(TaxonomyField::FIELD_DEPENDENCY); ?>">
            <?php esc_html_e('Field dependency', 'listivo-core'); ?>
        </label>
    </th>

    <td>
        <label for="<?php echo esc_attr(TaxonomyField::FIELD_DEPENDENCY); ?>">
            <input
                    name="<?php echo esc_attr(TaxonomyField::FIELD_DEPENDENCY); ?>"
                    id="<?php echo esc_attr(TaxonomyField::FIELD_DEPENDENCY); ?>"
                    type="checkbox"
                    value="1"
                <?php if ($field->fieldDependency()) : ?>
                    checked
                <?php endif; ?>
            >

            <p class="description listivo-backend-description">
                <?php esc_html_e('It allows you to show and hide specific fields on the search form and the form for adding an ad, depending on the selected terms of this taxonomy.',
                    'listivo-core'); ?>
            </p>
        </label>
    </td>
</tr>

<?php
if ($field->fieldDependency()) :
    tdf_load_view('dashboard/fields/partials/field_dependency', compact('field'));
endif;
?>

<tr>
    <th scope="row">
        <label for="<?php echo esc_attr(TaxonomyField::SHOW_FIELD_DEPENDENCY_ON_TERM_PAGE); ?>">
            <?php esc_html_e('Display Field Dependency on Term Pages', 'listivo-core'); ?>
        </label>
    </th>

    <td>
        <label for="<?php echo esc_attr(TaxonomyField::SHOW_FIELD_DEPENDENCY_ON_TERM_PAGE); ?>">
            <input
                    name="<?php echo esc_attr(TaxonomyField::SHOW_FIELD_DEPENDENCY_ON_TERM_PAGE); ?>"
                    id="<?php echo esc_attr(TaxonomyField::SHOW_FIELD_DEPENDENCY_ON_TERM_PAGE); ?>"
                    type="checkbox"
                    value="1"
                <?php if ($field->showFieldDependencyOnTermPage()) : ?>
                    checked
                <?php endif; ?>
            >

            <p class="description listivo-backend-description">
                <?php esc_html_e('Enable this option to show field dependency options on the create/edit term page. This will allow you to configure and manage field relationships more easily when creating or editing terms.',
                    'listivo-core'); ?>
            </p>
        </label>
    </td>
</tr>

<tr>
    <th scope="row">
        <label for="<?php echo esc_attr(TaxonomyField::PARENT_TAXONOMY_FIELDS); ?>">
            <?php esc_html_e('Parent taxonomies', 'listivo-core'); ?>
        </label>
    </th>

    <td>
        <select
                name="<?php echo esc_attr(TaxonomyField::PARENT_TAXONOMY_FIELDS); ?>[]"
                id="<?php echo esc_attr(TaxonomyField::PARENT_TAXONOMY_FIELDS); ?>"
                class="tdf-selectize-init"
                placeholder="<?php esc_attr_e('Not set', 'listivo-core'); ?>"
                multiple
        >
            <option value="0">
                <?php esc_html_e('Not set', 'listivo-core'); ?>
            </option>

            <?php foreach (tdf_taxonomy_fields() as $taxonomyField) :
                /* @var TaxonomyField $taxonomyField */
                if ($taxonomyField->getId() === $field->getId()) {
                    continue;
                }
                ?>
                <option
                        value="<?php echo esc_attr($taxonomyField->getId()); ?>"
                    <?php if (in_array($taxonomyField->getId(), $field->getParentTaxonomyFieldIds(), true)) : ?>
                        selected
                    <?php endif; ?>
                >
                    <?php echo esc_html($taxonomyField->getName()); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </td>
</tr>

<tr>
    <th scope="row">
        <label for="<?php echo esc_attr(TaxonomyField::STRICT_PARENT_TAXONOMY_FIELDS); ?>">
            <?php esc_html_e('Strict Parent Filtering (Frontend Panel Form)', 'listivo-core'); ?>
        </label>
    </th>

    <td>
        <select
                name="<?php echo esc_attr(TaxonomyField::STRICT_PARENT_TAXONOMY_FIELDS); ?>"
                id="<?php echo esc_attr(TaxonomyField::STRICT_PARENT_TAXONOMY_FIELDS); ?>"
                class="tdf-selectize-init"
                placeholder="<?php esc_attr_e('All terms', 'listivo-core'); ?>"
        >
            <option
                    value="disabled"
                <?php if ($field->getStrictParentTaxonomyFieldsMode() === 'disabled') : ?>
                    selected
                <?php endif; ?>
            >
                <?php esc_html_e('Disabled', 'listivo-core'); ?>
            </option>

            <option
                    value="atLeastOneValueFromEachParent"
                <?php if ($field->getStrictParentTaxonomyFieldsMode() === 'atLeastOneValueFromEachParent') : ?>
                    selected
                <?php endif; ?>
            >
                <?php esc_html_e('At Least One Value from Each Parent', 'listivo-core'); ?>
            </option>

            <option
                    value="allParentValuesSelected"
                <?php if ($field->getStrictParentTaxonomyFieldsMode() === 'allParentValuesSelected') : ?>
                    selected
                <?php endif; ?>
            >
                <?php esc_html_e('All Parent Values Selected', 'listivo-core'); ?>
            </option>
        </select>

        <p class="description listivo-backend-description">
            <?php esc_html_e('Choose the filtering mode for child field values based on the parent field selections.',
                'listivo-core'); ?>
        </p>
    </td>
</tr>

<tr>
    <th scope="row">
        <label for="<?php echo esc_attr(TaxonomyField::FRONTEND_PANEL_OPTIONS); ?>">
            <?php esc_html_e('Options visible on the frontend panel', 'listivo-core'); ?>
        </label>
    </th>

    <td>
        <select
                name="<?php echo esc_attr(TaxonomyField::FRONTEND_PANEL_OPTIONS); ?>[]"
                id="<?php echo esc_attr(TaxonomyField::FRONTEND_PANEL_OPTIONS); ?>"
                class="tdf-selectize-init"
                placeholder="<?php esc_attr_e('All terms', 'listivo-core'); ?>"
                multiple
        >
            <?php foreach ($field->getFrontendPanelOptions() as $term) : ?>
                <option
                        value="<?php echo esc_attr($term->getId()); ?>"
                        selected
                >
                    <?php echo esc_html($term->getName()); ?>
                </option>
            <?php endforeach; ?>

            <?php foreach ($field->getTerms() as $term) :if (!$field->isFrontendPanelOption($term->getId())) : ?>
                <option value="<?php echo esc_attr($term->getId()); ?>">
                    <?php echo esc_html($term->getName()); ?>
                </option>
            <?php endif;endforeach; ?>
        </select>
    </td>
</tr>

<tr>
    <th scope="row">
        <label for="<?php echo esc_attr(TaxonomyField::DISABLE_TERMS_LAZY_LOADING); ?>">
            <?php esc_html_e('Disable Terms Lazy Loading', 'listivo-core'); ?>
        </label>
    </th>

    <td>
        <label for="<?php echo esc_attr(TaxonomyField::DISABLE_TERMS_LAZY_LOADING); ?>">
            <input
                    name="<?php echo esc_attr(TaxonomyField::DISABLE_TERMS_LAZY_LOADING); ?>"
                    id="<?php echo esc_attr(TaxonomyField::DISABLE_TERMS_LAZY_LOADING); ?>"
                    type="checkbox"
                    value="1"
                <?php if ($field->isTermsLazyLoadingDisabled()) : ?>
                    checked
                <?php endif; ?>
            >

            <p class="description listivo-backend-description">
                <?php esc_html_e('Don\'t use lazy loading for terms when the field has parent fields. It can be useful if you have a lot of terms and you want to display them all.',
                    'listivo-core'); ?>
            </p>
        </label>
    </td>
</tr>