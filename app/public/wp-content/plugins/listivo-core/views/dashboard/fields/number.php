<?php

use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Field\NumberField;

/* @var NumberField $field */
global $field;
?>
<tr>
    <th scope="row">
        <label for="<?php echo esc_attr(NumberField::DECIMAL_PLACES); ?>">
            <?php esc_html_e('Decimal Places', 'listivo-core'); ?>
        </label>
    </th>

    <td>
        <input
                name="<?php echo esc_attr(NumberField::DECIMAL_PLACES); ?>"
                id="<?php echo esc_attr(NumberField::DECIMAL_PLACES); ?>"
                class="regular-text"
                type="text"
                value="<?php echo esc_html($field->getDecimalPlaces()); ?>"
        >
    </td>
</tr>

<tr>
    <th scope="row">
        <label for="<?php echo esc_attr(NumberField::HIDE_THOUSANDS_SEPARATOR); ?>">
            <?php esc_html_e('Hide Thousands Separator', 'listivo-core'); ?>
        </label>
    </th>

    <td>
        <input
                name="<?php echo esc_attr(NumberField::HIDE_THOUSANDS_SEPARATOR); ?>"
                id="<?php echo esc_attr(NumberField::HIDE_THOUSANDS_SEPARATOR); ?>"
                type="checkbox"
                value="1"
            <?php if ($field->hideThousandsSeparator()) : ?>
                checked
            <?php endif; ?>
        >
    </td>
</tr>

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

<tr>
    <th scope="row">
        <label for="<?php echo esc_attr(Field::DISPLAY_VALUE_WITH_FIELD_NAME); ?>">
            <?php esc_html_e('Display field name before value on card', 'listivo-core'); ?>
        </label>
    </th>

    <td>
        <input
                name="<?php echo esc_attr(Field::DISPLAY_VALUE_WITH_FIELD_NAME); ?>"
                id="<?php echo esc_attr(Field::DISPLAY_VALUE_WITH_FIELD_NAME); ?>"
                type="checkbox"
                value="1"
            <?php if ($field->displayValueWithFieldName()) : ?>
                checked
            <?php endif; ?>
        >
    </td>
</tr>