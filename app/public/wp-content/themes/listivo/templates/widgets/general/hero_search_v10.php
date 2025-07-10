<?php

use Tangibledesign\Framework\Models\Term\CustomTerm;
use Tangibledesign\Listivo\Widgets\General\HeroSearchV10Widget;

/* @var HeroSearchV10Widget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-hero-search-v10 listivo-app">
    <div class="listivo-hero-search-v10__background">
        <?php if (!empty($lstCurrentWidget->getBackgroundImage())) : ?>
            <img
                    src="<?php echo esc_url($lstCurrentWidget->getBackgroundImage()); ?>"
                    alt="<?php echo esc_attr($lstCurrentWidget->getHeading()); ?>"
            >
        <?php endif; ?>
    </div>

    <div class="listivo-hero-search-v10__container">
        <div class="listivo-hero-search-v10__content">
            <div class="listivo-hero-search-v10__left">
                <h1 class="listivo-hero-search-v10__heading">
                    <?php echo nl2br(wp_kses_post($lstCurrentWidget->getHeading())); ?>
                </h1>

                <div class="listivo-hero-search-v10__text">
                    <?php echo nl2br(wp_kses_post($lstCurrentWidget->getText())); ?>
                </div>

                <div class="listivo-hero-search-v10__terms-container">
                    <div class="listivo-hero-search-v10__terms">
                        <?php if ($lstCurrentWidget->showArrow()) : ?>
                            <div class="listivo-hero-search-v10__arrow">
                                <svg xmlns="http://www.w3.org/2000/svg" width="165" height="132" viewBox="0 0 165 132"
                                     fill="none">
                                    <path d="M2.34023 75.9972C8.21078 91.5275 30.6305 105.065 43.8518 106.15C102.049 110.93 125.108 73.862 136.864 20.142"
                                          stroke="#FF9540" stroke-width="3" stroke-dasharray="8"/>
                                    <path d="M119.737 26.7773C145.605 11.3468 136.232 6.43047 147.243 29.7675"
                                          stroke="#FF9540"
                                          stroke-width="3"/>
                                </svg>
                            </div>
                        <?php endif; ?>

                        <?php foreach ($lstCurrentWidget->getTerms() as $lstItem) :
                            /* @var CustomTerm $lstTerm */
                            $lstTerm = $lstItem['term'];
                            ?>
                            <a
                                    class="listivo-hero-search-v10__term"
                                    href="<?php echo esc_url($lstTerm->getUrl()); ?>"
                            >
                                <div class="listivo-hero-search-v10__term-image">
                                    <?php if (!empty($lstItem['image']['url'])) : ?>
                                        <img
                                                src="<?php echo esc_url($lstItem['image']['url']); ?>"
                                                alt="<?php echo esc_attr($lstTerm->getName()); ?>"
                                        >
                                    <?php endif; ?>
                                </div>

                                <div class="listivo-hero-search-v10__term-label">
                                    <?php echo esc_html($lstTerm->getName()); ?>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <lst-search-form
                    base-url="<?php echo esc_url(get_post_type_archive_link(tdf_model_post_type())); ?>"
                    request-url="<?php echo esc_url(get_rest_url() . 'listivo/v1/listings'); ?>"
                    :dependency-terms="<?php echo htmlspecialchars(json_encode(tdf_app('dependency_terms'))); ?>"
                    :initial-term-count="<?php echo htmlspecialchars(json_encode($lstCurrentWidget->getTermCount())); ?>"
                    initial-sort-by="<?php echo esc_attr(tdf_slug('newest')); ?>"
                    field-selector=".listivo-search-form-field"
                    class="listivo-hero-search-v10__form"
            >
                <div slot-scope="props">
                    <div class="listivo-search-form-v3">
                        <div class="listivo-search-form-v3__label">
                            <?php echo esc_html($lstCurrentWidget->getFormLabel()); ?>
                        </div>

                        <div class="listivo-search-form-v3__fields">
                            <?php
                            global $lstSearchField;
                            foreach ($lstCurrentWidget->getFields() as $lstSearchField) : ?>
                                <?php get_template_part('templates/partials/search/v2/' . $lstSearchField->getType()); ?>
                            <?php endforeach; ?>
                        </div>

                        <button
                                class="listivo-search-form-v3__button listivo-button-primary-1-selector"
                                :class="{'listivo-search-form-v3__button--loading': props.inProgress}"
                                @click="props.onSearch"
                        >
                            <span>
                                <?php echo esc_html(tdf_string('search')); ?>
                            </span>

                            <template>
                                <svg
                                        width='40'
                                        height='10'
                                        viewBox='0 0 120 30'
                                        xmlns='http://www.w3.org/2000/svg'
                                        fill='#fff'
                                >
                                    <circle cx='15' cy='15' r='15'>
                                        <animate attributeName='r' from='15' to='15' begin='0s' dur='0.8s'
                                                 values='15;9;15'
                                                 calcMode='linear' repeatCount='indefinite'/>
                                        <animate attributeName='fill-opacity' from='1' to='1' begin='0s' dur='0.8s'
                                                 values='1;.5;1'
                                                 calcMode='linear' repeatCount='indefinite'/>
                                    </circle>

                                    <circle cx='60' cy='15' r='9' fill-opacity='0.3'>
                                        <animate attributeName='r' from='9' to='9' begin='0s' dur='0.8s' values='9;15;9'
                                                 calcMode='linear' repeatCount='indefinite'/>
                                        <animate attributeName='fill-opacity' from='0.5' to='0.5' begin='0s' dur='0.8s'
                                                 values='.5;1;.5' calcMode='linear' repeatCount='indefinite'/>
                                    </circle>

                                    <circle cx='105' cy='15' r='15'>
                                        <animate attributeName='r' from='15' to='15' begin='0s' dur='0.8s'
                                                 values='15;9;15'
                                                 calcMode='linear' repeatCount='indefinite'/>
                                        <animate attributeName='fill-opacity' from='1' to='1' begin='0s' dur='0.8s'
                                                 values='1;.5;1'
                                                 calcMode='linear' repeatCount='indefinite'/>
                                    </circle>
                                </svg>
                            </template>
                        </button>
                    </div>
                </div>
            </lst-search-form>
        </div>
    </div>
</div>