<?php

namespace Tangibledesign\Listivo\Providers\Listing;

use Tangibledesign\Framework\Core\ServiceProvider;

class ListivoServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function initiation(): void
    {
        $this->container['version'] = static function () {
            if (!defined('LISTIVO_VERSION')) {
                return '1.0.0';
            }

            return LISTIVO_VERSION;
        };

        $this->container['tablet_breakpoint'] = '1024px';
        $this->container['mobile_breakpoint'] = '767px';
    }

    public function afterInitiation(): void
    {
        add_filter(tdf_prefix().'/templates/modelSingle/type', static function () {
            return 'listing_single';
        });

        add_filter(tdf_prefix().'/templates/modelSingle/name', static function () {
            return 'Ad Page';
        });

        add_filter(tdf_prefix().'/templates/modelArchive/type', static function () {
            return 'listing_archive';
        });

        add_filter(tdf_prefix().'/templates/modelArchive/name', static function () {
            return 'Search Results Page';
        });

        add_action('listivo/panel/load', static function () {
            add_action('wp_footer', static function () {
                ?>
                <script>
                    jQuery(window).on('load', function () {
                        if (jQuery(window).width() <= 1024) {
                            let element = jQuery('.listivo-panel-menu__item--active').get(0)
                            jQuery('.listivo-panel-menu__list').scrollLeft(element.getBoundingClientRect().left - (jQuery('.listivo-panel-menu').width() - jQuery('.listivo-panel-menu__list').width()) / 2)
                        }
                    })
                </script>
                <?php
            });
        });
    }

}