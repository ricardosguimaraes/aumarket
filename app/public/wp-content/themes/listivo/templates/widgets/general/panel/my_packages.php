<?php

use Tangibledesign\Framework\Models\User\User;
use Tangibledesign\Framework\Widgets\General\PanelWidget;

/* @var \Tangibledesign\Listivo\Widgets\General\PanelWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstCurrentUser = tdf_current_user();
if (!$lstCurrentUser instanceof User) {
    return;
}
?>
<div class="listivo-panel-head">
    <div class="listivo-container">
        <h1 class="listivo-panel-head__label">
            <?php echo esc_html(tdf_string('my_packages')); ?>
        </h1>
    </div>
</div>

<div class="listivo-panel-section">
    <div class="listivo-container">
        <div class="listivo-panel-section__content listivo-panel-section__content--no-margin-top">
            <?php if ($lstCurrentUser->getBumpsNumber() > 0 && tdf_settings()->bumpsEnabled()) : ?>
                <div class="listivo-panel-section__bumps">
                    <?php echo esc_html(tdf_string('number_of_available_bumps')); ?>
                    <span><?php echo esc_html($lstCurrentUser->getBumpsNumber()); ?></span>
                </div>
            <?php endif; ?>

            <template>
                <lst-select-package
                        request-url="<?php echo esc_url(admin_url('admin-ajax.php?action=listivo/monetization/selectPackage')); ?>"
                        close-text="<?php echo esc_attr(tdf_string('close')); ?>"
                        error-title="<?php echo esc_attr(tdf_string('something_went_wrong')); ?>"
                        initial-tab="<?php echo esc_attr(tdf_current_user()->hasPackages() ? 'my' : 'buy'); ?>"
                >
                    <div slot-scope="props">
                        <div class="listivo-panel-packages">
                            <?php
                            global $lstPackage;
                            foreach (tdf_current_user()->getNotEmptyPackages() as $lstPackage) :?>
                                <a href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_CREATE) . '?package=' . $lstPackage->getId()); ?>">
                                    <?php get_template_part('templates/widgets/general/panel/my_package'); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </lst-select-package>
            </template>
        </div>
    </div>
</div>