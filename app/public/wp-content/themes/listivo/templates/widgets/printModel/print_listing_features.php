<?php
/* @var \Tangibledesign\Listivo\Widgets\PrintModel\PrintListingFeaturesWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstTerms = $lstCurrentWidget->getTerms();
if ($lstTerms->isEmpty()) {
    return;
}

if (!empty($lstCurrentWidget->getLabel())) : ?>
    <h3 class="listivo-print-label listivo-print-label--margin-bottom">
        <?php echo esc_html($lstCurrentWidget->getLabel()); ?>
    </h3>
<?php endif; ?>

<div class="listivo-print-features">
    <?php foreach ($lstTerms as $lstTerm) : ?>
        <div class="listivo-print-features__feature">
            <div class="listivo-print-features__icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="9" viewBox="0 0 12 9" fill="none">
                    <path d="M10.6633 0.000289842C10.4901 0.0054506 10.3257 0.0778367 10.205 0.202113L3.34299 7.06409L1.14768 4.86878C1.08625 4.8048 1.01267 4.75372 0.931251 4.71853C0.849832 4.68334 0.76221 4.66474 0.673516 4.66384C0.584823 4.66294 0.49684 4.67974 0.414722 4.71327C0.332604 4.7468 0.258001 4.79637 0.195282 4.85909C0.132563 4.92181 0.0829883 4.99641 0.0494622 5.07853C0.0159361 5.16065 -0.000867871 5.24863 3.45076e-05 5.33732C0.000936886 5.42602 0.0195273 5.51364 0.0547172 5.59506C0.0899072 5.67648 0.140989 5.75006 0.204971 5.81149L2.87164 8.47816C2.99667 8.60313 3.16621 8.67334 3.34299 8.67334C3.51977 8.67334 3.68932 8.60313 3.81435 8.47816L11.1477 1.14482C11.244 1.05118 11.3098 0.930619 11.3365 0.798939C11.3631 0.667259 11.3493 0.530603 11.297 0.406879C11.2446 0.283156 11.1561 0.178136 11.043 0.105583C10.9299 0.0330305 10.7976 -0.0036704 10.6633 0.000289842Z"
                          fill="#537CD9"/>
                </svg>
            </div>

            <?php echo esc_html($lstTerm->getName()); ?>
        </div>
    <?php endforeach; ?>
</div>
