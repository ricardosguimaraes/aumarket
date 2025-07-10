<?php

namespace Tangibledesign\Listivo\Providers\Listing;

use Tangibledesign\Framework\Core\ServiceProvider;

class ListingCardCssServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('listivo/dynamicCss', static function () {
            $cardSize = tdf_app('listing_card_image_size');
            $rowSize = tdf_app('listing_row_image_size');

            ob_start();
            ?>
            .listivo-mini-listing-carousel-card__image img {
            aspect-ratio: <?php echo esc_html($cardSize['width']); ?> / <?php echo esc_html($cardSize['height']); ?>;
            }

            .listivo-listing-card-v3__gallery img {
            aspect-ratio: <?php echo esc_html($cardSize['width']); ?> / <?php echo esc_html($cardSize['height']); ?>;
            }

            .listivo-listing-card-v4__gallery img {
            aspect-ratio: <?php echo esc_html($cardSize['width']); ?> / <?php echo esc_html($cardSize['height']); ?>;
            }

            .listivo-skeleton-listing-card-v3__gallery img {
            aspect-ratio: <?php echo esc_html($cardSize['width']); ?> / <?php echo esc_html($cardSize['height']); ?>;
            }

            .listivo-skeleton-listing-card-v4__gallery img {
            aspect-ratio: <?php echo esc_html($cardSize['width']); ?> / <?php echo esc_html($cardSize['height']); ?>;
            }

            .listivo-listing-card-row__gallery img {
            aspect-ratio: <?php echo esc_html($rowSize['width']); ?> / <?php echo esc_html($rowSize['height']); ?>;
            }

            .listivo-listing-card-row-v2__gallery img {
            aspect-ratio: <?php echo esc_html($rowSize['width']); ?> / <?php echo esc_html($rowSize['height']); ?>;
            }

            .listivo-skeleton-listing-row__gallery img {
            aspect-ratio: <?php echo esc_html($rowSize['width']); ?> / <?php echo esc_html($rowSize['height']); ?>;
            }

            .listivo-skeleton-listing-row-v2__gallery img {
            aspect-ratio: <?php echo esc_html($rowSize['width']); ?> / <?php echo esc_html($rowSize['height']); ?>;
            }

            @media (max-width: <?php echo esc_html(tdf_app('tablet_breakpoint')); ?>) {
            .listivo-listing-card-row__gallery img {
            aspect-ratio: <?php echo esc_html($cardSize['width']); ?> / <?php echo esc_html($cardSize['height']); ?>;
            }
            }

            @media (max-width: <?php echo esc_html(tdf_app('tablet_breakpoint')); ?>) {
            .listivo-listing-card-row-v2__gallery img {
            aspect-ratio: <?php echo esc_html($cardSize['width']); ?> / <?php echo esc_html($cardSize['height']); ?>;
            }
            }

            @media (max-width: <?php echo esc_html(tdf_app('tablet_breakpoint')); ?>) {
            .listivo-skeleton-listing-row__gallery img {
            aspect-ratio: <?php echo esc_html($cardSize['width']); ?> / <?php echo esc_html($cardSize['height']); ?>;
            }
            }

            @media (max-width: <?php echo esc_html(tdf_app('tablet_breakpoint')); ?>) {
            .listivo-skeleton-listing-row-v2__gallery img {
            aspect-ratio: <?php echo esc_html($cardSize['width']); ?> / <?php echo esc_html($cardSize['height']); ?>;
            }
            }
            <?php
            echo ob_get_clean();
        });
    }

}