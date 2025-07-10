<?php

use Tangibledesign\Listivo\Widgets\User\AccountTypeUserWidget;

/* @var AccountTypeUserWidget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-user-account-type">
    <?php if (!empty($lstCurrentWidget->getLabel())) : ?>
        <div class="listivo-user-account-type__label">
            <?php echo esc_html($lstCurrentWidget->getLabel()); ?>
        </div>
    <?php endif; ?>

    <div class="listivo-user-account-type__value">
        <?php echo esc_html($lstCurrentWidget->getAccountType()); ?>
    </div>
</div>
