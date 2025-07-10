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
            <?php esc_html_e('Map Integration', 'listivo-core'); ?>
        </div>
    </div>

    <div class="listivo-docs___content">
        <p>
            <?php echo wp_kses(
                __('Discover the steps to seamlessly <strong>add and configure maps</strong> in your service. Detailed guidance is just a click away.', 'listivo-core'),
                array('strong' => array())
            ); ?>        </p>
    </div>

    <a
            class="listivo-docs__button"
            href="https://support.listivotheme.com/support/solutions/articles/101000520414"
            target="_blank"
    >
        <?php esc_html_e('Go to Article', 'listivo-core'); ?>
    </a>
</div>

<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::MAP_PROVIDER); ?>">
                <?php esc_html_e('Map Provider', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <select
                    id="<?php echo esc_attr(SettingKey::MAP_PROVIDER); ?>"
                    name="<?php echo esc_attr(SettingKey::MAP_PROVIDER); ?>"
                    class="tdf-selectize tdf-selectize-init"
            >
                <option
                        value="<?php echo esc_attr(SettingKey::MAP_PROVIDER_GOOGLE_MAPS); ?>"
                    <?php if (tdf_settings()->getMapProvider() === SettingKey::MAP_PROVIDER_GOOGLE_MAPS) : ?>
                        selected
                    <?php endif; ?>
                >
                    <?php esc_html_e('Google Maps', 'listivo-core'); ?>
                </option>

                <option
                        value="<?php echo esc_attr(SettingKey::MAP_PROVIDER_OPEN_STREET_MAP); ?>"
                    <?php if (tdf_settings()->getMapProvider() === SettingKey::MAP_PROVIDER_OPEN_STREET_MAP) : ?>
                        selected
                    <?php endif; ?>
                >
                    <?php esc_html_e('Open Street Map', 'listivo-core'); ?>
                </option>
            </select>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::GOOGLE_MAPS_API_KEY); ?>">
                <?php esc_html_e('Google Maps API Key', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::GOOGLE_MAPS_API_KEY); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::GOOGLE_MAPS_API_KEY); ?>"
                        id="<?php echo esc_attr(SettingKey::GOOGLE_MAPS_API_KEY); ?>"
                        class="regular-text"
                        type="text"
                        value="<?php echo esc_attr(tdf_settings()->getGoogleMapsApiKey()); ?>"
                >

                <p class="description">
                    <a
                            href="https://support.listivotheme.com/support/solutions/articles/101000373809-how-to-turn-on-google-maps-how-to-obtain-google-maps-api-key"
                            target="_blank"
                    >
                        <?php esc_html_e('Learn how to get api key', 'listivo-core'); ?>
                    </a>
                </p>
            </label>
        </td>
    </tr>

    <?php if (!empty(tdf_settings()->getGoogleMapsApiKey())) : ?>
        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr(SettingKey::MAP_INITIAL_LOCATION); ?>">
                    <?php esc_html_e('Initial Location', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                <lst-set-location
                        map-id="listivo-initial-location"
                        input-id="<?php echo esc_attr(SettingKey::MAP_INITIAL_LOCATION); ?>"
                        :initial-location="<?php echo htmlspecialchars(json_encode(tdf_settings()->getMapInitialLocation())); ?>"
                        :initial-zoom-level="<?php echo esc_attr(tdf_settings()->getMapZoomLevel()); ?>"
                >
                    <div slot-scope="props">
                        <input
                                name="<?php echo esc_attr(SettingKey::MAP_INITIAL_LOCATION); ?>[lat]"
                                type="hidden"
                                :value="props.location.lat"
                        >

                        <input
                                name="<?php echo esc_attr(SettingKey::MAP_INITIAL_LOCATION); ?>[lng]"
                                type="hidden"
                                :value="props.location.lng"
                        >

                        <p>
                            <input
                                    id="<?php echo esc_attr(SettingKey::MAP_INITIAL_LOCATION); ?>"
                                    class="regular-text"
                                    type="text"
                            >
                        </p>

                        <div>
                            <div
                                    id="listivo-initial-location"
                                    class="tdf-map-initial-location"
                            ></div>
                        </div>

                        <p v-if="props.apiKeyError" class="description">
                            <?php esc_html_e('Invalid Google Maps Api Key', 'listivo-core'); ?>
                        </p>
                    </div>
                </lst-set-location>
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr(SettingKey::MAP_ZOOM_LEVEL); ?>">
                    <?php esc_html_e('Zoom Level', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                <label for="<?php echo esc_attr(SettingKey::MAP_ZOOM_LEVEL); ?>">
                    <input
                            name="<?php echo esc_attr(SettingKey::MAP_ZOOM_LEVEL); ?>"
                            id="<?php echo esc_attr(SettingKey::MAP_ZOOM_LEVEL); ?>"
                            class="regular-text"
                            type="text"
                            value="<?php echo esc_attr(tdf_settings()->getMapZoomLevel()); ?>"
                    >
                </label>
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr(SettingKey::MAP_DEFAULT_RADIUS); ?>">
                    <?php esc_html_e('Default Radius', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                <label for="<?php echo esc_attr(SettingKey::MAP_DEFAULT_RADIUS); ?>">
                    <input
                            name="<?php echo esc_attr(SettingKey::MAP_DEFAULT_RADIUS); ?>"
                            id="<?php echo esc_attr(SettingKey::MAP_DEFAULT_RADIUS); ?>"
                            class="regular-text"
                            type="text"
                            value="<?php echo esc_attr(tdf_settings()->getMapDefaultRadius()); ?>"
                    >
                </label>
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr(SettingKey::MAP_RADIUS_UNIT); ?>">
                    <?php esc_html_e('Radius Unit', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                <label for="<?php echo esc_attr(SettingKey::MAP_RADIUS_UNIT); ?>">
                    <select
                            name="<?php echo esc_attr(SettingKey::MAP_RADIUS_UNIT); ?>"
                            id="<?php echo esc_attr(SettingKey::MAP_RADIUS_UNIT); ?>"
                            class="tdf-selectize tdf-selectize-init"
                    >
                        <option
                                value="<?php echo esc_attr(SettingKey::MAP_RADIUS_UNIT_KM); ?>"
                            <?php if (tdf_settings()->getMapRadiusUnit() === SettingKey::MAP_RADIUS_UNIT_KM) : ?>
                                selected
                            <?php endif; ?>
                        >
                            <?php esc_attr_e('KM', 'listivo-core'); ?>
                        </option>

                        <option
                                value="<?php echo esc_attr(SettingKey::MAP_RADIUS_UNIT_MILES); ?>"
                            <?php if (tdf_settings()->getMapRadiusUnit() === SettingKey::MAP_RADIUS_UNIT_MILES) : ?>
                                selected
                            <?php endif; ?>
                        >
                            <?php esc_attr_e('Miles', 'listivo-core'); ?>
                        </option>
                    </select>
                </label>
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr(SettingKey::MAP_LANGUAGE); ?>">
                    <?php esc_html_e('Language', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                <select
                        name="<?php echo esc_attr(SettingKey::MAP_LANGUAGE); ?>"
                        id="<?php echo esc_attr(SettingKey::MAP_LANGUAGE); ?>"
                        class="tdf-selectize tdf-selectize-init"
                >
                    <?php foreach (tdf_app('google_map_languages') as $lstLanguageCode => $lstLanguageName) : ?>
                        <option
                                value="<?php echo esc_attr($lstLanguageCode); ?>"
                            <?php if (tdf_settings()->getMapLanguage() === $lstLanguageCode) : ?>
                                selected
                            <?php endif; ?>
                        >
                            <?php echo esc_html($lstLanguageName); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="<?php echo esc_attr(SettingKey::MAP_SNAZZY); ?>">
                    <?php esc_html_e('Snazzy', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                <textarea
                        name="<?php echo esc_attr(SettingKey::MAP_SNAZZY); ?>"
                        id="<?php echo esc_attr(SettingKey::MAP_SNAZZY); ?>"
                        class="listivo-backend-text-area"
                        rows="5"
                        cols="30"
                ><?php echo tdf_settings()->getMapSnazzy(); ?></textarea>
            </td>
        </tr>
    <?php endif; ?>
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
                href="https://support.listivotheme.com/support/solutions/articles/101000521260-enabling-marker-clustering-in-map-widgets"
                target="_blank"
        >
            <div class="listivo-docs__number">1.</div>

            <?php esc_html_e('Enabling Marker Clustering in Map Widgets', 'listivo-core'); ?>
        </a>

        <a
                class="listivo-docs__item"
                href="https://support.listivotheme.com/support/solutions/articles/101000521288-customizing-location-input-for-the-ad-add-form-in-listivo"
                target="_blank"
        >
            <div class="listivo-docs__number">2.</div>

            <?php esc_html_e('Customizing Location Input for the Ad Add Form in Listivo', 'listivo-core'); ?>
        </a>

        <a
                class="listivo-docs__item"
                href="https://support.listivotheme.com/support/solutions/articles/101000521262-automatically-ask-for-the-current-user-location"
                target="_blank"
        >
            <div class="listivo-docs__number">3.</div>

            <?php esc_html_e('Automatically Ask for the Current User Location', 'listivo-core'); ?>
        </a>

        <a
                class="listivo-docs__item"
                href="https://support.listivotheme.com/support/solutions/articles/101000479754-location-field-based-on-predefined-list-taxonomy-instead-of-google-maps"
                target="_blank"
        >
            <div class="listivo-docs__number">4.</div>

            <?php esc_html_e('Location Field Based on Predefined List Taxonomy Instead of Google Maps', 'listivo-core'); ?>
        </a>

        <a
                class="listivo-docs__item"
                href="https://support.listivotheme.com/support/solutions/articles/101000520411-understanding-the-search-radius-feature-in-listivo"
                target="_blank"
        >
            <div class="listivo-docs__number">5.</div>

            <?php esc_html_e('Understanding the Search Radius Feature in Listivo', 'listivo-core'); ?>
        </a>

        <a
                class="listivo-docs__item"
                href="https://support.listivotheme.com/support/solutions/articles/101000521259-configuring-map-pins"
                target="_blank"
        >
            <div class="listivo-docs__number">6.</div>

            <?php esc_html_e('Configuring Map Pins', 'listivo-core'); ?>
        </a>

        <a
                class="listivo-docs__item"
                href="https://support.listivotheme.com/support/solutions/articles/101000521261-limiting-google-maps-autocomplete-to-specific-countries-on-your-website"
                target="_blank"
        >
            <div class="listivo-docs__number">7.</div>

            <?php esc_html_e('Limiting Google Maps Autocomplete to Specific Countries on Your Website', 'listivo-core'); ?>
        </a>

        <a
                class="listivo-docs__item"
                href="https://support.listivotheme.com/support/solutions/articles/101000373810-how-to-customize-google-maps-with-snazzy-maps-styles"
                target="_blank"
        >
            <div class="listivo-docs__number">8.</div>

            <?php esc_html_e('How to Customize Google Maps with Snazzy Maps Styles', 'listivo-core'); ?>
        </a>

        <a
                class="listivo-docs__item"
                href="https://support.listivotheme.com/support/solutions/articles/101000520253-integrating-openstreetmap-a-hybrid-approach"
                target="_blank"
        >
            <div class="listivo-docs__number">9.</div>

            <?php esc_html_e('Integrating OpenStreetMap: A Hybrid Approach', 'listivo-core'); ?>
        </a>
    </div>
</div>