<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;
use Tangibledesign\Framework\Models\Field\Helpers\SimpleTextValue;
use Tangibledesign\Framework\Models\Field\TaxonomyField;

?>
<div class="listivo-docs listivo-docs--margin-top">
    <div class="listivo-docs__label-wrapper">
        <div class="listivo-docs__icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                <path d="M320 32c-8.1 0-16.1 1.4-23.7 4.1L15.8 137.4C6.3 140.9 0 149.9 0 160s6.3 19.1 15.8 22.6l57.9 20.9C57.3 229.3 48 259.8 48 291.9v28.1c0 28.4-10.8 57.7-22.3 80.8c-6.5 13-13.9 25.8-22.5 37.6C0 442.7-.9 448.3 .9 453.4s6 8.9 11.2 10.2l64 16c4.2 1.1 8.7 .3 12.4-2s6.3-6.1 7.1-10.4c8.6-42.8 4.3-81.2-2.1-108.7C90.3 344.3 86 329.8 80 316.5V291.9c0-30.2 10.2-58.7 27.9-81.5c12.9-15.5 29.6-28 49.2-35.7l157-61.7c8.2-3.2 17.5 .8 20.7 9s-.8 17.5-9 20.7l-157 61.7c-12.4 4.9-23.3 12.4-32.2 21.6l159.6 57.6c7.6 2.7 15.6 4.1 23.7 4.1s16.1-1.4 23.7-4.1L624.2 182.6c9.5-3.4 15.8-12.5 15.8-22.6s-6.3-19.1-15.8-22.6L343.7 36.1C336.1 33.4 328.1 32 320 32zM128 408c0 35.3 86 72 192 72s192-36.7 192-72L496.7 262.6 354.5 314c-11.1 4-22.8 6-34.5 6s-23.5-2-34.5-6L143.3 262.6 128 408z"></path>
            </svg>
        </div>

        <div class="listivo-docs__label">
            SEO Configuration Guide
        </div>
    </div>

    <div class="listivo-docs___content">
        <p>
            Listivo offers comprehensive SEO customization options. You can customize slugs (URLs), breadcrumbs, search
            results H1, meta titles, descriptions, and more. Check out our article for a full overview of the SEO
            potential when using Listivo.
        </p>
    </div>

    <a
            class="listivo-docs__button"
            href="https://support.listivotheme.com/support/solutions/articles/101000527308-comprehensive-seo-guide"
            target="_blank"
    >
        Go to Article
    </a>
</div>

<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::BREADCRUMBS); ?>">
                <?php esc_html_e('Breadcrumbs', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <select
                    id="<?php echo esc_attr(SettingKey::BREADCRUMBS); ?>"
                    name="<?php echo esc_attr(SettingKey::BREADCRUMBS); ?>[]"
                    class="tdf-selectize tdf-selectize-init"
                    multiple
            >
                <?php foreach (tdf_settings()->getBreadcrumbs() as $tdfTaxonomyKey) :
                    $tdfTaxonomyField = tdf_taxonomy_fields()->find(static function ($taxonomy) use ($tdfTaxonomyKey) {
                        /* @var TaxonomyField $taxonomy */
                        return $taxonomy->getKey() === $tdfTaxonomyKey;
                    });

                    if (!$tdfTaxonomyField instanceof TaxonomyField) {
                        continue;
                    }
                    ?>
                    <option value="<?php echo esc_attr($tdfTaxonomyField->getKey()); ?>" selected>
                        <?php echo esc_html($tdfTaxonomyField->getName()); ?> <i class="fas fa-arrow-right"></i>
                    </option>
                <?php endforeach; ?>

                <?php foreach (tdf_taxonomy_fields() as $tdfTaxonomyField) :
                    if (in_array($tdfTaxonomyField->getKey(), tdf_settings()->getBreadcrumbs(), true)) {
                        continue;
                    }
                    ?>
                    <option value="<?php echo esc_attr($tdfTaxonomyField->getKey()); ?>">
                        <?php echo esc_html($tdfTaxonomyField->getName()); ?> <i class="fas fa-arrow-right"></i>
                    </option>
                <?php endforeach; ?>
            </select>

            <p class="description">
                <?php esc_html_e('These fields will be used to generate breadcrumbs.', 'listivo-core'); ?>
            </p>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::PRETTY_URLS); ?>">
                <?php esc_html_e('Pretty URL\'s', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::PRETTY_URLS); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::PRETTY_URLS); ?>"
                        id="<?php echo esc_attr(SettingKey::PRETTY_URLS); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->prettyUrls()) : ?>
                        checked
                    <?php endif; ?>
                >

                <?php esc_html_e('Generate pretty urls based on breadcrumbs settings. Slugs for search results and specific ad must be different.', 'listivo-core'); ?>
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::AUTO_GENERATE_MODEL_TITLE); ?>">
                <?php esc_html_e('Auto-Generate Ad Title', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <select
                    id="<?php echo esc_attr(SettingKey::AUTO_GENERATE_MODEL_TITLE); ?>"
                    name="<?php echo esc_attr(SettingKey::AUTO_GENERATE_MODEL_TITLE); ?>[]"
                    class="tdf-selectize tdf-selectize-init"
                    placeholder="<?php esc_attr_e('Do not auto generate - user enter title manually', 'listivo-core'); ?>"
                    multiple
            >
                <?php foreach (tdf_settings()->getAutoGenerateModelTitleFields() as $lstField) : /* @var SimpleTextValue $lstField */ ?>
                    <option
                            value="<?php echo esc_attr($lstField->getId()); ?>"
                            selected
                    >
                        <?php echo esc_html($lstField->getName()); ?>
                    </option>
                <?php endforeach; ?>

                <?php foreach (tdf_settings()->getNotAutoGenerateModelTitleFields() as $lstField) : /* @var SimpleTextValue $lstField */ ?>
                    <option value="<?php echo esc_attr($lstField->getId()); ?>">
                        <?php echo esc_html($lstField->getName()); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::SEARCH_DEFAULT_DESCRIPTION); ?>">
                <?php esc_html_e('Default Search Description', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <textarea
                    id="<?php echo esc_attr(SettingKey::SEARCH_DEFAULT_DESCRIPTION); ?>"
                    name="<?php echo esc_attr(SettingKey::SEARCH_DEFAULT_DESCRIPTION); ?>"
                    class="regular-text listivo-backend-description listivo-backend-description--small listivo-backend-description--wide"
                    rows="3"
            ><?php echo esc_html(tdf_settings()->getSearchDefaultDescription()); ?></textarea>
        </td>
    </tr>
    </tbody>
</table>

<h2><?php esc_html_e('Search Results Title (H1 tag)', 'listivo-core'); ?></h2>

<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::SEARCH_DEFAULT_TITLE); ?>">
                <?php esc_html_e('Default', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::SEARCH_DEFAULT_TITLE); ?>"
                    name="<?php echo esc_attr(SettingKey::SEARCH_DEFAULT_TITLE); ?>"
                    class="regular-text"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getSearchDefaultTitle()); ?>"
            >
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::SEARCH_TITLE_FIELDS); ?>">
                <?php esc_html_e('Fields', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <select
                    id="<?php echo esc_attr(SettingKey::SEARCH_TITLE_FIELDS); ?>"
                    name="<?php echo esc_attr(SettingKey::SEARCH_TITLE_FIELDS); ?>[]"
                    class="tdf-selectize tdf-selectize-init"
                    placeholder="<?php esc_attr_e('Search Title Fields', 'listivo-core'); ?>"
                    multiple
            >
                <?php foreach (tdf_settings()->getSearchTitleFields() as $taxonomyField) : ?>
                    <option
                            value="<?php echo esc_attr($taxonomyField->getId()); ?>"
                            selected
                    >
                        <?php echo esc_html($taxonomyField->getName()); ?>
                    </option>
                <?php endforeach; ?>

                <?php foreach (tdf_taxonomy_fields() as $taxonomyField) :
                    if (in_array($taxonomyField->getId(), tdf_settings()->getSearchTitleFieldIds(), true)) {
                        continue;
                    }
                    ?>
                    <option value="<?php echo esc_attr($taxonomyField->getId()); ?>">
                        <?php echo esc_html($taxonomyField->getName()); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <p class="description">
                <?php esc_html_e('Taxonomy fields used to generate the title.', 'listivo-core'); ?>
            </p>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::SECOND_SEARCH_TITLE_FIELDS); ?>">
                <?php esc_html_e('Priority Fields', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <select
                    id="<?php echo esc_attr(SettingKey::SECOND_SEARCH_TITLE_FIELDS); ?>"
                    name="<?php echo esc_attr(SettingKey::SECOND_SEARCH_TITLE_FIELDS); ?>[]"
                    class="tdf-selectize tdf-selectize-init"
                    placeholder="<?php esc_attr_e('Search Title Fields', 'listivo-core'); ?>"
                    multiple
            >
                <?php foreach (tdf_settings()->getSearchTitleFields2() as $taxonomyField) : ?>
                    <option
                            value="<?php echo esc_attr($taxonomyField->getId()); ?>"
                            selected
                    >
                        <?php echo esc_html($taxonomyField->getName()); ?>
                    </option>
                <?php endforeach; ?>

                <?php foreach (tdf_taxonomy_fields() as $taxonomyField) :
                    if (in_array($taxonomyField->getId(), tdf_settings()->getSearchTitleFieldIds2(), true)) {
                        continue;
                    }
                    ?>
                    <option value="<?php echo esc_attr($taxonomyField->getId()); ?>">
                        <?php echo esc_html($taxonomyField->getName()); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <p class="description">
                <?php esc_html_e('These fields will be used first.', 'listivo-core'); ?>
            </p>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::SEARCH_OVERRIDE_TITLE_TAG); ?>">
                <?php esc_html_e('Override Title Tag', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::SEARCH_OVERRIDE_TITLE_TAG); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::SEARCH_OVERRIDE_TITLE_TAG); ?>"
                        id="<?php echo esc_attr(SettingKey::SEARCH_OVERRIDE_TITLE_TAG); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->searchOverrideTitleTag()) : ?>
                        checked
                    <?php endif; ?>
                >

                <?php esc_html_e('Override the default html title tag.', 'listivo-core'); ?>
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

<div class="listivo-docs listivo-docs--tips listivo-docs--margin-top">
    <div class="listivo-docs__label-wrapper">
        <div class="listivo-docs__icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                <path d="M0 256L28.5 28c2-16 15.6-28 31.8-28H228.9c15 0 27.1 12.1 27.1 27.1c0 3.2-.6 6.5-1.7 9.5L208 160H347.3c20.2 0 36.7 16.4 36.7 36.7c0 7.4-2.2 14.6-6.4 20.7l-192.2 281c-5.9 8.6-15.6 13.7-25.9 13.7h-2.9c-15.7 0-28.5-12.8-28.5-28.5c0-2.3 .3-4.6 .9-6.9L176 288H32c-17.7 0-32-14.3-32-32z"></path>
            </svg>
        </div>
        <div class="listivo-docs__label">
            HOT TIPS!
        </div>
    </div>

    <div class="listivo-docs__list">
        <a
                class="listivo-docs__item"
                href="https://support.listivotheme.com/support/solutions/articles/101000527458-how-to-optimize-search-results-page-for-seo-h1-tags-descriptions-and-meta-details"
                target="_blank"
        >
            <div class="listivo-docs__number">1.</div>

            Optimize your search results page for SEO. Learn how to set H1 tags, descriptions, and meta details.
        </a>

        <a
                class="listivo-docs__item"
                href="https://support.listivotheme.com/support/solutions/articles/101000527455-how-to-customize-url-slugs-for-search-results-and-single-ad-pages"
                target="_blank"
        >
            <div class="listivo-docs__number">2.</div>

            Customize URL slugs for search results and single ad pages. Learn how to set up pretty URLs.
        </a>

        <a
                class="listivo-docs__item"
                href="https://support.listivotheme.com/support/solutions/articles/101000527435-how-to-use-breadcrumbs-and-how-canonical-urls-work"
                target="_blank"
        >
            <div class="listivo-docs__number">3.</div>

            Learn how to use breadcrumbs and canonical URLs to improve your site's SEO.
        </a>

        <a
                class="listivo-docs__item"
                href="https://support.listivotheme.com/support/solutions/articles/101000527385-how-to-auto-generate-ad-titles"
                target="_blank"
        >
            <div class="listivo-docs__number">4.</div>

            Auto-generate ad titles to save time and improve SEO. Learn how to set up auto-generated titles.
        </a>
    </div>
</div>