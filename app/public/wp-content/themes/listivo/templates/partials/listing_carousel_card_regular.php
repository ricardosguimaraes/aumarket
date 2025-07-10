<?php

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Model;

/* @var Collection|Model[] $lstModels */
global $lstModels;

global $lstCurrentListing;
foreach ($lstModels as $lstCurrentListing) : ?>
    <div class="listivo-swiper-slide">
        <?php get_template_part('templates/partials/card/listing_card_v3'); ?>
    </div>
<?php
endforeach;