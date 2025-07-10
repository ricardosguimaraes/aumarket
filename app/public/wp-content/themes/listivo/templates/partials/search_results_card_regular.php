<?php
global $lstCurrentListings;
?>
<div class="listivo-listing-grid listivo-listing-grid--cards">
    <?php
    global $lstCurrentListing;
    foreach ($lstCurrentListings as $lstCurrentListing) : ?>
        <?php get_template_part('templates/partials/card/listing_card_v3'); ?>
    <?php endforeach; ?>
</div>