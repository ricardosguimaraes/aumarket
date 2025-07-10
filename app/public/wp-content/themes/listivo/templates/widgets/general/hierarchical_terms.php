<?php
/* @var \Tangibledesign\Listivo\Widgets\General\HierarchicalTermsWidget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-hierarchical-terms">
    <?php foreach ($lstCurrentWidget->getTerms() as $lstItem) :
        /* @var \Tangibledesign\Framework\Models\Term\CustomTerm $lstTerm */
        $lstTerm = $lstItem['term'];
        ?>
        <div class="listivo-hierarchical-term">
            <div class="listivo-hierarchical-term__main">
                <div class="listivo-hierarchical-term__heading">
                    <?php if (!empty($lstItem['icon']['value'])) : ?>
                        <a href="<?php echo esc_url($lstTerm->getUrl()); ?>" class="listivo-hierarchical-term__icon">
                            <i class="<?php echo esc_attr($lstItem['icon']['value']); ?>"></i>
                        </a>
                    <?php endif; ?>

                    <a
                            href="<?php echo esc_url($lstTerm->getUrl()) ?>"
                            title="<?php echo esc_attr($lstTerm->getName()); ?>"
                    >
                        <h3 class="listivo-hierarchical-term__name">
                            <?php echo esc_html($lstTerm->getName()); ?>
                        </h3>
                    </a>
                </div>

                <div class="listivo-hierarchical-term__list">
                    <?php foreach ($lstItem['terms'] as $lstCurrentTerm) :
                        /* @var \Tangibledesign\Framework\Models\Term\CustomTerm $lstCurrentTerm */
                        ?>
                        <a
                                class="listivo-hierarchical-term__item"
                                href="<?php echo esc_url($lstCurrentTerm->getUrl()); ?>"
                        >
                            <?php echo esc_html($lstCurrentTerm->getName()); ?>

                            <span>(<?php echo esc_html($lstCurrentTerm->getCount()); ?>)</span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="listivo-hierarchical-term__bottom">
                <a
                        class="listivo-hierarchical-term__link"
                        href="<?php echo esc_url($lstTerm->getUrl()); ?>"
                >
                    <?php echo esc_html(tdf_string('view_all')); ?>

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                              clip-rule="evenodd"/>
                    </svg>
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
