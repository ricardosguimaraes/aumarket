<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;
use Tangibledesign\Framework\Models\Menu;
use Tangibledesign\Framework\Models\Page;

?>
<div class="listivo-docs listivo-docs--margin-top">
    <div class="listivo-docs__label-wrapper">
        <div class="listivo-docs__icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                <!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                <path d="M320 32c-8.1 0-16.1 1.4-23.7 4.1L15.8 137.4C6.3 140.9 0 149.9 0 160s6.3 19.1 15.8 22.6l57.9 20.9C57.3 229.3 48 259.8 48 291.9v28.1c0 28.4-10.8 57.7-22.3 80.8c-6.5 13-13.9 25.8-22.5 37.6C0 442.7-.9 448.3 .9 453.4s6 8.9 11.2 10.2l64 16c4.2 1.1 8.7 .3 12.4-2s6.3-6.1 7.1-10.4c8.6-42.8 4.3-81.2-2.1-108.7C90.3 344.3 86 329.8 80 316.5V291.9c0-30.2 10.2-58.7 27.9-81.5c12.9-15.5 29.6-28 49.2-35.7l157-61.7c8.2-3.2 17.5 .8 20.7 9s-.8 17.5-9 20.7l-157 61.7c-12.4 4.9-23.3 12.4-32.2 21.6l159.6 57.6c7.6 2.7 15.6 4.1 23.7 4.1s16.1-1.4 23.7-4.1L624.2 182.6c9.5-3.4 15.8-12.5 15.8-22.6s-6.3-19.1-15.8-22.6L343.7 36.1C336.1 33.4 328.1 32 320 32zM128 408c0 35.3 86 72 192 72s192-36.7 192-72L496.7 262.6 354.5 314c-11.1 4-22.8 6-34.5 6s-23.5-2-34.5-6L143.3 262.6 128 408z"/>
            </svg>
        </div>

        <div class="listivo-docs__label">
            <?php esc_html_e('Menu Configuration Guide', 'listivo-core'); ?>
        </div>
    </div>

    <div class="listivo-docs___content">
        <p>
            <?php echo wp_kses(
                __('Listivo allows customization of menus, including colors, typography, and logo size. It supports sticky and transparent menus, CTA buttons, and mobile off-canvas options. Configure menus through the Listivo Panel, Elementor Menu Widget, or WordPress Appearance module. Maintain menu consistency across layouts.', 'listivo-core'),
                array('strong' => array())
            ); ?>        </p>
    </div>

    <a
            class="listivo-docs__button"
            href="https://support.listivotheme.com/support/solutions/articles/101000521869-menu-configuration-a-comprehensive-guide"
            target="_blank"
    >
        <?php esc_html_e('Go to Article', 'listivo-core'); ?>
    </a>
</div>

<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::MAIN_MENU); ?>">
                <?php esc_html_e('Menu', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <select
                    id="<?php echo esc_attr(SettingKey::MAIN_MENU); ?>"
                    name="<?php echo esc_attr(SettingKey::MAIN_MENU); ?>"
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
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::STICKY_MAIN_MENU); ?>">
                <?php esc_html_e('Sticky', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::STICKY_MAIN_MENU); ?>"
                    name="<?php echo esc_attr(SettingKey::STICKY_MAIN_MENU); ?>"
                    type="checkbox"
                    value="1"
                <?php if (tdf_settings()->isMainMenuSticky()) : ?>
                    checked
                <?php endif; ?>
            >
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::SHOW_MENU_ACCOUNT); ?>">
                <?php esc_html_e('User Menu', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label>
                <input
                        id="<?php echo esc_attr(SettingKey::SHOW_MENU_ACCOUNT); ?>"
                        name="<?php echo esc_attr(SettingKey::SHOW_MENU_ACCOUNT); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->showMenuAccount()) : ?>
                        checked
                    <?php endif; ?>
                >

                <?php esc_html_e('Show user menu for logged in and "login / register" for not logged in.',
                    'listivo-core'); ?>
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::SHOW_MENU_CTA_BUTTON); ?>">
                <?php esc_html_e('CTA Button', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::SHOW_MENU_CTA_BUTTON); ?>"
                    name="<?php echo esc_attr(SettingKey::SHOW_MENU_CTA_BUTTON); ?>"
                    type="checkbox"
                    value="1"
                <?php if (tdf_settings()->showMenuCtaButton()) : ?>
                    checked
                <?php endif; ?>
            >
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::MENU_CTA_BUTTON_PAGE); ?>">
                <?php esc_html_e('CTA Button Link', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <select
                    id="<?php echo esc_attr(SettingKey::MENU_CTA_BUTTON_PAGE); ?>"
                    name="<?php echo esc_attr(SettingKey::MENU_CTA_BUTTON_PAGE); ?>"
            >
                <option value="0">
                    <?php esc_html_e('Add Listing', 'listivo-core'); ?>
                </option>

                <option
                        value="-1"
                    <?php if (tdf_settings()->getMenuCtaButtonPageId()) : ?>
                        selected
                    <?php endif; ?>
                >
                    <?php esc_html_e('Search Results', 'listivo-core'); ?>
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
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::CUSTOM_MENU_CTA_TEXT); ?>">
                <?php esc_html_e('Custom CTA Button Text', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::CUSTOM_MENU_CTA_TEXT); ?>"
                    name="<?php echo esc_attr(SettingKey::CUSTOM_MENU_CTA_TEXT); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getCustomMenuCtaText()); ?>"
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

<div class="listivo-docs listivo-docs--tips listivo-docs--margin-top">
    <div class="listivo-docs__label-wrapper">
        <div class="listivo-docs__icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                <!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                <path d="M0 256L28.5 28c2-16 15.6-28 31.8-28H228.9c15 0 27.1 12.1 27.1 27.1c0 3.2-.6 6.5-1.7 9.5L208 160H347.3c20.2 0 36.7 16.4 36.7 36.7c0 7.4-2.2 14.6-6.4 20.7l-192.2 281c-5.9 8.6-15.6 13.7-25.9 13.7h-2.9c-15.7 0-28.5-12.8-28.5-28.5c0-2.3 .3-4.6 .9-6.9L176 288H32c-17.7 0-32-14.3-32-32z"/>
            </svg>
        </div>

        <div class="listivo-docs__label">
            <?php esc_html_e('HOT TIPS!', 'listivo-core'); ?>
        </div>
    </div>

    <div class="listivo-docs__list">
        <a
                class="listivo-docs__item"
                href="https://support.listivotheme.com/support/solutions/articles/101000521871-menu-cta-button-customization-options-and-flexibility"
                target="_blank"
        >
            <div class="listivo-docs__number">1.</div>

            <?php esc_html_e('Menu CTA Button Customization: Options and Flexibility', 'listivo-core'); ?>
        </a>

        <a
                class="listivo-docs__item"
                href="https://support.listivotheme.com/support/solutions/articles/101000372961-menu-log-in-register-links-how-to-manage-and-customize"
                target="_blank"
        >
            <div class="listivo-docs__number">2.</div>

            <?php esc_html_e('Menu Log In/Register Links: How to Manage and Customize', 'listivo-core'); ?>
        </a>

        <a
                class="listivo-docs__item"
                href="https://support.listivotheme.com/support/solutions/articles/101000521872-configuring-transparent-menus-guidelines-and-tips"
                target="_blank"
        >
            <div class="listivo-docs__number">3.</div>

            <?php esc_html_e('Config Transparent Menus: Guidelines and Tips', 'listivo-core'); ?>
        </a>

        <a
                class="listivo-docs__item"
                href="https://support.listivotheme.com/support/solutions/articles/101000521876-fixing-menu-collapse-to-second-line-expanding-width-and-adjusting-mobile-breakpoints-"
                target="_blank"
        >
            <div class="listivo-docs__number">4.</div>

            <?php esc_html_e('Fixing Menu Collapse to Second Line: Expanding Width and Adjusting Mobile Breakpoints', 'listivo-core'); ?>
        </a>

        <a
                class="listivo-docs__item"
                href="https://support.listivotheme.com/support/solutions/articles/101000372963-sticky-menu-setup-keeping-your-menu-visible-as-users-scroll"
                target="_blank"
        >
            <div class="listivo-docs__number">5.</div>

            <?php esc_html_e('Sticky Menu Setup: Keeping Your Menu Visible as Users Scroll', 'listivo-core'); ?>
        </a>

        <a
                class="listivo-docs__item"
                href="https://support.listivotheme.com/support/solutions/articles/101000372960-how-to-change-logo-image-and-its-size"
                target="_blank"
        >
            <div class="listivo-docs__number">6.</div>

            <?php esc_html_e('How to Change Logo Image and Its Size', 'listivo-core'); ?>
        </a>

        <a
                class="listivo-docs__item"
                href="https://support.listivotheme.com/support/solutions/articles/101000372962-how-to-turn-off-add-listing-button-"
                target="_blank"
        >
            <div class="listivo-docs__number">7.</div>

            <?php esc_html_e('How to Turn Off Add Listing Button', 'listivo-core'); ?>
        </a>
    </div>
</div>