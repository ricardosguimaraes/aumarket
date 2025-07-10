<?php

use Tangibledesign\Framework\Core\Image\RenderImage;
use Tangibledesign\Framework\Models\Field\PriceField;
use Tangibledesign\Framework\Models\Field\SalaryField;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Listivo\Widgets\General\PanelWidget;

/* @var Model $lstCurrentListing */
global $lstCurrentListing;
$lstMainValue = '';
$lstMainValueFields = tdf_settings()->getCardMainValueFields();

foreach ($lstMainValueFields as $lstMainValueField) {
    /* @var PriceField|SalaryField $lstMainValueField */
    $lstHtmlValue = $lstMainValueField->getHtmlValue($lstCurrentListing);
    if (!empty($lstHtmlValue)) {
        $lstMainValue = $lstHtmlValue;
    }
}

$lstMainCategory = tdf_settings()->getMainCategory();
$lstMainCategories = $lstMainCategory ? $lstMainCategory->getMultilevelValue($lstCurrentListing) : tdf_collect();
?>
<div class="listivo-panel-listing-card-v2">
    <div class="listivo-panel-listing-card-v2__image">
        <div class="listivo-panel-listing-card-v2__status listivo-panel-listing-card-v2__status--<?php echo esc_attr($lstCurrentListing->getStatus()); ?>">
            <?php echo esc_html($lstCurrentListing->getStatusLabel()); ?>
        </div>

        <?php RenderImage::render($lstCurrentListing->getMainImage(), 'listivo_360_320'); ?>
    </div>

    <div class="listivo-panel-listing-card-v2__content">
        <a
                class="listivo-panel-listing-card-v2__name"
                href="<?php echo esc_url($lstCurrentListing->getUrl()); ?>"
        >
            <?php echo esc_html($lstCurrentListing->getName()); ?>
        </a>

        <?php if ($lstMainCategories->isNotEmpty()) : ?>
            <div class="listivo-panel-listing-card-v2__categories">
                <?php foreach ($lstMainCategories as $lstMainCategory) : ?>
                    <div class="listivo-panel-listing-card-v2__category">
                        <?php echo esc_html($lstMainCategory->getName()); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="listivo-panel-listing-card-v2__dates">
            <?php if (tdf_settings()->paymentsEnabled() || !empty(tdf_settings()->getListingExpireAfter())) : ?>
                <div class="listivo-panel-listing-card-v2__date">
                    <span>
                        <?php echo esc_html(tdf_string('added')); ?>:
                    </span>

                    <?php echo esc_html($lstCurrentListing->getPublishDate()) ?>
                </div>

                <?php if ($lstCurrentListing->isPublished()) : ?>
                    <div class="listivo-panel-listing-card-v2__date">
                        <span>
                            <?php echo esc_html(tdf_string('expires')); ?>:
                        </span>

                        <?php if ($lstCurrentListing->hasExpireDate()) : ?>
                            <?php echo esc_html($lstCurrentListing->getExpireDateText()) ?>
                        <?php else : ?>
                            <?php echo esc_html(tdf_string('never')); ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ($lstCurrentListing->hasFeaturedExpireDate()) : ?>
                    <div class="listivo-panel-listing-card-v2__date">
                        <span>
                            <?php echo esc_html(tdf_string('featured_expires')); ?>:
                        </span>

                        <?php echo esc_html($lstCurrentListing->getFeaturedExpireDateText()); ?>
                    </div>
                <?php endif; ?>
            <?php else : ?>
                <div class="listivo-panel-listing-card-v2__date">
                    <span>
                        <?php echo esc_html(tdf_string('added')); ?>:
                    </span>

                    <?php echo esc_html($lstCurrentListing->getPublishDate()) ?>
                </div>

                <?php if ($lstCurrentListing->getPublishDate() !== $lstCurrentListing->getModifiedDate()) : ?>
                    <div class="listivo-panel-listing-card-v2__date">
                        <span>
                            <?php echo esc_html(tdf_string('modified')); ?>:
                        </span>

                        <?php echo esc_html($lstCurrentListing->getModifiedDate()); ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <?php if ($lstCurrentListing->hasNextBumpDate() && tdf_settings()->bumpsEnabled()) : ?>
                <div class="listivo-panel-listing-card-v2__date">
                    <span>
                        <?php echo esc_html(tdf_string('next_bump')); ?>:
                    </span>

                    <?php echo esc_html($lstCurrentListing->getNextBumpDateFormatted()); ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($lstMainValue)) : ?>
            <div class="listivo-panel-listing-card-v2__main-value">
                <?php echo wp_kses_post($lstMainValue); ?>
            </div>
        <?php endif; ?>

        <div class="listivo-panel-listing-card-v2__stats">
            <div class="listivo-panel-listing-card-v2__stat">
                <div class="listivo-panel-listing-card-v2__stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="11" viewBox="0 0 15 11" fill="none">
                        <path d="M7.5 0C2.04545 0 0 5.45455 0 5.45455C0 5.45455 2.04545 10.9091 7.5 10.9091C12.9545 10.9091 15 5.45455 15 5.45455C15 5.45455 12.9545 0 7.5 0ZM7.5 1.36364C11.0973 1.36364 12.9168 4.27302 13.5059 5.45188C12.9161 6.62256 11.083 9.54545 7.5 9.54545C3.90273 9.54545 2.08323 6.63607 1.49414 5.45721C2.0846 4.28653 3.91705 1.36364 7.5 1.36364ZM7.5 2.72727C5.99386 2.72727 4.77273 3.94841 4.77273 5.45455C4.77273 6.96068 5.99386 8.18182 7.5 8.18182C9.00614 8.18182 10.2273 6.96068 10.2273 5.45455C10.2273 3.94841 9.00614 2.72727 7.5 2.72727ZM7.5 4.09091C8.25341 4.09091 8.86364 4.70114 8.86364 5.45455C8.86364 6.20795 8.25341 6.81818 7.5 6.81818C6.74659 6.81818 6.13636 6.20795 6.13636 5.45455C6.13636 4.70114 6.74659 4.09091 7.5 4.09091Z"
                              fill="#73818C"/>
                    </svg>
                </div>

                <div class="listivo-panel-listing-card-v2__stat-value">
                    <?php echo esc_html($lstCurrentListing->getViews()); ?>
                </div>
            </div>

            <div class="listivo-panel-listing-card-v2__stat">
                <div class="listivo-panel-listing-card-v2__stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="15" viewBox="0 0 10 15" fill="none">
                        <path d="M2.32813 0C1.40281 0 0.640625 0.762187 0.640625 1.6875V13.3125C0.640625 14.2378 1.40281 15 2.32813 15H7.95313C8.87844 15 9.64063 14.2378 9.64063 13.3125V1.6875C9.64063 0.762187 8.87844 0 7.95313 0H2.32813ZM2.32813 1.125H7.95313C8.27056 1.125 8.51563 1.37006 8.51563 1.6875V13.3125C8.51563 13.6299 8.27056 13.875 7.95313 13.875H2.32813C2.01069 13.875 1.76563 13.6299 1.76563 13.3125V1.6875C1.76563 1.37006 2.01069 1.125 2.32813 1.125ZM5.14063 2.25C4.99144 2.25 4.84837 2.30926 4.74288 2.41475C4.63739 2.52024 4.57813 2.66332 4.57813 2.8125C4.57813 2.96168 4.63739 3.10476 4.74288 3.21025C4.84837 3.31574 4.99144 3.375 5.14063 3.375C5.28981 3.375 5.43288 3.31574 5.53837 3.21025C5.64386 3.10476 5.70312 2.96168 5.70312 2.8125C5.70312 2.66332 5.64386 2.52024 5.53837 2.41475C5.43288 2.30926 5.28981 2.25 5.14063 2.25ZM4.20313 11.625C4.12859 11.6239 4.05458 11.6377 3.98541 11.6655C3.91624 11.6933 3.85329 11.7346 3.80021 11.7869C3.74712 11.8392 3.70497 11.9016 3.6762 11.9704C3.64743 12.0392 3.63261 12.113 3.63261 12.1875C3.63261 12.262 3.64743 12.3358 3.6762 12.4046C3.70497 12.4734 3.74712 12.5358 3.80021 12.5881C3.85329 12.6404 3.91624 12.6817 3.98541 12.7095C4.05458 12.7373 4.12859 12.7511 4.20313 12.75H6.07812C6.15266 12.7511 6.22667 12.7373 6.29584 12.7095C6.36501 12.6817 6.42796 12.6404 6.48105 12.5881C6.53413 12.5358 6.57628 12.4734 6.60505 12.4046C6.63382 12.3358 6.64864 12.262 6.64864 12.1875C6.64864 12.113 6.63382 12.0392 6.60505 11.9704C6.57628 11.9016 6.53413 11.8392 6.48105 11.7869C6.42796 11.7346 6.36501 11.6933 6.29584 11.6655C6.22667 11.6377 6.15266 11.6239 6.07812 11.625H4.20313Z"
                              fill="#73818C"/>
                    </svg>
                </div>

                <div class="listivo-panel-listing-card-v2__stat-value">
                    <?php echo esc_html($lstCurrentListing->getRevealPhoneCounter()); ?>
                </div>
            </div>

            <div class="listivo-panel-listing-card-v2__stat">
                <div class="listivo-panel-listing-card-v2__stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="14" viewBox="0 0 15 14" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M0 4.24289C0 1.90639 1.85342 0 4.125 0C5.42866 0 6.56369 0.719937 7.5 1.9429C8.43631 0.719937 9.57134 0 10.875 0C13.1466 0 15 1.90639 15 4.24289C15 5.82285 13.8421 7.31046 12.4307 8.83609C11.6206 9.71165 10.7033 10.5936 9.80691 11.4554C9.14141 12.0953 8.48749 12.724 7.89771 13.3306C7.67803 13.5565 7.32197 13.5565 7.10229 13.3306C6.51251 12.724 5.85859 12.0953 5.19309 11.4554C4.29675 10.5936 3.37938 9.71165 2.56934 8.83609C1.15787 7.31046 0 5.82285 0 4.24289ZM7.02484 3.20183C6.13755 1.75833 5.2234 1.15723 4.12518 1.15723C2.46152 1.15723 1.12518 2.53175 1.12518 4.24297C1.12518 5.17017 2.02982 6.57544 3.38397 8.03912C4.15614 8.87374 5.04565 9.73171 5.93302 10.5876C6.46475 11.1005 6.99571 11.6126 7.50018 12.1185C8.00466 11.6126 8.53562 11.1005 9.06735 10.5876C9.95471 9.73171 10.8442 8.87374 11.6164 8.03912C12.9705 6.57544 13.8752 5.17017 13.8752 4.24297C13.8752 2.53175 12.5388 1.15723 10.8752 1.15723C9.77697 1.15723 8.86282 1.75833 7.97552 3.20183C7.8724 3.36942 7.69301 3.471 7.50018 3.471C7.30736 3.471 7.12797 3.36942 7.02484 3.20183Z"
                              fill="#73818C"/>
                    </svg>
                </div>

                <div class="listivo-panel-listing-card-v2__stat-value">
                    <?php echo esc_html($lstCurrentListing->getFavoriteCount()); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="listivo-panel-listing-card-v2__actions">
        <div class="listivo-panel-listing-card-v2__actions-top">
            <a
                    class="listivo-panel-listing-card-v2__action"
                    href="<?php echo esc_url($lstCurrentListing->getEditUrl()); ?>"
            >
                <div class="listivo-panel-listing-card-v2__action-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="14" viewBox="0 0 13 14" fill="none">
                        <path d="M1.49458 0C0.67502 0 0 0.67502 0 1.49458V10.4621C0 11.2816 0.67502 11.9566 1.49458 11.9566H4.01084V10.9602H1.49458C1.21413 10.9602 0.996386 10.7425 0.996386 10.4621V1.49458C0.996386 1.21413 1.21413 0.996386 1.49458 0.996386H5.97832V3.98554H8.96747V4.98193H9.96386V3.28107L6.68279 0H1.49458ZM6.9747 1.70086L8.263 2.98916H6.9747V1.70086ZM11.1665 5.98221C10.8389 5.9843 10.512 6.11173 10.2674 6.36169L5.66111 11.0478L4.95858 14L7.90881 13.2975L8.00806 13.2002L12.5969 8.69308C13.099 8.20233 13.103 7.38158 12.6066 6.88518L12.0734 6.35196C11.825 6.10358 11.4956 5.98011 11.1665 5.98221ZM11.1724 6.97275C11.2418 6.97232 11.3124 6.99992 11.3689 7.05644L11.9021 7.58966C12.0135 7.70106 12.0139 7.86975 11.9002 7.98082V7.98276L7.41062 12.3906L6.30331 12.6553L6.56603 11.5499L10.9778 7.06033L10.9797 7.05838C11.0348 7.00168 11.103 6.97319 11.1724 6.97275Z"
                              fill="#374B5C"/>
                    </svg>
                </div>

                <div class="listivo-panel-listing-card-v2__action-label">
                    <?php echo esc_html(tdf_string('edit')); ?>
                </div>
            </a>

            <lst-delete-model
                    request-url="<?php echo esc_url(tdf_action_url('listivo/model/delete')); ?>"
                    td-nonce="<?php echo esc_attr(wp_create_nonce('delete_model_' . $lstCurrentListing->getId())); ?>"
                    :model-id="<?php echo esc_attr($lstCurrentListing->getId()); ?>"
                    title-text="<?php echo esc_attr(tdf_string('are_you_sure')); ?>"
                    msg-text="<?php echo esc_attr(tdf_string('delete_listing_msg')); ?>"
                    confirm-text="<?php echo esc_attr(tdf_string('delete')); ?>"
                    cancel-text="<?php echo esc_attr(tdf_string('cancel')); ?>"
                    success-title="<?php echo esc_attr(tdf_string('success')); ?>"
                    success-msg="<?php echo esc_attr(tdf_string('listing_has_been_deleted')); ?>"
                    error-title="<?php echo esc_attr(tdf_string('something_went_wrong')); ?>"
                    confirm-error-text="<?php echo esc_attr(tdf_string('ok')); ?>"
            >
                <button
                        class="listivo-panel-listing-card-v2__action"
                        slot-scope="props"
                        @click.prevent="props.onDelete"
                >
                    <div class="listivo-panel-listing-card-v2__action-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="14" viewBox="0 0 12 14" fill="none">
                            <path d="M3.23077 2.65385H3.73077V2.15385V1.61118C3.73077 1.00391 4.23468 0.5 4.84195 0.5H7.00421C7.61148 0.5 8.11539 1.00391 8.11539 1.61118V2.15385V2.65385H8.61539H11.3462V2.73077H10.7692H10.2692V3.23077V12.3846C10.2692 12.9961 9.76532 13.5 9.15385 13.5H2.69231C2.08083 13.5 1.57692 12.9961 1.57692 12.3846V3.23077V2.73077H1.07692H0.5V2.65385H3.23077ZM7.53846 2.65385H8.03846V2.15385V1.61118C8.03846 1.03215 7.58323 0.576923 7.00421 0.576923H4.84195C4.26292 0.576923 3.80769 1.03215 3.80769 1.61118V2.15385V2.65385H4.30769H7.53846ZM2.15385 2.73077H1.65385V3.23077V12.3846C1.65385 12.9636 2.11328 13.4231 2.69231 13.4231H9.15385C9.73287 13.4231 10.1923 12.9636 10.1923 12.3846V3.23077V2.73077H9.69231H2.15385ZM3.80769 11.3462H3.73077V4.80769H3.80769V11.3462ZM5.96154 11.3462H5.88462V4.80769H5.96154V11.3462ZM8.11539 11.3462H8.03846V4.80769H8.11539V11.3462Z"
                                  fill="#374B5C" stroke="#374B5C"/>
                        </svg>
                    </div>

                    <div class="listivo-panel-listing-card-v2__action-label">
                        <?php echo esc_html(tdf_string('delete')); ?>
                    </div>
                </button>
            </lst-delete-model>
        </div>

        <?php if ($lstCurrentListing->isDraft() && tdf_settings()->paymentsEnabled()) : ?>
            <div class="listivo-panel-listing-card-v2__actions-buttons">
                <a
                        class="listivo-simple-button listivo-simple-button--background-primary-1 listivo-panel-listing-card-v2__primary-button"
                        href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_SELECT_PACKAGE)); ?>?id=<?php echo esc_attr($lstCurrentListing->getId()); ?>"
                >
                    <span class="listivo-simple-button__icon">
                      <svg xmlns="http://www.w3.org/2000/svg" width="12" height="14" viewBox="0 0 12 14"
                           fill="none">
                                <path d="M6.10688 5.84822C6.0416 5.80694 5.9584 5.80694 5.89312 5.84822L0.0931191 9.51532C0.0351465 9.55197 0 9.61578 0 9.68436V13.6369C0 13.7945 0.173711 13.8902 0.306881 13.806L5.89312 10.274C5.9584 10.2328 6.0416 10.2328 6.10688 10.274L11.6931 13.806C11.8263 13.8902 12 13.7945 12 13.6369V9.68436C12 9.61578 11.9649 9.55197 11.9069 9.51532L6.10688 5.84822ZM5.89311 7.36754C5.95839 7.32627 6.04161 7.32627 6.10689 7.36754L10.5736 10.1918C10.6315 10.2285 10.6667 10.2923 10.6667 10.3609V11.5465C10.6667 11.5859 10.6232 11.6098 10.5899 11.5887L6.10689 8.75409C6.04161 8.71281 5.95839 8.71281 5.89311 8.75409L1.41005 11.5887C1.37676 11.6098 1.33333 11.5859 1.33333 11.5465V10.3609C1.33333 10.2923 1.36848 10.2285 1.42645 10.1918L5.89311 7.36754Z"
                                      fill="#374B5C"/>
                                <path d="M6.10688 0.0675765C6.0416 0.0263043 5.9584 0.0263042 5.89312 0.0675764L0.0931191 3.73468C0.0351465 3.77133 0 3.83514 0 3.90373V7.8563C0 8.01385 0.173711 8.10954 0.306881 8.02534L5.89312 4.49339C5.9584 4.45212 6.0416 4.45212 6.10688 4.49339L11.6931 8.02534C11.8263 8.10954 12 8.01385 12 7.8563V3.90373C12 3.83514 11.9649 3.77133 11.9069 3.73468L6.10688 0.0675765ZM5.89311 1.5869C5.95839 1.54563 6.04161 1.54563 6.10689 1.5869L10.5736 4.4112C10.6315 4.44785 10.6667 4.51165 10.6667 4.58024V5.76584C10.6667 5.80523 10.6232 5.82916 10.5899 5.8081L6.10689 2.97345C6.04161 2.93217 5.95839 2.93217 5.89311 2.97345L1.41005 5.8081C1.37676 5.82916 1.33333 5.80523 1.33333 5.76584V4.58024C1.33333 4.51165 1.36848 4.44785 1.42645 4.4112L5.89311 1.5869Z"
                                      fill="#374B5C"/>
                            </svg>
                    </span>

                    <span class="listivo-simple-button__text">
                        <?php echo esc_html(tdf_string('publish')); ?>
                    </span>
                </a>
            </div>
        <?php endif; ?>

        <?php
        $lstPackagesAvailable = tdf_payment_packages()->isNotEmpty();

        if ($lstCurrentListing->isPublished() && tdf_settings()->paymentsEnabled()) : ?>
            <div class="listivo-panel-listing-card-v2__actions-buttons">
                <?php if ($lstPackagesAvailable) : ?>
                    <?php if (!$lstCurrentListing->isFeatured()) : ?>
                        <a
                                class="listivo-simple-button listivo-simple-button--background-primary-1 listivo-panel-listing-card-v2__primary-button"
                                href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_PROMOTE)); ?>?id=<?php echo esc_attr($lstCurrentListing->getId()); ?>"
                        >
                        <span class="listivo-simple-button__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="14" viewBox="0 0 12 14"
                                 fill="none">
                                <path d="M6.10688 5.84822C6.0416 5.80694 5.9584 5.80694 5.89312 5.84822L0.0931191 9.51532C0.0351465 9.55197 0 9.61578 0 9.68436V13.6369C0 13.7945 0.173711 13.8902 0.306881 13.806L5.89312 10.274C5.9584 10.2328 6.0416 10.2328 6.10688 10.274L11.6931 13.806C11.8263 13.8902 12 13.7945 12 13.6369V9.68436C12 9.61578 11.9649 9.55197 11.9069 9.51532L6.10688 5.84822ZM5.89311 7.36754C5.95839 7.32627 6.04161 7.32627 6.10689 7.36754L10.5736 10.1918C10.6315 10.2285 10.6667 10.2923 10.6667 10.3609V11.5465C10.6667 11.5859 10.6232 11.6098 10.5899 11.5887L6.10689 8.75409C6.04161 8.71281 5.95839 8.71281 5.89311 8.75409L1.41005 11.5887C1.37676 11.6098 1.33333 11.5859 1.33333 11.5465V10.3609C1.33333 10.2923 1.36848 10.2285 1.42645 10.1918L5.89311 7.36754Z"
                                      fill="#374B5C"/>
                                <path d="M6.10688 0.0675765C6.0416 0.0263043 5.9584 0.0263042 5.89312 0.0675764L0.0931191 3.73468C0.0351465 3.77133 0 3.83514 0 3.90373V7.8563C0 8.01385 0.173711 8.10954 0.306881 8.02534L5.89312 4.49339C5.9584 4.45212 6.0416 4.45212 6.10688 4.49339L11.6931 8.02534C11.8263 8.10954 12 8.01385 12 7.8563V3.90373C12 3.83514 11.9649 3.77133 11.9069 3.73468L6.10688 0.0675765ZM5.89311 1.5869C5.95839 1.54563 6.04161 1.54563 6.10689 1.5869L10.5736 4.4112C10.6315 4.44785 10.6667 4.51165 10.6667 4.58024V5.76584C10.6667 5.80523 10.6232 5.82916 10.5899 5.8081L6.10689 2.97345C6.04161 2.93217 5.95839 2.93217 5.89311 2.97345L1.41005 5.8081C1.37676 5.82916 1.33333 5.80523 1.33333 5.76584V4.58024C1.33333 4.51165 1.36848 4.44785 1.42645 4.4112L5.89311 1.5869Z"
                                      fill="#374B5C"/>
                            </svg>
                        </span>

                            <?php echo esc_html(tdf_string('promote')); ?>
                        </a>
                    <?php endif; ?>

                    <?php if ($lstCurrentListing->isFeatured()) : ?>
                        <a
                                class="listivo-simple-button listivo-simple-button--background-primary-1 listivo-panel-listing-card-v2__primary-button"
                                href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_EXTEND)); ?>?id=<?php echo esc_attr($lstCurrentListing->getId()); ?>"
                        >
                        <span class="listivo-simple-button__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="14" viewBox="0 0 12 14"
                                 fill="none">
                                <path d="M6.10688 5.84822C6.0416 5.80694 5.9584 5.80694 5.89312 5.84822L0.0931191 9.51532C0.0351465 9.55197 0 9.61578 0 9.68436V13.6369C0 13.7945 0.173711 13.8902 0.306881 13.806L5.89312 10.274C5.9584 10.2328 6.0416 10.2328 6.10688 10.274L11.6931 13.806C11.8263 13.8902 12 13.7945 12 13.6369V9.68436C12 9.61578 11.9649 9.55197 11.9069 9.51532L6.10688 5.84822ZM5.89311 7.36754C5.95839 7.32627 6.04161 7.32627 6.10689 7.36754L10.5736 10.1918C10.6315 10.2285 10.6667 10.2923 10.6667 10.3609V11.5465C10.6667 11.5859 10.6232 11.6098 10.5899 11.5887L6.10689 8.75409C6.04161 8.71281 5.95839 8.71281 5.89311 8.75409L1.41005 11.5887C1.37676 11.6098 1.33333 11.5859 1.33333 11.5465V10.3609C1.33333 10.2923 1.36848 10.2285 1.42645 10.1918L5.89311 7.36754Z"
                                      fill="#374B5C"/>
                                <path d="M6.10688 0.0675765C6.0416 0.0263043 5.9584 0.0263042 5.89312 0.0675764L0.0931191 3.73468C0.0351465 3.77133 0 3.83514 0 3.90373V7.8563C0 8.01385 0.173711 8.10954 0.306881 8.02534L5.89312 4.49339C5.9584 4.45212 6.0416 4.45212 6.10688 4.49339L11.6931 8.02534C11.8263 8.10954 12 8.01385 12 7.8563V3.90373C12 3.83514 11.9649 3.77133 11.9069 3.73468L6.10688 0.0675765ZM5.89311 1.5869C5.95839 1.54563 6.04161 1.54563 6.10689 1.5869L10.5736 4.4112C10.6315 4.44785 10.6667 4.51165 10.6667 4.58024V5.76584C10.6667 5.80523 10.6232 5.82916 10.5899 5.8081L6.10689 2.97345C6.04161 2.93217 5.95839 2.93217 5.89311 2.97345L1.41005 5.8081C1.37676 5.82916 1.33333 5.80523 1.33333 5.76584V4.58024C1.33333 4.51165 1.36848 4.44785 1.42645 4.4112L5.89311 1.5869Z"
                                      fill="#374B5C"/>
                            </svg>
                        </span>

                            <?php echo esc_html(tdf_string('extend')); ?>
                        </a>
                    <?php
                    endif; ?>
                <?php
                endif;

                if (tdf_settings()->bumpsEnabled()) :
                    $lstUserPackageCount = tdf_user_payment_packages_repository()
                        ->getBumpPaymentPackagesForModel(tdf_current_user(), $lstCurrentListing)
                        ->count();

                    if (!empty($lstUserPackageCount)) : ?>
                        <lst-bump-model
                                request-url="<?php echo esc_url(tdf_action_url('listivo/panel/model/bump')); ?>"
                                request-nonce="<?php echo esc_attr(wp_create_nonce(tdf_prefix() . '_panel_bump_model')); ?>"
                                :model-id="<?php echo esc_attr($lstCurrentListing->getId()); ?>"
                                title-text="<?php echo esc_attr($lstCurrentListing->getName()); ?>"
                                text="<?php echo esc_attr(tdf_string('bump_up_confirm_text')); ?>"
                                confirm-text="<?php echo esc_attr(tdf_string('bump_up')); ?>"
                                cancel-text="<?php echo esc_attr(tdf_string('cancel')); ?>"
                        >
                            <button
                                    slot-scope="bump"
                                    @click="bump.onClick"
                                    class="listivo-simple-button listivo-simple-button--color-1 listivo-simple-button--background-color-3 listivo-panel-listing-card-v2__secondary-button"
                            >
                                <span class="listivo-simple-button__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="14" viewBox="0 0 13 14"
                                         fill="none">
                                        <path d="M6.48958 0C3.50684 0 1.01628 1.84342 0 4.44792L1.07552 4.88542C1.92546 2.70703 3.98763 1.16667 6.48958 1.16667C8.38086 1.16667 10.0671 2.09408 11.1198 3.5H8.82292V4.66667H12.9062V0.583333H11.7396V2.38802C10.4613 0.922852 8.57227 0 6.48958 0ZM11.9036 9.11458C11.0537 11.293 8.99154 12.8333 6.48958 12.8333C4.5778 12.8333 2.89844 11.8923 1.84115 10.5H4.15625V9.33333H0.0729167V13.4167H1.23958V11.612C2.51562 13.0589 4.38639 14 6.48958 14C9.47233 14 11.9629 12.1566 12.9792 9.55208L11.9036 9.11458Z"
                                              fill="#374B5C"/>
                                    </svg>
                                </span>

                                <?php echo esc_html(tdf_string('bump_up')); ?>
                            </button>
                        </lst-bump-model>
                    <?php
                    else :
                        $lstPackageCount = tdf_bumps_payment_packages()->count();

                        if (!empty($lstPackageCount)) : ?>
                            <a
                                    class="listivo-simple-button listivo-simple-button--color-1 listivo-simple-button--background-color-3 listivo-panel-listing-card-v2__secondary-button"
                                <?php if ($lstPackageCount === 1) : ?>
                                    href="<?php echo esc_url(admin_url('admin-ajax.php?action=listivo/paymentPackage/bump/purchase&id=' . $lstCurrentListing->getId())); ?>"
                                <?php else : ?>
                                    href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_BUMP_UP)); ?>?id=<?php echo esc_attr($lstCurrentListing->getId()); ?>"
                                <?php endif; ?>
                            >
                                <span class="listivo-simple-button__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="14" viewBox="0 0 13 14"
                                         fill="none">
                                        <path d="M6.48958 0C3.50684 0 1.01628 1.84342 0 4.44792L1.07552 4.88542C1.92546 2.70703 3.98763 1.16667 6.48958 1.16667C8.38086 1.16667 10.0671 2.09408 11.1198 3.5H8.82292V4.66667H12.9062V0.583333H11.7396V2.38802C10.4613 0.922852 8.57227 0 6.48958 0ZM11.9036 9.11458C11.0537 11.293 8.99154 12.8333 6.48958 12.8333C4.5778 12.8333 2.89844 11.8923 1.84115 10.5H4.15625V9.33333H0.0729167V13.4167H1.23958V11.612C2.51562 13.0589 4.38639 14 6.48958 14C9.47233 14 11.9629 12.1566 12.9792 9.55208L11.9036 9.11458Z"
                                              fill="#374B5C"/>
                                    </svg>
                                </span>

                                <?php echo esc_html(tdf_string('bump_up')); ?>
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>