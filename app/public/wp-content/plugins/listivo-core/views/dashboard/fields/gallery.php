<?php

use Tangibledesign\Framework\Models\Field\GalleryField;

/* @var GalleryField $field */
global $field;
?>
<tr>
    <th scope="row">
        <label for="<?php echo esc_attr(GalleryField::MAX_IMAGE_NUMBER); ?>">
            <?php esc_html_e('Max Image Number', 'listivo-core'); ?>
        </label>
    </th>

    <td>
        <input
                name="<?php echo esc_attr(GalleryField::MAX_IMAGE_NUMBER); ?>"
                id="<?php echo esc_attr(GalleryField::MAX_IMAGE_NUMBER); ?>"
                class="regular-text"
                type="text"
                value="<?php echo esc_html($field->getMaxImageNumber()); ?>"
        >
    </td>
</tr>

<tr>
    <th scope="row">
        <label for="<?php echo esc_attr(GalleryField::MAX_FILE_SIZE); ?>">
            <?php esc_html_e('Max File Size (MB)', 'listivo-core'); ?>
        </label>
    </th>

    <td>
        <input
                name="<?php echo esc_attr(GalleryField::MAX_FILE_SIZE); ?>"
                id="<?php echo esc_attr(GalleryField::MAX_FILE_SIZE); ?>"
                class="regular-text"
                type="text"
                value="<?php echo esc_html($field->getMaxFileSize()); ?>"
        >
    </td>
</tr>