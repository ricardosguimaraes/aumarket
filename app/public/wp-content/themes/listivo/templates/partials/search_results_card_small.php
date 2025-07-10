<?php global $lstCurrentListings; ?>
<div class="listivo-listing-grid listivo-listing-grid--small-cards listivo-listing-grid--cards">
    <?php
    global $lstCurrentListing;
    foreach ($lstCurrentListings as $lstCurrentListing) : ?>
        <?php get_template_part('templates/partials/card/listing_card_v4'); ?>
    <?php endforeach; ?>
</div>