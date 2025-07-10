<?php

use Tangibledesign\Listivo\Widgets\General\Search\HasPrimaryFields;

/* @var HasPrimaryFields $lstCurrentWidget */
global $lstCurrentWidget;

$lstPrimaryFields = $lstCurrentWidget->getPrimaryFields();
?>
<div class="listivo-main-search-form">
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
</div>