<?php

use Tangibledesign\Listivo\Widgets\User\UserChatViaSocialsWidget;

/* @var UserChatViaSocialsWidget $lstCurrentWidget */
global $lstCurrentWidget;
$lstUser = $lstCurrentWidget->getUser();
if (!$lstUser) {
    return;
}

if ((!$lstUser->hasViber() || tdf_settings()->disableWhatsApp()) && (!$lstUser->hasWhatsApp() || tdf_settings()->disableWhatsApp())) {
    return;
}

$lstModel = $lstCurrentWidget->getModel();
$lstInitialMessage = $lstCurrentWidget->getInitialMessage($lstModel);
?>
<div class="listivo-chat-via-socials">
    <?php if ($lstUser->hasWhatsApp() && !tdf_settings()->disableWhatsApp()) : ?>
        <a
                class="listivo-chat-via-socials__button"
                href="https://wa.me/<?php echo esc_attr($lstUser->getWhatsAppUrl()); ?>?text=<?php echo esc_attr($lstInitialMessage); ?>"
                target="_blank"
        >
            <div
                <?php if ($lstCurrentWidget->isWhatsAppIconSet()) : ?>
                    class="listivo-chat-via-socials__icon"
                <?php else : ?>
                    class="listivo-chat-via-socials__icon listivo-chat-via-socials__icon--default"
                <?php endif; ?>
            >
                <?php if ($lstCurrentWidget->isWhatsAppIconSet()) : ?>
                    <?php if ($lstCurrentWidget->isWhatsAppSvgIcon()) : ?>
                        <?php echo tdf_load_icon($lstCurrentWidget->getWhatsAppSvgIcon()); ?>
                    <?php else : ?>
                        <i class="<?php echo esc_attr($lstCurrentWidget->getWhatsAppIcon()); ?>"></i>
                    <?php endif; ?>
                <?php else : ?>
                    <img
                            src="data:image/png;base64,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"
                            alt="whatsapp"
                    >
                <?php endif; ?>
            </div>

            <?php echo esc_html(tdf_string('chat_via_whatsapp')); ?>
        </a>
    <?php endif; ?>

    <?php if ($lstUser->hasViber() && !tdf_settings()->disableViber()) : ?>
        <a
                class="listivo-chat-via-socials__button"
                href="viber://chat?number=<?php echo esc_attr(str_replace('+', '', $lstUser->getPhoneUrl())); ?>&text=<?php echo esc_attr(urlencode($lstInitialMessage)); ?>"
                target="_blank"
        >
            <div
                <?php if ($lstCurrentWidget->isViberIconSet()) : ?>
                    class="listivo-chat-via-socials__icon"
                <?php else : ?>
                    class="listivo-chat-via-socials__icon listivo-chat-via-socials__icon--default"
                <?php endif; ?>
            >
                <?php if ($lstCurrentWidget->isViberIconSet()) : ?>
                    <?php if ($lstCurrentWidget->isViberSvgIcon()) : ?>
                        <?php echo tdf_load_icon($lstCurrentWidget->getViberSvgIcon()); ?>
                    <?php else : ?>
                        <i class="<?php echo esc_attr($lstCurrentWidget->getViberIcon()); ?>"></i>
                    <?php endif; ?>
                <?php else : ?>
                    <img
                            src="data:image/png;base64,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"
                            alt="viber"
                    >
                <?php endif; ?>
            </div>

            <?php echo esc_html(tdf_string('chat_via_viber')); ?>
        </a>
    <?php endif; ?>
</div>
