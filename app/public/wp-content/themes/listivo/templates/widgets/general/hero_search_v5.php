<?php


use Tangibledesign\Listivo\Widgets\General\HeroSearchV5Widget;

/* @var HeroSearchV5Widget $lstCurrentWidget */
global $lstCurrentWidget;

$lstFields = $lstCurrentWidget->getFields();
$lstColumns = $lstFields->count() > 3 ? 3 : $lstFields->count();
$lstTerms = $lstCurrentWidget->getTerms();
?>
<div class="listivo-hero-search-v5 listivo-app">
    <?php if (!empty($lstCurrentWidget->getBackgroundImage())) : ?>
        <div class="listivo-hero-search-v5__background">
            <img
                    src="<?php echo esc_url($lstCurrentWidget->getBackgroundImage()); ?>"
                    alt="<?php echo esc_attr($lstCurrentWidget->getHeading()); ?>"
            >
        </div>

        <div class="listivo-hero-search-v5__mask"></div>
    <?php endif; ?>

    <div class="listivo-hero-search-v5__content">
        <h1 class="listivo-hero-search-v5__heading">
            <?php echo wp_kses_post(nl2br($lstCurrentWidget->getHeading())); ?>

            <div class="listivo-hero-search-v5__arrow">
                <svg xmlns="http://www.w3.org/2000/svg" width="94" height="139" viewBox="0 0 94 139" fill="none">
                    <path d="M40.2109 2.30869C54.577 4.78222 70.385 21.1124 73.8221 31.7799C88.9516 78.7358 61.7016 103.2 18.0968 120.909"
                          stroke="#F09965" stroke-width="3" stroke-dasharray="8"/>
                    <path d="M20.5061 105.881C12.252 129.392 6.27717 122.453 28.2806 127.964" stroke="#F09965"
                          stroke-width="3"/>
                </svg>
            </div>
        </h1>

        <div class="listivo-hero-search-v5__form">
            <lst-search-form
                    base-url="<?php echo esc_url(get_post_type_archive_link(tdf_model_post_type())); ?>"
                    request-url="<?php echo esc_url(get_rest_url() . 'listivo/v1/listings'); ?>"
                    :dependency-terms="<?php echo htmlspecialchars(json_encode(tdf_app('dependency_terms'))); ?>"
                    :initial-term-count="<?php echo htmlspecialchars(json_encode($lstCurrentWidget->getTermCount())); ?>"
                    initial-sort-by="<?php echo esc_attr(tdf_slug('newest')); ?>"
                    field-selector=".listivo-search-form-field"
            >
                <div slot-scope="props" class="listivo-search-form-v2 listivo-search-form-v2--regular">
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

                        <button
                                @click.prevent="props.onSearch"
                                class="listivo-search-form-v2__button"
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

        <?php if ($lstTerms->isNotEmpty()) : ?>
            <div class="listivo-hero-search-v5__terms">
                <div class="listivo-terms-v2">
                    <?php foreach ($lstTerms as $lstTerm) : ?>
                        <a
                                class="listivo-terms-v2__term"
                                href="<?php echo esc_url($lstTerm['url']); ?>"
                        >
                            <div class="listivo-terms-v2__icon">
                                <?php if (!empty($lstTerm['image'])): ?>
                                    <img
                                            src="<?php echo esc_url($lstTerm['image']); ?>"
                                            alt="<?php echo esc_attr($lstTerm['label']); ?>"
                                    >
                                <?php endif; ?>
                            </div>

                            <?php echo esc_html($lstTerm['label']); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
