<?php

use Tangibledesign\Listivo\Widgets\General\Search\SearchWidget;

/* @var SearchWidget $lstCurrentWidget */
global $lstCurrentWidget, $lstSelectedDependencyTerms;

$lstSelectedDependencyTerms = $lstCurrentWidget->getSelectedDependencyTerms($lstCurrentWidget->getInitialFilters());
if (is_author()) {
    $lstUser = $lstCurrentWidget->getUser();
} else {
    $lstUser = false;
}
?>
<div class="listivo-app">
    <lst-query-models
            prefix="listivo"
            request-url="<?php echo esc_url(get_rest_url().'listivo/v1/listings'); ?>"
            :dependency-terms="<?php echo htmlspecialchars(json_encode(tdf_app('dependency_terms'))); ?>"
            :initial-filters="<?php echo htmlspecialchars(json_encode($lstCurrentWidget->getInitialFilters())); ?>"
            initial-template="<?php echo esc_attr($lstCurrentWidget->getInitialTemplate()); ?>"
            wrapper-class="listivo-search-results__list-results"
            :limit="<?php echo esc_attr($lstCurrentWidget->getLimit()); ?>"
            :initial-page="<?php echo esc_attr($lstCurrentWidget->getCurrentPage()); ?>"
            :initial-count="<?php echo esc_attr($lstCurrentWidget->getCount()); ?>"
            :initial-term-count="<?php echo htmlspecialchars(json_encode($lstCurrentWidget->getTermCount())); ?>"
            initial-sort-by="<?php echo esc_attr($lstCurrentWidget->getInitialSortBy()); ?>"
            scroll-to-selector=".listivo-search-results"
            card-type="<?php echo esc_attr($lstCurrentWidget->getCardType()); ?>"
            initial-title="<?php echo esc_attr($lstCurrentWidget->getSearchTitle()); ?>"
            initial-description="<?php echo esc_attr($lstCurrentWidget->getSearchDescription()); ?>"
            :update-title="<?php echo esc_attr(tdf_settings()->searchOverrideTitleTag() ? 'true' : 'false'); ?>"
        <?php if ($lstUser) : ?>
            :user-ids="<?php echo htmlspecialchars(json_encode([$lstUser->getId()])); ?>"
            base-url="<?php echo esc_url($lstUser->getUrl()); ?>"
        <?php else : ?>
            base-url="<?php echo esc_url(get_post_type_archive_link(tdf_model_post_type())); ?>"
        <?php endif; ?>
    >
        <div slot-scope="props" :class="{'listivo-loading': props.inProgress}">
            <?php get_template_part('templates/widgets/general/search/search_form'); ?>

            <div class="listivo-container">
                <?php get_template_part('templates/widgets/general/search/results'); ?>
            </div>
        </div>
    </lst-query-models>
</div>