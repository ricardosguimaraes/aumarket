<?php
/* @var \Tangibledesign\Listivo\Widgets\Listing\UserProfileButtonWidget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="<?php echo esc_attr($lstCurrentWidget->getAlignmentClass()); ?>">
    <a
            class="listivo-primary-outline-button listivo-primary-outline-button--full-width"
            href="<?php echo esc_url($lstCurrentWidget->getButtonUrl()); ?>"
    >
        <span class="listivo-primary-outline-button__text">
            <?php echo esc_html($lstCurrentWidget->getButtonText()); ?>
        </span>

        <span class="listivo-primary-outline-button__icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
            </svg>
        </span>
    </a>
</div>