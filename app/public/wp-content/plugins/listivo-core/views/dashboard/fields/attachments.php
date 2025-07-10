<?php

use Tangibledesign\Framework\Models\Field\AttachmentsField;

/* @var AttachmentsField $field */
global $field;
?>
<tr>
    <th scope="row">
        <label for="<?php echo esc_attr(AttachmentsField::MAX_FILE_NUMBER); ?>">
            <?php esc_html_e('Max Image Number', 'listivo-core'); ?>
        </label>
    </th>

    <td>
        <input
                name="<?php echo esc_attr(AttachmentsField::MAX_FILE_NUMBER); ?>"
                id="<?php echo esc_attr(AttachmentsField::MAX_FILE_NUMBER); ?>"
                class="regular-text"
                type="text"
                value="<?php echo esc_html($field->getMaxFileNumber()); ?>"
        >
    </td>
</tr>

<tr>
    <th scope="row">
        <label for="<?php echo esc_attr(AttachmentsField::MAX_FILE_SIZE); ?>">
            <?php esc_html_e('Max File Size (MB)', 'listivo-core'); ?>
        </label>
    </th>

    <td>
        <input
                name="<?php echo esc_attr(AttachmentsField::MAX_FILE_SIZE); ?>"
                id="<?php echo esc_attr(AttachmentsField::MAX_FILE_SIZE); ?>"
                class="regular-text"
                type="text"
                value="<?php echo esc_html($field->getMaxFileSize()); ?>"
        >
    </td>
</tr>