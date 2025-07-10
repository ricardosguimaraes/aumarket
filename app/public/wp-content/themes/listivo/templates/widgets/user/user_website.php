<?php

use Tangibledesign\Listivo\Widgets\User\UserWebsite;

/* @var UserWebsite $lstCurrentWidget */
global $lstCurrentWidget;

$lstWebsite = $lstCurrentWidget->getWebsite();
if (empty($lstWebsite)) {
    return;
}
?>
<a
        class="listivo-user-website"
        href="<?php echo esc_url($lstWebsite); ?>"
    <?php if ($lstCurrentWidget->openInNewWindow()): ?>
        target="_blank"
    <?php endif; ?>
>
    <?php echo esc_html($lstCurrentWidget->getText()); ?>
</a>

