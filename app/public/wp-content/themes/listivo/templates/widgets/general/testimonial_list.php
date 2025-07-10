<?php

use Tangibledesign\Listivo\Widgets\General\TestimonialListWidget;

/* @var TestimonialListWidget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-testimonial-list">
    <?php
    global $lstTestimonial;
    foreach ($lstCurrentWidget->getTestimonials() as $lstTestimonial) : ?>
        <?php get_template_part('templates/partials/testimonial_v3'); ?>
    <?php endforeach; ?>
</div>