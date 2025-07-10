<?php

use Tangibledesign\Framework\Models\Term\CustomTerm;
use Tangibledesign\Listivo\Widgets\General\TermListV2Widget;

/* @var TermListV2Widget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-term-list-v2">
    <div class="listivo-term-list-v2__list">
        <?php foreach ($lstCurrentWidget->getTerms() as $lstTermData) :
            /* @var CustomTerm $lstTerm */
            $lstTerm = $lstTermData['term'];
            ?>
            <a
                    class="listivo-term-list-v2-card"
                    href="<?php echo esc_url($lstTerm->getUrl()); ?>"
            >
                <?php if (!empty($lstTermData['image']['url']))  : ?>
                    <div class="listivo-term-list-v2-card__image">
                        <img
                                src="<?php echo esc_url($lstTermData['image']['url']); ?>"
                                alt="<?php echo esc_attr($lstTerm->getName()); ?>"
                        >
                    </div>
                <?php endif; ?>

                <h3 class="listivo-term-list-v2-card__label">
                    <?php echo esc_html($lstTerm->getName()); ?>
                </h3>
            </a>
        <?php endforeach; ?>
    </div>

    <?php if (!empty($lstCurrentWidget->getText())) : ?>
        <div class="listivo-term-list-v2__heading-wrapper">
            <h3 class="listivo-term-list-v2__heading">
                <?php echo esc_html($lstCurrentWidget->getText()); ?>

                <div class="listivo-term-list-v2__arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="51" height="26" viewBox="0 0 51 26" fill="none">
                        <path d="M1 12.2705C3.97507 14.3496 6.6109 17.0538 9.92521 18.5076C24.5141 24.907 39.7041 16.5982 46.6058 2.9904"
                              stroke="#D95D51" stroke-dasharray="3 3"/>
                        <path d="M41.7303 3.2983C49.4844 1.35944 47.4345 -0.801093 48.5726 6.52206" stroke="#D95D51"/>
                    </svg>
                </div>
            </h3>
        </div>
    <?php endif; ?>
</div>
