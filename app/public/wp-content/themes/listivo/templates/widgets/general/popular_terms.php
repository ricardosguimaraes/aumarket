<?php
/* @var \Tangibledesign\Listivo\Widgets\General\PopularTermsWidget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-popular-wrapper">
    <div class="listivo-popular">
        <?php if ($lstCurrentWidget->hasLabel()) : ?>
            <span class="listivo-popular__label"><?php echo esc_html($lstCurrentWidget->getLabel()); ?></span>
        <?php endif; ?>

        <?php foreach ($lstCurrentWidget->getPopularTerms() as $lstIndex => $lstTerm) : ?>
            <?php if (!empty($lstIndex)) : ?>
                <span class="listivo-popular__comma">,</span>
            <?php endif; ?>

            <a href="<?php echo esc_url($lstTerm->getUrl()) ?>" title="<?php echo esc_attr($lstTerm->getName()); ?>">
                <?php echo esc_html($lstTerm->getName()); ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>