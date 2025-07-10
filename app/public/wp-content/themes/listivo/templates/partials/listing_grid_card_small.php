<?php

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Model;

/* @var Collection|Model[] $lstModels */
global $lstModels;
?>
<div class="listivo-listing-grid">
    <?php
    global $lstCurrentListing;
    foreach ($lstModels as $lstCurrentListing) :
        get_template_part('templates/partials/card/listing_card_v4');
    endforeach;
    ?>
</div>