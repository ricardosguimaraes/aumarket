<?php
/* @var \Tangibledesign\Listivo\Widgets\User\UserNameWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstUser = $lstCurrentWidget->getUser();
if (!$lstUser) {
    return;
}

if ($lstCurrentWidget->linkUser()) : ?>
    <a href="<?php echo esc_url($lstUser->getUrl()); ?>" class="listivo-user-name">
        <?php echo esc_html($lstUser->getDisplayName()); ?>
    </a>
<?php else : ?>
    <div class="listivo-user-name">
        <?php echo esc_html($lstUser->getDisplayName()); ?>
    </div>
<?php
endif;