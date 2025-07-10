<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;
use Tangibledesign\Framework\Models\Page;
use Tangibledesign\Framework\Widgets\General\PanelWidget;

?>
<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::REGISTER_REDIRECT); ?>">
                <?php esc_html_e('After registration', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::REGISTER_REDIRECT); ?>">
                <?php $value = tdf_settings()->getRegisterRedirect(); ?>
                <select
                        name="<?php echo esc_attr(SettingKey::REGISTER_REDIRECT); ?>"
                        id="<?php echo esc_attr(SettingKey::REGISTER_REDIRECT); ?>"
                >
                    <option
                            value="<?php echo esc_attr(PanelWidget::ACTION_LIST); ?>"
                        <?php if ($value === PanelWidget::ACTION_LIST) : ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php esc_html_e('My Ads', 'listivo-core'); ?>
                    </option>

                    <option
                            value="<?php echo esc_attr(PanelWidget::ACTION_SETTINGS); ?>"
                        <?php if ($value === PanelWidget::ACTION_SETTINGS) : ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php esc_html_e('Profile settings', 'listivo-core'); ?>
                    </option>

                    <option
                            value="<?php echo esc_attr(PanelWidget::ACTION_CREATE); ?>"
                        <?php if ($value === PanelWidget::ACTION_CREATE) : ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php esc_html_e('Add new ad', 'listivo-core'); ?>
                    </option>

                    <option
                            value="<?php echo esc_attr(PanelWidget::ACTION_BUY_PACKAGE); ?>"
                        <?php if ($value === PanelWidget::ACTION_BUY_PACKAGE) : ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php esc_html_e('Buy package', 'listivo-core'); ?>
                    </option>

                    <?php foreach (tdf_pages() as $page) : /* @var Page $page */ ?>
                        <option
                                value="<?php echo esc_attr($page->getId()); ?>"
                            <?php if ($page->getId() === (int)($value)) : ?>
                                selected
                            <?php endif; ?>
                        >
                            <?php echo esc_html($page->getName()); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::LOGIN_REDIRECT); ?>">
                <?php esc_html_e('After login', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::LOGIN_REDIRECT); ?>">
                <?php $value = tdf_settings()->getLoginRedirect(); ?>
                <select
                        name="<?php echo esc_attr(SettingKey::LOGIN_REDIRECT); ?>"
                        id="<?php echo esc_attr(SettingKey::LOGIN_REDIRECT); ?>"
                >
                    <option
                            value="<?php echo esc_attr(PanelWidget::ACTION_LIST); ?>"
                        <?php if ($value === PanelWidget::ACTION_LIST) : ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php esc_html_e('My Ads', 'listivo-core'); ?>
                    </option>

                    <option
                            value="<?php echo esc_attr(PanelWidget::ACTION_SETTINGS); ?>"
                        <?php if ($value === PanelWidget::ACTION_SETTINGS) : ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php esc_html_e('Profile settings', 'listivo-core'); ?>
                    </option>

                    <option
                            value="<?php echo esc_attr(PanelWidget::ACTION_CREATE); ?>"
                        <?php if ($value === PanelWidget::ACTION_CREATE) : ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php esc_html_e('Add new ad', 'listivo-core'); ?>
                    </option>

                    <option
                            value="<?php echo esc_attr(PanelWidget::ACTION_BUY_PACKAGE); ?>"
                        <?php if ($value === PanelWidget::ACTION_BUY_PACKAGE) : ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php esc_html_e('Buy package', 'listivo-core'); ?>
                    </option>

                    <?php foreach (tdf_pages() as $page) : /* @var Page $page */ ?>
                        <option
                                value="<?php echo esc_attr($page->getId()); ?>"
                            <?php if ($page->getId() === (int)($value)) : ?>
                                selected
                            <?php endif; ?>
                        >
                            <?php echo esc_html($page->getName()); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::SOCIAL_REGISTER_REDIRECT); ?>">
                <?php esc_html_e('After social registration', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::SOCIAL_REGISTER_REDIRECT); ?>">
                <?php $value = tdf_settings()->getSocialRegisterRedirect(); ?>
                <select
                        name="<?php echo esc_attr(SettingKey::SOCIAL_REGISTER_REDIRECT); ?>"
                        id="<?php echo esc_attr(SettingKey::SOCIAL_REGISTER_REDIRECT); ?>"
                >
                    <option
                            value="<?php echo esc_attr(PanelWidget::ACTION_LIST); ?>"
                        <?php if ($value === PanelWidget::ACTION_LIST) : ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php esc_html_e('My Ads', 'listivo-core'); ?>
                    </option>

                    <option
                            value="<?php echo esc_attr(PanelWidget::ACTION_SETTINGS); ?>"
                        <?php if ($value === PanelWidget::ACTION_SETTINGS) : ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php esc_html_e('Profile settings', 'listivo-core'); ?>
                    </option>

                    <option
                            value="<?php echo esc_attr(PanelWidget::ACTION_CREATE); ?>"
                        <?php if ($value === PanelWidget::ACTION_CREATE) : ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php esc_html_e('Add new ad', 'listivo-core'); ?>
                    </option>

                    <option
                            value="<?php echo esc_attr(PanelWidget::ACTION_BUY_PACKAGE); ?>"
                        <?php if ($value === PanelWidget::ACTION_BUY_PACKAGE) : ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php esc_html_e('Buy package', 'listivo-core'); ?>
                    </option>

                    <?php foreach (tdf_pages() as $page) : /* @var Page $page */ ?>
                        <option
                                value="<?php echo esc_attr($page->getId()); ?>"
                            <?php if ($page->getId() === (int)($value)) : ?>
                                selected
                            <?php endif; ?>
                        >
                            <?php echo esc_html($page->getName()); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::SOCIAL_LOGIN_REDIRECT); ?>">
                <?php esc_html_e('After social login', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::SOCIAL_LOGIN_REDIRECT); ?>">
                <?php $value = tdf_settings()->getSocialLoginRedirect(); ?>
                <select
                        name="<?php echo esc_attr(SettingKey::SOCIAL_LOGIN_REDIRECT); ?>"
                        id="<?php echo esc_attr(SettingKey::SOCIAL_LOGIN_REDIRECT); ?>"
                >
                    <option
                            value="<?php echo esc_attr(PanelWidget::ACTION_LIST); ?>"
                        <?php if ($value === PanelWidget::ACTION_LIST) : ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php esc_html_e('My Ads', 'listivo-core'); ?>
                    </option>

                    <option
                            value="<?php echo esc_attr(PanelWidget::ACTION_SETTINGS); ?>"
                        <?php if ($value === PanelWidget::ACTION_SETTINGS) : ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php esc_html_e('Profile settings', 'listivo-core'); ?>
                    </option>

                    <option
                            value="<?php echo esc_attr(PanelWidget::ACTION_CREATE); ?>"
                        <?php if ($value === PanelWidget::ACTION_CREATE) : ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php esc_html_e('Add new ad', 'listivo-core'); ?>
                    </option>

                    <option
                            value="<?php echo esc_attr(PanelWidget::ACTION_BUY_PACKAGE); ?>"
                        <?php if ($value === PanelWidget::ACTION_BUY_PACKAGE) : ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php esc_html_e('Buy package', 'listivo-core'); ?>
                    </option>

                    <?php foreach (tdf_pages() as $page) : /* @var Page $page */ ?>
                        <option
                                value="<?php echo esc_attr($page->getId()); ?>"
                            <?php if ($page->getId() === (int)($value)) : ?>
                                selected
                            <?php endif; ?>
                        >
                            <?php echo esc_html($page->getName()); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </td>
    </tr>
    </tbody>
</table>

<p class="submit">
    <button class="button button-primary">
        <?php esc_html_e('Save Changes', 'listivo-core'); ?>
    </button>
</p>