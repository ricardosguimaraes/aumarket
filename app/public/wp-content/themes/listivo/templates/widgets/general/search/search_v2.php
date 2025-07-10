<?php

use Tangibledesign\Listivo\Widgets\General\Search\SearchV2Widget;

/* @var SearchV2Widget $lstCurrentWidget */
global $lstCurrentWidget, $lstCurrentListings, $lstSelectedDependencyTerms;

$lstInitialFilters = $lstCurrentWidget->getInitialFilters();
$lstCurrentListings = $lstCurrentWidget->getListings($lstInitialFilters);
$lstSelectedDependencyTerms = $lstCurrentWidget->getSelectedDependencyTerms($lstInitialFilters);
if (is_author()) {
    $lstUser = $lstCurrentWidget->getUser();
} else {
    $lstUser = false;
}
?>
<div class="listivo-app">
    <lst-query-models
            prefix="listivo"
            request-url="<?php echo esc_url(get_rest_url() . 'listivo/v1/listings'); ?>"
            :dependency-terms="<?php echo htmlspecialchars(json_encode(tdf_app('dependency_terms'))); ?>"
            :initial-filters="<?php echo htmlspecialchars(json_encode($lstInitialFilters)); ?>"
            initial-template="<?php echo esc_attr($lstCurrentWidget->getInitialTemplate()); ?>"
            wrapper-class="listivo-search-results__list-results"
            :limit="<?php echo esc_attr($lstCurrentWidget->getLimit()); ?>"
            :initial-page="<?php echo esc_attr($lstCurrentWidget->getCurrentPage()); ?>"
            :initial-count="<?php echo esc_attr($lstCurrentWidget->getCount()); ?>"
            initial-sort-by="<?php echo esc_attr($lstCurrentWidget->getInitialSortBy()); ?>"
            scroll-to-selector=".listivo-search-results"
            card-type="<?php echo esc_attr($lstCurrentWidget->getCardType()); ?>"
            row-type="<?php echo esc_attr($lstCurrentWidget->getRowCardType()); ?>"
            initial-title="<?php echo esc_attr($lstCurrentWidget->getSearchTitle()); ?>"
            initial-description="<?php echo esc_attr($lstCurrentWidget->getSearchDescription()); ?>"
            :update-title="<?php echo esc_attr(tdf_settings()->searchOverrideTitleTag() ? 'true' : 'false'); ?>"
        <?php if ($lstCurrentListings->isNotEmpty()) : ?>
            :initial-term-count="<?php echo htmlspecialchars(json_encode($lstCurrentWidget->getTermCount())); ?>"
        <?php endif; ?>
        <?php if ($lstUser) : ?>
            :user-ids="<?php echo htmlspecialchars(json_encode([$lstUser->getId()])); ?>"
            base-url="<?php echo esc_url($lstUser->getUrl()); ?>"
        <?php else : ?>
            base-url="<?php echo esc_url(get_post_type_archive_link(tdf_model_post_type())); ?>"
        <?php endif; ?>
    >
        <div
                slot-scope="props"
                class="listivo-search-v2"
                :class="{'listivo-loading': props.inProgress}"
        >
            <div class="listivo-search-v2__primary-form">
                <?php get_template_part('templates/widgets/general/search/primary_search_form'); ?>
            </div>

            <div class="listivo-search-v2__content">
                <lst-search-sidebar
                        prefix="listivo"
                    <?php if ($lstCurrentWidget->isStickySidebar()) : ?>
                        class="listivo-search-v2__sidebar listivo-search-v2__sidebar--sticky"
                    <?php else : ?>
                        class="listivo-search-v2__sidebar"
                    <?php endif; ?>
                >
                    <div
                            slot-scope="sidebarProps"
                            class="listivo-search-v2__sidebar"
                            :class="{'listivo-search-v2__sidebar--open': sidebarProps.open}"
                            @click="sidebarProps.onOpen"
                    >
                        <?php get_template_part('templates/widgets/general/search/sidebar'); ?>

                        <portal v-show="sidebarProps.open" to="footer">
                            <div
                                    class="listivo-search-sidebar-mobile-button"
                                    :class="{'listivo-search-sidebar-mobile-button--show': sidebarProps.open}"
                            >
                                <div
                                        class="listivo-search-sidebar-mobile-button__close"
                                        @click.stop.prevent="sidebarProps.onOpen"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17"
                                         viewBox="0 0 17 17"
                                         fill="none">
                                        <path d="M15.9999 15.9999L1 1" stroke="#2A3946" stroke-width="2"
                                              stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M16 1L1 16" stroke="#2A3946" stroke-width="2"
                                              stroke-linecap="round"
                                              stroke-linejoin="round"></path>
                                    </svg>
                                </div>
                            </div>
                        </portal>
                    </div>
                </lst-search-sidebar>

                <div class="listivo-search-v2__results">
                    <lst-open-sidebar-filters>
                        <div slot-scope="openSidebarFilters" class="listivo-search-v2__more-filters">
                            <div class=" listivo-mobile-container">
                                <button
                                        class="listivo-simple-button listivo-simple-button--full-width listivo-simple-button--height-45 listivo-simple-button--background-primary-1"
                                        @click="openSidebarFilters.onClick"
                                >
                                    <span class="listivo-simple-button__icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16"
                                             viewBox="0 0 14 16" fill="none">
                                            <path d="M0 0V1.49148L0.139205 1.67045L5.09091 7.85511V15.2727L6.10511 14.517L8.65057 12.608L8.90909 12.4091V7.85511L13.8608 1.67045L14 1.49148V0H0ZM1.4517 1.27273H12.5483L7.97443 7H6.02557L1.4517 1.27273ZM6.36364 8.27273H7.63636V11.7727L6.36364 12.7273V8.27273Z"
                                                  fill="#FDFDFE"/>
                                        </svg>
                                    </span>

                                    <?php echo esc_html(tdf_string('more_filters')); ?>
                                </button>
                            </div>
                        </div>
                    </lst-open-sidebar-filters>

                    <?php get_template_part('templates/widgets/general/search/results'); ?>
                </div>
            </div>
        </div>
    </lst-query-models>
</div>