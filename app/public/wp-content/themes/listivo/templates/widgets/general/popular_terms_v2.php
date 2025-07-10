<?php

use Tangibledesign\Listivo\Widgets\General\PopularTermsV2Widget;

/* @var PopularTermsV2Widget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-popular-terms-v2">
    <span class="listivo-popular-terms-v2__label">
        <?php if (!empty($lstCurrentWidget->getLabel())) : ?>
            <?php echo esc_html($lstCurrentWidget->getLabel()); ?>
        <?php else : ?>
            <?php echo esc_html(tdf_string('whats_popular')); ?>
        <?php endif; ?>
    </span>

    <?php foreach ($lstCurrentWidget->getPopularTerms() as $lstTerm) : ?>
        <a
                class="listivo-popular-terms-v2__term"
                href="<?php echo esc_url($lstTerm->getUrl()) ?>"
                title="<?php echo esc_attr($lstTerm->getName()); ?>"
        >
            <?php echo esc_html($lstTerm->getName()); ?>
        </a>
    <?php endforeach; ?>
</div>