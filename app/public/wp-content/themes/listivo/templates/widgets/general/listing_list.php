<?php

use Tangibledesign\Listivo\Widgets\General\ListingListWidget;

/* @var ListingListWidget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-app <?php echo esc_attr($lstCurrentWidget->getFeaturedLabelClasses()); ?>">
    <div class="listivo-listing-list__grid">
        <?php
        global $lstCurrentListing, $lstModelCard;
        foreach ($lstCurrentWidget->getListings() as $lstCurrentListing) :
            $lstModelCard = $lstCurrentWidget->getCardConfig($lstCurrentListing);
            $lstCurrentWidget->loadCardTemplate();
        endforeach;
        ?>
    </div>

    <?php if (!empty($lstCurrentWidget->getText())) : ?>
        <div class="listivo-listing-list__button">
            <a
                    class="listivo-button listivo-button--primary-1"
                    href="<?php echo esc_url($lstCurrentWidget->getUrl()); ?>"
            >
                <span>
                    <?php echo esc_html($lstCurrentWidget->getText()); ?>

                    <svg width="8" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 14">
                        <g>
                            <g>
                                <path d="M7.33974,6.18666v0l-5.45414,-5.86846c-0.24639,-0.30357 -0.50858,-0.30357 -0.78587,0l-0.32364,0.35442c-0.24616,0.26968 -0.24616,0.55668 0,0.85987l4.71474,5.05868v0l-4.71474,5.05905c-0.27718,0.30282 -0.27718,0.58982 0,0.8595l0.32364,0.35404c0.27729,0.30395 0.53947,0.30395 0.78587,0l5.45414,-5.86846c0.24696,-0.26892 0.24696,-0.5386 0,-0.80865z"
                                      fill="#ffffff" fill-opacity="1"></path>
                            </g>
                        </g>
                    </svg>
                </span>
            </a>
        </div>
    <?php endif; ?>

    <?php if ($lstCurrentWidget->showDecoration()) : ?>
        <div class="listivo-listing-list__decoration-outer">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 645 990">
                <g>
                    <g>
                        <path d="M130.49995,-39.00028c284.15039,0 514.50005,230.34957 514.50005,514.50016c0,284.15021 -230.34966,514.49979 -514.50005,514.49979c-284.15028,0 -514.49993,-230.34957 -514.49993,-514.49979c0,-284.15059 230.34966,-514.50016 514.49993,-514.50016z"
                              fill="#ffffff" fill-opacity="1"></path>
                    </g>
                </g>
            </svg>
        </div>

        <div class="listivo-listing-list__decoration-inner">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 495 729">
                <g>
                    <g>
                        <path d="M130.49995,-0.00007c201.30775,0 364.50005,163.19209 364.50005,364.49995c0,201.30748 -163.19229,364.49995 -364.50005,364.49995c-201.30764,0 -364.49993,-163.19247 -364.49993,-364.49995c0,-201.30786 163.19229,-364.49995 364.49993,-364.49995z"
                              fill="#f1f4f8" fill-opacity="1"
                        ></path>
                    </g>
                </g>
            </svg>
        </div>
    <?php endif; ?>
</div>