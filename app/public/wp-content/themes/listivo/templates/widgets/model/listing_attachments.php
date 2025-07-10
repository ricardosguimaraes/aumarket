<?php

use Tangibledesign\Framework\Models\Attachment;
use Tangibledesign\Listivo\Widgets\Listing\ListingAttachmentsWidget;

/* @var ListingAttachmentsWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstAttachments = $lstCurrentWidget->getAttachments();
if ($lstAttachments->isEmpty()) {
    return;
}
?>
<div class="listivo-listing-section">
    <?php if ($lstCurrentWidget->showLabel()) : ?>
        <h3 class="listivo-listing-section__label">
            <?php echo esc_html($lstCurrentWidget->getLabel()); ?>
        </h3>
    <?php endif; ?>

    <div class="listivo-listing-section__content">
        <div class="listivo-attachments">
            <?php foreach ($lstAttachments as $lstAttachment) :
                /* @var Attachment $lstAttachment */
                ?>
                <a
                        class="listivo-attachment"
                        href="<?php echo esc_url($lstAttachment->getUrl()); ?>"
                        target="_blank"
                >
                    <div class="listivo-attachment__icon">
                        <img
                                src="<?php echo esc_url($lstAttachment->getIconUrl()); ?>"
                                alt="<?php echo esc_attr($lstAttachment->getName()); ?>"
                        >
                    </div>

                    <?php echo esc_attr($lstAttachment->getName()); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>