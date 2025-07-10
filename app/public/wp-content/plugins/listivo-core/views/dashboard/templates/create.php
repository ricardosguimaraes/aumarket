<?php

use Tangibledesign\Framework\Models\Template\Template;
use Tangibledesign\Framework\Models\Template\TemplateType\TemplateType;

?>
<div class="tdf-app wrap">
    <h1 class="wp-heading-inline">
        <?php esc_html_e('Add New Template'); ?>
    </h1>

    <form action="<?php echo esc_url(admin_url('admin-post.php?action=listivo/template/create')); ?>" method="post">
        <input
                type="hidden"
                name="nonce"
                value="<?php echo esc_attr(wp_create_nonce('listivo/template/create')); ?>"
        >

        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row">
                    <label for="<?php echo esc_attr(Template::NAME); ?>">
                        <?php esc_html_e('Name', 'listivo-core'); ?>
                    </label>
                </th>

                <td>
                    <input
                            id="<?php echo esc_attr(Template::NAME); ?>"
                            name="<?php echo esc_attr(Template::NAME); ?>"
                            class="regular-text"
                            type="text"
                    >
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="<?php echo esc_attr(Template::TYPE); ?>">
                        <?php esc_html_e('Name', 'listivo-core'); ?>
                    </label>
                </th>

                <td>
                    <select
                            name="<?php echo esc_attr(Template::TYPE); ?>"
                            id="<?php echo esc_attr(Template::TYPE); ?>"
                    >
                        <?php foreach (tdf_app('template_types') as $templateType) : /* @var TemplateType $templateType */ ?>
                            <option value="<?php echo esc_attr($templateType->getType()); ?>">
                                <?php echo esc_html($templateType->getName()); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            </tbody>
        </table>

        <button class="button button-primary">
            <?php esc_html_e('Add Template', 'listivo-core'); ?>
        </button>
    </form>
</div>