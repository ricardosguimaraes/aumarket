<?php

use Tangibledesign\Framework\Models\Term\CustomTerm;
use Tangibledesign\Listivo\Widgets\General\HeroSearchV9Widget;

/* @var HeroSearchV9Widget $lstCurrentWidget */
global $lstCurrentWidget;

$lstFields = $lstCurrentWidget->getFields();
$lstColumns = $lstFields->count() > 3 ? 3 : $lstFields->count();
?>
<div class="listivo-hero-search-v9">
    <div class="listivo-hero-search-v9__content">
        <div class="listivo-hero-search-v9__patterns">
            <svg xmlns="http://www.w3.org/2000/svg" width="1406" height="700" viewBox="0 0 1406 700" fill="none">
                <path
                        class="listivo-fill-color-3"
                        d="M1329.16 102.574L1333.15 94.8944L1325.99 91.1737L1328.33 86.6795L1335.49 90.4002L1339.48 82.7207L1344.1 85.1256L1340.11 92.805L1347.27 96.5258L1344.93 101.02L1337.77 97.2993L1333.78 104.979L1329.16 102.574Z"
                        fill="#EFE9E4"/>
                <path
                        class="listivo-fill-color-3"
                        d="M665.135 105.504L669.116 97.8475L661.981 94.1377L664.311 89.6568L671.446 93.3665L675.427 85.7097L680.038 88.1075L676.057 95.7642L683.192 99.474L680.862 103.955L673.727 100.245L669.746 107.902L665.135 105.504Z"
                        fill="#EFE9E4"/>
                <path
                        class="listivo-fill-primary-1"
                        d="M41.5332 667.228L44.6207 661.29L39.0876 658.413L40.8944 654.938L46.4276 657.815L49.5151 651.877L53.0914 653.736L50.0039 659.675L55.5371 662.552L53.7302 666.027L48.197 663.15L45.1095 669.088L41.5332 667.228Z"
                        fill="#D6A26E"/>
                <rect
                        class="listivo-stroke-color-3"
                        x="1376" y="495" width="26" height="26" rx="13" stroke="#EFE9E4" stroke-width="8"/>
                <rect class="listivo-fill-primary-1" x="459" width="6" height="6" rx="3" fill="#D6A26E"/>
                <rect class="listivo-fill-color-3" y="148" width="10" height="10" rx="5" fill="#EFE9E4"/>
                <rect class="listivo-stroke-color-3" x="1027.5" y="680.5" width="17" height="17" rx="8.5"
                      stroke="#EFE9E4" stroke-width="5"/>
                <rect class="listivo-stroke-color-3" x="559.5" y="675.5" width="17" height="17" rx="8.5"
                      stroke="#EFE9E4" stroke-width="5"/>
                <path class="listivo-fill-primary-1"
                      d="M1213.18 687.801L1215.56 683.229L1211.29 681.013L1212.69 678.338L1216.95 680.553L1219.32 675.981L1222.08 677.413L1219.7 681.985L1223.96 684.2L1222.57 686.875L1218.31 684.66L1215.93 689.232L1213.18 687.801Z"
                      fill="#D6A26E"/>
            </svg>
        </div>

        <h1 class="listivo-hero-search-v9__heading">
            <?php echo nl2br(wp_kses_post($lstCurrentWidget->getHeading())); ?>
        </h1>

        <?php if (!empty($lstCurrentWidget->getText())) : ?>
            <div class="listivo-hero-search-v9__text">
                <?php echo wp_kses_post($lstCurrentWidget->getText()); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($lstCurrentWidget->getImageUrl())) : ?>
            <div class="listivo-hero-search-v9__image-mask">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="607"
                     height="718"
                     viewBox="0 0 607 718" fill="none">
                    <clipPath id="listivo-hero-search-v9-<?php echo esc_attr($lstCurrentWidget->get_id()); ?>">
                        <path d="M0 15C0 6.71572 6.71573 0 15 0H442C450.284 0 457 6.71573 457 15V492.242C457 507.674 448.123 521.729 434.189 528.36L42.892 714.587C22.9844 724.061 0 709.545 0 687.498V15Z"
                              fill="#D9D9D9"/>
                    </clipPath>
                </svg>
            </div>

            <div class="listivo-hero-search-v9__image-wrapper">
                <?php if (!empty($lstCurrentWidget->getMobileImage())) : ?>
                    <div class="listivo-hero-search-v9__mobile-image">
                        <img
                                src="<?php echo esc_url($lstCurrentWidget->getMobileImage()); ?>"
                                alt="<?php echo esc_attr($lstCurrentWidget->getHeading()); ?>"
                        >
                    </div>
                <?php endif; ?>

                <?php if (!empty($lstCurrentWidget->getImageUrl())) : ?>
                    <div class="listivo-hero-search-v9__image">
                        <img
                                src="<?php echo esc_url($lstCurrentWidget->getImageUrl()); ?>"
                                alt="<?php echo esc_attr($lstCurrentWidget->getHeading()); ?>"
                                style="clip-path: url('#listivo-hero-search-v9-<?php echo esc_attr($lstCurrentWidget->get_id()); ?>');"
                        >

                        <svg xmlns="http://www.w3.org/2000/svg" width="442" height="780" viewBox="0 0 442 780"
                             fill="none">
                            <path d="M0 0H442V559.193C442 574.563 433.193 588.574 419.343 595.238L43.007 776.308C23.0898 785.891 0 771.377 0 749.274V0Z"
                                  fill="#EFE9E4"/>
                        </svg>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="listivo-hero-search-v9__form listivo-app">
            <lst-search-form
                    base-url="<?php echo esc_url(get_post_type_archive_link(tdf_model_post_type())); ?>"
                    request-url="<?php echo esc_url(get_rest_url() . 'listivo/v1/listings'); ?>"
                    :dependency-terms="<?php echo htmlspecialchars(json_encode(tdf_app('dependency_terms'))); ?>"
                    :initial-term-count="<?php echo htmlspecialchars(json_encode($lstCurrentWidget->getTermCount())); ?>"
                    initial-sort-by="<?php echo esc_attr(tdf_slug('newest')); ?>"
                    field-selector=".listivo-search-form-field"
            >
                <div slot-scope="props" class="listivo-search-form-v2 listivo-search-form-v2--style-2">
                    <div class="listivo-search-form-v2__inner listivo-search-form-v2__inner--style-2">
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

                        <div class="listivo-search-form-v2__button-v2">
                            <button
                                    @click.prevent="props.onSearch"
                                    class="listivo-button listivo-button--height-60 listivo-button--primary-2"
                                    :class="{'listivo-button--loading': props.inProgress}"
                            >
                                <span>
                                    <?php echo esc_html(tdf_string('search')); ?>

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
                        </div>

                        <div class="listivo-search-form-v2__mobile-button">
                            <button
                                    @click.prevent="props.onSearch"
                                    class="listivo-button listivo-button--primary-2"
                                    :class="{'listivo-button--loading': props.inProgress}"
                            >
                                <span>
                                    <?php echo esc_html(tdf_string('search')); ?>

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

        <div class="listivo-hero-search-v9__terms-container">
            <div class="listivo-hero-search-v9__terms">
                <?php foreach ($lstCurrentWidget->getTerms() as $lstItem) :
                    /* @var CustomTerm $lstTerm */
                    $lstTerm = $lstItem['term'];
                    ?>
                    <a
                            class="listivo-hero-search-v9__term"
                            href="<?php echo esc_url($lstTerm->getUrl()); ?>"
                    >
                        <div class="listivo-hero-search-v9__term-image">
                            <?php if (!empty($lstItem['image']['url'])) : ?>
                                <img
                                        src="<?php echo esc_url($lstItem['image']['url']); ?>"
                                        alt="<?php echo esc_attr($lstTerm->getName()); ?>"
                                >
                            <?php endif; ?>
                        </div>

                        <div class="listivo-hero-search-v9__term-label">
                            <?php echo esc_html($lstTerm->getName()); ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
