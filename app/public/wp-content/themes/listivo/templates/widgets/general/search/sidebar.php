<?php

use Tangibledesign\Listivo\Widgets\General\Search\HasSidebarFields;

/* @var HasSidebarFields $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-search-sidebar" @click.stop.prevent>
    <?php
    global $lstSearchField;
    foreach ($lstCurrentWidget->getSidebarFields() as $lstSearchField) :
        get_template_part('templates/partials/search/sidebar/' . $lstSearchField->getType());
    endforeach;
    ?>
</div>