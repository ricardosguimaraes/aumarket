<?php

use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Term\CustomTerm;
use Tangibledesign\Framework\Models\Field\TaxonomyField;

/* @var TaxonomyField $field */
$terms = $field->getMainTerms();
$fields = tdf_ordered_fields()->filter(static function ($currentField) use ($field) {
    /* @var Field $currentField */
    return $currentField->getId() !== $field->getId();
});
?>
<tr>
    <th scope="row">
        <label for="<?php echo esc_attr(TaxonomyField::FIELD_DEPENDENCY); ?>">
            <?php esc_html_e('Relations', 'listivo-core'); ?>
        </label>
    </th>

    <td>
        <table class="wp-list-table widefat fixed striped posts listivo-backend-table listivo-backend-table--hover-row listivo-backend-table--width-auto">
            <thead>
            <tr>
                <td class="listivo-backend-table__col listivo-backend-table__col--primary">
                </td>

                <?php foreach ($terms as $term) : ?>
                    <th class="listivo-backend-table__col listivo-backend-table__col--medium">
                        <?php echo esc_html($term->getName()); ?>
                    </th>
                <?php endforeach; ?>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($fields as $currentField) : ?>
                <tr>
                    <td class="listivo-backend-table__cell listivo-backend-table__cell--primary">
                        <?php echo esc_html($currentField->getName()); ?>
                    </td>

                    <?php foreach ($terms as $term) :/* @var CustomTerm $term */ ?>
                        <td class="listivo-backend-table__cell">
                            <label for="<?php echo esc_attr($term->getKey()); ?>_<?php echo esc_attr($currentField->getId()); ?>">
                                <input
                                        type="checkbox"
                                        name="<?php echo esc_attr(CustomTerm::FIELD_DEPENDENCIES); ?>[<?php echo esc_attr($term->getKey()); ?>][]"
                                        value="<?php echo esc_attr($currentField->getId()); ?>"
                                        id="<?php echo esc_attr($term->getKey()); ?>_<?php echo esc_attr($currentField->getId()); ?>"
                                    <?php if (in_array($currentField->getId(), $term->getFieldDependencies(), true)) : ?>
                                        checked
                                    <?php endif; ?>
                                >
                            </label>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </td>
</tr>

<!--<div class="tdf-field-dependency-wrapper">-->
<!--    <table class="tdf-field-dependency">-->
<!--        <tr class="tdf-field-dependency__head">-->
<!--            <th></th>-->
<!---->
<!--            --><?php //foreach ($terms as $term) : ?>
<!--                <th>-->
<!--                    --><?php //echo esc_html($term->getName()); ?>
<!--                </th>-->
<!--            --><?php //endforeach; ?>
<!--        </tr>-->
<!---->
<!--        --><?php //foreach ($fields as $currentField) : ?>
<!--            <tr class="tdf-field-dependency__row">-->
<!--                <th>--><?php //echo esc_html($currentField->getName()); ?><!--</th>-->
<!---->
<!--                --><?php //foreach ($terms as $term) :
//                    /* @var CustomTerm $term */
//                    ?>
<!--                    <td>-->
<!--                        <div class="tdf-checkbox">-->
<!--                            <input-->
<!--                                    type="checkbox"-->
<!--                                    name="--><?php //echo esc_attr(CustomTerm::FIELD_DEPENDENCIES); ?><!--[--><?php //echo esc_attr($term->getKey()); ?><!--][]"-->
<!--                                    value="--><?php //echo esc_attr($currentField->getId()); ?><!--"-->
<!--                                    id="--><?php //echo esc_attr($term->getKey()); ?><!--_--><?php //echo esc_attr($currentField->getId()); ?><!--"-->
<!--                                --><?php //if (in_array($currentField->getId(), $term->getFieldDependencies(), true)) : ?>
<!--                                    checked-->
<!--                                --><?php //endif; ?>
<!--                            >-->
<!--                            <label for="--><?php //echo esc_attr($term->getKey()); ?><!--_--><?php //echo esc_attr($currentField->getId()); ?><!--"></label>-->
<!--                        </div>-->
<!--                    </td>-->
<!--                --><?php //endforeach; ?>
<!--            </tr>-->
<!--        --><?php //endforeach; ?>
<!--    </table>-->
<!--</div>-->
<!---->
<!--<div class="tdf-field-dependency-info">-->
<!--    <i class="fa fa-arrow-up"></i>-->
<!---->
<!--    <h3>--><?php //esc_html_e('Important Information', 'listivo-core'); ?><!--</h3>-->
<!---->
<!--    <div>-->
<!--        --><?php //esc_html_e('By default, each field(row) is displayed to all terms. If you check the box (e.g. Salary) in the column (e.g. Jobs), the field will be displayed only if the user selects Category: Jobs. ', 'listivo-core'); ?>
<!--    </div>-->
<!--</div>-->
