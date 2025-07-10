<?php

use Tangibledesign\Framework\Models\PanelFields\NamePanelField;
use Tangibledesign\Framework\Models\PanelFields\PanelField;
use Tangibledesign\Listivo\Widgets\General\PanelWidget;

/* @var PanelWidget $lstCurrentWidget */
global $lstCurrentWidget;

$orderedFields = $lstCurrentWidget->getOrderedFields();

if ($orderedFields->isNotEmpty()) :
    foreach ($orderedFields as $lstField) :
        $lstField->loadTemplate();
    endforeach;
else :
    ?>
    <div class="listivo-panel-form__single-column">
        <div class="listivo-panel-form-label listivo-panel-form-label--small-margin-bottom">
            <h3 class="listivo-panel-form-label__text">
                <?php echo esc_html(tdf_string('general_info')); ?>
            </h3>

            <div class="listivo-panel-form-label__line"></div>

            <div class="listivo-panel-form-label__icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="12"
                     viewBox="0 0 11 12"
                     fill="none">
                    <path d="M0.195669 7.13805C0.0653349 7.00772 0.00033474 6.83738 0.00033474 6.66671C0.00033474 6.49604 0.0653349 6.32571 0.195669 6.19538C0.456004 5.93504 0.878008 5.93504 1.13834 6.19538L4.66703 9.72407L4.66703 0.666672C4.66703 0.298669 4.9657 0 5.3337 0C5.70171 0 6.00038 0.298669 6.00038 0.666672L6.00038 9.72407L9.52907 6.19538C9.7894 5.93504 10.2114 5.93504 10.4717 6.19538C10.7321 6.45571 10.7321 6.87771 10.4717 7.13805L5.80504 11.8047C5.54471 12.0651 5.1227 12.0651 4.86237 11.8047L0.195669 7.13805Z"
                          fill="#D5E3EE"/>
                </svg>
            </div>
        </div>
    </div>
    <?php

    if (tdf_settings()->getAutoGenerateModelTitleFields()->isEmpty()) :
        $lstCurrentWidget->getNameField()->loadTemplate();
    endif;

    $lstMainCategory = $lstCurrentWidget->getMainCategoryField();
    if ($lstMainCategory) :
        $lstMainCategory->loadTemplate();
    endif;

    /* @var PanelField $lstField */
    foreach ($lstCurrentWidget->getMultilevelTaxonomyFields() as $lstField) :
        if ($lstMainCategory && $lstMainCategory->getKey() === $lstField->getKey()) {
            continue;
        }

        $lstField->loadTemplate();
    endforeach;

    foreach ($lstCurrentWidget->getSingleValueFields() as $lstField) :
        if ($lstField instanceof NamePanelField) {
            continue;
        }

        if ($lstMainCategory && $lstMainCategory->getKey() === $lstField->getKey()) {
            continue;
        }

        $lstField->loadTemplate();
    endforeach;

    foreach ($lstCurrentWidget->getMultipleValueTaxonomyFields() as $lstField):
        $lstField->loadTemplate();
    endforeach;

    foreach ($lstCurrentWidget->getDescriptionFields() as $lstField) :
        $lstField->loadTemplate();
    endforeach;

    foreach ($lstCurrentWidget->getEmbedFields() as $lstField) :
        $lstField->loadTemplate();
    endforeach;

    foreach ($lstCurrentWidget->getGalleryFields() as $lstField) :
        $lstField->loadTemplate();
    endforeach;

    foreach ($lstCurrentWidget->getAttachmentsFields() as $lstField) :
        $lstField->loadTemplate();
    endforeach;

    foreach ($lstCurrentWidget->getRichTextFields() as $lstField) :
        $lstField->loadTemplate();
    endforeach;

    foreach ($lstCurrentWidget->getLocationFields() as $lstField) :
        $lstField->loadTemplate();
    endforeach;
endif;