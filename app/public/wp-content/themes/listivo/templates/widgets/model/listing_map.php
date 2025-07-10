<?php

use Tangibledesign\Listivo\Widgets\Listing\ListingMapWidget;

/* @var ListingMapWidget $lstCurrentWidget */
global $lstCurrentWidget;
if (empty(tdf_settings()->getGoogleMapsApiKey())) {
    return;
}

$lstLocationField = $lstCurrentWidget->getLocationField();
if (!$lstLocationField) {
    return;
}

$lstLocation = $lstCurrentWidget->getLocation();
if (!$lstLocation) {
    return;
}
?>

<div class="listivo-listing-map-anchor"></div>

<div class="listivo-listing-section listivo-app">
    <?php if ($lstCurrentWidget->showLabel()) : ?>
        <h3 class="listivo-listing-section__label">
            <?php echo esc_html($lstCurrentWidget->getLabel()); ?>
        </h3>
    <?php endif; ?>

    <div class="listivo-listing-section__content">
        <?php if (tdf_settings()->getMapProvider() === \Tangibledesign\Framework\Core\Settings\SettingKey::MAP_PROVIDER_GOOGLE_MAPS) : ?>
            <lst-simple-google-map
                    map-id="listivo-listing-map-<?php echo esc_attr($lstCurrentWidget->get_id()); ?>"
                    map-type="<?php echo esc_attr($lstLocationField->getMapType()); ?>"
                    :zoom="<?php echo esc_attr(tdf_settings()->getMapZoomLevel()); ?>"
                    :position="<?php echo htmlspecialchars(json_encode($lstLocation)); ?>"
            >
                <div
                        slot-scope="props"
                        id="listivo-listing-map-<?php echo esc_attr($lstCurrentWidget->get_id()); ?>"
                        class="listivo-listing-map"
                ></div>
            </lst-simple-google-map>
        <?php elseif (tdf_settings()->getMapProvider() === \Tangibledesign\Framework\Core\Settings\SettingKey::MAP_PROVIDER_OPEN_STREET_MAP) : ?>
            <lst-simple-open-street-map
                    map-id="listivo-listing-map-<?php echo esc_attr($lstCurrentWidget->get_id()); ?>"
                    :zoom="<?php echo esc_attr(tdf_settings()->getMapZoomLevel()); ?>"
                    :position="<?php echo htmlspecialchars(json_encode($lstLocation)); ?>"
            >
                <div
                        slot-scope="props"
                        id="listivo-listing-map-<?php echo esc_attr($lstCurrentWidget->get_id()); ?>"
                        class="listivo-listing-map"
                ></div>
            </lst-simple-open-street-map>
        <?php endif; ?>
    </div>
</div>