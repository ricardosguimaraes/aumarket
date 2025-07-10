<?php

use Tangibledesign\Listivo\Widgets\General\TermListV4Widget;

/* @var TermListV4Widget $lstCurrentWidget */
global $lstCurrentWidget;

$lstTerms = $lstCurrentWidget->getTerms();
if ($lstTerms->isEmpty()) {
    return;
}
?>
<div class="listivo-terms-v2">
    <?php foreach ($lstTerms as $lstTerm) : ?>
        <a
                class="listivo-terms-v2__term"
                href="<?php echo esc_url($lstTerm['url']); ?>"
        >
            <div
                <?php if ($lstCurrentWidget->invertIconColor()) : ?>
                    class="listivo-terms-v2__icon listivo-terms-v2__icon--invert-color"
                <?php else : ?>
                    class="listivo-terms-v2__icon"
                <?php endif; ?>
            >
                <?php if (!empty($lstTerm['image'])): ?>
                    <img
                            src="<?php echo esc_url($lstTerm['image']); ?>"
                            alt="<?php echo esc_attr($lstTerm['label']); ?>"
                    >
                <?php endif; ?>
            </div>

            <?php echo esc_html($lstTerm['label']); ?>
        </a>
    <?php endforeach; ?>
</div>