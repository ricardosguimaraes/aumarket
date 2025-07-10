<?php
/* @var \Tangibledesign\Listivo\Widgets\General\PaymentPackagePricingTableWidget $lstCurrentWidget */
global $lstCurrentWidget;
$lstPaymentPackages = $lstCurrentWidget->getPaymentPackages();
if ($lstPaymentPackages->isEmpty()) {
    return;
}
?>
<div class="listivo-pricing-table">
    <?php
    foreach ($lstCurrentWidget->getPaymentPackages() as $lstPaymentPackage) :
        /* @var \Tangibledesign\Framework\Models\Payments\PaymentPackage $lstPaymentPackage */
        ?>
        <div
            <?php if ($lstPaymentPackage->isFeatured()): ?>
                class="listivo-panel-package-v2 listivo-panel-package-v2--featured listivo-panel-package-v2--no-bottom"
            <?php else : ?>
                class="listivo-panel-package-v2 listivo-panel-package-v2--no-bottom"
            <?php endif; ?>
        >
            <div class="listivo-panel-package-v2__head listivo-panel-package-v2__head--<?php echo esc_attr($lstPaymentPackage->getKey()); ?>">
                <div>
                    <?php echo esc_html($lstPaymentPackage->getName()); ?>
                </div>

                <?php if (!empty($lstPaymentPackage->getLabel())) : ?>
                    <div class="listivo-panel-package-v2__label">
                        <?php echo esc_html($lstPaymentPackage->getLabel()); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="listivo-panel-package-v2__body">
                <?php if (!empty($lstPaymentPackage->getDisplayPrice())) : ?>
                    <div class="listivo-panel-package-v2__main-value">
                        <?php echo esc_html($lstPaymentPackage->getDisplayPrice()); ?>
                    </div>
                <?php endif; ?>

                <div class="listivo-panel-package-v2__button">
                    <a
                            class="listivo-simple-button listivo-simple-button--background-primary-1"
                        <?php if (!is_user_logged_in()) : ?>
                            href="<?php echo esc_url(tdf_settings()->getLoginPageUrl()); ?>"
                        <?php else : ?>
                            href="<?php echo esc_url(admin_url('admin-ajax.php?action=listivo/paymentPackage/purchase&id=' . $lstPaymentPackage->getId())); ?>"
                        <?php endif; ?>
                    >
                        <?php echo esc_html(tdf_string('choose_this_package')) ?>
                    </a>
                </div>

                <?php if (!empty($lstPaymentPackage->getText())): ?>
                    <div class="listivo-panel-package-v2__description">
                        <?php echo esc_html($lstPaymentPackage->getText()); ?>
                    </div>
                <?php endif; ?>

                <div class="listivo-panel-package-v2__attributes">
                    <?php if ($lstPaymentPackage->isRegularPackage()) : ?>
                        <?php if (!empty($lstPaymentPackage->getNumber()) && $lstPaymentPackage->getNumber() !== 1) : ?>
                            <div class="listivo-panel-package-v2__attribute">
                                <div class="listivo-panel-package-v2__attribute-icon-wrapper">
                                    <div class="listivo-panel-package-v2__attribute-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="9" viewBox="0 0 12 9"
                                             fill="none">
                                            <path d="M10.6633 0.000289842C10.4901 0.0054506 10.3257 0.0778367 10.205 0.202113L3.34299 7.06409L1.14768 4.86878C1.08625 4.8048 1.01267 4.75372 0.931251 4.71853C0.849832 4.68334 0.76221 4.66474 0.673516 4.66384C0.584823 4.66294 0.49684 4.67974 0.414722 4.71327C0.332604 4.7468 0.258001 4.79637 0.195282 4.85909C0.132563 4.92181 0.0829883 4.99641 0.0494622 5.07853C0.0159361 5.16065 -0.000867871 5.24863 3.45076e-05 5.33732C0.000936886 5.42602 0.0195273 5.51364 0.0547172 5.59506C0.0899072 5.67648 0.140989 5.75006 0.204971 5.81149L2.87164 8.47816C2.99667 8.60313 3.16621 8.67334 3.34299 8.67334C3.51977 8.67334 3.68932 8.60313 3.81435 8.47816L11.1477 1.14482C11.244 1.05118 11.3098 0.930619 11.3365 0.798939C11.3631 0.667259 11.3493 0.530603 11.297 0.406879C11.2446 0.283156 11.1561 0.178136 11.043 0.105583C10.9299 0.0330305 10.7976 -0.0036704 10.6633 0.000289842Z"
                                                  fill="#374B5C"/>
                                        </svg>
                                    </div>
                                </div>

                                <div class="listivo-panel-package-v2__attribute-value">
                                    <?php echo esc_html(tdf_string('listings')); ?>:

                                    <span><?php echo esc_html($lstPaymentPackage->getNumber()) ?></span>x
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="listivo-panel-package-v2__attribute">
                            <div class="listivo-panel-package-v2__attribute-icon-wrapper">
                                <div class="listivo-panel-package-v2__attribute-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="9" viewBox="0 0 12 9"
                                         fill="none">
                                        <path d="M10.6633 0.000289842C10.4901 0.0054506 10.3257 0.0778367 10.205 0.202113L3.34299 7.06409L1.14768 4.86878C1.08625 4.8048 1.01267 4.75372 0.931251 4.71853C0.849832 4.68334 0.76221 4.66474 0.673516 4.66384C0.584823 4.66294 0.49684 4.67974 0.414722 4.71327C0.332604 4.7468 0.258001 4.79637 0.195282 4.85909C0.132563 4.92181 0.0829883 4.99641 0.0494622 5.07853C0.0159361 5.16065 -0.000867871 5.24863 3.45076e-05 5.33732C0.000936886 5.42602 0.0195273 5.51364 0.0547172 5.59506C0.0899072 5.67648 0.140989 5.75006 0.204971 5.81149L2.87164 8.47816C2.99667 8.60313 3.16621 8.67334 3.34299 8.67334C3.51977 8.67334 3.68932 8.60313 3.81435 8.47816L11.1477 1.14482C11.244 1.05118 11.3098 0.930619 11.3365 0.798939C11.3631 0.667259 11.3493 0.530603 11.297 0.406879C11.2446 0.283156 11.1561 0.178136 11.043 0.105583C10.9299 0.0330305 10.7976 -0.0036704 10.6633 0.000289842Z"
                                              fill="#374B5C"/>
                                    </svg>
                                </div>
                            </div>

                            <div class="listivo-panel-package-v2__attribute-value">
                                <?php echo esc_html(tdf_string('duration')); ?>:

                                <span>
                            <?php if (!empty($lstPaymentPackage->getExpire())) : ?>
                                <?php echo esc_html($lstPaymentPackage->getExpire()); ?>

                                <?php if ($lstPaymentPackage->getExpire() !== 1) : ?>
                                    <?php echo esc_html(tdf_string('days')); ?>
                                <?php else : ?>
                                    <?php echo esc_html(tdf_string('day')); ?>
                                <?php endif; ?>
                            <?php else : ?>
                                <?php echo esc_html(tdf_string('unlimited')); ?>
                            <?php endif; ?>
                        </span>
                            </div>
                        </div>

                        <?php if (!empty($lstPaymentPackage->getFeaturedExpire())) : ?>
                            <div class="listivo-panel-package-v2__attribute">
                                <div class="listivo-panel-package-v2__attribute-icon-wrapper">
                                    <div class="listivo-panel-package-v2__attribute-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="9" viewBox="0 0 12 9"
                                             fill="none">
                                            <path d="M10.6633 0.000289842C10.4901 0.0054506 10.3257 0.0778367 10.205 0.202113L3.34299 7.06409L1.14768 4.86878C1.08625 4.8048 1.01267 4.75372 0.931251 4.71853C0.849832 4.68334 0.76221 4.66474 0.673516 4.66384C0.584823 4.66294 0.49684 4.67974 0.414722 4.71327C0.332604 4.7468 0.258001 4.79637 0.195282 4.85909C0.132563 4.92181 0.0829883 4.99641 0.0494622 5.07853C0.0159361 5.16065 -0.000867871 5.24863 3.45076e-05 5.33732C0.000936886 5.42602 0.0195273 5.51364 0.0547172 5.59506C0.0899072 5.67648 0.140989 5.75006 0.204971 5.81149L2.87164 8.47816C2.99667 8.60313 3.16621 8.67334 3.34299 8.67334C3.51977 8.67334 3.68932 8.60313 3.81435 8.47816L11.1477 1.14482C11.244 1.05118 11.3098 0.930619 11.3365 0.798939C11.3631 0.667259 11.3493 0.530603 11.297 0.406879C11.2446 0.283156 11.1561 0.178136 11.043 0.105583C10.9299 0.0330305 10.7976 -0.0036704 10.6633 0.000289842Z"
                                                  fill="#374B5C"/>
                                        </svg>
                                    </div>
                                </div>

                                <div class="listivo-panel-package-v2__attribute-value">
                                    <?php echo esc_html(tdf_string('featured')); ?>:

                                    <span>
                                <?php echo esc_html($lstPaymentPackage->getFeaturedExpire()); ?>

                                <?php if ($lstPaymentPackage->getFeaturedExpire() !== 1) : ?>
                                    <?php echo esc_html(tdf_string('days')); ?>
                                <?php else : ?>
                                    <?php echo esc_html(tdf_string('day')); ?>
                                <?php endif; ?>
                            </span>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($lstPaymentPackage->getBumpsNumber()) && !empty($lstPaymentPackage->getBumpsInterval())) : ?>
                            <div class="listivo-panel-package-v2__attribute">
                                <div class="listivo-panel-package-v2__attribute-icon-wrapper">
                                    <div class="listivo-panel-package-v2__attribute-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="9" viewBox="0 0 12 9"
                                             fill="none">
                                            <path d="M10.6633 0.000289842C10.4901 0.0054506 10.3257 0.0778367 10.205 0.202113L3.34299 7.06409L1.14768 4.86878C1.08625 4.8048 1.01267 4.75372 0.931251 4.71853C0.849832 4.68334 0.76221 4.66474 0.673516 4.66384C0.584823 4.66294 0.49684 4.67974 0.414722 4.71327C0.332604 4.7468 0.258001 4.79637 0.195282 4.85909C0.132563 4.92181 0.0829883 4.99641 0.0494622 5.07853C0.0159361 5.16065 -0.000867871 5.24863 3.45076e-05 5.33732C0.000936886 5.42602 0.0195273 5.51364 0.0547172 5.59506C0.0899072 5.67648 0.140989 5.75006 0.204971 5.81149L2.87164 8.47816C2.99667 8.60313 3.16621 8.67334 3.34299 8.67334C3.51977 8.67334 3.68932 8.60313 3.81435 8.47816L11.1477 1.14482C11.244 1.05118 11.3098 0.930619 11.3365 0.798939C11.3631 0.667259 11.3493 0.530603 11.297 0.406879C11.2446 0.283156 11.1561 0.178136 11.043 0.105583C10.9299 0.0330305 10.7976 -0.0036704 10.6633 0.000289842Z"
                                                  fill="#374B5C"/>
                                        </svg>
                                    </div>
                                </div>

                                <div class="listivo-panel-package-v2__attribute-value">
                                    <?php echo esc_html(tdf_string('bump_up')); ?>:

                                    <span>
                                <?php echo esc_html($lstPaymentPackage->getBumpsNumber()); ?>x
                            </span>
                                </div>
                            </div>

                            <div class="listivo-panel-package-v2__attribute">
                                <div class="listivo-panel-package-v2__attribute-icon-wrapper">
                                    <div class="listivo-panel-package-v2__attribute-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="9" viewBox="0 0 12 9"
                                             fill="none">
                                            <path d="M10.6633 0.000289842C10.4901 0.0054506 10.3257 0.0778367 10.205 0.202113L3.34299 7.06409L1.14768 4.86878C1.08625 4.8048 1.01267 4.75372 0.931251 4.71853C0.849832 4.68334 0.76221 4.66474 0.673516 4.66384C0.584823 4.66294 0.49684 4.67974 0.414722 4.71327C0.332604 4.7468 0.258001 4.79637 0.195282 4.85909C0.132563 4.92181 0.0829883 4.99641 0.0494622 5.07853C0.0159361 5.16065 -0.000867871 5.24863 3.45076e-05 5.33732C0.000936886 5.42602 0.0195273 5.51364 0.0547172 5.59506C0.0899072 5.67648 0.140989 5.75006 0.204971 5.81149L2.87164 8.47816C2.99667 8.60313 3.16621 8.67334 3.34299 8.67334C3.51977 8.67334 3.68932 8.60313 3.81435 8.47816L11.1477 1.14482C11.244 1.05118 11.3098 0.930619 11.3365 0.798939C11.3631 0.667259 11.3493 0.530603 11.297 0.406879C11.2446 0.283156 11.1561 0.178136 11.043 0.105583C10.9299 0.0330305 10.7976 -0.0036704 10.6633 0.000289842Z"
                                                  fill="#374B5C"/>
                                        </svg>
                                    </div>
                                </div>

                                <div class="listivo-panel-package-v2__attribute-value">
                                    <?php echo esc_html(tdf_string('bumps_interval')); ?>:

                                    <span>
                                <?php if ($lstPaymentPackage->getBumpsInterval() === 1) : ?>
                                    <?php echo sprintf(esc_html('%d ' . tdf_string('day')),
                                        $lstPaymentPackage->getBumpsInterval()); ?>
                                <?php else : ?>
                                    <?php echo sprintf(esc_html('%d ' . tdf_string('days')),
                                        $lstPaymentPackage->getBumpsInterval()); ?>
                                <?php endif; ?>
                            </span>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($lstPaymentPackage->isBumpPackage()) : ?>
                        <div class="listivo-panel-package-v2__attribute">
                            <div class="listivo-panel-package-v2__attribute-icon-wrapper">
                                <div class="listivo-panel-package-v2__attribute-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="9" viewBox="0 0 12 9"
                                         fill="none">
                                        <path d="M10.6633 0.000289842C10.4901 0.0054506 10.3257 0.0778367 10.205 0.202113L3.34299 7.06409L1.14768 4.86878C1.08625 4.8048 1.01267 4.75372 0.931251 4.71853C0.849832 4.68334 0.76221 4.66474 0.673516 4.66384C0.584823 4.66294 0.49684 4.67974 0.414722 4.71327C0.332604 4.7468 0.258001 4.79637 0.195282 4.85909C0.132563 4.92181 0.0829883 4.99641 0.0494622 5.07853C0.0159361 5.16065 -0.000867871 5.24863 3.45076e-05 5.33732C0.000936886 5.42602 0.0195273 5.51364 0.0547172 5.59506C0.0899072 5.67648 0.140989 5.75006 0.204971 5.81149L2.87164 8.47816C2.99667 8.60313 3.16621 8.67334 3.34299 8.67334C3.51977 8.67334 3.68932 8.60313 3.81435 8.47816L11.1477 1.14482C11.244 1.05118 11.3098 0.930619 11.3365 0.798939C11.3631 0.667259 11.3493 0.530603 11.297 0.406879C11.2446 0.283156 11.1561 0.178136 11.043 0.105583C10.9299 0.0330305 10.7976 -0.0036704 10.6633 0.000289842Z"
                                              fill="#374B5C"/>
                                    </svg>
                                </div>
                            </div>

                            <div class="listivo-panel-package-v2__attribute-value">
                                <?php echo esc_html(tdf_string('bump_up')); ?>:

                                <span><?php echo esc_html($lstPaymentPackage->getBumpsNumber()) ?></span>x
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

