<?php

use Tangibledesign\Framework\Models\Field\RichTextField;

/* @var RichTextField $field */
global $field;
?>
<tr>
    <th scope="row">
        <label for="<?php echo esc_attr(RichTextField::SIMPLE_EDITOR); ?>">
            <?php esc_html_e('Simple Front-End Panel Editor', 'listivo-core'); ?>
        </label>
    </th>

    <td>
        <input
                name="<?php echo esc_attr(RichTextField::SIMPLE_EDITOR); ?>"
                id="<?php echo esc_attr(RichTextField::SIMPLE_EDITOR); ?>"
                type="checkbox"
                value="1"
            <?php if ($field->isSimpleEditorEnabled()) : ?>
                checked
            <?php endif; ?>
        >
    </td>
</tr>