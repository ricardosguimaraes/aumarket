<?php
/* @var Field $field */

use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Field\Helpers\HasInputPlaceholderInterface;
use Tangibledesign\Framework\Models\Field\Helpers\HasSlugInterface;
use Tangibledesign\Framework\Models\Term\CustomTerm;

?>
<div class="tdf-app wrap">
    <h1 class="wp-heading-inline">
        <?php esc_html_e('Edit Field', 'listivo-core'); ?>
    </h1>

    <template>
        <form
                action="<?php echo esc_url(admin_url('admin-post.php?action=listivo/field/update')); ?>"
                method="post"
        >
            <input
                    type="hidden"
                    name="nonce"
                    value="<?php echo esc_attr(wp_create_nonce('listivo/field/update')); ?>"
            >

            <input
                    type="hidden"
                    name="id"
                    value="<?php echo esc_attr($field->getId()); ?>"
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
                                name="<?php echo esc_attr(Field::NAME); ?>"
                                id="<?php echo esc_attr(Field::NAME); ?>"
                                class="regular-text"
                                type="text"
                                value="<?php echo esc_html($field->getName()); ?>"
                        >
                    </td>
                </tr>

                <?php if ($field instanceof HasSlugInterface) : ?>
                    <tr>
                        <th scope="row">
                            <label for="<?php echo esc_attr(Field::SLUG); ?>">
                                <?php esc_html_e('Slug', 'listivo-core'); ?>
                            </label>
                        </th>

                        <td>
                            <input
                                    name="<?php echo esc_attr(Field::SLUG); ?>"
                                    id="<?php echo esc_attr(Field::SLUG); ?>"
                                    class="regular-text"
                                    type="text"
                                    value="<?php echo esc_html($field->getSlug()); ?>"
                            >
                        </td>
                    </tr>
                <?php endif; ?>

                <tr>
                    <th scope="row">
                        <label for="<?php echo esc_attr(Field::REQUIRED); ?>">
                            <?php esc_html_e('Required', 'listivo-core'); ?>
                        </label>
                    </th>

                    <td>
                        <input
                                name="<?php echo esc_attr(Field::REQUIRED); ?>"
                                id="<?php echo esc_attr(Field::REQUIRED); ?>"
                                type="checkbox"
                                value="1"
                            <?php if ($field->isRequired()) : ?>
                                checked
                            <?php endif; ?>
                        >
                    </td>
                </tr>

                <?php tdf_load_view('dashboard/fields/'.$field->getType()); ?>

                <?php if ($field instanceof HasInputPlaceholderInterface): ?>
                    <tr>
                        <th scope="row">
                            <label for="<?php echo esc_attr(Field::INPUT_PLACEHOLDER); ?>">
                                <?php esc_html_e('Input Placeholder', 'listivo-core'); ?>
                            </label>
                        </th>

                        <td>
                            <input
                                    name="<?php echo esc_attr(Field::INPUT_PLACEHOLDER); ?>"
                                    id="<?php echo esc_attr(Field::INPUT_PLACEHOLDER); ?>"
                                    class="regular-text"
                                    type="text"
                                    value="<?php echo esc_html($field->getInputPlaceholder()); ?>"
                            >
                        </td>
                    </tr>
                <?php endif; ?>

                <tr>
                    <th scope="row">
                        <label for="<?php echo esc_attr(Field::VALUE_VISIBILITY_BY_USER_ROLE); ?>">
                            <?php esc_html_e('Who can see this field on the single listing page?', 'listivo-core'); ?>
                        </label>
                    </th>

                    <td>
                        <select
                                id="<?php echo esc_attr(Field::VALUE_VISIBILITY_BY_USER_ROLE); ?>"
                                name="<?php echo esc_attr(Field::VALUE_VISIBILITY_BY_USER_ROLE); ?>[]"
                                class="tdf-selectize-init"
                                placeholder="<?php esc_attr_e('Everyone', 'listivo-core'); ?>"
                                multiple
                        >
                            <?php foreach (tdf_app('user_roles') as $userRoleKey => $userRoleName): ?>
                                <option
                                        value="<?php echo esc_attr($userRoleKey); ?>"
                                    <?php if (!$field->isValueVisibleForAllUserRoles() && $field->isValueVisibleForUserRole($userRoleKey)) : ?>
                                        selected
                                    <?php endif; ?>
                                >
                                    <?php echo esc_html($userRoleName); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="<?php echo esc_attr(Field::FRONTEND_PANEL_VISIBILITY_BY_USER_ROLE); ?>">
                            <?php esc_html_e('Who can fill out this field on the frontend panel?', 'listivo-core'); ?>
                        </label>
                    </th>

                    <td>
                        <select
                                id="<?php echo esc_attr(Field::FRONTEND_PANEL_VISIBILITY_BY_USER_ROLE); ?>"
                                name="<?php echo esc_attr(Field::FRONTEND_PANEL_VISIBILITY_BY_USER_ROLE); ?>[]"
                                class="tdf-selectize-init"
                                placeholder="<?php esc_attr_e('Everyone', 'listivo-core'); ?>"
                                multiple
                        >
                            <?php foreach (tdf_app('user_roles') as $userRoleKey => $userRoleName): ?>
                                <option
                                        value="<?php echo esc_attr($userRoleKey); ?>"
                                    <?php if (!$field->isVisibleOnFrontendPanelForEveryone() && $field->isVisibleOnFrontendPanelForUserRole($userRoleKey)) : ?>
                                        selected
                                    <?php endif; ?>
                                >
                                    <?php echo esc_html($userRoleName); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="<?php echo esc_attr(Field::HIDE_TERMS); ?>">
                            <?php esc_html_e('Hide Terms', 'listivo-core'); ?>
                        </label>
                    </th>

                    <td>
                        <select
                                name="<?php echo esc_attr(Field::HIDE_TERMS); ?>[]"
                                id="<?php echo esc_attr(Field::HIDE_TERMS); ?>"
                                class="tdf-selectize-init"
                                placeholder="<?php esc_attr_e('Not set', 'listivo-core'); ?>"
                                multiple
                        >
                            <?php foreach (tdf_app('all_dependency_terms') as $term): /* @var CustomTerm $term */
                                if ($term->getTaxonomyKey() === $field->getKey()) {
                                    continue;
                                }
                                ?>
                                <option
                                        value="<?php echo esc_attr($term->getId()); ?>"
                                    <?php if (in_array($term->getId(), $field->getHideTermIds(), true)) : ?>
                                        selected
                                    <?php endif; ?>
                                >
                                    <?php echo esc_html($term->getName()); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="<?php echo esc_attr(Field::HINT); ?>">
                            <?php esc_html_e('Hint', 'listivo-core'); ?>
                        </label>
                    </th>

                    <td>
                        <input
                                id="<?php echo esc_attr(Field::HINT); ?>"
                                name="<?php echo esc_attr(Field::HINT); ?>"
                                class="regular-text"
                                type="text"
                                value="<?php echo esc_attr($field->getHint()); ?>"
                        >
                    </td>
                </tr>
                </tbody>
            </table>

            <p class="submit">
                <button class="button button-primary">
                    <?php esc_html_e('Save Changes', 'listivo-core'); ?>
                </button>
            </p>
        </form>
    </template>
</div>