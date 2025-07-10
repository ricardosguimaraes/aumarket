<?php

use Tangibledesign\Framework\Models\Term\CustomTerm;
use Tangibledesign\Listivo\Widgets\General\HeroSearchV8Widget;

/* @var HeroSearchV8Widget $lstCurrentWidget */
global $lstCurrentWidget;

$lstFields = $lstCurrentWidget->getFields();
$lstColumns = $lstFields->count() > 4 ? 4 : $lstFields->count();
$lstMainFieldTaxonomy = $lstCurrentWidget->getMainFieldTaxonomy();
$lstTermsData = $lstCurrentWidget->getMainFieldTermsData();
$lstMainFieldTerms = $lstCurrentWidget->getMainFieldTerms($lstTermsData);
if ($lstMainFieldTerms->isEmpty() || $lstCurrentWidget->hasMainFieldAllOption()) {
    $lstInitialTermCount = $lstCurrentWidget->getTermCount();
} else {
    $lstInitialTermCount = $lstCurrentWidget->getTermCount(['filters' => $lstCurrentWidget->getInitialFilters($lstMainFieldTerms->first())]);
}
?>
<div class="listivo-app listivo-hero-search-v8">
    <div class="listivo-hero-search-v8__container">
        <?php if (!empty($lstCurrentWidget->getFirstImage())) : ?>
            <div class="listivo-hero-search-v8__first-image-wrapper">
                <div class="listivo-hero-search-v8__first-image">
                    <img
                            src="<?php echo esc_url($lstCurrentWidget->getFirstImage()); ?>"
                            alt="<?php echo esc_attr($lstCurrentWidget->getHeading()); ?>"
                    >
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($lstCurrentWidget->getSecondImage())) : ?>
            <div class="listivo-hero-search-v8__second-image-wrapper">
                <div class="listivo-hero-search-v8__second-image">
                    <img
                            class="lazyload"
                            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                            data-src="<?php echo esc_url($lstCurrentWidget->getSecondImage()); ?>"
                            alt="<?php echo esc_attr($lstCurrentWidget->getHeading()); ?>"
                    >
                </div>
            </div>
        <?php endif; ?>

        <div class="listivo-hero-search-v8__content">
            <h1 class="listivo-hero-search-v8__heading">
                <?php echo nl2br(wp_kses_post($lstCurrentWidget->getHeading())); ?>

                <?php if ($lstCurrentWidget->showArrow()) : ?>
                    <div class="listivo-hero-search-v8__arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="113" height="138" viewBox="0 0 113 138"
                             fill="none">
                            <path d="M64.5426 2.27885C78.0427 7.77898 89.9761 27.1222 91.0428 38.2789C95.7385 87.388 63.8716 105.431 17.4817 113.366"
                                  stroke="#FA5343" stroke-width="3" stroke-dasharray="8"/>
                            <path d="M23.061 99.2057C9.95166 120.397 5.60595 112.336 25.9132 122.443" stroke="#FA5343"
                                  stroke-width="3"/>
                        </svg>
                    </div>
                <?php endif; ?>
            </h1>

            <lst-search-form
                    class="listivo-hero-search-v8__form-container"
                    base-url="<?php echo esc_url(get_post_type_archive_link(tdf_model_post_type())); ?>"
                    request-url="<?php echo esc_url(get_rest_url() . 'listivo/v1/listings'); ?>"
                    :dependency-terms="<?php echo htmlspecialchars(json_encode(tdf_app('dependency_terms'))); ?>"
                    :initial-term-count="<?php echo htmlspecialchars(json_encode($lstInitialTermCount)); ?>"
                    initial-sort-by="<?php echo esc_attr(tdf_slug('newest')); ?>"
                    field-selector=".listivo-search-form-field"
                    :max-fields-per-row="3"
                <?php if (!$lstCurrentWidget->hasMainFieldAllOption() && $lstMainFieldTerms->isNotEmpty()) : ?>
                    :initial-filters="<?php echo htmlspecialchars(json_encode($lstCurrentWidget->getInitialFilters($lstMainFieldTerms->first()))); ?>"
                <?php endif; ?>
            >
                <div class="listivo-hero-search-v8__form-container" slot-scope="props">
                    <?php if ($lstMainFieldTaxonomy && $lstMainFieldTerms->isNotEmpty())  : ?>
                        <lst-taxonomy-search-field
                                :field="<?php echo htmlspecialchars(json_encode($lstMainFieldTaxonomy->getSearchField([]))); ?>"
                                :initial-terms="<?php echo htmlspecialchars(json_encode($lstMainFieldTerms)); ?>"
                                :disable-fetch-terms="true"
                                :filters="props.filters"
                                :dependencies="props.dependencies"
                                :term-count="props.termCount"
                                :multiple="false"
                                class="listivo-hero-search-v8__tabs"
                                :on-change-clear-other-taxonomies="true"
                        >
                            <div slot-scope="taxonomyField" class="listivo-hero-search-v8__tabs">
                                <?php if ($lstCurrentWidget->hasMainFieldAllOption()) : ?>
                                    <div
                                            class="listivo-hero-search-v8__tab"
                                            :class="{'listivo-hero-search-v8__tab--active': taxonomyField.values.length === 0}"
                                            @click.prevent="taxonomyField.clear"
                                    >
                                        <?php if (!empty($lstCurrentWidget->getMainFieldAllImage())) : ?>
                                            <div class="listivo-hero-search-v8__tab-image">
                                                <img
                                                        src="<?php echo esc_url($lstCurrentWidget->getMainFieldAllImage()); ?>"
                                                        alt="<?php echo esc_attr(tdf_string('all')); ?>"
                                                >
                                            </div>
                                        <?php endif; ?>

                                        <div class="listivo-hero-search-v8__tab-label">
                                            <?php echo esc_html(tdf_string('all')); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php foreach ($lstTermsData as $lstItem) :
                                    /* @var CustomTerm $lstTerm */
                                    $lstTerm = $lstItem['term'];
                                    ?>
                                    <div
                                            class="listivo-hero-search-v8__tab"
                                            :class="{'listivo-hero-search-v8__tab--active': taxonomyField.selectedTermIds.indexOf(<?php echo esc_attr($lstTerm->getId()); ?>) !== -1}"
                                            @click="taxonomyField.setTerm(<?php echo esc_attr($lstTerm->getId()); ?>)"
                                    >
                                        <div class="listivo-hero-search-v8__tab-image">
                                            <?php if (!empty($lstItem['image']['url'])) : ?>
                                                <img
                                                        src="<?php echo esc_url($lstItem['image']['url']); ?>"
                                                        alt="<?php echo esc_attr($lstTerm->getName()); ?>"
                                                >
                                            <?php endif; ?>
                                        </div>

                                        <div class="listivo-hero-search-v8__tab-label">
                                            <?php echo esc_html($lstTerm->getName()); ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </lst-taxonomy-search-field>
                    <?php endif; ?>

                    <div class="listivo-hero-search-v8__form-wrapper">
                        <div
                            <?php if ($lstMainFieldTerms->isNotEmpty()) : ?>
                                class="listivo-hero-search-v8__form listivo-hero-search-v8__form--has-tabs"
                            <?php else : ?>
                                class="listivo-hero-search-v8__form"
                            <?php endif; ?>
                        >
                            <div
                                    class="listivo-hero-search-v8__fields listivo-hero-search-v8__fields--initial-<?php echo esc_attr($lstColumns); ?>"
                                    :class="'listivo-hero-search-v8__fields--' + props.fieldsNumber"
                            >
                                <?php
                                global $lstSearchField;
                                foreach ($lstFields as $lstSearchField) :
                                    get_template_part(
                                        'templates/partials/search/v2/' . $lstSearchField->getType(),
                                        '',
                                        [
                                            'show_label' => true,
                                        ]);
                                endforeach;
                                ?>
                            </div>

                            <button
                                    class="listivo-hero-search-v8__button"
                                    :class="{'listivo-hero-search-v8__button--loading': props.inProgress}"
                                    @click="props.onSearch"
                            >
                                <svg
                                        v-if="!props.inProgress"
                                        xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"
                                        fill="none"
                                >
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M0 7.24416C0 3.25516 3.25515 0 7.24416 0C11.2332 0 14.4883 3.25516 14.4883 7.24416C14.4883 8.87942 13.9353 10.3861 13.0149 11.601L17.6928 16.2798C17.9538 16.5305 18.0589 16.9026 17.9677 17.2528C17.8764 17.6029 17.6029 17.8764 17.2528 17.9677C16.9026 18.0589 16.5305 17.9538 16.2798 17.6928L11.601 13.0149C10.3861 13.9353 8.87942 14.4883 7.24416 14.4883C3.25515 14.4883 0 11.2332 0 7.24416ZM12.4899 7.24416C12.4899 4.33516 10.1532 1.99839 7.24416 1.99839C4.33516 1.99839 1.99839 4.33516 1.99839 7.24416C1.99839 10.1532 4.33516 12.4899 7.24416 12.4899C8.64188 12.4899 9.90406 11.9466 10.8418 11.0633C10.904 10.9775 10.9794 10.9021 11.0653 10.8399C11.9474 9.90231 12.4899 8.64089 12.4899 7.24416Z"
                                          fill="#FDFDFE"/>
                                </svg>

                                <template>
                                    <svg
                                            v-if="props.inProgress"
                                            width='40'
                                            height='10'
                                            viewBox='0 0 120 30'
                                            xmlns='http://www.w3.org/2000/svg'
                                            fill='#fff'
                                    >
                                        <circle cx='60' cy='15' r='9' fill-opacity='0.3'>
                                            <animate attributeName='r' from='9' to='9' begin='0s'
                                                     dur='0.8s' values='9;15;9'
                                                     calcMode='linear' repeatCount='indefinite'/>
                                            <animate attributeName='fill-opacity' from='0.5' to='0.5'
                                                     begin='0s' dur='0.8s'
                                                     values='.5;1;.5' calcMode='linear'
                                                     repeatCount='indefinite'/>
                                        </circle>
                                    </svg>
                                </template>
                            </button>

                            <div class="listivo-hero-search-v8__mobile-button">
                                <button
                                        @click.prevent="props.onSearch"
                                        class="listivo-button listivo-button--height-60 listivo-button--primary-1"
                                        :class="{'listivo-button--loading': props.inProgress}"
                                >
                                    <span>
                                        <?php echo esc_html(tdf_string('search')); ?>

                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                             viewBox="0 0 12 12" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M0 4.82944C0 2.1701 2.1701 0 4.82944 0C7.48877 0 9.65888 2.1701 9.65888 4.82944C9.65888 5.91961 9.29018 6.92405 8.6766 7.734L11.7952 10.8532C11.9692 11.0203 12.0393 11.2684 11.9784 11.5018C11.9176 11.7353 11.7353 11.9176 11.5018 11.9784C11.2684 12.0393 11.0203 11.9692 10.8532 11.7952L7.734 8.6766C6.92406 9.29018 5.91961 9.65888 4.82944 9.65888C2.1701 9.65888 0 7.48877 0 4.82944ZM8.32639 4.82944C8.32639 2.89011 6.76854 1.33226 4.82921 1.33226C2.88988 1.33226 1.33203 2.89011 1.33203 4.82944C1.33203 6.76877 2.88988 8.32662 4.82921 8.32662C5.76103 8.32662 6.60248 7.96438 7.22767 7.37556C7.26911 7.31832 7.31939 7.26803 7.37664 7.22659C7.9647 6.60154 8.32639 5.76059 8.32639 4.82944Z"
                                                  fill="#FDFDFE"/>
                                        </svg>
                                    </span>

                                    <template>
                                        <svg
                                                width='40'
                                                height='10'
                                                viewBox='0 0 120 30'
                                                xmlns='http://www.w3.org/2000/svg'
                                                fill='#fff'
                                                class="listivo-button__loading"
                                        >
                                            <circle cx='15' cy='15' r='15'>
                                                <animate attributeName='r' from='15' to='15' begin='0s'
                                                         dur='0.8s' values='15;9;15'
                                                         calcMode='linear' repeatCount='indefinite'/>
                                                <animate attributeName='fill-opacity' from='1' to='1'
                                                         begin='0s' dur='0.8s'
                                                         values='1;.5;1'
                                                         calcMode='linear' repeatCount='indefinite'/>
                                            </circle>

                                            <circle cx='60' cy='15' r='9' fill-opacity='0.3'>
                                                <animate attributeName='r' from='9' to='9' begin='0s'
                                                         dur='0.8s' values='9;15;9'
                                                         calcMode='linear' repeatCount='indefinite'/>
                                                <animate attributeName='fill-opacity' from='0.5' to='0.5'
                                                         begin='0s' dur='0.8s'
                                                         values='.5;1;.5' calcMode='linear'
                                                         repeatCount='indefinite'/>
                                            </circle>

                                            <circle cx='105' cy='15' r='15'>
                                                <animate attributeName='r' from='15' to='15' begin='0s'
                                                         dur='0.8s' values='15;9;15'
                                                         calcMode='linear' repeatCount='indefinite'/>
                                                <animate attributeName='fill-opacity' from='1' to='1'
                                                         begin='0s' dur='0.8s'
                                                         values='1;.5;1'
                                                         calcMode='linear' repeatCount='indefinite'/>
                                            </circle>
                                        </svg>
                                    </template>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </lst-search-form>

            <?php
            $lstPopularTerms = $lstCurrentWidget->getPopularTerms();
            if ($lstPopularTerms->isNotEmpty()) : ?>
                <div class="listivo-hero-search-v8__popular-terms">
                    <?php echo esc_html($lstCurrentWidget->getPopularTermsLabel()); ?>

                    <?php foreach ($lstCurrentWidget->getPopularTerms() as $lstIndex => $lstTerm) : ?>
                        <a
                                class="listivo-hero-search-v8__popular-term"
                                href="<?php echo esc_url($lstTerm->getUrl()); ?>"
                        >
                            <?php echo esc_html($lstTerm->getName()); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
