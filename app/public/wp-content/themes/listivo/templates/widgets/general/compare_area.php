<?php

use Elementor\Plugin;
use Tangibledesign\Framework\Core\Image\RenderImage;
use Tangibledesign\Framework\Models\Field\PriceField;
use Tangibledesign\Framework\Models\Field\SalaryField;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Listivo\Widgets\General\CompareAreaWidget;

/* @var CompareAreaWidget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-app">
    <lst-compare-area
            :redirect="<?php echo esc_attr(Plugin::instance()->editor->is_edit_mode() ? 'false' : 'true'); ?>"
            redirect-url="<?php echo esc_url(get_site_url()); ?>"
            :breakpoints="<?php echo esc_attr(json_encode($lstCurrentWidget->getBreakpoints())); ?>"
            :items-to-show="<?php echo esc_attr(json_encode($lstCurrentWidget->getItemsToShow())); ?>"
    >
        <div slot-scope="props" class="listivo-compare-area">
            <template>
                <div class="listivo-compare-area__row listivo-compare-area__row--mobile-full">
                    <div class="listivo-compare-area__head">
                        <div class="listivo-compare-area__heading-wrapper">
                            <h1 class="listivo-compare-area__heading">
                                <?php echo esc_html(tdf_string('compare')); ?>

                                <span class="listivo-compare-area__heading-count">
                                    {{ props.count }}
                                </span>
                            </h1>
                        </div>

                        <?php if (!empty($lstCurrentWidget->getText())) : ?>
                            <div class="listivo-compare-area__text">
                                <?php echo wp_kses_post($lstCurrentWidget->getText()); ?>
                            </div>
                        <?php endif; ?>

                        <div class="listivo-compare-area__head-bottom">
                            <div class="listivo-compare-area__back-button">
                                <a
                                        class="listivo-simple-button listivo-simple-button--background-primary-2"
                                        href="<?php echo esc_url(get_post_type_archive_link(tdf_model_post_type())); ?>"
                                >
                                    <?php echo esc_html(tdf_string('back_to_search')); ?>
                                </a>
                            </div>

                            <div class="listivo-compare-area__nav listivo-box-arrows">
                                <div
                                        class="listivo-box-arrow"
                                        :class="{'listivo-box-arrow--disabled': props.disablePrev}"
                                        @click="props.prev"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                         fill="none">
                                        <path d="M4.86195 10.4713C4.99228 10.6017 5.16262 10.6667 5.33329 10.6667C5.50395 10.6667 5.67429 10.6017 5.80462 10.4713C6.06496 10.211 6.06496 9.78898 5.80462 9.52865L2.27593 5.99996H11.3333C11.7013 5.99996 12 5.70129 12 5.33329C12 4.96528 11.7013 4.66662 11.3333 4.66662H2.27593L5.80462 1.13792C6.06496 0.877589 6.06496 0.455586 5.80462 0.195251C5.54429 -0.0650838 5.12229 -0.0650838 4.86195 0.195251L0.195251 4.86195C-0.0650838 5.12229 -0.0650838 5.54429 0.195251 5.80462L4.86195 10.4713Z"/>
                                    </svg>
                                </div>

                                <div
                                        class="listivo-box-arrow"
                                        :class="{'listivo-box-arrow--disabled': props.disableNext}"
                                        @click="props.next"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                         fill="none">
                                        <path d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49604 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455587 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php foreach (tdf_app('compareModels') as $lstIndex => $lstListing) : /* @var Model $lstListing */ ?>
                        <a
                                v-if="props.isVisible(<?php echo esc_attr($lstListing->getId()); ?>)"
                                :key="'compare-' + <?php echo esc_attr($lstListing->getId()); ?>"
                                class="listivo-compare-area__image"
                                :class="{'listivo-compare-area__locked': props.isLocked(<?php echo esc_attr($lstListing->getId()); ?>)}"
                                href="<?php echo esc_url($lstListing->getUrl()); ?>"
                                target="_blank"
                        >
                            <?php RenderImage::render($lstListing->getMainImage(), 'listivo_360_240'); ?>

                            <div
                                    class="listivo-compare-area__remove"
                                    @click.stop.prevent="props.remove(<?php echo esc_attr($lstListing->getId()); ?>)"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 11 11"
                                     fill="none">
                                    <path d="M1.61169 0.500482C1.39146 0.500755 1.1763 0.566706 0.993713 0.68991C0.811124 0.813114 0.66939 0.987978 0.586617 1.19216C0.503843 1.39635 0.483789 1.62059 0.529015 1.83623C0.574241 2.05188 0.682695 2.24914 0.840521 2.40281L3.93386 5.49762L0.840521 8.59243C0.734227 8.69453 0.649364 8.81683 0.590902 8.95216C0.532441 9.08748 0.501556 9.23312 0.500057 9.38054C0.498558 9.52796 0.526475 9.67419 0.582173 9.81068C0.63787 9.94717 0.720229 10.0712 0.824425 10.1754C0.928621 10.2797 1.05256 10.3621 1.18898 10.4178C1.32541 10.4735 1.47158 10.5014 1.61892 10.4999C1.76627 10.4984 1.91184 10.4675 2.0471 10.409C2.18237 10.3506 2.3046 10.2657 2.40666 10.1593L5.5 7.0645L8.59334 10.1593C8.69539 10.2657 8.81763 10.3506 8.95289 10.4091C9.08815 10.4675 9.23372 10.4984 9.38107 10.4999C9.52842 10.5014 9.67459 10.4735 9.81101 10.4178C9.94744 10.3621 10.0714 10.2797 10.1756 10.1754C10.2798 10.0712 10.3621 9.94718 10.4178 9.81069C10.4735 9.6742 10.5014 9.52796 10.4999 9.38054C10.4984 9.23312 10.4676 9.08748 10.4091 8.95216C10.3506 8.81683 10.2658 8.69453 10.1595 8.59243L7.06613 5.49762L10.1595 2.40281C10.3195 2.24717 10.4288 2.04679 10.4731 1.82792C10.5173 1.60906 10.4945 1.38192 10.4075 1.17628C10.3205 0.970635 10.1734 0.796081 9.9856 0.675491C9.79775 0.5549 9.57787 0.493899 9.35477 0.500482C9.06703 0.509059 8.79393 0.629373 8.59334 0.835933L5.5 3.93074L2.40666 0.835933C2.30332 0.729655 2.17971 0.645206 2.04316 0.587585C1.90661 0.529965 1.75989 0.500346 1.61169 0.500482Z"
                                          fill="#2A3946"/>
                                </svg>
                            </div>

                            <div
                                    class="listivo-compare-area__lock"
                                    v-if="props.showLock(<?php echo esc_attr($lstListing->getId()); ?>)"
                                    @click.stop.prevent="props.lock(<?php echo esc_attr($lstListing->getId()); ?>)"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="14" viewBox="0 0 11 14"
                                     fill="none">
                                    <path d="M5.33333 0C3.11746 0 1.33333 1.78413 1.33333 4V4.66667C0.604625 4.66667 0 5.27129 0 6V12.6667C0 13.3954 0.604625 14 1.33333 14H9.33333C10.062 14 10.6667 13.3954 10.6667 12.6667V6C10.6667 5.27129 10.062 4.66667 9.33333 4.66667V4C9.33333 1.78413 7.54921 0 5.33333 0ZM5.33333 1.33333C6.85079 1.33333 8 2.48254 8 4V4.66667H2.66667V4C2.66667 2.48254 3.81587 1.33333 5.33333 1.33333ZM1.33333 6H9.33333V12.6667H1.33333V6ZM5.33333 8C4.6 8 4 8.6 4 9.33333C4 10.0667 4.6 10.6667 5.33333 10.6667C6.06667 10.6667 6.66667 10.0667 6.66667 9.33333C6.66667 8.6 6.06667 8 5.33333 8Z"
                                          fill="#FDFDFE"/>
                                </svg>

                                <span v-if="!props.isLocked(<?php echo esc_attr($lstListing->getId()); ?>)">
                                    <?php echo esc_html(tdf_string('lock')); ?>
                                </span>

                                <span v-if="props.isLocked(<?php echo esc_attr($lstListing->getId()); ?>)">
                                    <?php echo esc_html(tdf_string('locked')); ?>
                                </span>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>

                <div class="listivo-compare-area__row listivo-compare-area__row--mobile-flex listivo-compare-area__row--with-border">
                    <div class="listivo-compare-area__empty-block"></div>

                    <?php foreach (tdf_app('compareModels') as $lstListing) : /* @var Model $lstListing */ ?>
                        <a
                                v-if="props.isVisible(<?php echo esc_html($lstListing->getId()); ?>)"
                                :key="'compare-' + <?php echo esc_attr($lstListing->getId()); ?>"
                                class="listivo-compare-area__cell listivo-compare-area__cell--label"
                                :class="{'listivo-compare-area__locked': props.isLocked(<?php echo esc_attr($lstListing->getId()); ?>)}"
                                href="<?php echo esc_url($lstListing->getUrl()); ?>"
                                target="_blank"
                        >
                            <?php echo esc_html($lstListing->getName()); ?>
                        </a>
                    <?php endforeach; ?>
                </div>

                <?php foreach ($lstCurrentWidget->getFields() as $lstField) :
                    $lstValues = $lstCurrentWidget->getValues($lstField);
                    if ($lstValues) : ?>
                        <div class="listivo-compare-area__row listivo-compare-area__row--mobile-flex listivo-compare-area__row--with-border">
                            <div class="listivo-compare-area__cell listivo-compare-area__cell--field-label">
                                <?php echo esc_html($lstField->getName()); ?>
                            </div>

                            <?php foreach (tdf_app('compareModels') as $lstListing) : /* @var Model $lstListing */ ?>
                                <div
                                        v-if="props.isVisible(<?php echo esc_html($lstListing->getId()); ?>)"
                                        :key="'compare-' + <?php echo esc_attr($lstListing->getId()); ?>"
                                    <?php if ($lstField instanceof PriceField || $lstField instanceof SalaryField) : ?>
                                        class="listivo-compare-area__cell listivo-compare-area__cell--primary-value"
                                    <?php else : ?>
                                        class="listivo-compare-area__cell"
                                    <?php endif; ?>
                                        :class="{'listivo-compare-area__locked': props.isLocked(<?php echo esc_attr($lstListing->getId()); ?>)}"
                                >
                                    <?php echo esc_html(implode(', ', $lstField->getSimpleTextValue($lstListing))); ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>

                <div class="listivo-compare-area__row listivo-compare-area__row--button">
                    <div class="listivo-compare-area__empty-block"></div>

                    <?php foreach (tdf_app('compareModels') as $lstListing) : /* @var Model $lstListing */ ?>
                        <div
                                v-if="props.isVisible(<?php echo esc_html($lstListing->getId()); ?>)"
                                :key="'compare-' + <?php echo esc_attr($lstListing->getId()); ?>"
                                class="listivo-compare-area__cell listivo-compare-area__cell--button"
                                :class="{'listivo-compare-area__locked': props.isLocked(<?php echo esc_attr($lstListing->getId()); ?>)}"
                        >
                            <a
                                    class="listivo-button listivo-button--primary-1"
                                    href="<?php echo esc_url($lstListing->getUrl()); ?>"
                                    target="_blank"
                            >
                                <span>
                                    <?php echo esc_html(tdf_string('view_listing')); ?>

                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                         fill="none">
                                        <path d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49605 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455586 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z"
                                              fill="#FDFDFE"/>
                                    </svg>
                                </span>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </template>
        </div>
    </lst-compare-area>
</div>