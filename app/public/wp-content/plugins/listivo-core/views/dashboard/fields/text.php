<?php

use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Field\TextField;

/* @var TextField $field */
global $field;
?>
<tr>
    <th scope="row">
        <label for="<?php echo esc_attr(TextField::COMPARE_LOGIC); ?>">
            <?php esc_html_e('Compare Logic', 'listivo-core'); ?>
        </label>
    </th>

    <td>
        <select
                name="<?php echo esc_attr(TextField::COMPARE_LOGIC); ?>"
                id="<?php echo esc_attr(TextField::COMPARE_LOGIC); ?>"
        >
            <option
                    value="<?php echo esc_attr(TextField::COMPARE_LOGIC_LIKE); ?>"
                <?php if ($field->getCompareLogic() === TextField::COMPARE_LOGIC_LIKE) : ?>
                    selected
                <?php endif; ?>
            >
                <?php esc_html_e('Like', 'listivo-core'); ?>
            </option>

            <option
                    value="<?php echo esc_attr(TextField::COMPARE_LOGIC_EQUAL); ?>"
                <?php if ($field->getCompareLogic() === TextField::COMPARE_LOGIC_EQUAL) : ?>
                    selected
                <?php endif; ?>
            >
                <?php esc_html_e('Equal', 'listivo-core'); ?>
            </option>
        </select>
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