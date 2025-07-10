<?php

use Tangibledesign\Listivo\Widgets\General\PageNotFoundWidget;

/* @var PageNotFoundWidget $lstCurrentWidget */
global $lstCurrentWidget;
$lstImage = $lstCurrentWidget->getImage();
?>
<div class="listivo-page-not-found">
    <div class="listivo-page-not-found__image">
        <?php if (!empty($lstImage)) : ?>
            <img
                    src="<?php echo esc_url($lstImage); ?>"
                    alt="404"
            >
        <?php endif; ?>
    </div>

    <div class="listivo-page-not-found__text">
        404
    </div>
</div>
