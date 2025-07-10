<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::MODERATION); ?>">
                <?php esc_html_e('Enabled', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::MODERATION); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::MODERATION); ?>"
                        id="<?php echo esc_attr(SettingKey::MODERATION); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->moderationEnabled()) : ?>
                        checked
                    <?php endif; ?>
                >

                <a
                        href="https://support.listivotheme.com/support/solutions/articles/101000479834-moderation-how-it-works-and-how-to-enable-or-disable-it"
                        target="_blank"
                >
                    <?php esc_html_e('Learn more about the Moderation feature', 'listivo-core'); ?>
                </a>
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::MODERATION_RE_APPROVE); ?>">
                <?php esc_html_e('Re-Approval', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::MODERATION_RE_APPROVE); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::MODERATION_RE_APPROVE); ?>"
                        id="<?php echo esc_attr(SettingKey::MODERATION_RE_APPROVE); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->moderationRequiredReApprove()) : ?>
                        checked
                    <?php endif; ?>
                >

                <?php esc_html_e('Edited ads must be moderated again.', 'listivo-core'); ?>
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::MODERATORS); ?>">
                <?php esc_html_e('Moderators', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <select
                    id="<?php echo esc_attr(SettingKey::MODERATORS); ?>"
                    name="<?php echo esc_attr(SettingKey::MODERATORS); ?>[]"
                    class="tdf-selectize tdf-selectize-init"
                    placeholder="<?php esc_attr_e('Only Administrators', 'listivo-core'); ?>"
                    multiple
            >
                <?php foreach (tdf_query_users()->roleNotIn('administrator')->get() as $lstUser) : ?>
                    <option
                            value="<?php echo esc_attr($lstUser->getId()); ?>"
                        <?php if (in_array($lstUser->getId(), tdf_settings()->getModeratorIds(), true)): ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php echo esc_html($lstUser->getDisplayName()); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <p class="description">
                <?php esc_html_e('Users who have access to the moderation section.', 'listivo-core'); ?>
            </p>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::SUBMIT_WITHOUT_LOGIN); ?>">
                <?php esc_html_e('Adding Before Logging In', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::SUBMIT_WITHOUT_LOGIN); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::SUBMIT_WITHOUT_LOGIN); ?>"
                        id="<?php echo esc_attr(SettingKey::SUBMIT_WITHOUT_LOGIN); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->submitWithoutLogin()) : ?>
                        checked
                    <?php endif; ?>
                >

                <?php esc_html_e('Possibility to start adding an ad before logging in.', 'listivo-core'); ?>
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::MODERATION_PAGE_CUSTOM_FIELDS); ?>">
                <?php esc_html_e('Extra Display Fields', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <select
                    id="<?php echo esc_attr(SettingKey::MODERATION_PAGE_CUSTOM_FIELDS); ?>"
                    name="<?php echo esc_attr(SettingKey::MODERATION_PAGE_CUSTOM_FIELDS); ?>[]"
                    class="tdf-selectize tdf-selectize-init"
                    multiple
            >
                <?php foreach (tdf_settings()->getModerationPageCustomFields() as $field) :
                    /* @var \Tangibledesign\Framework\Models\Field\Field $field */
                    ?>
                    <option value="<?php echo esc_attr($field->getId()); ?>" selected>
                        <?php echo esc_html($field->getName()); ?>
                    </option>
                <?php endforeach; ?>

                <?php foreach (tdf_simple_text_value_fields() as $field) :
                    if (in_array($field->getKey(), tdf_settings()->getModerationPageCustomFieldsIds(), true)) {
                        continue;
                    }
                    ?>
                    <option value="<?php echo esc_attr($field->getId()); ?>">
                        <?php echo esc_html($field->getName()); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <p class="description">
                <?php esc_html_e('Extra fields that will be displayed on the moderation page.', 'listivo-core'); ?>
            </p>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::NAME_REQUIRED); ?>">
                <?php esc_html_e('Require Ad Name', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::NAME_REQUIRED); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::NAME_REQUIRED); ?>"
                        id="<?php echo esc_attr(SettingKey::NAME_REQUIRED); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->nameRequired()) : ?>
                        checked
                    <?php endif; ?>
                >
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::NAME_HINT); ?>">
                <?php esc_html_e('Ad Name Hint', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::NAME_HINT); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::NAME_HINT); ?>"
                        id="<?php echo esc_attr(SettingKey::NAME_HINT); ?>"
                        type="text"
                        value="<?php echo esc_attr(tdf_settings()->getNameHint()); ?>"
                >
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::NAME_LENGTH); ?>">
                <?php esc_html_e('Max Ad Name Length', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::NAME_LENGTH); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::NAME_LENGTH); ?>"
                        id="<?php echo esc_attr(SettingKey::NAME_LENGTH); ?>"
                        type="text"
                        value="<?php echo esc_attr(tdf_settings()->getNameLength()); ?>"
                >
            </label>

            <p class="description">
                <?php esc_html_e('The maximum number of characters that an ad name can have.', 'listivo-core'); ?>
            </p>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::DESCRIPTION_REQUIRED); ?>">
                <?php esc_html_e('Require Ad Description', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::DESCRIPTION_REQUIRED); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::DESCRIPTION_REQUIRED); ?>"
                        id="<?php echo esc_attr(SettingKey::DESCRIPTION_REQUIRED); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->descriptionRequired()) : ?>
                        checked
                    <?php endif; ?>
                >
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::DESCRIPTION_HINT); ?>">
                <?php esc_html_e('Ad Description Hint', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::DESCRIPTION_HINT); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::DESCRIPTION_HINT); ?>"
                        id="<?php echo esc_attr(SettingKey::DESCRIPTION_HINT); ?>"
                        type="text"
                        value="<?php echo esc_attr(tdf_settings()->getDescriptionHint()); ?>"
                >
            </label>
        </td>
    </tr>

    <tr>
        <th>
            <label for="<?php echo esc_attr(SettingKey::LISTING_TERMS_AND_CONDITIONS); ?>">
                <?php esc_html_e('Ad Terms and Conditions', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <textarea
                    name="<?php echo esc_attr(SettingKey::LISTING_TERMS_AND_CONDITIONS); ?>"
                    id="<?php echo esc_attr(SettingKey::LISTING_TERMS_AND_CONDITIONS); ?>"
                    rows="5"
                    cols="50"
            ><?php echo esc_html(tdf_settings()->getListingTermsAndConditions()); ?></textarea>

            <p class="listivo-backend-description">
                <?php esc_html_e('Terms and conditions that the user must accept when adding an ad. When left empty, the user will not be asked to accept any terms and conditions.', 'listivo-core'); ?>
            </p>
        </td>
    </tr>
    </tbody>
</table>

<p class="submit">
    <button class="button button-primary">
        <?php esc_html_e('Save Changes', 'listivo-core'); ?>
    </button>
</p>