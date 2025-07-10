<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;
use Tangibledesign\Framework\Models\ContactForm;
use Tangibledesign\Framework\Models\Page;

?>

<div class="tdf-content-section">
    <div class="tdf-content-section__left">
        <h2><?php esc_html_e('Global Assignments', 'listivo-core'); ?></h2>

        <div>
            <?php esc_html_e('Thanks to this settings theme assign correct information across website. Changing it can be useful only in some advanced customizations so it is highly recommended to not change this settings without clear reason.', 'listivo-core'); ?>
        </div>
    </div>

    <div class="tdf-content-section__right">
        <div class="tdf-field">
            <label for="<?php echo esc_attr(SettingKey::ADDITIONAL_SEARCH_PAGES); ?>">
                <i class="fas fa-search"></i> <?php esc_html_e('Additional Search Pages', 'listivo-core'); ?>
            </label>

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
        </div>

        <div class="tdf-field">
            <label for="<?php echo esc_attr(SettingKey::PANEL_PAGE); ?>">
                <i class="fas fa-user-circle"></i> <?php esc_html_e('Panel Page', 'listivo-core'); ?>
            </label>

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
        </div>

        <div class="tdf-field">
            <label for="<?php echo esc_attr(SettingKey::COMPARE_PAGE); ?>">
                <i class="fas fa-exchange-alt"></i> <?php esc_html_e('Compare Page', 'listivo-core'); ?>
            </label>

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
        </div>

        <div class="tdf-field">
            <div>
                <label for="<?php echo esc_attr(SettingKey::LOGIN_PAGE); ?>">
                    <i class="fas fa-sign-in-alt"></i> <?php esc_html_e('Login Page', 'listivo-core'); ?>
                </label>
            </div>

            <div>
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
            </div>
        </div>

        <div class="tdf-field">
            <div>
                <label for="<?php echo esc_attr(SettingKey::REGISTER_PAGE); ?>">
                    <i class="fas fa-sign-in-alt"></i> <?php esc_html_e('Register Page', 'listivo-core'); ?>
                </label>
            </div>

            <div>
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
            </div>
        </div>

        <div class="tdf-field">
            <label for="<?php echo esc_attr(SettingKey::BLOG_PAGE); ?>">
                <i class="fas fa-pen-nib"></i> <?php esc_html_e('Blog Page', 'listivo-core'); ?>
            </label>

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
        </div>

        <div class="tdf-field">
            <label for="<?php echo esc_attr(SettingKey::ERROR_PAGE); ?>">
                <i class="fas fa-exclamation-triangle"></i> <?php esc_html_e('404 Page', 'listivo-core'); ?>
            </label>

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
        </div>

        <div class="tdf-field">
            <label for="<?php echo esc_attr(SettingKey::CONTACT_USER_FORM); ?>">
                <i class="fas fa-address-card"></i> <?php esc_html_e('Contact User Form', 'listivo-core'); ?>
            </label>

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
        </div>

        <?php tdf_load_view('dashboard/partials/save_changes_button'); ?>
    </div>
</div>