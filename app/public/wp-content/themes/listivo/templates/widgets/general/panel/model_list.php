<?php

use Tangibledesign\Framework\Models\Model;

global $lstModels;
global $lstCurrentListing;
foreach ($lstModels as $lstCurrentListing):
    /* @var Model $lstCurrentListing */
    get_template_part('templates/widgets/general/panel/listing_card_v2');
endforeach;