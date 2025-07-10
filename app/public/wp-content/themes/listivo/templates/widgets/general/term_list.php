<?php

use Tangibledesign\Framework\Models\Term\CustomTerm;
use Tangibledesign\Listivo\Widgets\General\TermListWidget;

/* @var TermListWidget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-term-list">
    <div class="listivo-term-list__head">
        <div class="listivo-term-list__heading">
            <div class="listivo-heading-v2 listivo-heading-v2--left listivo-heading-v2--tablet-left listivo-heading-v2--mobile-left">
                <?php if ($lstCurrentWidget->hasSmallHeading())  : ?>
                    <h3 class="listivo-heading-v2__small-text">
                        <?php echo esc_html($lstCurrentWidget->getSmallHeading()); ?>
                    </h3>
                <?php endif; ?>

                <h2 class="listivo-heading-v2__text">
                    <?php echo wp_kses_post(nl2br($lstCurrentWidget->getHeading())); ?>
                </h2>
            </div>
        </div>

        <div class="listivo-term-list__button">
            <a
                    class="listivo-button listivo-button--primary-1"
                    href="<?php echo esc_url(get_post_type_archive_link(tdf_model_post_type())); ?>"
            >
                <span>
                    <?php echo esc_html(tdf_string('view_all')); ?>

                    <svg width="8" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 14">
                        <g>
                            <g>
                                <path d="M7.33974,6.18666v0l-5.45414,-5.86846c-0.24639,-0.30357 -0.50858,-0.30357 -0.78587,0l-0.32364,0.35442c-0.24616,0.26968 -0.24616,0.55668 0,0.85987l4.71474,5.05868v0l-4.71474,5.05905c-0.27718,0.30282 -0.27718,0.58982 0,0.8595l0.32364,0.35404c0.27729,0.30395 0.53947,0.30395 0.78587,0l5.45414,-5.86846c0.24696,-0.26892 0.24696,-0.5386 0,-0.80865z"
                                      fill="#ffffff" fill-opacity="1"></path>
                            </g>
                        </g>
                    </svg>
                </span>
            </a>
        </div>
    </div>

    <div class="listivo-term-list__grid">
        <?php foreach ($lstCurrentWidget->getTerms() as $lstTermData) :
            /* @var CustomTerm $lstTerm */
            $lstTerm = $lstTermData['term'];
            ?>
            <a
                    class="listivo-term-list__item listivo-term-card"
                    href="<?php echo esc_url($lstTerm->getUrl()); ?>"
            >
                <div class="listivo-term-card__image">
                    <img
                            class="lazyload"
                            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                            data-src="<?php echo esc_url($lstTermData['image']['url']); ?>"
                            alt="<?php echo esc_attr($lstTerm->getName()); ?>"
                    >
                </div>

                <div class="listivo-term-card__content">
                    <h4 class="listivo-term-card__name">
                        <?php echo esc_html($lstTerm->getName()); ?>
                    </h4>

                    <div class="listivo-term-card__meta">
                        <div class="listivo-term-card__count">
                            <?php echo esc_html($lstTerm->getCount()); ?>
                        </div>

                        <?php echo esc_html(tdf_string('listings')); ?>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="listivo-term-list__mobile-button">
        <a
                class="listivo-button listivo-button--primary-1"
                href="<?php echo esc_url(get_post_type_archive_link(tdf_model_post_type())); ?>"
        >
            <span>
                <?php echo esc_html(tdf_string('view_all')); ?>

                <svg width="8" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 14">
                    <g>
                        <g>
                            <path d="M7.33974,6.18666v0l-5.45414,-5.86846c-0.24639,-0.30357 -0.50858,-0.30357 -0.78587,0l-0.32364,0.35442c-0.24616,0.26968 -0.24616,0.55668 0,0.85987l4.71474,5.05868v0l-4.71474,5.05905c-0.27718,0.30282 -0.27718,0.58982 0,0.8595l0.32364,0.35404c0.27729,0.30395 0.53947,0.30395 0.78587,0l5.45414,-5.86846c0.24696,-0.26892 0.24696,-0.5386 0,-0.80865z"
                                  fill="#ffffff" fill-opacity="1"></path>
                        </g>
                    </g>
                </svg>
            </span>
        </a>
    </div>
</div>
