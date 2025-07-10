<?php

use Tangibledesign\Framework\Search\SearchField;
use Tangibledesign\Listivo\Widgets\General\Search\SearchMapWidget;
use Tangibledesign\Listivo\Widgets\General\Search\SearchWidget;

/* @var SearchWidget $lstCurrentWidget */
global $lstCurrentWidget, $lstSelectedDependencyTerms;
$lstPrimaryFields = $lstCurrentWidget->getPrimaryFields();
$lstSecondaryFields = $lstCurrentWidget->getSecondaryFields();
$lstSecondaryFieldsKeys = $lstSecondaryFields->map(static function ($lstSecondaryField) {
    /* @var SearchField $lstSecondaryField */
    return $lstSecondaryField->getKey();
})->values();
?>
<div
    <?php if ($lstCurrentWidget instanceof SearchMapWidget) : ?>
        class="listivo-main-search-form listivo-main-search-form--map"
    <?php else : ?>
        class="listivo-main-search-form"
    <?php endif; ?>
>
    <div class="listivo-container">
        <template>
            <div
                    v-show="props.showMobileFilters"
                    class="listivo-mobile-search-form"
            >
                <div class="listivo-container">
                    <div class="listivo-mobile-search-form__inner">
                        <div class="listivo-mobile-search-form__top">
                            <div
                                    class="listivo-mobile-search-form__close"
                                    @click.prevent="props.onShowMobileFilters"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 11 11"
                                     fill="none">
                                    <path d="M1.61169 0.500482C1.39146 0.500755 1.1763 0.566706 0.993713 0.68991C0.811124 0.813114 0.66939 0.987978 0.586617 1.19216C0.503843 1.39635 0.483789 1.62059 0.529015 1.83623C0.574241 2.05188 0.682695 2.24914 0.840521 2.40281L3.93386 5.49762L0.840521 8.59243C0.734227 8.69453 0.649364 8.81683 0.590902 8.95216C0.532441 9.08748 0.501556 9.23312 0.500057 9.38054C0.498558 9.52796 0.526475 9.67419 0.582173 9.81068C0.63787 9.94717 0.720229 10.0712 0.824425 10.1754C0.928621 10.2797 1.05256 10.3621 1.18898 10.4178C1.32541 10.4735 1.47158 10.5014 1.61892 10.4999C1.76627 10.4984 1.91184 10.4675 2.0471 10.409C2.18237 10.3506 2.3046 10.2657 2.40666 10.1593L5.5 7.0645L8.59334 10.1593C8.69539 10.2657 8.81763 10.3506 8.95289 10.4091C9.08815 10.4675 9.23372 10.4984 9.38107 10.4999C9.52842 10.5014 9.67459 10.4735 9.81101 10.4178C9.94744 10.3621 10.0714 10.2797 10.1756 10.1754C10.2798 10.0712 10.3621 9.94718 10.4178 9.81069C10.4735 9.6742 10.5014 9.52796 10.4999 9.38054C10.4984 9.23312 10.4676 9.08748 10.4091 8.95216C10.3506 8.81683 10.2658 8.69453 10.1595 8.59243L7.06613 5.49762L10.1595 2.40281C10.3195 2.24717 10.4288 2.04679 10.4731 1.82792C10.5173 1.60906 10.4945 1.38192 10.4075 1.17628C10.3205 0.970635 10.1734 0.796081 9.9856 0.675491C9.79775 0.5549 9.57787 0.493899 9.35477 0.500482C9.06703 0.509059 8.79393 0.629373 8.59334 0.835933L5.5 3.93074L2.40666 0.835933C2.30332 0.729655 2.17971 0.645206 2.04316 0.587585C1.90661 0.529965 1.75989 0.500346 1.61169 0.500482Z"
                                          fill="#FDFDFE"/>
                                </svg>
                            </div>
                        </div>

                        <div class="listivo-mobile-search-form__fields">
                            <?php
                            global $lstSearchField;
                            foreach ($lstPrimaryFields as $lstSearchField) :
                                get_template_part('templates/partials/search/v2/' . $lstSearchField->getType());
                            endforeach;

                            foreach ($lstSecondaryFields as $lstSearchField) :
                                get_template_part('templates/partials/search/v2/' . $lstSearchField->getType());
                            endforeach;
                            ?>
                        </div>

                        <div class="listivo-mobile-search-form__buttons">
                            <button
                                    class="listivo-mobile-search-form__button listivo-mobile-search-form__button--color-2"
                                    @click.prevent="props.onClear();props.onShowMobileFilters();"
                            >
                                <?php echo esc_html(tdf_string('clear')); ?>
                            </button>

                            <button
                                    class="listivo-mobile-search-form__button listivo-mobile-search-form__button--color-1"
                                    @click.prevent="props.onShowMobileFilters"
                            >
                                <?php echo esc_html(tdf_string('apply')); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <div class="listivo-main-search-form__filters">
            <div
                    @click.prevent="props.onShowMobileFilters"
                    class="listivo-toggle"
            >
                <div class="listivo-toggle__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16" fill="none">
                        <path d="M0 0V1.49148L0.139205 1.67045L5.09091 7.85511V15.2727L6.10511 14.517L8.65057 12.608L8.90909 12.4091V7.85511L13.8608 1.67045L14 1.49148V0H0ZM1.4517 1.27273H12.5483L7.97443 7H6.02557L1.4517 1.27273ZM6.36364 8.27273H7.63636V11.7727L6.36364 12.7273V8.27273Z"
                              fill="#FDFDFE"/>
                    </svg>
                </div>

                <div class="listivo-toggle__label">
                    <?php echo esc_html(tdf_string('filters')); ?>
                </div>

                <div class="listivo-toggle__circle">
                    <svg v-if="props.filtersCount === 0" xmlns="http://www.w3.org/2000/svg" width="7" height="5"
                         viewBox="0 0 7 5" fill="none">
                        <path d="M3.5 2.56775L5.87477 0.192978C6.13207 -0.0643244 6.54972 -0.0643244 6.80702 0.192978C7.06433 0.450281 7.06433 0.867931 6.80702 1.12523L3.9394 3.99285C3.6964 4.23586 3.30298 4.23586 3.0606 3.99285L0.192977 1.12523C-0.0643257 0.867931 -0.0643257 0.450281 0.192977 0.192978C0.45028 -0.0643244 0.86793 -0.0643244 1.12523 0.192978L3.5 2.56775Z"
                              fill="#2A3946"/>
                    </svg>

                    <template v-if="props.filtersCount > 0">
                        {{ props.filtersCount }}
                    </template>
                </div>
            </div>
        </div>
    </div>

    <?php if ($lstPrimaryFields->isNotEmpty()) : ?>
        <div class="listivo-main-search-form__primary-wrapper">
            <div class="listivo-container">
                <div class="listivo-main-search-form__primary">
                    <?php
                    global $lstSearchField;
                    foreach ($lstPrimaryFields as $lstSearchField) :
                        get_template_part('templates/partials/search/v2/' . $lstSearchField->getType());
                    endforeach;
                    ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($lstSecondaryFields->isNotEmpty()) : ?>
        <div class="listivo-main-search-form__secondary-wrapper">
            <div class="listivo-container">
                <lst-secondary-search-fields
                        :filters="props.filters"
                        :field-keys="<?php echo htmlspecialchars(json_encode($lstSecondaryFieldsKeys)); ?>"
                >
                    <div
                            slot-scope="secondarySearchFields"
                            v-show="secondarySearchFields.visible"
                            class="listivo-main-search-form__secondary"
                    >
                        <?php
                        global $lstSearchField;
                        foreach ($lstSecondaryFields as $lstSearchField) :
                            if ($lstSearchField->displayAtStart($lstSelectedDependencyTerms)) :
                                get_template_part('templates/partials/search/v2/' . $lstSearchField->getType());
                            else :?>
                                <template>
                                    <?php get_template_part('templates/partials/search/v2/' . $lstSearchField->getType()); ?>
                                </template>
                            <?php
                            endif;
                        endforeach;
                        ?>
                    </div>
                </lst-secondary-search-fields>
            </div>
        </div>
    <?php endif; ?>
</div>