<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Listivo\Widgets\PrintModel\PrintListingMapWidget;

/* @var PrintListingMapWidget $lstCurrentWidget */
global $lstCurrentWidget;
$lstModel = $lstCurrentWidget->getModel();
if (!$lstModel instanceof Model) {
    return;
}

$lstLocationField = $lstCurrentWidget->getLocationField();
if (!$lstLocationField) {
    return;
}

$lstLocation = $lstLocationField->getLocation($lstModel);
if (!$lstLocation) {
    return;
}
?>
<div class="listivo-app">
    <?php if (tdf_settings()->getMapProvider() === SettingKey::MAP_PROVIDER_GOOGLE_MAPS) : ?>
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
    <?php elseif (tdf_settings()->getMapProvider() === SettingKey::MAP_PROVIDER_OPEN_STREET_MAP) : ?>
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