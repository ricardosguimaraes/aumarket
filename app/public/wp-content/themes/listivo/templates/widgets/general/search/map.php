<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;
use Tangibledesign\Listivo\Widgets\General\Search\SearchMapWidget;

/* @var SearchMapWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstLocationField = $lstCurrentWidget->getLocationField();
if (!$lstLocationField) {
    return;
}

if (tdf_settings()->getMapProvider() === SettingKey::MAP_PROVIDER_GOOGLE_MAPS) :?>
    <lst-google-map-search-models
            prefix-class="listivo"
            map-selector=".listivo-map-results__map"
            map-container-selector=".listivo-map-search__map"
            :markers="props.markers"
            :field="<?php echo htmlspecialchars(json_encode($lstLocationField)); ?>"
            :card-selectors="<?php echo htmlspecialchars(json_encode($lstCurrentWidget->getCardSelectors())); ?>"
            :marker-clustering="<?php echo esc_attr($lstCurrentWidget->isMarkerClusteringEnabled() ? 'true' : 'false'); ?>"
            marker-type="<?php echo esc_attr($lstCurrentWidget->getMarkerType()); ?>"
            custom-label="<?php echo esc_attr(tdf_string('selected_area_on_the_map')); ?>"
    >
        <div slot-scope="map" class="listivo-map-results">
            <?php if (empty(tdf_settings()->getGoogleMapsApiKey())) : ?>
                <div class="listivo-google-maps-placeholder">
                    <div class="listivo-google-maps-placeholder__content">
                        <div class="listivo-google-maps-placeholder__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" viewBox="0 0 90 90"
                                 fill="none">
                                <circle cx="45" cy="45" r="45" fill="#EE7679"/>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M18 45C18 59.9117 30.0883 72 45 72C59.9117 72 72 59.9117 72 45C72 30.0883 59.9117 18 45 18C30.0883 18 18 30.0883 18 45ZM45 15C28.4315 15 15 28.4315 15 45C15 61.5685 28.4315 75 45 75C61.5685 75 75 61.5685 75 45C75 28.4315 61.5685 15 45 15Z"
                                      fill="#FDFDFE"/>
                                <path d="M44 59.5C44 58.6716 44.6716 58 45.5 58C46.3284 58 47 58.6716 47 59.5C47 60.3284 46.3284 61 45.5 61C44.6716 61 44 60.3284 44 59.5Z"
                                      fill="#FDFDFE"/>
                                <path d="M44 30.5C44 29.6716 44.6716 29 45.5 29C46.3284 29 47 29.6716 47 30.5V52.5C47 53.3284 46.3284 54 45.5 54C44.6716 54 44 53.3284 44 52.5V30.5Z"
                                      fill="#FDFDFE"/>
                            </svg>
                        </div>

                        <div class="listivo-google-maps-placeholder__text">
                            <?php esc_html_e('You must add Google maps API key to display map', 'listivo'); ?>
                        </div>

                        <?php if (is_user_logged_in() && current_user_can('manage_options')) : ?>
                            <a
                                    class="listivo-google-maps-placeholder__tip"
                                    href="<?php echo esc_url(admin_url('admin.php?page=listivo_maps')); ?>"
                                    target="_blank"
                            >
                                <?php esc_html_e('Click here to add Google Maps API Key', 'listivo'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="listivo-map-results__zoom-nav">
                <button
                        class="listivo-map-results__zoom-button"
                        @click.prevent="map.zoomIn"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="9" viewBox="0 0 8 9" fill="none">
                        <path d="M3.04952 8.678V5.51H0.0975157V3.656H3.04952V0.487999H4.95752V3.656H7.90952V5.51H4.95752V8.678H3.04952Z"
                              fill="#2A3946"/>
                    </svg>
                </button>

                <button
                        class="listivo-map-results__zoom-button"
                        @click.prevent="map.zoomOut"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="3" viewBox="0 0 8 3" fill="none">
                        <path d="M0.61593 2.914V0.826H7.38393V2.914H0.61593Z" fill="#2A3946"/>
                    </svg>
                </button>
            </div>

            <div
                    class="listivo-map-results__move-option"
                    :class="{'listivo-loading': props.inProgress}"
                    @click.prevent="map.setMapSearch"
            >
                <div
                        class="listivo-map-results__checkbox listivo-checkbox"
                        :class="{'listivo-checkbox--checked': map.mapSearch}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11" fill="none">
                        <path d="M11.7142 0.779513L10.6378 0.103783C10.3399 -0.0824758 9.93186 -0.011004 9.73252 0.261887L4.45585 7.44801L2.03093 5.20858C1.77765 4.97467 1.3649 4.97467 1.11162 5.20858L0.18996 6.05974C-0.06332 6.29364 -0.06332 6.67482 0.18996 6.9109L3.91881 10.3545C4.12753 10.5473 4.45585 10.6945 4.75135 10.6945C5.04684 10.6945 5.34468 10.5235 5.53698 10.2657L11.8877 1.61335C12.0894 1.34046 12.012 0.965772 11.7142 0.779513Z"
                              fill="#FDFDFE"/>
                    </svg>
                </div>

                <?php echo esc_html(tdf_string('search_as_i_move_the_map')); ?>
            </div>

            <div class="listivo-map-results__map"></div>
        </div>
    </lst-google-map-search-models>
<?php elseif (tdf_settings()->getMapProvider() === SettingKey::MAP_PROVIDER_OPEN_STREET_MAP) : ?>
    <lst-open-street-map-search-models
            prefix-class="listivo"
            map-selector=".listivo-map-results__map"
            map-container-selector=".listivo-map-search__map"
            :markers="props.markers"
            :current-tab="tabs.tab"
            :field="<?php echo htmlspecialchars(json_encode($lstLocationField)); ?>"
            :card-selectors="<?php echo htmlspecialchars(json_encode($lstCurrentWidget->getCardSelectors())); ?>"
            :marker-clustering="<?php echo esc_attr($lstCurrentWidget->isMarkerClusteringEnabled() ? 'true' : 'false'); ?>"
            marker-type="<?php echo esc_attr($lstCurrentWidget->getMarkerType()); ?>"
    >
        <div slot-scope="map" class="listivo-map-results">
            <div class="listivo-map-results__zoom-nav">
                <button
                        class="listivo-map-results__zoom-button"
                        @click.prevent="map.zoomIn"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="9" viewBox="0 0 8 9" fill="none">
                        <path d="M3.04952 8.678V5.51H0.0975157V3.656H3.04952V0.487999H4.95752V3.656H7.90952V5.51H4.95752V8.678H3.04952Z"
                              fill="#2A3946"/>
                    </svg>
                </button>

                <button
                        class="listivo-map-results__zoom-button"
                        @click.prevent="map.zoomOut"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="3" viewBox="0 0 8 3" fill="none">
                        <path d="M0.61593 2.914V0.826H7.38393V2.914H0.61593Z" fill="#2A3946"/>
                    </svg>
                </button>
            </div>

            <div
                    class="listivo-map-results__move-option"
                    :class="{'listivo-loading': props.inProgress}"
                    @click.prevent="map.setMapSearch"
            >
                <div
                        class="listivo-map-results__checkbox listivo-checkbox"
                        :class="{'listivo-checkbox--checked': map.mapSearch}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11" fill="none">
                        <path d="M11.7142 0.779513L10.6378 0.103783C10.3399 -0.0824758 9.93186 -0.011004 9.73252 0.261887L4.45585 7.44801L2.03093 5.20858C1.77765 4.97467 1.3649 4.97467 1.11162 5.20858L0.18996 6.05974C-0.06332 6.29364 -0.06332 6.67482 0.18996 6.9109L3.91881 10.3545C4.12753 10.5473 4.45585 10.6945 4.75135 10.6945C5.04684 10.6945 5.34468 10.5235 5.53698 10.2657L11.8877 1.61335C12.0894 1.34046 12.012 0.965772 11.7142 0.779513Z"
                              fill="#FDFDFE"/>
                    </svg>
                </div>

                <?php echo esc_html(tdf_string('search_as_i_move_the_map')); ?>
            </div>

            <div class="listivo-map-results__map"></div>
        </div>
    </lst-open-street-map-search-models>
<?php endif; ?>
