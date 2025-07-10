<?php

use Tangibledesign\Framework\Actions\Field\CheckFieldVisibilityAction;
use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Term\CustomTerm;

$fieldId = isset($_POST['field_id']) ? (int)$_POST['field_id'] : 0;
if (!empty($fieldId)) {
    $fieldVisibilityDetails = (new CheckFieldVisibilityAction())->execute($fieldId);
} else {
    $fieldVisibilityDetails = false;
}
?>
<div class="tdf-app">
    <div class="wrap">
        <h1 class="wp-heading-inline">
            <?php

            esc_html_e('Custom Fields', 'listivo-core'); ?>
        </h1>

        <a
                class="page-title-action"
                href="<?php echo esc_url(admin_url('admin.php?page=listivo-add-new-field')); ?>"
        >
            <?php esc_html_e('Add New Field', 'listivo-core'); ?>
        </a>

        <div class="listivo-backend-content listivo-backend-content--no-padding-bottom">
            <a
                    class="button button-primary button-hero"
                    href="https://support.listivotheme.com/support/solutions/folders/101000235973"
                    target="_blank"
            >
                <?php esc_html_e('Learn more about custom fields'); ?>
            </a>
        </div>

        <?php tdf_load_view('dashboard/fields/list'); ?>
    </div>

    <div class="listivo-margin-top-1">
        <h2><?php esc_html_e('Check Field Visibility', 'listivo-core'); ?></h2>

        <form action="<?php echo esc_url($_SERVER['REQUEST_URI']) ?>" method="post">
            <div style="display: flex; gap: 10px;">
                <div>
                    <select name="field_id">
                        <?php
                        foreach (tdf_ordered_fields() as $field) :
                            /* @var Field $field */
                            ?>
                            <option value="<?php echo esc_attr($field->getId()); ?>">
                                <?php echo esc_html($field->getName()); ?>
                            </option>
                        <?php endforeach;
                        ?>
                    </select>
                </div>

                <div>
                    <button class="button button-small button-primary">
                        <?php esc_html_e('Check Visibility', 'listivo-core'); ?>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <?php if ($fieldVisibilityDetails) : ?>
        <h2><?php echo esc_html($fieldVisibilityDetails['field_name']); ?></h2>

        <?php if (empty($fieldVisibilityDetails['terms_can_hide_field']) && empty($fieldVisibilityDetails['terms_must_be_selected'])) : ?>
            <h3><?php esc_html_e('The field is always visible', 'listivo-core'); ?></h3>
        <?php endif; ?>

        <?php if (!empty($fieldVisibilityDetails['terms_can_hide_field'])) : ?>
            <h3><?php esc_html_e('Terms That Can Hide the Field', 'listivo-core'); ?></h3>

            <?php foreach ($fieldVisibilityDetails['terms_can_hide_field'] as $term) : ?>
                <?php /* @var CustomTerm $term */ ?>
                <div>
                    <?php echo esc_html($term->getName() . ' (' . $term->getTaxonomyField()->getName()) . ')'; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (!empty($fieldVisibilityDetails['terms_must_be_selected'])) : ?>
            <h3><?php esc_html_e('Terms That Must Be Selected Before the Field is Visible', 'listivo-core'); ?></h3>

            <?php foreach ($fieldVisibilityDetails['terms_must_be_selected'] as $term) : ?>
                <?php /* @var CustomTerm $term */ ?>
                <div>
                    <?php echo esc_html($term->getName() . ' (' . $term->getTaxonomyField()->getName()) . ')'; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endif; ?>
</div>