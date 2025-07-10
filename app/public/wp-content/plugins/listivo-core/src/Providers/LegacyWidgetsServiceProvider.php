<?php

namespace Tangibledesign\Listivo\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Widgets\BlogArchive\BlogArchiveTitleWidget;
use Tangibledesign\Framework\Widgets\General\SocialShareWidget;
use Tangibledesign\Framework\Widgets\General\UserProfileWidget;
use Tangibledesign\Listivo\Widgets\BlogArchive\BlogArchiveWidget;
use Tangibledesign\Listivo\Widgets\BlogPost\BlogPostWidget;
use Tangibledesign\Listivo\Widgets\BlogPost\RelatedBlogPostsWidget;
use Tangibledesign\Listivo\Widgets\General\AddressWidget;
use Tangibledesign\Listivo\Widgets\General\BlogPostsV1Widget;
use Tangibledesign\Listivo\Widgets\General\BreadcrumbsWidget;
use Tangibledesign\Listivo\Widgets\General\CallToActionSectionWidget;
use Tangibledesign\Listivo\Widgets\General\EmailWidget;
use Tangibledesign\Listivo\Widgets\General\HeadingWidget;
use Tangibledesign\Listivo\Widgets\General\HeroSearchV1Widget;
use Tangibledesign\Listivo\Widgets\General\HeroSearchV2Widget;
use Tangibledesign\Listivo\Widgets\General\HeroSearchV3Widget;
use Tangibledesign\Listivo\Widgets\General\HierarchicalTermsWidget;
use Tangibledesign\Listivo\Widgets\General\InfoWidget;
use Tangibledesign\Listivo\Widgets\General\ListingCarouselWithTabsWidget;
use Tangibledesign\Listivo\Widgets\General\LoanCalculatorLinkWidget;
use Tangibledesign\Listivo\Widgets\General\MainCategoriesV2Widget;
use Tangibledesign\Listivo\Widgets\General\MainCategoriesWidget;
use Tangibledesign\Listivo\Widgets\General\MenuWidget;
use Tangibledesign\Listivo\Widgets\General\PhoneV2Widget;
use Tangibledesign\Listivo\Widgets\General\PhoneWidget;
use Tangibledesign\Listivo\Widgets\General\PopularSearchesWidget;
use Tangibledesign\Listivo\Widgets\General\PopularTermsWidget;
use Tangibledesign\Listivo\Widgets\General\SearchFormWidget;
use Tangibledesign\Listivo\Widgets\General\SeparatorWidget;
use Tangibledesign\Listivo\Widgets\General\ServicesV2Widget;
use Tangibledesign\Listivo\Widgets\General\ServicesWidget;
use Tangibledesign\Listivo\Widgets\General\ShapeWidget;
use Tangibledesign\Listivo\Widgets\General\SocialProfilesWidget;
use Tangibledesign\Listivo\Widgets\General\SubheadingWidget;
use Tangibledesign\Listivo\Widgets\General\TermsWithImagesV2Widget;
use Tangibledesign\Listivo\Widgets\General\TermsWithImagesWidget;
use Tangibledesign\Listivo\Widgets\General\TestimonialsWidget;
use Tangibledesign\Listivo\Widgets\Listing\ListingAttributesV2Widget;
use Tangibledesign\Listivo\Widgets\Listing\ListingNumberFieldWidget;
use Tangibledesign\Listivo\Widgets\Listing\ListingPrintWidget;
use Tangibledesign\Listivo\Widgets\Listing\ListingPublishDateWidget;
use Tangibledesign\Listivo\Widgets\Listing\ListingTextFieldWidget;
use Tangibledesign\Listivo\Widgets\Listing\ListingViewsWidget;
use Tangibledesign\Listivo\Widgets\Listing\UserProfileButtonWidget;
use Tangibledesign\Listivo\Widgets\PrintModel\PrintListingMainInfoWidget;
use Tangibledesign\Listivo\Widgets\User\UserAddressWidget;
use Tangibledesign\Listivo\Widgets\User\UserJobTitleWidget;
use Tangibledesign\Listivo\Widgets\User\UserPhoneWidget;

class LegacyWidgetsServiceProvider extends ServiceProvider
{
    protected array $legacyWidgets = [
        UserJobTitleWidget::class,
        UserPhoneWidget::class,
        TermsWithImagesWidget::class,
        TermsWithImagesV2Widget::class,
        BlogArchiveWidget::class,
        BlogPostsV1Widget::class,
        SocialShareWidget::class,
        ListingPublishDateWidget::class,
        ListingViewsWidget::class,
        UserProfileButtonWidget::class,
        UserProfileWidget::class,
        BreadcrumbsWidget::class,
        BlogPostWidget::class,
        PhoneV2Widget::class,
        PhoneWidget::class,
        AddressWidget::class,
        EmailWidget::class,
        ListingAttributesV2Widget::class,
        ListingTextFieldWidget::class,
        ListingNumberFieldWidget::class,
        HeadingWidget::class,
        TestimonialsWidget::class,
        MainCategoriesWidget::class,
        MainCategoriesV2Widget::class,
        PopularSearchesWidget::class,
        HierarchicalTermsWidget::class,
        CallToActionSectionWidget::class,
        HeroSearchV1Widget::class,
        HeroSearchV2Widget::class,
        HeroSearchV3Widget::class,
        PopularTermsWidget::class,
        ServicesWidget::class,
        ServicesV2Widget::class,
        SubheadingWidget::class,
        InfoWidget::class,
        ListingCarouselWithTabsWidget::class,
        RelatedBlogPostsWidget::class,
        ShapeWidget::class,
        MenuWidget::class,
        SocialProfilesWidget::class,
        SeparatorWidget::class,
        SearchFormWidget::class,
        LoanCalculatorLinkWidget::class,
        ListingPrintWidget::class,
        PrintListingMainInfoWidget::class,
        BlogArchiveTitleWidget::class,
    ];

    public function afterInitiation(): void
    {
        add_action('wp_enqueue_scripts', function () {
            if (!tdf_settings()->isLegacyModeEnabled()) {
                return;
            }

            wp_enqueue_style(tdf_prefix() . '-legacy', get_template_directory_uri() . '/assets/css/style-legacy.css',
                LISTIVO_VERSION);
        });

        add_filter('tdf/widgets', function (array $widgets) {
            if (tdf_settings()->isLegacyModeEnabled()) {
                return $widgets;
            }

            return tdf_collect($widgets)->filter(function ($widget) {
                return !in_array($widget, $this->legacyWidgets, true);
            })->values();
        }, 20);

        add_filter('listivo/images/sizes', static function (array $imageSizes) {
            if (!tdf_settings()->isLegacyModeEnabled()) {
                return $imageSizes;
            }

            if (tdf_ordered_fields()->isEmpty()) {
                return $imageSizes;
            }

            if (get_option(tdf_prefix() . '_status' === 'demo_installation')) {
                return $imageSizes;
            }

            return array_merge($imageSizes, [
                [
                    'key' => 'listivo_360_270',
                    'width' => 360,
                    'height' => 270,
                    'crop' => true,
                ],
                [
                    'key' => 'listivo_720_540',
                    'width' => 720,
                    'height' => 540,
                    'crop' => true,
                ],
                [
                    'key' => 'listivo_300_295',
                    'width' => 300,
                    'height' => 295,
                    'crop' => true,
                ],
                [
                    'key' => 'listivo_600_590',
                    'width' => 600,
                    'height' => 590,
                    'crop' => true,
                ],
                [
                    'key' => 'listivo_750_480',
                    'width' => 750,
                    'height' => 480,
                    'crop' => true,
                ],
                [
                    'key' => 'listivo_375_240',
                    'width' => 375,
                    'height' => 240,
                    'crop' => true,
                ],
            ]);
        }, 20);
    }
}