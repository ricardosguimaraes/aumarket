<?php

use Tangibledesign\Framework\Models\Term\CustomTerm;
use Tangibledesign\Listivo\Widgets\General\ListingListWithTabsWidget;

/* @var ListingListWithTabsWidget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-app <?php echo esc_attr($lstCurrentWidget->getFeaturedLabelClasses()); ?>">
    <lst-model-list-with-tabs
            initial-tab="<?php echo esc_attr($lstCurrentWidget->getInitialTab()); ?>"
            :limit="<?php echo esc_attr($lstCurrentWidget->getLimit()); ?>"
            request-url="<?php echo esc_url(tdf_action_url('listivo/modelWidget/queryByTab')); ?>"
            :include-excluded="<?php echo esc_attr($lstCurrentWidget->includeExcluded() ? 'true' : 'false'); ?>"
            template="listing_grid_<?php echo esc_attr($lstCurrentWidget->getCardType()); ?>"
            selector-class="listivo-listing-list-with-tabs__dynamic"
            order-by="<?php echo esc_attr($lstCurrentWidget->getInitialSortBy()); ?>"
            :featured-only="<?php echo esc_attr($lstCurrentWidget->onlyFeatured() ? 'true' : 'false'); ?>"
    >
        <div slot-scope="props" class="listivo-listing-list-with-tabs">
            <div class="listivo-listing-list-with-tabs__head">
                <div class="listivo-listing-list-with-tabs__tabs listivo-tabs-v2">
                    <?php if ($lstCurrentWidget->showAllTab()) : ?>
                        <div
                                class="listivo-tabs-v2__tab listivo-tab-v2"
                                :class="{'listivo-tab-v2--active': props.tab === 'all'}"
                                @click.prevent="props.setTab('all')"
                        >
                            <?php echo esc_html(tdf_string('all')); ?>
                        </div>
                    <?php endif; ?>

                    <?php foreach ($lstCurrentWidget->getTabs() as $lstTab) : ?>
                        <div
                                class="listivo-tabs-v2__tab listivo-tab-v2"
                                :class="{'listivo-tab-v2--active': props.tab === '<?php echo esc_attr($lstTab->getId()); ?>'}"
                                @click.prevent="props.setTab('<?php echo esc_attr($lstTab->getId()); ?>')"
                        >
                            <?php echo esc_html($lstTab->getName()); ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="listivo-listing-list-with-tabs__button">
                    <a
                            class="listivo-button listivo-button--primary-1"
                            href="<?php echo esc_url(get_post_type_archive_link(tdf_model_post_type())); ?>"
                    >
                        <span>
                            <?php echo esc_html(tdf_string('view_all')); ?>

                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                 fill="none">
                                <path d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49605 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455586 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z"
                                      fill="#FDFDFE"/>
                            </svg>
                        </span>
                    </a>
                </div>
            </div>

            <div class="listivo-listing-list-with-tabs__list">
                <template>
                    <div v-if="props.inProgress" class="listivo-listing-grid">
                        <?php for ($lstI = 0; $lstI < $lstCurrentWidget->getLimit(); $lstI++): ?>
                            <?php if ($lstCurrentWidget->isRegularCardType()) : ?>
                                <?php get_template_part('templates/partials/card/skeleton_listing_card_v3'); ?>
                            <?php else : ?>
                                <?php get_template_part('templates/partials/card/skeleton_listing_card_v4'); ?>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                </template>

                <div v-if="!props.showContent && !props.inProgress">
                    <?php
                    global $lstModels, $lstShowFeaturedLabel;
                    $lstModels = $lstCurrentWidget->getModels();
                    $lstShowFeaturedLabel = $lstCurrentWidget->showFeaturedLabel();

                    get_template_part('templates/partials/listing_grid_' . $lstCurrentWidget->getCardType());
                    ?>
                </div>

                <template v-show="props.showContent && !props.inProgress">
                    <div class="listivo-listing-list-with-tabs__dynamic"></div>
                </template>
            </div>
        </div>
    </lst-model-list-with-tabs>
</div>