<?php

namespace Tangibledesign\Framework\Core\ServiceProvider\Elementor;

use Elementor\Core\Kits\Documents\Kit;
use Elementor\Plugin;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Listivo\Elementor\BlogCardTab;
use Tangibledesign\Listivo\Elementor\DesignTab;
use Tangibledesign\Listivo\Elementor\FeaturedListingCardTab;
use Tangibledesign\Listivo\Elementor\ListingCardTab;
use Tangibledesign\Listivo\Elementor\PackageTab;
use Tangibledesign\Listivo\Elementor\PaginationTab;
use Tangibledesign\Listivo\Elementor\QuickViewTab;

class ElementorKitServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function initiation(): void
    {
        $this->container['current_kit'] = static function () {
            return Plugin::instance()->kits_manager->get_active_kit();
        };
    }

    public function afterInitiation(): void
    {
        add_action('elementor/kit/register_tabs', [$this, 'registerTabs']);
    }

    /**
     * @param  Kit  $kit
     * @return void
     */
    public function registerTabs(Kit $kit): void
    {
        $kit->register_tab('listivo-design', DesignTab::class);

        $kit->register_tab('listivo-listing-card', ListingCardTab::class);

        $kit->register_tab('listivo-featured-listing-card', FeaturedListingCardTab::class);

        $kit->register_tab('listivo-quick-view', QuickViewTab::class);

        $kit->register_tab('listivo-blog-card', BlogCardTab::class);

        $kit->register_tab('listivo-pagination', PaginationTab::class);

        $kit->register_tab('listivo-package', PackageTab::class);
    }

}