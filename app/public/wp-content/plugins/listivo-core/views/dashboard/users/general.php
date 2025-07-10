<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;
use Tangibledesign\Framework\Models\Field\TaxonomyField;

?>
<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::USER_REGISTRATION); ?>">
                <?php esc_html_e('Registration', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::USER_REGISTRATION); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::USER_REGISTRATION); ?>"
                        id="<?php echo esc_attr(SettingKey::USER_REGISTRATION); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->userRegistrationOpen()) : ?>
                        checked
                    <?php endif; ?>
                >
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::ACCOUNT_INITIAL_TAB); ?>">
                <?php esc_html_e('Login / Register - Initial Tab', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <select
                    name="<?php echo esc_attr(SettingKey::ACCOUNT_INITIAL_TAB); ?>"
                    id="<?php echo esc_attr(SettingKey::ACCOUNT_INITIAL_TAB); ?>"
                    class="tdf-selectize tdf-selectize-init"
            >
                <option
                        value="<?php echo esc_attr(SettingKey::ACCOUNT_TAB_LOGIN); ?>"
                    <?php if (tdf_settings()->getInitialTab() === SettingKey::ACCOUNT_TAB_LOGIN) : ?>
                        selected
                    <?php endif; ?>
                >
                    <?php echo esc_html__('Login', 'listivo-core'); ?>
                </option>

                <option
                        value="<?php echo esc_attr(SettingKey::ACCOUNT_TAB_REGISTER); ?>"
                    <?php if (tdf_settings()->getInitialTab() === SettingKey::ACCOUNT_TAB_REGISTER) : ?>
                        selected
                    <?php endif; ?>
                >
                    <?php echo esc_html__('Register', 'listivo-core'); ?>
                </option>
            </select>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::MAIN_CATEGORY); ?>">
                <?php esc_html_e('Main Category', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <?php $lstMainCategoryId = tdf_settings()->getMainCategoryId(); ?>
            <select
                    id="<?php echo esc_attr(SettingKey::MAIN_CATEGORY); ?>"
                    name="<?php echo esc_attr(SettingKey::MAIN_CATEGORY); ?>"
                    class="tdf-selectize tdf-selectize-init"
            >
                <option value="0"><?php esc_html_e('Not Set', 'listivo-core'); ?></option>

                <?php foreach (tdf_taxonomy_fields() as $lstTaxonomy) : /* @var TaxonomyField $lstTaxonomy */ ?>
                    <option
                            value="<?php echo esc_attr($lstTaxonomy->getId()); ?>"
                        <?php if ($lstMainCategoryId === $lstTaxonomy->getId()) : ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php echo esc_html($lstTaxonomy->getName()); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::POLICY_LABEL); ?>">
                <?php esc_html_e('Policy Label', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <textarea
                    id="<?php echo esc_attr(SettingKey::POLICY_LABEL); ?>"
                    name="<?php echo esc_attr(SettingKey::POLICY_LABEL); ?>"
                    class="listivo-backend-text-area"
                    rows="5"
                    cols="30"
            ><?php echo wp_kses_post(tdf_settings()->getPolicyLabel()); ?></textarea>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::DESCRIPTION_SIMPLE_EDITOR); ?>">
                <?php esc_html_e('Basic Description Editor', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::DESCRIPTION_SIMPLE_EDITOR); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::DESCRIPTION_SIMPLE_EDITOR); ?>"
                        id="<?php echo esc_attr(SettingKey::DESCRIPTION_SIMPLE_EDITOR); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->isDescriptionSimpleEditorEnabled()) : ?>
                        checked
                    <?php endif; ?>
                >

                <?php esc_html_e('By default, the advanced editor is used.', 'listivo-core'); ?>
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::LISTING_EXPIRE_AFTER); ?>">
                <?php esc_html_e('Listing Expires After', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::LISTING_EXPIRE_AFTER); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::LISTING_EXPIRE_AFTER); ?>"
                        id="<?php echo esc_attr(SettingKey::LISTING_EXPIRE_AFTER); ?>"
                        type="text"
                        value="<?php echo esc_attr(tdf_settings()->getListingExpireAfter()); ?>"
                >
            </label>

            <p class="description">
                <?php esc_html_e('The number of days after which a listing will expire. Set to 0 or leave empty to disable. Works only when monetization is off.', 'listivo-core'); ?>
            </p>
        </td>
    </tr>
    </tbody>
</table>

<h2><?php esc_html_e('Marketing Consents', 'listivo-core'); ?></h2>

<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::MARKETING_CONSENTS); ?>">
                <?php esc_html_e('Enable', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::MARKETING_CONSENTS); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::MARKETING_CONSENTS); ?>"
                        id="<?php echo esc_attr(SettingKey::MARKETING_CONSENTS); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->isMarketingConsentsEnabled()) : ?>
                        checked
                    <?php endif; ?>
                >

                <?php esc_html_e('Enable marketing consents to ask users during registration. This option allows you to collect consents for marketing communications.', 'listivo-core'); ?>
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::MARKETING_CONSENTS_LABEL); ?>">
                <?php esc_html_e('Label', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <textarea
                    id="<?php echo esc_attr(SettingKey::MARKETING_CONSENTS_LABEL); ?>"
                    name="<?php echo esc_attr(SettingKey::MARKETING_CONSENTS_LABEL); ?>"
                    class="listivo-backend-text-area"
                    rows="5"
                    cols="30"
                    placeholder="<?php esc_html_e("Enter the description for marketing consents that will be displayed on the registration form. E.g., 'I agree to receive promotional emails and newsletters.'", 'listivo-core'); ?>"
            ><?php echo wp_kses_post(tdf_settings()->getMarketingConsentsLabel()); ?></textarea>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::MARKETING_CONSENTS_DEFAULT); ?>">
                <?php esc_html_e('Default', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::MARKETING_CONSENTS_DEFAULT); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::MARKETING_CONSENTS_DEFAULT); ?>"
                        id="<?php echo esc_attr(SettingKey::MARKETING_CONSENTS_DEFAULT); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->isMarketingConsentsCheckedByDefault()) : ?>
                        checked
                    <?php endif; ?>
                >

                <?php esc_html_e('Set marketing consents as checked by default during registration. Users can still uncheck it if they want to opt-out.', 'listivo-core'); ?>
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::MARKETING_CONSENTS_REQUIRED); ?>">
                <?php esc_html_e('Required', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::MARKETING_CONSENTS_REQUIRED); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::MARKETING_CONSENTS_REQUIRED); ?>"
                        id="<?php echo esc_attr(SettingKey::MARKETING_CONSENTS_REQUIRED); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->isMarketingConsentsRequired()) : ?>
                        checked
                    <?php endif; ?>
                >

                <?php esc_html_e('Make marketing consents a required field during registration. Users must check this box to proceed.', 'listivo-core'); ?>
            </label>
        </td>
    <tr>
    </tbody>
</table>

<p class="submit">
    <button class="button button-primary">
        <?php esc_html_e('Save Changes', 'listivo-core'); ?>
    </button>
</p>