<?php

use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Field\Helpers\FieldType;

?>
<div class="tdf-app wrap">
    <h1 class="wp-heading-inline">
        <?php esc_html_e('Add New Field', 'listivo-core'); ?>
    </h1>

    <form action="<?php echo esc_url(admin_url('admin-post.php?action=listivo/field/create')); ?>" method="post">
        <input
                type="hidden"
                name="nonce"
                value="<?php echo esc_attr(wp_create_nonce('listivo/field/create')); ?>"
        >

        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row">
                    <label for="<?php echo esc_attr(Field::NAME); ?>">
                        <?php esc_html_e('Name', 'listivo-core'); ?>
                    </label>
                </th>

                <td>
                    <input
                            id="<?php echo esc_attr(Field::NAME); ?>"
                            name="<?php echo esc_attr(Field::NAME); ?>"
                            class="regular-text"
                            type="text"
                            required
                    >
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="<?php echo esc_attr(Field::TYPE); ?>">
                        <?php esc_html_e('Type', 'listivo-core'); ?>
                    </label>
                </th>

                <td>
                    <select
                            name="<?php echo esc_attr(Field::TYPE); ?>"
                            id="<?php echo esc_attr(Field::TYPE); ?>"
                    >
                        <?php foreach (FieldType::getAll() as $tdfFieldTypeKey => $tdfFieldTypeName) : ?>
                            <option value="<?php echo esc_attr($tdfFieldTypeKey); ?>">
                                <?php echo esc_html($tdfFieldTypeName); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            </tbody>
        </table>

        <button class="button button-primary">
            <?php esc_html_e('Add Field', 'listivo-core'); ?>
        </button>
    </form>
</div>