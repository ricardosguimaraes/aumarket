<?php
global $lstPagination;
$lstPaginationPages = $lstPagination->getPages();
$lstCurrentPage = $lstPagination->getCurrentPage();
?>
<div class="listivo-pagination">
    <div class="listivo-pagination__info">
        <?php echo esc_html(tdf_string('showing')); ?>
        <span><?php echo esc_html($lstPagination->getCurrentPageFirstItem()); ?></span> <?php echo esc_html(tdf_string('to')); ?>
        <span><?php echo esc_html($lstPagination->getCurrentPageLastItem()); ?></span> <?php echo esc_html(tdf_string('of')); ?>
        <span><?php echo esc_html($lstPagination->getTotalItems()); ?></span> <?php echo esc_html(tdf_string('results_lower_case')); ?>
    </div>

    <div class="listivo-pagination__list">
        <?php if (count($lstPaginationPages) > 1) : ?>
            <a
                    href="<?php echo esc_url($lstPagination->getPrevUrl()); ?>"
                <?php if ($lstCurrentPage > 1) : ?>
                    class="listivo-pagination__item"
                <?php else : ?>
                    class="listivo-pagination__item listivo-pagination__item--disabled"
                <?php endif; ?>
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                     fill="none">
                    <path d="M4.86195 10.4713C4.99228 10.6017 5.16262 10.6667 5.33329 10.6667C5.50395 10.6667 5.67429 10.6017 5.80462 10.4713C6.06496 10.211 6.06496 9.78898 5.80462 9.52865L2.27593 5.99996H11.3333C11.7013 5.99996 12 5.70129 12 5.33329C12 4.96528 11.7013 4.66662 11.3333 4.66662H2.27593L5.80462 1.13792C6.06496 0.877589 6.06496 0.455586 5.80462 0.195251C5.54429 -0.0650838 5.12229 -0.0650838 4.86195 0.195251L0.195251 4.86195C-0.0650838 5.12229 -0.0650838 5.54429 0.195251 5.80462L4.86195 10.4713Z"
                          fill="#2A3946"/>
                </svg>
            </a>
        <?php endif; ?>

        <?php foreach ($lstPaginationPages as $lstPage) : ?>
            <?php if (!empty($lstPage['url'])) : ?>
                <a
                        href="<?php echo esc_url($lstPage['url']); ?>"
                    <?php if ($lstPage['isCurrent']) : ?>
                        class="listivo-pagination__item listivo-pagination__item--active"
                    <?php else : ?>
                        class="listivo-pagination__item"
                    <?php endif; ?>
                >
                    <?php echo esc_html($lstPage['num']); ?>
                </a>
            <?php else : ?>
                <div class="listivo-pagination__item listivo-pagination__item--separator">
                    ...
                </div>
            <?php endif; ?>
        <?php endforeach; ?>

        <?php if (count($lstPaginationPages) > 1) : ?>
            <a
                    href="<?php echo esc_url($lstPagination->getNextUrl()); ?>"
                <?php if ($lstCurrentPage < $lstPagination->getNumPages()) : ?>
                    class="listivo-pagination__item"
                <?php else : ?>
                    class="listivo-pagination__item listivo-pagination__item--disabled"
                <?php endif; ?>
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                     fill="none">
                    <path d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49605 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455586 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z"
                          fill="#2A3946"/>
                </svg>
            </a>
        <?php endif; ?>
    </div>
</div>
