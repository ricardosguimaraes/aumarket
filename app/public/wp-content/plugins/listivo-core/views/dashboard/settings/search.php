<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::EXCLUDE_FROM_SEARCH); ?>">
                <?php esc_html_e('Exclude From Search', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <select
                    id="<?php echo esc_attr(SettingKey::EXCLUDE_FROM_SEARCH); ?>"
                    name="<?php echo esc_attr(SettingKey::EXCLUDE_FROM_SEARCH); ?>[]"
                    class="tdf-selectize tdf-selectize-lazy"
                    multiple
                    data-request-url="<?php echo esc_url(admin_url('admin-post.php?action=tdf/terms/query')); ?>"
            >
                <?php foreach (tdf_app('terms_excluded_from_search') as $term) : ?>
                    <option value="<?php echo esc_attr($term->getId()); ?>" selected>
                        <?php echo esc_html($term->getName()); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <p class="description">
                <?php esc_html_e('Ads with these terms will not be visible in search results.', 'listivo-core'); ?>

                <a
                        href="https://support.listivotheme.com/support/solutions/articles/101000527757-marking-ads-as-sold-via-custom-field-offer-type-"
                        target="_blank"
                >
                    <?php esc_html_e('Learn more about marking ads as sold', 'listivo-core'); ?>
                </a>
            </p>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::KEYWORD_SEARCH_DESCRIPTION); ?>">
                <?php esc_html_e('Use Ad Descriptions', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::KEYWORD_SEARCH_DESCRIPTION); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::KEYWORD_SEARCH_DESCRIPTION); ?>"
                        id="<?php echo esc_attr(SettingKey::KEYWORD_SEARCH_DESCRIPTION); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->keywordSearchDescription()) : ?>
                        checked
                    <?php endif; ?>
                >

                <?php esc_html_e('Keyword searches will also use ad descriptions.', 'listivo-core'); ?>
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::KEYWORD_SEARCH_TERMS); ?>">
                <?php esc_html_e('Suggest Terms', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::KEYWORD_SEARCH_TERMS); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::KEYWORD_SEARCH_TERMS); ?>"
                        id="<?php echo esc_attr(SettingKey::KEYWORD_SEARCH_TERMS); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->isKeywordSearchTermsEnabled()) : ?>
                        checked
                    <?php endif; ?>
                >

                <?php esc_html_e('Searching by keyword will suggest specific terms.', 'listivo-core'); ?>
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::ENABLE_CACHE); ?>">
                <?php esc_html_e('Activate Caching', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::ENABLE_CACHE); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::ENABLE_CACHE); ?>"
                        id="<?php echo esc_attr(SettingKey::ENABLE_CACHE); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->isCacheEnabled()) : ?>
                        checked
                    <?php endif; ?>
                >

                <?php esc_html_e('Activates caching of results, enhancing performance by storing frequently used data.', 'listivo-core'); ?>
            </label>

            <p class="description">
                <a
                        class="button button-secondary"
                        href="<?php echo esc_url(admin_url('admin-post.php?action=tdf/cache/clear')); ?>"
                >
                    <?php esc_html_e('Clear Cache', 'listivo-core'); ?>
                </a>
            </p>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::CACHE_DURATION); ?>">
                <?php esc_html_e('Cache Duration (in seconds)', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    name="<?php echo esc_attr(SettingKey::CACHE_DURATION); ?>"
                    id="<?php echo esc_attr(SettingKey::CACHE_DURATION); ?>"
                    type="text"
                    value="<?php echo esc_attr(tdf_settings()->getCacheDuration()); ?>"
            >

            <p class="description">
                <?php esc_html_e('Determines the duration of the cache.', 'listivo-core'); ?>
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