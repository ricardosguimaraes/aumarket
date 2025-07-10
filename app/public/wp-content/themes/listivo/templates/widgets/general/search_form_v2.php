<?php

use Tangibledesign\Listivo\Widgets\General\SearchFormV2Widget;

/* @var SearchFormV2Widget $lstCurrentWidget */
global $lstCurrentWidget;

$lstFields = $lstCurrentWidget->getFields();
$lstMainFieldTaxonomy = $lstCurrentWidget->getMainFieldTaxonomy();
$lstColumns = $lstFields->count() > 3 ? 3 : $lstFields->count();
$lstTermsData = $lstCurrentWidget->getMainFieldTermsData();
$lstMainFieldTerms = $lstCurrentWidget->getMainFieldTerms($lstTermsData);

if ($lstMainFieldTerms->isNotEmpty()) {
    $lstInitialFilters = $lstCurrentWidget->getInitialFilters($lstMainFieldTerms->first());
} else {
    $lstInitialFilters = null;
}
?>
<div class="listivo-app listivo-search-form-v2--wrapper">
    <lst-search-form
            base-url="<?php echo esc_url(get_post_type_archive_link(tdf_model_post_type())); ?>"
            request-url="<?php echo esc_url(get_rest_url() . 'listivo/v1/listings'); ?>"
            :dependency-terms="<?php echo htmlspecialchars(json_encode(tdf_app('dependency_terms'))); ?>"
            :initial-term-count="<?php echo htmlspecialchars(json_encode($lstCurrentWidget->getTermCount())); ?>"
            initial-sort-by="<?php echo esc_attr(tdf_slug('newest')); ?>"
            field-selector=".listivo-search-form-field"
        <?php if ($lstInitialFilters) : ?>
            :initial-filters="<?php echo htmlspecialchars(json_encode($lstInitialFilters)); ?>"
        <?php endif; ?>
    >
        <div
                slot-scope="props"
            <?php if ($lstMainFieldTerms->isNotEmpty()) : ?>
                class="listivo-search-form-v2 listivo-search-form-v2--inline-flex"
            <?php else : ?>
                class="listivo-search-form-v2 listivo-search-form-v2--inline-flex listivo-search-form-v2--no-tabs"
            <?php endif; ?>
        >
            <?php if ($lstMainFieldTaxonomy && $lstMainFieldTerms->isNotEmpty()) : ?>
                <lst-taxonomy-search-field
                        :field="<?php echo htmlspecialchars(json_encode($lstMainFieldTaxonomy->getSearchField([]))); ?>"
                        :initial-terms="<?php echo htmlspecialchars(json_encode($lstMainFieldTerms)); ?>"
                        :disable-fetch-terms="true"
                        :filters="props.filters"
                        :dependencies="props.dependencies"
                        :term-count="props.termCount"
                        :multiple="false"
                        :on-change-clear-other-taxonomies="true"
                >
                    <div class="listivo-search-form-v2__tabs-wrapper" slot-scope="taxonomyField">
                        <div class="listivo-search-form-v2__tabs">
                            <?php if ($lstCurrentWidget->hasMainFieldAllOption()) : ?>
                                <div
                                        @click.prevent="taxonomyField.clear"
                                        class="listivo-search-form-v2__tab"
                                        :class="{'listivo-search-form-v2__tab--active': taxonomyField.values.length === 0}"
                                >
                                    <?php echo esc_html(tdf_string('all')); ?>
                                </div>
                            <?php endif; ?>

                            <?php foreach ($lstMainFieldTerms as $lstTerm) : ?>
                                <div
                                        @click.prevent="taxonomyField.setTerm(<?php echo esc_attr($lstTerm->getId()); ?>)"
                                        class="listivo-search-form-v2__tab"
                                        :class="{'listivo-search-form-v2__tab--active': taxonomyField.selectedTermIds.indexOf(<?php echo esc_attr($lstTerm->getId()); ?>) !== -1}"
                                >
                                    <?php echo esc_html($lstTerm->getName()); ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </lst-taxonomy-search-field>
            <?php endif; ?>

            <div class="listivo-search-form-v2__inner">
                <div
                        class="listivo-search-form-v2__fields listivo-search-form-v2__fields--initial-<?php echo esc_attr($lstColumns); ?>"
                        :class="'listivo-search-form-v2__fields--' + props.fieldsNumber"
                >
                    <?php
                    global $lstSearchField;
                    foreach ($lstFields as $lstSearchField) : ?>
                        <?php get_template_part('templates/partials/search/v2/' . $lstSearchField->getType()); ?>
                    <?php endforeach; ?>
                </div>

                <?php if ($lstCurrentWidget->isButtonIconStyle()) : ?>
                    <button
                            @click.prevent="props.onSearch"
                        <?php if ($lstCurrentWidget->isPrimary1ButtonType()) : ?>
                            class="listivo-search-form-v2__button listivo-button-primary-1-colors-selector"
                        <?php else : ?>
                            class="listivo-search-form-v2__button listivo-button-primary-2-colors-selector"
                        <?php endif; ?>
                    >
                        <svg v-if="!props.inProgress" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                             viewBox="0 0 18 18"
                             fill="none">
                            <path
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
                <?php else : ?>
                    <button
                            @click.prevent="props.onSearch"
                        <?php if ($lstCurrentWidget->isPrimary1ButtonType()) : ?>
                            class="listivo-search-form-v2__text-button listivo-button listivo-button--height-60 listivo-button--primary-1"
                        <?php else : ?>
                            class="listivo-search-form-v2__text-button listivo-button listivo-button--height-60 listivo-button--primary-2"
                        <?php endif; ?>
                            :class="{'listivo-button--loading': props.inProgress}"
                    >
                        <span>
                            <?php echo esc_html($lstCurrentWidget->getButtonText()); ?>

                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14"
                                 fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M0 5.63434C0 2.53179 2.53179 0 5.63434 0C8.7369 0 11.2687 2.53179 11.2687 5.63434C11.2687 6.90621 10.8385 8.07806 10.1227 9.023L13.761 12.6621C13.9641 12.857 14.0458 13.1465 13.9748 13.4188C13.9038 13.6912 13.6912 13.9038 13.4188 13.9748C13.1465 14.0458 12.857 13.9641 12.6621 13.761L9.023 10.1227C8.07806 10.8385 6.90621 11.2687 5.63434 11.2687C2.53179 11.2687 0 8.7369 0 5.63434ZM9.71428 5.63436C9.71428 3.37181 7.89679 1.55432 5.63424 1.55432C3.37169 1.55432 1.5542 3.37181 1.5542 5.63436C1.5542 7.89691 3.37169 9.71441 5.63424 9.71441C6.72136 9.71441 7.70306 9.29179 8.43244 8.60484C8.48079 8.53806 8.53945 8.47939 8.60624 8.43104C9.29232 7.70182 9.71428 6.72071 9.71428 5.63436Z"
                                      fill="#FFFEFE"/>
                            </svg>
                        </span>

                        <div class="listivo-button__loading">
                            <svg width="40" height="10" viewBox="0 0 120 30" xmlns="http://www.w3.org/2000/svg"
                                 fill="#fff">
                                <circle cx="15" cy="15" r="15">
                                    <animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s"
                                             values="15;9;15" calcMode="linear"
                                             repeatCount="indefinite"></animate>
                                    <animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s"
                                             values="1;.5;1" calcMode="linear"
                                             repeatCount="indefinite"></animate>
                                </circle>
                                <circle cx="60" cy="15" r="9" fill-opacity="0.3">
                                    <animate attributeName="r" from="9" to="9" begin="0s" dur="0.8s"
                                             values="9;15;9"
                                             calcMode="linear" repeatCount="indefinite"></animate>
                                    <animate attributeName="fill-opacity" from="0.5" to="0.5" begin="0s"
                                             dur="0.8s"
                                             values=".5;1;.5" calcMode="linear"
                                             repeatCount="indefinite"></animate>
                                </circle>
                                <circle cx="105" cy="15" r="15">
                                    <animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s"
                                             values="15;9;15" calcMode="linear"
                                             repeatCount="indefinite"></animate>
                                    <animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s"
                                             values="1;.5;1" calcMode="linear"
                                             repeatCount="indefinite"></animate>
                                </circle>
                            </svg>
                        </div>
                    </button>
                <?php endif; ?>

                <div class="listivo-search-form-v2__mobile-button">
                    <button
                            @click.prevent="props.onSearch"
                        <?php if ($lstCurrentWidget->isPrimary1ButtonType()) : ?>
                            class="listivo-button listivo-button--primary-1"
                        <?php else : ?>
                            class="listivo-button listivo-button--primary-2"
                        <?php endif; ?>
                            :class="{'listivo-button--loading': props.inProgress}"
                    >
                        <span>
                            <?php echo esc_html($lstCurrentWidget->getButtonText()); ?>

                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                 viewBox="0 0 12 12" fill="none">
                                <path
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
    </lst-search-form>
</div>
