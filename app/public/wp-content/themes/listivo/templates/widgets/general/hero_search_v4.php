<?php
/* @var \Tangibledesign\Listivo\Widgets\General\HeroSearchV4Widget $lstCurrentWidget */
global $lstCurrentWidget;

$lstMainFieldTaxonomy = $lstCurrentWidget->getMainFieldTaxonomy();
$lstFields = $lstCurrentWidget->getFields();
$lstColumns = $lstFields->count() > 3 ? 3 : $lstFields->count();
$lstTermsData = $lstCurrentWidget->getMainFieldTermsData();
$lstMainFieldTerms = $lstCurrentWidget->getMainFieldTerms($lstTermsData);
?>
<div class="listivo-hero-search-v4">
    <div class="listivo-hero-search-v4__container-wrapper">
        <div class="listivo-hero-search-v4__container">
            <div class="listivo-hero-search-v4__mobile-mask"></div>

            <?php if (!empty($lstCurrentWidget->getMainImage())) : ?>
                <div class="listivo-hero-search-v4__main-image-wrapper">
                    <div class="listivo-hero-search-v4__main-image">
                        <img
                                src="<?php echo esc_url($lstCurrentWidget->getMainImage()); ?>"
                                alt=""
                        >
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($lstCurrentWidget->getTopImage())) : ?>
                <div class="listivo-hero-search-v4__top-image-wrapper">
                    <div class="listivo-hero-search-v4__top-image">
                        <img
                                src="<?php echo esc_url($lstCurrentWidget->getTopImage()); ?>"
                                alt=""
                        >
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($lstCurrentWidget->getBottomImage())) : ?>
                <div class="listivo-hero-search-v4__bottom-image-wrapper">
                    <div class="listivo-hero-search-v4__bottom-image">
                        <img
                                src="<?php echo esc_url($lstCurrentWidget->getBottomImage()); ?>"
                                alt=""
                        >
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!$lstCurrentWidget->hideDecorations()) : ?>
                <div class="listivo-hero-search-v4__line">
                    <svg xmlns="http://www.w3.org/2000/svg" width="797" height="881" viewBox="0 0 797 881" fill="none">
                        <line x1="1.93934" y1="879.456" x2="917.456" y2="-36.0607" stroke="#E6F0FA" stroke-width="3"
                              stroke-dasharray="8 8"/>
                    </svg>
                </div>

                <div class="listivo-hero-search-v4__x">
                    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 45 45" fill="none">
                        <path d="M13.7572 35.3433L9.63333 31.2195L31.2199 9.63291L35.3437 13.7568L13.7572 35.3433ZM9.0733 13.2476L13.299 9.02197L35.9547 31.6777L31.729 35.9033L9.0733 13.2476Z"
                              fill="#E6F0FA"/>
                    </svg>
                </div>

                <div class="listivo-hero-search-v4__plus">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="33" viewBox="0 0 32 33" fill="none">
                        <path d="M0.736282 19.832V14H31.2643V19.832H0.736282ZM13.0483 0.895997H19.0243V32.936H13.0483V0.895997Z"
                              fill="#E6F0FA"/>
                    </svg>
                </div>

                <div class="listivo-hero-search-v4__circle"></div>
            <?php endif; ?>
        </div>
    </div>

    <div class="listivo-hero-search-v4__content">
        <div class="listivo-container">
            <?php if (!empty($lstCurrentWidget->getHeading())) : ?>
                <div class="listivo-hero-search-v4__heading">
                    <h1>
                        <?php echo nl2br(wp_kses_post($lstCurrentWidget->getHeading())); ?>
                    </h1>

                    <?php if (!$lstCurrentWidget->hideArrow()) : ?>
                        <div class="listivo-hero-search-v4__arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="44" height="140" viewBox="0 0 44 140"
                                 fill="none">
                                <path d="M1 2C9.31819 8.79881 19.2533 14.2514 25.9546 22.3964C55.4519 58.2489 41.6204 105.491 6.0824 133.467"
                                      stroke="#EFA470" stroke-width="3" stroke-dasharray="8"/>
                                <path d="M3.50389 119.867C3.29393 142.458 -4.60351 138.256 18 136.534" stroke="#EFA470"
                                      stroke-width="3"/>
                            </svg>
                        </div>
                    <?php endif; ?>

                    <?php if (!$lstCurrentWidget->hideDecorations()) : ?>
                        <div class="listivo-hero-search-v4__circle listivo-hero-search-v4__circle--bottom"></div>

                        <div class="listivo-hero-search-v4__plus listivo-hero-search-v4__plus--left">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="33" viewBox="0 0 32 33"
                                 fill="none">
                                <path d="M0.736282 19.832V14H31.2643V19.832H0.736282ZM13.0483 0.895997H19.0243V32.936H13.0483V0.895997Z"
                                      fill="#E6F0FA"/>
                            </svg>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="listivo-app listivo-hero-search-v4__form">
                <lst-search-form
                        base-url="<?php echo esc_url(get_post_type_archive_link(tdf_model_post_type())); ?>"
                        request-url="<?php echo esc_url(get_rest_url().'listivo/v1/listings'); ?>"
                        :dependency-terms="<?php echo htmlspecialchars(json_encode(tdf_app('dependency_terms'))); ?>"
                        :initial-term-count="<?php echo htmlspecialchars(json_encode($lstCurrentWidget->getTermCount())); ?>"
                        initial-sort-by="<?php echo esc_attr(tdf_slug('newest')); ?>"
                        field-selector=".listivo-search-form-field"
                    <?php if (!$lstCurrentWidget->hasMainFieldAllOption() && $lstMainFieldTerms->isNotEmpty()) : ?>
                        :initial-filters="<?php echo htmlspecialchars(json_encode($lstCurrentWidget->getInitialFilters($lstMainFieldTerms->first()))); ?>"
                    <?php endif; ?>
                >
                    <div slot-scope="props" class="listivo-search-form-v2">
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
                                    <?php get_template_part('templates/partials/search/v2/'.$lstSearchField->getType()); ?>
                                <?php endforeach; ?>
                            </div>

                            <button
                                    @click.prevent="props.onSearch"
                                    class="listivo-search-form-v2__button"
                                    :class="{'listivo-search-form-v2__button--loading': props.inProgress}"
                                    :disabled="props.inProgress"
                            >
                                <span v-if="!props.inProgress">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"
                                         fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M0 7.24416C0 3.25516 3.25515 0 7.24416 0C11.2332 0 14.4883 3.25516 14.4883 7.24416C14.4883 8.87942 13.9353 10.3861 13.0149 11.601L17.6928 16.2798C17.9538 16.5305 18.0589 16.9026 17.9677 17.2528C17.8764 17.6029 17.6029 17.8764 17.2528 17.9677C16.9026 18.0589 16.5305 17.9538 16.2798 17.6928L11.601 13.0149C10.3861 13.9353 8.87942 14.4883 7.24416 14.4883C3.25515 14.4883 0 11.2332 0 7.24416ZM12.4899 7.24416C12.4899 4.33516 10.1532 1.99839 7.24416 1.99839C4.33516 1.99839 1.99839 4.33516 1.99839 7.24416C1.99839 10.1532 4.33516 12.4899 7.24416 12.4899C8.64188 12.4899 9.90406 11.9466 10.8418 11.0633C10.904 10.9775 10.9794 10.9021 11.0653 10.8399C11.9474 9.90231 12.4899 8.64089 12.4899 7.24416Z"
                                              fill="#FDFDFE"/>
                                    </svg>
                                </span>

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

                            <div class="listivo-search-form-v2__mobile-button">
                                <button
                                        @click.prevent="props.onSearch"
                                        class="listivo-button listivo-button--primary-1"
                                        :class="{'listivo-button--loading': props.inProgress}"
                                        :disabled="props.inProgress"
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
                </lst-search-form>
            </div>

            <div class="listivo-hero-search-v4__popular-terms">
                <span><?php echo esc_html($lstCurrentWidget->getLabel()); ?></span>

                <?php foreach ($lstCurrentWidget->getPopularTerms() as $lstIndex => $lstTerm) : ?>
                    <a href="<?php echo esc_url($lstTerm->getUrl()); ?>" class="listivo-hero-search-v4__popular-term">
                        <?php echo esc_html($lstTerm->getName()); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>