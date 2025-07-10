<?php

use Tangibledesign\Listivo\Widgets\General\ButtonWidget;

/* @var ButtonWidget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div
    <?php if (is_404() && tdf_settings()->isLegacyModeEnabled()) : ?>
        class="listivo-button-wrapper listivo-button-wrapper--center"
    <?php else : ?>
        class="listivo-button-wrapper"
    <?php endif; ?>
>
    <a
        <?php if ($lstCurrentWidget->isPrimary1Type()) : ?>
            class="listivo-button listivo-button--primary-1"
        <?php elseif ($lstCurrentWidget->isPrimary2Type()) : ?>
            class="listivo-button listivo-button--primary-2"
        <?php else : ?>
            class="listivo-button listivo-button--primary-1"
        <?php endif; ?>
            href="<?php echo esc_url($lstCurrentWidget->getUrl()); ?>"
            title="<?php echo esc_attr($lstCurrentWidget->getText()); ?>"
    >
        <span>
            <?php echo esc_html($lstCurrentWidget->getText()); ?>

            <?php if (!empty($lstCurrentWidget->getIcon())) : ?>
                <?php if ($lstCurrentWidget->isSvgIcon()) : ?>
                    <?php tdf_load_icon($lstCurrentWidget->getIcon()); ?>
                <?php else : ?>
                    <i class="<?php echo esc_attr($lstCurrentWidget->getIcon()); ?>"></i>
                <?php endif; ?>
            <?php else : ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                     fill="none">
                    <path d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49605 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455586 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z"
                          fill="#FDFDFE"/>
                </svg>
            <?php endif; ?>
        </span>
    </a>
</div>