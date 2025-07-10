<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;
use Tangibledesign\Framework\Models\Page;

?>
<div class="listivo-docs listivo-docs--margin-top">
    <div class="listivo-docs__label-wrapper">
        <div class="listivo-docs__icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                <path d="M320 32c-8.1 0-16.1 1.4-23.7 4.1L15.8 137.4C6.3 140.9 0 149.9 0 160s6.3 19.1 15.8 22.6l57.9 20.9C57.3 229.3 48 259.8 48 291.9v28.1c0 28.4-10.8 57.7-22.3 80.8c-6.5 13-13.9 25.8-22.5 37.6C0 442.7-.9 448.3 .9 453.4s6 8.9 11.2 10.2l64 16c4.2 1.1 8.7 .3 12.4-2s6.3-6.1 7.1-10.4c8.6-42.8 4.3-81.2-2.1-108.7C90.3 344.3 86 329.8 80 316.5V291.9c0-30.2 10.2-58.7 27.9-81.5c12.9-15.5 29.6-28 49.2-35.7l157-61.7c8.2-3.2 17.5 .8 20.7 9s-.8 17.5-9 20.7l-157 61.7c-12.4 4.9-23.3 12.4-32.2 21.6l159.6 57.6c7.6 2.7 15.6 4.1 23.7 4.1s16.1-1.4 23.7-4.1L624.2 182.6c9.5-3.4 15.8-12.5 15.8-22.6s-6.3-19.1-15.8-22.6L343.7 36.1C336.1 33.4 328.1 32 320 32zM128 408c0 35.3 86 72 192 72s192-36.7 192-72L496.7 262.6 354.5 314c-11.1 4-22.8 6-34.5 6s-23.5-2-34.5-6L143.3 262.6 128 408z"></path>
            </svg>
        </div>

        <div class="listivo-docs__label">
            Discover the Help Center
        </div>
    </div>

    <div class="listivo-docs___content">
        <p>
            Listivo offers detailed articles explaining different configuration options. Please visit our Help Center to
            learn more about the theme and build your website quickly and easily.
        </p>
    </div>

    <a
            class="listivo-docs__button"
            href="https://support.listivotheme.com/support/home"
            target="_blank"
    >
        Visit Help Center
    </a>
</div>

<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label for="logo">
                <?php esc_html_e('Logo Default', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <lst-set-image :initial-image-id="<?php echo esc_attr(tdf_settings()->getLogoId()); ?>">
                <div slot-scope="props">
                    <div v-if="props.imageId" class="listivo-backend-add-logo">
                        <img :src="props.imageUrl" alt="">

                        <button class="listivo-backend-add-logo__remove" @click.prevent="props.remove"></button>

                        <input
                                name="<?php echo esc_attr(SettingKey::LOGO); ?>"
                                :value="props.imageId"
                                type="hidden"
                        >
                    </div>

                    <button
                            class="button button-secondary"
                            @click.prevent="props.openUploader"
                    >
                        <?php esc_html_e('Set Logo', 'listivo-core'); ?>
                    </button>
                </div>
            </lst-set-image>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="logo_reversed">
                <?php esc_html_e('Logo Reversed', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <lst-set-image :initial-image-id="<?php echo esc_attr(tdf_settings()->getInverseLogoId()); ?>">
                <div slot-scope="props">
                    <div class="listivo-backend-add-logo listivo-backend-add-logo--inverse" v-if="props.imageId">
                        <img :src="props.imageUrl" alt="">

                        <button class="listivo-backend-add-logo__remove" @click.prevent="props.remove"></button>

                        <input
                                name="<?php echo esc_attr(SettingKey::INVERSE_LOGO); ?>"
                                :value="props.imageId"
                                type="hidden"
                        >
                    </div>

                    <button
                            class="button button-secondary"
                            @click.prevent="props.openUploader"
                    >
                        <?php esc_html_e('Set Logo', 'listivo-core'); ?>
                    </button>
                </div>
            </lst-set-image>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::HOMEPAGE); ?>">
                <?php esc_html_e('Homepage', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <select
                    name="<?php echo esc_attr(SettingKey::HOMEPAGE); ?>"
                    id="<?php echo esc_attr(SettingKey::HOMEPAGE); ?>"
            >
                <option value="0">
                    <?php esc_html_e('Not set', 'listivo-core'); ?>
                </option>

                <?php foreach (tdf_app('pages') as $lstPage) : /* @var Page $lstPage */ ?>
                    <option
                            value="<?php echo esc_attr($lstPage->getId()); ?>"
                        <?php if (tdf_settings()->getHomepageId() === $lstPage->getId()) : ?>
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
            <label for="<?php echo esc_attr(SettingKey::MAIL); ?>">
                <?php esc_html_e('Public Email', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::MAIL); ?>"
                    name="<?php echo esc_attr(SettingKey::MAIL); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getMail()); ?>"
            >
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::PHONE); ?>">
                <?php esc_html_e('Public Phone', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::PHONE); ?>"
                    name="<?php echo esc_attr(SettingKey::PHONE); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getPhone()); ?>"
            >
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::ADDRESS); ?>">
                <?php esc_html_e('Public Address', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <textarea
                    id="<?php echo esc_attr(SettingKey::ADDRESS); ?>"
                    name="<?php echo esc_attr(SettingKey::ADDRESS); ?>"
                    class="listivo-backend-text-area"
                    rows="5"
                    cols="30"
            ><?php echo esc_html(tdf_settings()->getAddress()); ?></textarea>

        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::COPYRIGHTS_TEXT); ?>">
                <?php esc_html_e('Copyright Notice', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::COPYRIGHTS_TEXT); ?>"
                    name="<?php echo esc_attr(SettingKey::COPYRIGHTS_TEXT); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_html(tdf_settings()->getCopyrightsText()); ?>"
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
                href="https://support.listivotheme.com/support/solutions/articles/101000522141-global-design-management-of-colors-typography-ad-cards-style-and-many-other-repetitive-elements"
                target="_blank"
        >
            <div class="listivo-docs__number">1.</div>

            <div class="listivo-docs__text">
                <?php esc_html_e('Global Design Management', 'listivo-core'); ?>
            </div>
        </a>

        <a
                class="listivo-docs__item"
                href="https://support.listivotheme.com/support/solutions/articles/101000372953-how-to-translate-or-rename-all-texts"
                target="_blank"
        >
            <div class="listivo-docs__number">2.</div>

            <div class="listivo-docs__text">
                <?php esc_html_e('How to Translate or Rename All Texts', 'listivo-core'); ?>
            </div>
        </a>

        <a
                class="listivo-docs__item"
                href="https://support.listivotheme.com/support/solutions/articles/101000373800-how-to-prevent-emails-go-to-spam-folder-how-to-use-smtp-"
                target="_blank"
        >
            <div class="listivo-docs__number">3.</div>

            <div class="listivo-docs__text">
                <?php esc_html_e('How to Prevent Emails Go to Spam Folder', 'listivo-core'); ?>
            </div>
        </a>

        <a
                class="listivo-docs__item"
                href="https://support.listivotheme.com/support/solutions/articles/101000527308-comprehensive-seo-guide"
                target="_blank"
        >
            <div class="listivo-docs__number">4.</div>

            <div class="listivo-docs__text">
                <?php esc_html_e('Comprehensive SEO Guide', 'listivo-core'); ?>
            </div>
        </a>
    </div>
</div>