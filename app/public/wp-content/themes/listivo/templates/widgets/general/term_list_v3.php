<?php

use Tangibledesign\Framework\Models\Term\CustomTerm;
use Tangibledesign\Listivo\Widgets\General\TermListV3Widget;

/* @var TermListV3Widget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-term-list-v3">
    <?php foreach ($lstCurrentWidget->getTerms() as $lstTermData) :
        /* @var CustomTerm $lstTerm */
        $lstTerm = $lstTermData['term'];
        ?>
        <a
                class="listivo-term-list-v3-card"
                href="<?php echo esc_url($lstTerm->getUrl()); ?>"
        >
            <div class="listivo-term-list-v3-card__count">
                <?php echo esc_html($lstTerm->getCount()); ?>
            </div>

            <?php if (!empty($lstTermData['image']['url']))  : ?>
                <div class="listivo-term-list-v3-card__image">
                    <img
                            class="lazyload"
                            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                            data-src="<?php echo esc_url($lstTermData['image']['url']); ?>"
                            alt="<?php echo esc_attr($lstTerm->getName()); ?>"
                    >
                </div>
            <?php endif; ?>
        </a>
    <?php endforeach; ?>
</div>
