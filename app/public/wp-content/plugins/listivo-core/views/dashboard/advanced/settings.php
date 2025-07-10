<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;
use Tangibledesign\Framework\Models\ContactForm;
use Tangibledesign\Framework\Models\Page;
use Tangibledesign\Listivo\Providers\Settings\SettingsServiceProvider;

?>
<form
        action="<?php echo esc_url(tdf_action_url(tdf_prefix() . '/settings/save&type=' . SettingsServiceProvider::TYPE_ADVANCED)); ?>"
        method="post"
>
    <input
            type="hidden"
            name="redirect"
            value="<?php echo esc_url(admin_url('admin.php?page=listivo_advanced')); ?>"
    >

    <div class="listivo-docs listivo-docs--margin-top">
        <div class="listivo-docs__label-wrapper">
            <div class="listivo-docs__icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                    <path d="M320 32c-8.1 0-16.1 1.4-23.7 4.1L15.8 137.4C6.3 140.9 0 149.9 0 160s6.3 19.1 15.8 22.6l57.9 20.9C57.3 229.3 48 259.8 48 291.9v28.1c0 28.4-10.8 57.7-22.3 80.8c-6.5 13-13.9 25.8-22.5 37.6C0 442.7-.9 448.3 .9 453.4s6 8.9 11.2 10.2l64 16c4.2 1.1 8.7 .3 12.4-2s6.3-6.1 7.1-10.4c8.6-42.8 4.3-81.2-2.1-108.7C90.3 344.3 86 329.8 80 316.5V291.9c0-30.2 10.2-58.7 27.9-81.5c12.9-15.5 29.6-28 49.2-35.7l157-61.7c8.2-3.2 17.5 .8 20.7 9s-.8 17.5-9 20.7l-157 61.7c-12.4 4.9-23.3 12.4-32.2 21.6l159.6 57.6c7.6 2.7 15.6 4.1 23.7 4.1s16.1-1.4 23.7-4.1L624.2 182.6c9.5-3.4 15.8-12.5 15.8-22.6s-6.3-19.1-15.8-22.6L343.7 36.1C336.1 33.4 328.1 32 320 32zM128 408c0 35.3 86 72 192 72s192-36.7 192-72L496.7 262.6 354.5 314c-11.1 4-22.8 6-34.5 6s-23.5-2-34.5-6L143.3 262.6 128 408z"></path>
                </svg>
            </div>

            <div class="listivo-docs__label">
                Advanced Settings Guide
            </div>
        </div>

        <div class="listivo-docs___content">
            <p>
                Before changing any option in this tab, please take the time to read the documentation to fully
                understand what each option does.
            </p>
        </div>

        <a
                class="listivo-docs__button"
                href="https://support.listivotheme.com/support/solutions/articles/101000528044-listivo-panel-advanced-setting"
                target="_blank"
        >
            Go to Article
        </a>
    </div>

    <table class="form-table">
        <tbody>
        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr(SettingKey::ADDITIONAL_SEARCH_PAGES); ?>">
                    <?php esc_html_e('Additional Search Pages', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                <select
                        id="<?php echo esc_attr(SettingKey::ADDITIONAL_SEARCH_PAGES); ?>"
                        name="<?php echo esc_attr(SettingKey::ADDITIONAL_SEARCH_PAGES); ?>[]"
                        class="tdf-selectize tdf-selectize-init"
                        placeholder="<?php esc_attr_e('Not Set', 'listivo-core'); ?>"
                        multiple
                >
                    <?php foreach (tdf_app('pages') as $lstPage) : /* @var Page $lstPage */ ?>
                        <option
                                value="<?php echo esc_attr($lstPage->getId()); ?>"
                            <?php if (in_array($lstPage->getId(), tdf_settings()->getAdditionalSearchPagesIds(), true)) : ?>
                                selected
                            <?php endif; ?>
                        >
                            <?php echo esc_html($lstPage->getName()); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr(SettingKey::PANEL_PAGE); ?>">
                    <?php esc_html_e('Panel Page', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                <select
                        id="<?php echo esc_attr(SettingKey::PANEL_PAGE); ?>"
                        name="<?php echo esc_attr(SettingKey::PANEL_PAGE); ?>"
                        class="tdf-selectize tdf-selectize-init"
                >
                    <option value="0">
                        <?php esc_html_e('Not set', 'listivo-core'); ?>
                    </option>

                    <?php foreach (tdf_app('pages') as $lstPage) : /* @var Page $lstPage */ ?>
                        <option
                                value="<?php echo esc_attr($lstPage->getId()); ?>"
                            <?php if (tdf_settings()->getPanelPageId() === $lstPage->getId()) : ?>
                                selected
                            <?php endif; ?>
                        >
                            <?php echo esc_html($lstPage->getName()); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr(SettingKey::COMPARE_PAGE); ?>">
                    <?php esc_html_e('Compare Page', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                <select
                        id="<?php echo esc_attr(SettingKey::COMPARE_PAGE); ?>"
                        name="<?php echo esc_attr(SettingKey::COMPARE_PAGE); ?>"
                        class="tdf-selectize tdf-selectize-init"
                >
                    <option value="0">
                        <?php esc_html_e('Not set', 'listivo-core'); ?>
                    </option>

                    <?php foreach (tdf_app('pages') as $lstPage) : /* @var Page $lstPage */ ?>
                        <option
                                value="<?php echo esc_attr($lstPage->getId()); ?>"
                            <?php if (tdf_settings()->getComparePageId() === $lstPage->getId()) : ?>
                                selected
                            <?php endif; ?>
                        >
                            <?php echo esc_html($lstPage->getName()); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr(SettingKey::LOGIN_PAGE); ?>">
                    <?php esc_html_e('Login Page', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                <select
                        id="<?php echo esc_attr(SettingKey::LOGIN_PAGE); ?>"
                        name="<?php echo esc_attr(SettingKey::LOGIN_PAGE); ?>"
                        class="tdf-selectize tdf-selectize-init"
                >
                    <option value="0">
                        <?php esc_html_e('Not set', 'listivo-core'); ?>
                    </option>

                    <?php foreach (tdf_app('pages') as $lstPage) : /* @var Page $lstPage */ ?>
                        <option
                                value="<?php echo esc_attr($lstPage->getId()); ?>"
                            <?php if (tdf_settings()->getLoginPageId() === $lstPage->getId()) : ?>
                                selected
                            <?php endif; ?>
                        >
                            <?php echo esc_html($lstPage->getName()); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr(SettingKey::REGISTER_PAGE); ?>">
                    <?php esc_html_e('Register Page', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                <select
                        id="<?php echo esc_attr(SettingKey::REGISTER_PAGE); ?>"
                        name="<?php echo esc_attr(SettingKey::REGISTER_PAGE); ?>"
                        class="tdf-selectize tdf-selectize-init"
                >
                    <option value="0">
                        <?php esc_html_e('Not set', 'listivo-core'); ?>
                    </option>

                    <?php foreach (tdf_app('pages') as $lstPage) : /* @var Page $lstPage */ ?>
                        <option
                                value="<?php echo esc_attr($lstPage->getId()); ?>"
                            <?php if (tdf_settings()->getRegisterPageId() === $lstPage->getId()) : ?>
                                selected
                            <?php endif; ?>
                        >
                            <?php echo esc_html($lstPage->getName()); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr(SettingKey::BLOG_PAGE); ?>">
                    <?php esc_html_e('Blog Page', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                <select
                        id="<?php echo esc_attr(SettingKey::BLOG_PAGE); ?>"
                        name="<?php echo esc_attr(SettingKey::BLOG_PAGE); ?>"
                        class="tdf-selectize tdf-selectize-init"
                >
                    <option value="0">
                        <?php esc_html_e('Not set', 'listivo-core'); ?>
                    </option>

                    <?php foreach (tdf_app('pages') as $lstPage) : /* @var Page $lstPage */ ?>
                        <option
                                value="<?php echo esc_attr($lstPage->getId()); ?>"
                            <?php if (tdf_settings()->getBlogPageId() === $lstPage->getId()) : ?>
                                selected
                            <?php endif; ?>
                        >
                            <?php echo esc_html($lstPage->getName()); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr(SettingKey::ERROR_PAGE); ?>">
                    <?php esc_html_e('Error Page', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                <select
                        id="<?php echo esc_attr(SettingKey::ERROR_PAGE); ?>"
                        name="<?php echo esc_attr(SettingKey::ERROR_PAGE); ?>"
                        class="tdf-selectize tdf-selectize-init"
                >
                    <option value="0">
                        <?php esc_html_e('Not set', 'listivo-core'); ?>
                    </option>

                    <?php foreach (tdf_app('pages') as $lstPage) : /* @var Page $lstPage */ ?>
                        <option
                                value="<?php echo esc_attr($lstPage->getId()); ?>"
                            <?php if (tdf_settings()->getErrorPageId() === $lstPage->getId()) : ?>
                                selected
                            <?php endif; ?>
                        >
                            <?php echo esc_html($lstPage->getName()); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr(SettingKey::CONTACT_USER_FORM); ?>">
                    <?php esc_html_e('Contact User Form', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                <select
                        id="<?php echo esc_attr(SettingKey::CONTACT_USER_FORM); ?>"
                        name="<?php echo esc_attr(SettingKey::CONTACT_USER_FORM); ?>"
                        class="tdf-selectize tdf-selectize-init"
                >
                    <option value="0">
                        <?php esc_html_e('Not set', 'listivo-core'); ?>
                    </option>

                    <?php foreach (tdf_app('contact_forms') as $lstContactForm) : /* @var ContactForm $lstContactForm */ ?>
                        <option
                                value="<?php echo esc_attr($lstContactForm->getId()); ?>"
                            <?php if (tdf_settings()->getContactUserFormId() === $lstContactForm->getId()) : ?>
                                selected
                            <?php endif; ?>
                        >
                            <?php echo esc_html($lstContactForm->getName()); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr(SettingKey::LEGACY_MODE); ?>">
                    <?php esc_html_e('Legacy Mode', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                <label for="<?php echo esc_attr(SettingKey::LEGACY_MODE); ?>">
                    <input
                            name="<?php echo esc_attr(SettingKey::LEGACY_MODE); ?>"
                            id="<?php echo esc_attr(SettingKey::LEGACY_MODE); ?>"
                            type="checkbox"
                            value="1"
                        <?php if (tdf_settings()->isLegacyModeEnabled()) : ?>
                            checked
                        <?php endif; ?>
                    >
                </label>

                <p class="listivo-backend-description">
                    Leave it unchecked to avoid issues with the Listivo 2.X version. This option was designed only for
                    clients who migrated from 1.X to 2.X, and in that specific scenario, it should auto-check during the
                    update.
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
</form>