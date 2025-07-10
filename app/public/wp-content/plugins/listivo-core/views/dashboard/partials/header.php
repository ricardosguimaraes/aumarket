<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;
use Tangibledesign\Framework\Models\Menu;
use Tangibledesign\Framework\Models\Page;

?>
<div id="tdf-menu" class="tdf-content-section">
    <div class="tdf-content-section__left">
        <h2><?php esc_html_e('Menu', 'listivo-core'); ?></h2>

        <div class="tdf-doc">
            <div class="tdf-doc__icon">
                <i class="fas fa-info"></i>
            </div>
            <div class="tdf-doc__text">

                Need to change menu colors and size?
                <a
                        target="_blank"
                        href="https://support.listivotheme.com/support/solutions/articles/101000372958">
                    Click here to read more
                </a>
            </div>
        </div>
    </div>

    <div class="tdf-content-section__right">
        <div class="tdf-field">
            <label for="<?php echo esc_attr(SettingKey::MAIN_MENU); ?>">
                <i class="fas fa-bars"></i> <?php esc_html_e('Main Menu', 'listivo-core'); ?>
            </label>

            <select
                    name="<?php echo esc_attr(SettingKey::MAIN_MENU); ?>"
                    id="<?php echo esc_attr(SettingKey::MAIN_MENU); ?>"
                    class="tdf-selectize tdf-selectize-init"
            >
                <option value="0">
                    <?php esc_html_e('Not set', 'listivo-core'); ?>
                </option>

                <?php foreach (tdf_app('menus') as $lstMenu) : /* @var Menu $lstMenu */ ?>
                    <option
                            value="<?php echo esc_attr($lstMenu->getID()); ?>"
                        <?php if (tdf_settings()->getMainMenuId() === $lstMenu->getID()) : ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php echo esc_html($lstMenu->getName()); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="tdf-checkbox">
            <input
                    name="<?php echo esc_attr(SettingKey::STICKY_MAIN_MENU); ?>"
                    id="<?php echo esc_attr(SettingKey::STICKY_MAIN_MENU); ?>"
                    type="checkbox"
                    value="1"
                <?php if (tdf_settings()->isMainMenuSticky()) : ?>
                    checked
                <?php endif; ?>
            >
            <label for="<?php echo esc_attr(SettingKey::STICKY_MAIN_MENU); ?>">
                <?php esc_html_e('Sticky Main Menu', 'listivo-core'); ?>
            </label>
        </div>

        <div class="tdf-checkbox">
            <input
                    name="<?php echo esc_attr(SettingKey::SHOW_MENU_ACCOUNT); ?>"
                    id="<?php echo esc_attr(SettingKey::SHOW_MENU_ACCOUNT); ?>"
                    type="checkbox"
                    value="1"
                <?php if (tdf_settings()->showMenuAccount()) : ?>
                    checked
                <?php endif; ?>
            >
            <label for="<?php echo esc_attr(SettingKey::SHOW_MENU_ACCOUNT); ?>">
                <?php esc_html_e('Display User Menu for logged in users and "Login / Register" links for not logged in', 'listivo-core'); ?>
            </label>

        </div>

        <div class="tdf-checkbox">
            <input
                    name="<?php echo esc_attr(SettingKey::SHOW_MENU_CTA_BUTTON); ?>"
                    id="<?php echo esc_attr(SettingKey::SHOW_MENU_CTA_BUTTON); ?>"
                    type="checkbox"
                    value="1"
                <?php if (tdf_settings()->showMenuCtaButton()) : ?>
                    checked
                <?php endif; ?>
            >

            <label for="<?php echo esc_attr(SettingKey::SHOW_MENU_CTA_BUTTON); ?>">
                <?php esc_html_e('Display CTA Button (by default "+ Add Listing")', 'listivo-core'); ?>
            </label>
        </div>

        <div class="tdf-field">
            <label for="<?php echo esc_attr(SettingKey::MENU_CTA_BUTTON_PAGE); ?>">
                <i class="fas fa-link"></i> <?php esc_html_e('Menu CTA Button Link', 'listivo-core'); ?>
            </label>

            <select
                    id="<?php echo esc_attr(SettingKey::MENU_CTA_BUTTON_PAGE); ?>"
                    name="<?php echo esc_attr(SettingKey::MENU_CTA_BUTTON_PAGE); ?>"
                    class="tdf-selectize tdf-selectize-init"
            >
                <option value="0">
                    <?php esc_html_e('Add Listing', 'listivo-core'); ?>
                </option>

                <?php foreach (tdf_app('pages') as $lstPage) : /* @var Page $lstPage */ ?>
                    <option
                            value="<?php echo esc_attr($lstPage->getId()); ?>"
                        <?php if (tdf_settings()->getMenuCtaButtonPageId() === $lstPage->getId()) : ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php echo esc_html($lstPage->getName()); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <?php tdf_load_view('dashboard/partials/save_changes_button'); ?>
    </div>
</div>