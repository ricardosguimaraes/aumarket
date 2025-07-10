<?php

use Tangibledesign\Framework\Models\Field\EmbedField;

/* @var EmbedField $field */
global $field;
?>
<tr>
    <th scope="row">
        <label for="<?php echo esc_attr(EmbedField::ALLOW_RAW_HTML); ?>">
            <?php esc_html_e('Allow RAW HTML', 'listivo-core'); ?>
        </label>
    </th>

    <td>
        <input
                name="<?php echo esc_attr(EmbedField::ALLOW_RAW_HTML); ?>"
                id="<?php echo esc_attr(EmbedField::ALLOW_RAW_HTML); ?>"
                type="checkbox"
                value="1"
            <?php if ($field->allowRawHtml()) : ?>
                checked
            <?php endif; ?>
        >
    </td>
</tr>