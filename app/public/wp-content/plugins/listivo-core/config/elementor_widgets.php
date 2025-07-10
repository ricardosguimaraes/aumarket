<?php

use Tangibledesign\Framework\Widgets\BlogArchive\BlogArchiveTitleWidget;
use Tangibledesign\Framework\Widgets\General\LogoWidget;
use Tangibledesign\Framework\Widgets\General\MapWidget;
use Tangibledesign\Framework\Widgets\General\SocialShareWidget;
use Tangibledesign\Framework\Widgets\General\UserProfileWidget;
use Tangibledesign\Framework\Widgets\TemplateLoaderWidget;
use Tangibledesign\Framework\Widgets\User\UserDescriptionWidget;
use Tangibledesign\Listivo\Widgets\BlogArchive\BlogArchiveTitleWithBreadcrumbsWidget;
use Tangibledesign\Listivo\Widgets\BlogArchive\BlogArchiveV2Widget;
use Tangibledesign\Listivo\Widgets\BlogArchive\BlogArchiveWidget;
use Tangibledesign\Listivo\Widgets\BlogPost\BlogPostCommentsWidget;
use Tangibledesign\Listivo\Widgets\BlogPost\BlogPostV2Widget;
use Tangibledesign\Listivo\Widgets\BlogPost\BlogPostWidget;
use Tangibledesign\Listivo\Widgets\BlogPost\RelatedBlogPostsCarouselWidget;
use Tangibledesign\Listivo\Widgets\BlogPost\RelatedBlogPostsWidget;
use Tangibledesign\Listivo\Widgets\General\AccordionWidget;
use Tangibledesign\Listivo\Widgets\General\AddressV2Widget;
use Tangibledesign\Listivo\Widgets\General\AddressWidget;
use Tangibledesign\Listivo\Widgets\General\BadgeWidget;
use Tangibledesign\Listivo\Widgets\General\BlockWidget;
use Tangibledesign\Listivo\Widgets\General\BlogCategoriesWidget;
use Tangibledesign\Listivo\Widgets\General\BlogKeywordSearchWidget;
use Tangibledesign\Listivo\Widgets\General\BlogPostsV1Widget;
use Tangibledesign\Listivo\Widgets\General\BlogPostsV2Widget;
use Tangibledesign\Listivo\Widgets\General\BreadcrumbsV2Widget;
use Tangibledesign\Listivo\Widgets\General\BreadcrumbsWidget;
use Tangibledesign\Listivo\Widgets\General\ButtonWidget;
use Tangibledesign\Listivo\Widgets\General\CallToActionSectionV2Widget;
use Tangibledesign\Listivo\Widgets\General\CallToActionSectionV3Widget;
use Tangibledesign\Listivo\Widgets\General\CallToActionSectionWidget;
use Tangibledesign\Listivo\Widgets\General\CategoriesV1Widget;
use Tangibledesign\Listivo\Widgets\General\CategoriesV3Widget;
use Tangibledesign\Listivo\Widgets\General\CategoriesV4Widget;
use Tangibledesign\Listivo\Widgets\General\CategoriesV5Widget;
use Tangibledesign\Listivo\Widgets\General\CompareAreaWidget;
use Tangibledesign\Listivo\Widgets\General\ContactFormWidget;
use Tangibledesign\Listivo\Widgets\General\ContentV1Widget;
use Tangibledesign\Listivo\Widgets\General\ContentV2Widget;
use Tangibledesign\Listivo\Widgets\General\ContentV4Widget;
use Tangibledesign\Listivo\Widgets\General\ContentV5Widget;
use Tangibledesign\Listivo\Widgets\General\ContentV6Widget;
use Tangibledesign\Listivo\Widgets\General\ContentV7Widget;
use Tangibledesign\Listivo\Widgets\General\ContentV8Widget;
use Tangibledesign\Listivo\Widgets\General\CopyrightsWidget;
use Tangibledesign\Listivo\Widgets\General\DynamicTitleWidget;
use Tangibledesign\Listivo\Widgets\General\EmailV2Widget;
use Tangibledesign\Listivo\Widgets\General\EmailWidget;
use Tangibledesign\Listivo\Widgets\General\FooterListingListWidget;
use Tangibledesign\Listivo\Widgets\General\HeadingV2Widget;
use Tangibledesign\Listivo\Widgets\General\HeadingWidget;
use Tangibledesign\Listivo\Widgets\General\HeroSearchV10Widget;
use Tangibledesign\Listivo\Widgets\General\HeroSearchV1Widget;
use Tangibledesign\Listivo\Widgets\General\HeroSearchV2Widget;
use Tangibledesign\Listivo\Widgets\General\HeroSearchV3Widget;
use Tangibledesign\Listivo\Widgets\General\HeroSearchV4Widget;
use Tangibledesign\Listivo\Widgets\General\HeroSearchV5Widget;
use Tangibledesign\Listivo\Widgets\General\HeroSearchV6Widget;
use Tangibledesign\Listivo\Widgets\General\HeroSearchV7Widget;
use Tangibledesign\Listivo\Widgets\General\HeroSearchV8Widget;
use Tangibledesign\Listivo\Widgets\General\HeroSearchV9Widget;
use Tangibledesign\Listivo\Widgets\General\HeroV1Widget;
use Tangibledesign\Listivo\Widgets\General\HierarchicalTermsWidget;
use Tangibledesign\Listivo\Widgets\General\IconBoxWidget;
use Tangibledesign\Listivo\Widgets\General\ImageMosaicWidget;
use Tangibledesign\Listivo\Widgets\General\InfoBoxWidget;
use Tangibledesign\Listivo\Widgets\General\InfoWidget;
use Tangibledesign\Listivo\Widgets\General\LinksSidebarWidget;
use Tangibledesign\Listivo\Widgets\General\ListingCarouselWidget;
use Tangibledesign\Listivo\Widgets\General\ListingCarouselWithTabsWidget;
use Tangibledesign\Listivo\Widgets\General\ListingCarouselWithTabsWidgetV2;
use Tangibledesign\Listivo\Widgets\General\ListingListV2Widget;
use Tangibledesign\Listivo\Widgets\General\ListingListWidget;
use Tangibledesign\Listivo\Widgets\General\ListingListWithTabsV2Widget;
use Tangibledesign\Listivo\Widgets\General\ListingListWithTabsWidget as ListingListWithTabsWidgetAlias;
use Tangibledesign\Listivo\Widgets\General\ListingNameWidget;
use Tangibledesign\Listivo\Widgets\General\LoanCalculatorLinkWidget;
use Tangibledesign\Listivo\Widgets\General\LoanCalculatorWidget;
use Tangibledesign\Listivo\Widgets\General\LoginAndRegisterWidget;
use Tangibledesign\Listivo\Widgets\General\MailchimpNewsletterFormV2Widget;
use Tangibledesign\Listivo\Widgets\General\MailchimpNewsletterFormV3Widget;
use Tangibledesign\Listivo\Widgets\General\MailchimpNewsletterFormV4Widget;
use Tangibledesign\Listivo\Widgets\General\MailchimpNewsletterFormV5Widget;
use Tangibledesign\Listivo\Widgets\General\MailchimpNewsletterFormWidget;
use Tangibledesign\Listivo\Widgets\General\MainCategoriesV2Widget;
use Tangibledesign\Listivo\Widgets\General\MainCategoriesWidget;
use Tangibledesign\Listivo\Widgets\General\MenuV2Widget;
use Tangibledesign\Listivo\Widgets\General\MenuWidget;
use Tangibledesign\Listivo\Widgets\General\MiniListingCarouselWidget;
use Tangibledesign\Listivo\Widgets\General\PageNotFoundWidget;
use Tangibledesign\Listivo\Widgets\General\PagesCarouselWidget;
use Tangibledesign\Listivo\Widgets\General\PanelWidget;
use Tangibledesign\Listivo\Widgets\General\PatternWidget;
use Tangibledesign\Listivo\Widgets\General\PaymentPackagePricingTableWidget;
use Tangibledesign\Listivo\Widgets\General\PhoneBoxWidget;
use Tangibledesign\Listivo\Widgets\General\PhoneV2Widget;
use Tangibledesign\Listivo\Widgets\General\PhoneV3Widget;
use Tangibledesign\Listivo\Widgets\General\PhoneWidget;
use Tangibledesign\Listivo\Widgets\General\PopularSearchesWidget;
use Tangibledesign\Listivo\Widgets\General\PopularTermsV2Widget;
use Tangibledesign\Listivo\Widgets\General\PopularTermsWidget;
use Tangibledesign\Listivo\Widgets\General\PostCarouselWidget;
use Tangibledesign\Listivo\Widgets\General\PostsSidebarWidget;
use Tangibledesign\Listivo\Widgets\General\SearchFormV2Widget;
use Tangibledesign\Listivo\Widgets\General\SearchFormWidget;
use Tangibledesign\Listivo\Widgets\General\Search\SearchMapWidget;
use Tangibledesign\Listivo\Widgets\General\Search\SearchV2Widget;
use Tangibledesign\Listivo\Widgets\General\Search\SearchWidget;
use Tangibledesign\Listivo\Widgets\General\SeparatorWidget;
use Tangibledesign\Listivo\Widgets\General\ServicesV2Widget;
use Tangibledesign\Listivo\Widgets\General\ServicesV3Widget as ServicesV3WidgetAlias;
use Tangibledesign\Listivo\Widgets\General\ServicesV4Widget;
use Tangibledesign\Listivo\Widgets\General\ServicesV5Widget;
use Tangibledesign\Listivo\Widgets\General\CategoriesV2Widget;
use Tangibledesign\Listivo\Widgets\General\ServicesV6Widget;
use Tangibledesign\Listivo\Widgets\General\ServicesV7Widget;
use Tangibledesign\Listivo\Widgets\General\ServicesV8Widget;
use Tangibledesign\Listivo\Widgets\General\ServicesV9Widget;
use Tangibledesign\Listivo\Widgets\General\ServicesWidget;
use Tangibledesign\Listivo\Widgets\General\ShapeWidget;
use Tangibledesign\Listivo\Widgets\General\SimpleListWidget;
use Tangibledesign\Listivo\Widgets\General\SimpleMenuWidget;
use Tangibledesign\Listivo\Widgets\General\SocialProfilesV2Widget;
use Tangibledesign\Listivo\Widgets\General\SocialProfilesWidget;
use Tangibledesign\Listivo\Widgets\General\StatsV1Widget;
use Tangibledesign\Listivo\Widgets\General\StatsV2Widget;
use Tangibledesign\Listivo\Widgets\General\StatsV3Widget;
use Tangibledesign\Listivo\Widgets\General\SubheadingWidget;
use Tangibledesign\Listivo\Widgets\General\SvgWidget;
use Tangibledesign\Listivo\Widgets\General\TagCloudWidget;
use Tangibledesign\Listivo\Widgets\General\TermCarouselWidget;
use Tangibledesign\Listivo\Widgets\General\TermListV2Widget;
use Tangibledesign\Listivo\Widgets\General\TermListV3Widget;
use Tangibledesign\Listivo\Widgets\General\TermListV4Widget;
use Tangibledesign\Listivo\Widgets\General\TermListWidget;
use Tangibledesign\Listivo\Widgets\General\TermsWithImagesV2Widget;
use Tangibledesign\Listivo\Widgets\General\TermsWithImagesWidget;
use Tangibledesign\Listivo\Widgets\General\TestimonialListWidget;
use Tangibledesign\Listivo\Widgets\General\TestimonialsV2Widget;
use Tangibledesign\Listivo\Widgets\General\TestimonialsV3Widget;
use Tangibledesign\Listivo\Widgets\General\TestimonialsWidget;
use Tangibledesign\Listivo\Widgets\General\TitleWithBreadcrumbsWidget;
use Tangibledesign\Listivo\Widgets\General\ContentV3Widget;
use Tangibledesign\Listivo\Widgets\General\UserProfilesWidget;
use Tangibledesign\Listivo\Widgets\General\UserProfileV2Widget;
use Tangibledesign\Listivo\Widgets\Listing\ListingAddressWidget;
use Tangibledesign\Listivo\Widgets\Listing\ListingAttachmentsWidget;
use Tangibledesign\Listivo\Widgets\Listing\ListingAttributesV2Widget;
use Tangibledesign\Listivo\Widgets\Listing\ListingAttributesV3Widget;
use Tangibledesign\Listivo\Widgets\Listing\ListingAttributesV4Widget;
use Tangibledesign\Listivo\Widgets\Listing\ListingAttributesWidget;
use Tangibledesign\Listivo\Widgets\Listing\ListingDescriptionWidget;
use Tangibledesign\Listivo\Widgets\Listing\ListingDirectionWidget;
use Tangibledesign\Listivo\Widgets\Listing\ListingEmbedFieldWidget;
use Tangibledesign\Listivo\Widgets\Listing\ListingFeaturesWidget;
use Tangibledesign\Listivo\Widgets\Listing\ListingGalleryV2Widget;
use Tangibledesign\Listivo\Widgets\Listing\ListingGalleryV3Widget;
use Tangibledesign\Listivo\Widgets\Listing\ListingGalleryWidget;
use Tangibledesign\Listivo\Widgets\Listing\ListingIdWidget;
use Tangibledesign\Listivo\Widgets\Listing\ListingInfoWidget;
use Tangibledesign\Listivo\Widgets\Listing\ListingImageWidget;
use Tangibledesign\Listivo\Widgets\Listing\ListingLinkFieldWidget;
use Tangibledesign\Listivo\Widgets\Listing\ListingMapWidget;
use Tangibledesign\Listivo\Widgets\Listing\ListingNumberFieldWidget;
use Tangibledesign\Listivo\Widgets\Listing\ListingPriceWidget;
use Tangibledesign\Listivo\Widgets\Listing\ListingPrintWidget;
use Tangibledesign\Listivo\Widgets\Listing\ListingPublishDateWidget;
use Tangibledesign\Listivo\Widgets\Listing\ListingRatingWidget;
use Tangibledesign\Listivo\Widgets\Listing\ListingReportAbuseWidget;
use Tangibledesign\Listivo\Widgets\Listing\ListingReviewsWidget;
use Tangibledesign\Listivo\Widgets\Listing\ListingRichTextFieldWidget;
use Tangibledesign\Listivo\Widgets\Listing\ListingSocialsWidget;
use Tangibledesign\Listivo\Widgets\Listing\ListingStatsWidget;
use Tangibledesign\Listivo\Widgets\Listing\ListingTextFieldWidget;
use Tangibledesign\Listivo\Widgets\Listing\ListingTopWidget;
use Tangibledesign\Listivo\Widgets\Listing\ListingUserV2Widget;
use Tangibledesign\Listivo\Widgets\Listing\ListingUserWidget;
use Tangibledesign\Listivo\Widgets\Listing\ListingViewsWidget;
use Tangibledesign\Listivo\Widgets\Listing\RelatedListingsWidget;
use Tangibledesign\Listivo\Widgets\Listing\ListingUserListingsWidget;
use Tangibledesign\Listivo\Widgets\Listing\UserProfileButtonWidget;
use Tangibledesign\Listivo\Widgets\PrintModel\PrintListingAddressWidget;
use Tangibledesign\Listivo\Widgets\PrintModel\PrintListingAttributesWidget;
use Tangibledesign\Listivo\Widgets\PrintModel\PrintListingDescriptionWidget;
use Tangibledesign\Listivo\Widgets\PrintModel\PrintListingFeaturesWidget;
use Tangibledesign\Listivo\Widgets\PrintModel\PrintListingGalleryWidget;
use Tangibledesign\Listivo\Widgets\PrintModel\PrintListingImageWidget;
use Tangibledesign\Listivo\Widgets\PrintModel\PrintListingMainInfoWidget;
use Tangibledesign\Listivo\Widgets\PrintModel\PrintListingMapWidget;
use Tangibledesign\Listivo\Widgets\PrintModel\PrintListingNameWidget;
use Tangibledesign\Listivo\Widgets\PrintModel\PrintListingPriceWidget;
use Tangibledesign\Listivo\Widgets\PrintModel\PrintUserWidget;
use Tangibledesign\Listivo\Widgets\User\AccountTypeUserWidget;
use Tangibledesign\Listivo\Widgets\User\CompanyInformationWidget;
use Tangibledesign\Listivo\Widgets\User\RatingUserWidget;
use Tangibledesign\Listivo\Widgets\User\UserChatViaSocialsWidget;
use Tangibledesign\Listivo\Widgets\User\ContactUserWidget;
use Tangibledesign\Listivo\Widgets\User\UserAddressWidget;
use Tangibledesign\Listivo\Widgets\User\UserCustomTextWidget;
use Tangibledesign\Listivo\Widgets\User\UserFullNameWidget;
use Tangibledesign\Listivo\Widgets\User\UserHeroWidget;
use Tangibledesign\Listivo\Widgets\User\UserHiddenPhoneWidget;
use Tangibledesign\Listivo\Widgets\User\UserImageWidget;
use Tangibledesign\Listivo\Widgets\User\UserJobTitleWidget;
use Tangibledesign\Listivo\Widgets\User\UserListingsWidget;
use Tangibledesign\Listivo\Widgets\User\UserNameWidget;
use Tangibledesign\Listivo\Widgets\User\UserPhoneWidget;
use Tangibledesign\Listivo\Widgets\User\UserRegisteredSinceWidget;
use Tangibledesign\Listivo\Widgets\User\UserReviewsWidget;
use Tangibledesign\Listivo\Widgets\User\UserSmsWidget;
use Tangibledesign\Listivo\Widgets\User\UserSocialsWidget;
use Tangibledesign\Listivo\Widgets\User\UserViberWidget;
use Tangibledesign\Listivo\Widgets\User\UserWebsite;
use Tangibledesign\Listivo\Widgets\User\UserWhatsAppWidget;

add_filter('tdf/widgets', static function (array $widgets) {
    return array_merge($widgets, [
        TemplateLoaderWidget::class,
        /**
         * General
         */
        PagesCarouselWidget::class,
        AccordionWidget::class,
        ButtonWidget::class,
        BlockWidget::class,
        SocialProfilesV2Widget::class,
        ContactFormWidget::class,
        LogoWidget::class,
        SimpleMenuWidget::class,
        SearchWidget::class,
        CopyrightsWidget::class,
        MapWidget::class,
        SearchMapWidget::class,
        PanelWidget::class,
        PhoneV3Widget::class,
        AddressV2Widget::class,
        EmailV2Widget::class,
        TitleWithBreadcrumbsWidget::class,
        ServicesV4Widget::class,
        LinksSidebarWidget::class,
        MailchimpNewsletterFormV2Widget::class,
        PageNotFoundWidget::class,
        ContentV2Widget::class,
        StatsV1Widget::class,
        ServicesV5Widget::class,
        ContentV3Widget::class,
        HeroSearchV5Widget::class,
        CategoriesV1Widget::class,
        ListingCarouselWithTabsWidgetV2::class,
        CallToActionSectionV2Widget::class,
        TestimonialsV3Widget::class,
        HeroSearchV6Widget::class,
        CategoriesV2Widget::class,
        CallToActionSectionV3Widget::class,
        MailchimpNewsletterFormV3Widget::class,
        UserProfileV2Widget::class,
        BreadcrumbsV2Widget::class,
        CompareAreaWidget::class,
        MenuV2Widget::class,
        HeroSearchV4Widget::class,
        ServicesV3WidgetAlias::class,
        HeadingV2Widget::class,
        ContentV1Widget::class,
        ListingListWithTabsWidgetAlias::class,
        TermCarouselWidget::class,
        TestimonialsV2Widget::class,
        BlogPostsV2Widget::class,
        MailchimpNewsletterFormWidget::class,
        UserProfilesWidget::class,
        LoginAndRegisterWidget::class,
        FooterListingListWidget::class,
        BlogCategoriesWidget::class,
        TagCloudWidget::class,
        PostsSidebarWidget::class,
        BlogKeywordSearchWidget::class,
        ListingListWidget::class,
        ListingListV2Widget::class,
        ListingCarouselWidget::class,
        CategoriesV3Widget::class,
        ContentV4Widget::class,
        ServicesV6Widget::class,
        MailchimpNewsletterFormV4Widget::class,
        HeroSearchV7Widget::class,
        HeroV1Widget::class,
        ContentV5Widget::class,
        ListingListWithTabsV2Widget::class,
        TermListWidget::class,
        InfoBoxWidget::class,
        PhoneBoxWidget::class,
        HeroSearchV8Widget::class,
        ContentV6Widget::class,
        TermListV2Widget::class,
        ServicesV7Widget::class,
        TestimonialListWidget::class,
        PostCarouselWidget::class,
        MailchimpNewsletterFormV5Widget::class,
        HeroSearchV9Widget::class,
        ServicesV8Widget::class,
        ContentV7Widget::class,
        HeroSearchV10Widget::class,
        ContentV8Widget::class,
        TermListV3Widget::class,
        ServicesV9Widget::class,
        StatsV2Widget::class,
        PopularTermsV2Widget::class,
        SearchFormV2Widget::class,
        SimpleListWidget::class,
        StatsV3Widget::class,
        IconBoxWidget::class,
        CategoriesV4Widget::class,
        BadgeWidget::class,
        DynamicTitleWidget::class,
        SvgWidget::class,
        CategoriesV5Widget::class,
        ImageMosaicWidget::class,
        TermListV4Widget::class,
        MiniListingCarouselWidget::class,
        SearchV2Widget::class,
        PatternWidget::class,
        PaymentPackagePricingTableWidget::class,
        /**
         * Listing
         */
        ListingGalleryWidget::class,
        ListingGalleryV2Widget::class,
        ListingGalleryV3Widget::class,
        ListingDescriptionWidget::class,
        ListingAttributesWidget::class,
        ListingEmbedFieldWidget::class,
        ListingMapWidget::class,
        ListingUserListingsWidget::class,
        ListingAddressWidget::class,
        LoanCalculatorWidget::class,
        ListingAttachmentsWidget::class,
        RelatedListingsWidget::class,
        ListingUserWidget::class,
        ListingSocialsWidget::class,
        ListingInfoWidget::class,
        ListingImageWidget::class,
        ListingTopWidget::class,
        ListingDirectionWidget::class,
        ListingStatsWidget::class,
        ContactUserWidget::class,
        ListingNameWidget::class,
        ListingAttributesV3Widget::class,
        ListingPriceWidget::class,
        ListingFeaturesWidget::class,
        ListingUserV2Widget::class,
        ListingReportAbuseWidget::class,
        ListingLinkFieldWidget::class,
        ListingRichTextFieldWidget::class,
        ListingAttributesV4Widget::class,
        ListingReviewsWidget::class,
        ListingRatingWidget::class,
        /**
         * Listing Print
         */
        PrintListingNameWidget::class,
        PrintListingDescriptionWidget::class,
        PrintListingGalleryWidget::class,
        PrintListingImageWidget::class,
        PrintListingAddressWidget::class,
        PrintListingAttributesWidget::class,
        PrintListingFeaturesWidget::class,
        PrintUserWidget::class,
        PrintListingPriceWidget::class,
        PrintListingMapWidget::class,
        /**
         * User
         */
        UserHiddenPhoneWidget::class,
        UserRegisteredSinceWidget::class,
        UserWhatsAppWidget::class,
        UserSmsWidget::class,
        UserViberWidget::class,
        UserHeroWidget::class,
        UserListingsWidget::class,
        UserChatViaSocialsWidget::class,
        UserDescriptionWidget::class,
        AccountTypeUserWidget::class,
        UserWebsite::class,
        CompanyInformationWidget::class,
        UserFullNameWidget::class,
        UserCustomTextWidget::class,
        UserSocialsWidget::class,
        UserReviewsWidget::class,
        RatingUserWidget::class,
        /**
         * Blog
         */
        BlogArchiveTitleWithBreadcrumbsWidget::class,
        BlogArchiveV2Widget::class,
        /**
         * Post
         */
        BlogPostCommentsWidget::class,
        RelatedBlogPostsCarouselWidget::class,
        BlogPostV2Widget::class,
        UserImageWidget::class,
        /* Legacy */
        TermsWithImagesWidget::class,
        TermsWithImagesV2Widget::class,
        BlogArchiveWidget::class,
        BlogPostsV1Widget::class,
        UserNameWidget::class,
        UserAddressWidget::class,
        SocialShareWidget::class,
        ListingPublishDateWidget::class,
        ListingAttributesV2Widget::class,
        ListingIdWidget::class,
        ListingViewsWidget::class,
        UserProfileButtonWidget::class,
        UserProfileWidget::class,
        BreadcrumbsWidget::class,
        BlogPostWidget::class,
        PhoneV2Widget::class,
        PhoneWidget::class,
        AddressWidget::class,
        EmailWidget::class,
        ListingTextFieldWidget::class,
        ListingNumberFieldWidget::class,
        HeadingWidget::class,
        TestimonialsWidget::class,
        MainCategoriesV2Widget::class,
        MainCategoriesWidget::class,
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
        UserJobTitleWidget::class,
        UserPhoneWidget::class,
    ]);
});