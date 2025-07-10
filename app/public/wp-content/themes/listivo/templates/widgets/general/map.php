<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;
use Tangibledesign\Framework\Widgets\General\MapWidget;

/* @var MapWidget $lstCurrentWidget */
global $lstCurrentWidget;
$lstMarkerType = $lstCurrentWidget->getMarkerType();
$lstMapProvider = tdf_settings()->getMapProvider();
?>
<div class="listivo-app">
    <?php if ($lstMapProvider === SettingKey::MAP_PROVIDER_GOOGLE_MAPS && !empty(tdf_settings()->getGoogleMapsApiKey())) : ?>
        <lst-simple-google-map
                map-id="listivo-map-<?php echo esc_attr($lstCurrentWidget->get_id()); ?>"
                map-type="roadmap"
                :position="<?php echo htmlspecialchars(json_encode($lstCurrentWidget->getPosition())); ?>"
                :zoom="<?php echo esc_attr($lstCurrentWidget->getZoom()); ?>"
                marker-type="<?php echo esc_attr($lstMarkerType); ?>"
                marker-id="listivo-map-marker-<?php echo esc_attr($lstCurrentWidget->get_id()); ?>"
                icon="<?php echo esc_attr($lstCurrentWidget->getIcon()); ?>"
        >
            <div slot-scope="props">
                <div
                        id="listivo-map-<?php echo esc_attr($lstCurrentWidget->get_id()); ?>"
                        class="listivo-map"
                ></div>

                <div class="listivo-map-marker-hide">
                    <?php if ($lstMarkerType === 'big') : ?>


                    <?php elseif ($lstMarkerType === 'small') : ?>
                        <div
                                id="listivo-map-marker-<?php echo esc_attr($lstCurrentWidget->get_id()); ?>"
                                class="listivo-map-marker"
                        >
                            <div class="listivo-map-marker__small-circle"></div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </lst-simple-google-map>
    <?php endif; ?>

    <?php if ($lstMapProvider === SettingKey::MAP_PROVIDER_OPEN_STREET_MAP) : ?>
        <lst-simple-open-street-map
                map-id="listivo-listing__map-<?php echo esc_attr($lstCurrentWidget->get_id()); ?>"
                :zoom="<?php echo esc_attr(tdf_settings()->getMapZoomLevel()); ?>"
                :position="<?php echo htmlspecialchars(json_encode($lstCurrentWidget->getPosition())); ?>"
                marker-type="<?php echo esc_attr($lstCurrentWidget->getMarkerType()); ?>"
                icon="<?php echo esc_attr($lstCurrentWidget->getIcon()); ?>"
        >
            <div slot-scope="props">
                <div
                        id="listivo-listing__map-<?php echo esc_attr($lstCurrentWidget->get_id()); ?>"
                        class="listivo-map"
                ></div>
            </div>
        </lst-simple-open-street-map>
    <?php endif; ?>
</div>
