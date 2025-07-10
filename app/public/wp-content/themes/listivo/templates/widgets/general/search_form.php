<?php
/* @var \Tangibledesign\Listivo\Widgets\General\SearchFormWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstSearchFields = $lstCurrentWidget->getFields();
$lstSelectedDependencyTerms = tdf_collect();
?>
<div class="listivo-app">
    <lst-search-form
            base-url="<?php echo esc_url(get_post_type_archive_link(tdf_model_post_type())); ?>"
            request-url="<?php echo esc_url(get_rest_url() . 'listivo/v1/listings'); ?>"
            :dependency-terms="<?php echo htmlspecialchars(json_encode(tdf_app('dependency_terms'))); ?>"
            :initial-term-count="<?php echo htmlspecialchars(json_encode($lstCurrentWidget->getTermCount())); ?>"
            initial-sort-by="<?php echo esc_attr(tdf_slug('newest')); ?>"
            field-selector=".listivo-search-form-field"
    >
        <div
                slot-scope="props"
                class="listivo-search listivo-search--<?php echo esc_attr($lstCurrentWidget->getAlignModifier()); ?>"
        >
            <div class="listivo-search__inner">
                <div class="listivo-search__fields">
                    <?php
                    global $lstSearchField;
                    foreach ($lstSearchFields as $lstSearchField) :
                        if ($lstSearchField->displayAtStart($lstSelectedDependencyTerms)) :
                            get_template_part('templates/widgets/general/search/fields/' . $lstSearchField->getType());
                        else :?>
                            <template>
                                <?php get_template_part('templates/widgets/general/search/fields/' . $lstSearchField->getType()); ?>
                            </template>
                        <?php
                        endif;
                    endforeach;
                    ?>
                </div>

                <div class="listivo-search__search-button">
                    <button
                            class="listivo-button listivo-button--primary-1"
                            :class="{'listivo-button--loading': props.inProgress}"
                            @click.prevent="props.onSearch"
                            :disabled="props.inProgress"
                    >
                        <span>
                            <?php echo esc_html(tdf_string('search')); ?>

                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"
                                 fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M0 7.24416C0 3.25516 3.25515 0 7.24416 0C11.2332 0 14.4883 3.25516 14.4883 7.24416C14.4883 8.87942 13.9353 10.3861 13.0149 11.601L17.6928 16.2798C17.9538 16.5305 18.0589 16.9026 17.9677 17.2528C17.8764 17.6029 17.6029 17.8764 17.2528 17.9677C16.9026 18.0589 16.5305 17.9538 16.2798 17.6928L11.601 13.0149C10.3861 13.9353 8.87942 14.4883 7.24416 14.4883C3.25515 14.4883 0 11.2332 0 7.24416ZM12.4899 7.24416C12.4899 4.33516 10.1532 1.99839 7.24416 1.99839C4.33516 1.99839 1.99839 4.33516 1.99839 7.24416C1.99839 10.1532 4.33516 12.4899 7.24416 12.4899C8.64188 12.4899 9.90406 11.9466 10.8418 11.0633C10.904 10.9775 10.9794 10.9021 11.0653 10.8399C11.9474 9.90231 12.4899 8.64089 12.4899 7.24416Z"
                                      fill="#FDFDFE"></path>
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