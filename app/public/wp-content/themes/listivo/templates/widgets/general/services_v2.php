<?php
/* @var \Tangibledesign\Listivo\Widgets\General\ServicesV2Widget $lstCurrentWidget */
global $lstCurrentWidget;

$lstServices = $lstCurrentWidget->getServices();
if (empty($lstServices)) {
    return;
}
?>
<div class="listivo-services-v2">
    <?php foreach ($lstServices as $lstService) : ?>
        <div class="listivo-service-v2">
            <div class="listivo-service-v2__icon">
                <?php if ($lstService['icon']['type'] === 'regular') : ?>
                    <i class="<?php echo esc_attr($lstService['icon']['value']); ?>"></i>
                <?php elseif ($lstService['icon']['type'] === 'svg') : ?>
                    <?php echo tdf_load_icon($lstService['icon']['value']); ?>
                <?php endif; ?>
            </div>

            <h4 class="listivo-service-v2__name">
                <?php echo esc_html($lstService['name']); ?>
            </h4>

            <div class="listivo-service-v2__description">
                <?php echo wp_kses_post($lstService['description']); ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>