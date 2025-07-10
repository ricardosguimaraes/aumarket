<?php

use Tangibledesign\Framework\Models\Field\LocationField;
use Tangibledesign\Listivo\Widgets\General\Search\SearchMapWidget;

/* @var SearchMapWidget $lstCurrentWidget */
global $lstCurrentWidget, $lstCurrentListings, $lstSelectedDependencyTerms;

$lstInitialFilters = $lstCurrentWidget->getInitialFilters();
$lstCurrentListings = $lstCurrentWidget->getListings($lstInitialFilters);
$lstSelectedDependencyTerms = $lstCurrentWidget->getSelectedDependencyTerms($lstInitialFilters);
$lstLocationField = tdf_settings()->getCardLocationField()->find(static function ($field) {
    return $field instanceof LocationField;
});

if (!$lstLocationField instanceof LocationField) {
    $lstLocationField = tdf_location_fields()->first(false);
}

if (!$lstLocationField instanceof LocationField) {
    return;
}
?>
<div class="listivo-app">
    <lst-map-tabs
            initial-tab="listings"
            overflow-class="listivo-overflow-hidden"
    >
        <div
                slot-scope="tabs"
                class="listivo-map-search-wrapper"
                :class="{
                    'listivo-map-search-wrapper--map-view': tabs.tab === 'map',
                    'listivo-map-search-wrapper--results-view': tabs.tab === 'listings',
                }"
        >
            <lst-query-models
                    prefix="listivo"
                    base-url="<?php echo esc_url($lstCurrentWidget->getBaseUrl()); ?>"
                    request-url="<?php echo esc_url(get_rest_url() . 'listivo/v1/listings'); ?>"
                    :dependency-terms="<?php echo htmlspecialchars(json_encode(tdf_app('dependency_terms'))); ?>"
                    :initial-filters="<?php echo htmlspecialchars(json_encode($lstInitialFilters)); ?>"
                    initial-template="<?php echo esc_attr($lstCurrentWidget->getInitialTemplate()); ?>"
                    wrapper-class="listivo-search-results__list-results"
                    :limit="<?php echo esc_attr($lstCurrentWidget->getLimit()); ?>"
                    :initial-page="<?php echo esc_attr($lstCurrentWidget->getCurrentPage()); ?>"
                    :initial-count="<?php echo esc_attr($lstCurrentWidget->getCount()); ?>"
                    :initial-term-count="<?php echo htmlspecialchars(json_encode($lstCurrentWidget->getTermCount())); ?>"
                    scroll-to-selector=".listivo-search-results"
                    :map="true"
                    :initial-markers="<?php echo htmlspecialchars(json_encode($lstCurrentWidget->getMarkers())); ?>"
                    initial-sort-by="<?php echo esc_attr($lstCurrentWidget->getInitialSortBy()); ?>"
                    initial-title="<?php echo esc_attr($lstCurrentWidget->getSearchTitle()); ?>"
                    initial-description="<?php echo esc_attr($lstCurrentWidget->getSearchDescription()); ?>"
                    :update-title="<?php echo esc_attr(tdf_settings()->searchOverrideTitleTag() ? 'true' : 'false'); ?>"
                <?php if (tdf_settings()->getCardLocationField()) : ?>
                    :location-field-id="<?php echo esc_attr($lstLocationField->getId()); ?>"
                <?php endif; ?>
            >
                <div
                        slot-scope="props"
                        class="listivo-map-search"
                        :class="{'listivo-loading': props.inProgress}"
                >
                    <div class="listivo-map-search__left">
                        <?php get_template_part('templates/widgets/general/search/search_form'); ?>

                        <div class="listivo-container">
                            <?php get_template_part('templates/widgets/general/search/results'); ?>
                        </div>
                    </div>

                    <div class="listivo-map-search__right">
                        <div class="listivo-map-search__map">
                            <?php get_template_part('templates/widgets/general/search/map'); ?>
                        </div>
                    </div>
                </div>
            </lst-query-models>

            <template v-if="tabs.tab === 'listings'">
                <div
                        class="listivo-search-map-switcher"
                        @click="tabs.setTab('map')"
                >
                    <div class="listivo-search-map-switcher__inner">
                        <div class="listivo-search-map-switcher__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="18" viewBox="0 0 16 18"
                                 fill="none">
                                <path d="M12.6316 0C10.7714 0 9.26316 1.5036 9.26316 3.35811C9.26316 5.75665 12.6316 9.23481 12.6316 9.23481C12.6316 9.23481 16 5.75665 16 3.35811C16 1.5036 14.4918 0 12.6316 0ZM12.6316 2.15785C13.296 2.15785 13.8355 2.69573 13.8355 3.35811C13.8355 4.0205 13.296 4.55838 12.6316 4.55838C11.9672 4.55838 11.4276 4.0205 11.4276 3.35811C11.4276 2.69573 11.9672 2.15785 12.6316 2.15785ZM5.02632 2.46448L0.529605 4.25831C0.209605 4.38592 0 4.6938 0 5.03717V16.7906C0 17.3841 0.601342 17.791 1.15461 17.5711L5.07895 16.0052L10.1316 17.6842L14.6283 15.892C14.9483 15.7636 15.1579 15.4549 15.1579 15.1115V8.8872C14.5752 9.62598 14.0602 10.1773 13.8421 10.4023L13.4737 10.7827V14.5442L10.9474 15.551V9.8907C10.5019 9.39202 9.86611 8.63442 9.26316 7.73612V15.6264L5.89474 14.5081V4.5223L7.93914 5.20114C7.71851 4.58409 7.57895 3.9609 7.57895 3.35811C7.57895 3.343 7.58224 3.32895 7.58224 3.31384L5.02632 2.46448ZM4.21053 4.59773V14.5425L1.68421 15.551V5.60615L4.21053 4.59773Z"
                                      fill="#FDFDFE"/>
                            </svg>
                        </div>

                        <?php echo esc_html(tdf_string('map_view')); ?>
                    </div>
                </div>
            </template>

            <template v-if="tabs.tab === 'map'">
                <div
                        class="listivo-search-map-switcher"
                        @click="tabs.setTab('listings')"
                >
                    <div class="listivo-search-map-switcher__inner">
                        <div class="listivo-search-map-switcher__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="18" viewBox="0 0 16 18"
                                 fill="none">
                                <path d="M12.6316 0C10.7714 0 9.26316 1.5036 9.26316 3.35811C9.26316 5.75665 12.6316 9.23481 12.6316 9.23481C12.6316 9.23481 16 5.75665 16 3.35811C16 1.5036 14.4918 0 12.6316 0ZM12.6316 2.15785C13.296 2.15785 13.8355 2.69573 13.8355 3.35811C13.8355 4.0205 13.296 4.55838 12.6316 4.55838C11.9672 4.55838 11.4276 4.0205 11.4276 3.35811C11.4276 2.69573 11.9672 2.15785 12.6316 2.15785ZM5.02632 2.46448L0.529605 4.25831C0.209605 4.38592 0 4.6938 0 5.03717V16.7906C0 17.3841 0.601342 17.791 1.15461 17.5711L5.07895 16.0052L10.1316 17.6842L14.6283 15.892C14.9483 15.7636 15.1579 15.4549 15.1579 15.1115V8.8872C14.5752 9.62598 14.0602 10.1773 13.8421 10.4023L13.4737 10.7827V14.5442L10.9474 15.551V9.8907C10.5019 9.39202 9.86611 8.63442 9.26316 7.73612V15.6264L5.89474 14.5081V4.5223L7.93914 5.20114C7.71851 4.58409 7.57895 3.9609 7.57895 3.35811C7.57895 3.343 7.58224 3.32895 7.58224 3.31384L5.02632 2.46448ZM4.21053 4.59773V14.5425L1.68421 15.551V5.60615L4.21053 4.59773Z"
                                      fill="#FDFDFE"/>
                            </svg>
                        </div>

                        <?php echo esc_html(tdf_string('list_view')); ?>
                    </div>
                </div>
            </template>
        </div>
    </lst-map-tabs>
</div>