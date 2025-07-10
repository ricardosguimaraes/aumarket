<?php

use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Field\SalaryField;

/* @var SalaryField $field */
global $field;
?>
<tr>
    <th scope="row">
        <label for="<?php echo esc_attr(Field::TEXT_BEFORE_VALUE); ?>">
            <?php esc_html_e('Text Before Value', 'listivo-core'); ?>
        </label>
    </th>

    <td>
        <input
                name="<?php echo esc_attr(Field::TEXT_BEFORE_VALUE); ?>"
                id="<?php echo esc_attr(Field::TEXT_BEFORE_VALUE); ?>"
                class="regular-text"
                type="text"
                value="<?php echo esc_html($field->getTextBeforeValue()); ?>"
        >
    </td>
</tr>

<tr>
    <th scope="row">
        <label for="<?php echo esc_attr(Field::TEXT_AFTER_VALUE); ?>">
            <?php esc_html_e('Text After Value', 'listivo-core'); ?>
        </label>
    </th>

    <td>
        <input
                name="<?php echo esc_attr(Field::TEXT_AFTER_VALUE); ?>"
                id="<?php echo esc_attr(Field::TEXT_AFTER_VALUE); ?>"
                class="regular-text"
                type="text"
                value="<?php echo esc_html($field->getTextAfterValue()); ?>"
        >
    </td>
</tr>