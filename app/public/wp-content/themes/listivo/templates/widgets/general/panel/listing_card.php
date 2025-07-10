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
?>
<div class="listivo-panel-listing-card">
    <a
            class="listivo-panel-listing-card__image"
            href="<?php echo esc_url($lstCurrentListing->getUrl()); ?>"
    >
        <div
            <?php if ($lstCurrentListing->isPublished()) : ?>
                class="listivo-panel-listing-card__status listivo-panel-listing-card__status--active"
            <?php else : ?>
                class="listivo-panel-listing-card__status"
            <?php endif; ?>
        >
            <?php echo esc_html($lstCurrentListing->getStatusLabel()); ?>
        </div>

        <?php RenderImage::render($lstCurrentListing->getMainImage(), 'listivo_360_320'); ?>
    </a>

    <div class="listivo-panel-listing-card__right">
        <div class="listivo-panel-listing-card__content">
            <a
                    class="listivo-panel-listing-card__label"
                    href="<?php echo esc_url($lstCurrentListing->getUrl()); ?>"
                    target="_blank"
            >
                <?php echo esc_html($lstCurrentListing->getName()); ?>
            </a>

            <div class="listivo-panel-listing-card__meta-wrapper">
                <div class="listivo-panel-listing-card__meta">
                    <?php if ($lstCurrentListing->hasExpireDate() && tdf_settings()->paymentsEnabled()) : ?>
                        <div class="listivo-panel-listing-card__meta-data">
                            <span>
                                <?php echo esc_html(tdf_string('added')); ?>:
                            </span>

                            <?php echo esc_html($lstCurrentListing->getPublishDate()) ?>
                        </div>

                        <div class="listivo-panel-listing-card__meta-data">
                            <span>
                                <?php echo esc_html(tdf_string('expires')); ?>:
                            </span>

                            <?php echo esc_html($lstCurrentListing->getExpireDateText()) ?>
                        </div>

                        <?php if ($lstCurrentListing->hasFeaturedExpireDate()) : ?>
                            <div class="listivo-panel-listing-card__meta-data">
                                <span>
                                    <?php echo esc_html(tdf_string('featured_expires')); ?>:
                                </span>

                                <?php echo esc_html($lstCurrentListing->getFeaturedExpireDateText()); ?>
                            </div>
                        <?php endif; ?>
                    <?php else : ?>
                        <div class="listivo-panel-listing-card__meta-data">
                            <span>
                                <?php echo esc_html(tdf_string('added')); ?>:
                            </span>

                            <?php echo esc_html($lstCurrentListing->getPublishDate()) ?>
                        </div>

                        <?php if ($lstCurrentListing->getPublishDate() !== $lstCurrentListing->getModifiedDate()) : ?>
                            <div class="listivo-panel-listing-card__meta-data">
                                <span>
                                    <?php echo esc_html(tdf_string('modified')); ?>:
                                </span>

                                <?php echo esc_html($lstCurrentListing->getModifiedDate()); ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (!empty($lstMainValue)) : ?>
                <div class="listivo-panel-listing-card__value">
                    <?php echo wp_kses_post($lstMainValue); ?>
                </div>
            <?php endif; ?>

            <div class="listivo-panel-listing-card__attributes-wrapper">
                <div class="listivo-panel-listing-card__attributes">
                    <div class="listivo-panel-listing-card__attribute listivo-notice">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="11" viewBox="0 0 15 11" fill="none">
                            <path d="M7.5 0C2.04545 0 0 5.45455 0 5.45455C0 5.45455 2.04545 10.9091 7.5 10.9091C12.9545 10.9091 15 5.45455 15 5.45455C15 5.45455 12.9545 0 7.5 0ZM7.5 1.36364C11.0973 1.36364 12.9168 4.27302 13.5059 5.45188C12.9161 6.62256 11.083 9.54545 7.5 9.54545C3.90273 9.54545 2.08323 6.63607 1.49414 5.45721C2.0846 4.28653 3.91705 1.36364 7.5 1.36364ZM7.5 2.72727C5.99386 2.72727 4.77273 3.94841 4.77273 5.45455C4.77273 6.96068 5.99386 8.18182 7.5 8.18182C9.00614 8.18182 10.2273 6.96068 10.2273 5.45455C10.2273 3.94841 9.00614 2.72727 7.5 2.72727ZM7.5 4.09091C8.25341 4.09091 8.86364 4.70114 8.86364 5.45455C8.86364 6.20795 8.25341 6.81818 7.5 6.81818C6.74659 6.81818 6.13636 6.20795 6.13636 5.45455C6.13636 4.70114 6.74659 4.09091 7.5 4.09091Z"
                                  fill="#455867"/>
                        </svg>

                        <?php echo esc_html($lstCurrentListing->getViews()); ?>

                        <div class="listivo-notice__content">
                            <?php echo esc_html(tdf_string('views')); ?>
                        </div>
                    </div>

                    <div class="listivo-panel-listing-card__attribute listivo-notice">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="15" viewBox="0 0 10 15" fill="none">
                            <path d="M2.33008 0C1.40477 0 0.642578 0.762187 0.642578 1.6875V13.3125C0.642578 14.2378 1.40477 15 2.33008 15H7.95508C8.88039 15 9.64258 14.2378 9.64258 13.3125V1.6875C9.64258 0.762187 8.88039 0 7.95508 0H2.33008ZM2.33008 1.125H7.95508C8.27252 1.125 8.51758 1.37006 8.51758 1.6875V13.3125C8.51758 13.6299 8.27252 13.875 7.95508 13.875H2.33008C2.01264 13.875 1.76758 13.6299 1.76758 13.3125V1.6875C1.76758 1.37006 2.01264 1.125 2.33008 1.125ZM5.14258 2.25C4.99339 2.25 4.85032 2.30926 4.74483 2.41475C4.63934 2.52024 4.58008 2.66332 4.58008 2.8125C4.58008 2.96168 4.63934 3.10476 4.74483 3.21025C4.85032 3.31574 4.99339 3.375 5.14258 3.375C5.29176 3.375 5.43484 3.31574 5.54033 3.21025C5.64581 3.10476 5.70508 2.96168 5.70508 2.8125C5.70508 2.66332 5.64581 2.52024 5.54033 2.41475C5.43484 2.30926 5.29176 2.25 5.14258 2.25ZM4.20508 11.625C4.13054 11.6239 4.05654 11.6377 3.98737 11.6655C3.9182 11.6933 3.85524 11.7346 3.80216 11.7869C3.74908 11.8392 3.70692 11.9016 3.67815 11.9704C3.64938 12.0392 3.63457 12.113 3.63457 12.1875C3.63457 12.262 3.64938 12.3358 3.67815 12.4046C3.70692 12.4734 3.74908 12.5358 3.80216 12.5881C3.85524 12.6404 3.9182 12.6817 3.98737 12.7095C4.05654 12.7373 4.13054 12.7511 4.20508 12.75H6.08008C6.15462 12.7511 6.22862 12.7373 6.29779 12.7095C6.36696 12.6817 6.42992 12.6404 6.483 12.5881C6.53608 12.5358 6.57823 12.4734 6.607 12.4046C6.63577 12.3358 6.65059 12.262 6.65059 12.1875C6.65059 12.113 6.63577 12.0392 6.607 11.9704C6.57823 11.9016 6.53608 11.8392 6.483 11.7869C6.42992 11.7346 6.36696 11.6933 6.29779 11.6655C6.22862 11.6377 6.15462 11.6239 6.08008 11.625H4.20508Z"
                                  fill="#455867"/>
                        </svg>

                        <?php echo esc_html($lstCurrentListing->getRevealPhoneCounter()); ?>

                        <div class="listivo-notice__content">
                            <?php echo esc_html(tdf_string('phone_reveal')); ?>
                        </div>
                    </div>

                    <div class="listivo-panel-listing-card__attribute listivo-notice">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="14" viewBox="0 0 15 14" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M0 4.24289C0 1.90639 1.85342 0 4.125 0C5.42866 0 6.56369 0.719937 7.5 1.9429C8.43631 0.719937 9.57134 0 10.875 0C13.1466 0 15 1.90639 15 4.24289C15 5.82285 13.8421 7.31046 12.4307 8.83609C11.6206 9.71165 10.7033 10.5936 9.80691 11.4554C9.14141 12.0953 8.48749 12.724 7.89771 13.3306C7.67803 13.5565 7.32197 13.5565 7.10229 13.3306C6.51251 12.724 5.85859 12.0953 5.19309 11.4554C4.29675 10.5936 3.37938 9.71165 2.56934 8.83609C1.15787 7.31046 0 5.82285 0 4.24289ZM7.02484 3.20183C6.13755 1.75833 5.2234 1.15723 4.12518 1.15723C2.46152 1.15723 1.12518 2.53175 1.12518 4.24297C1.12518 5.17017 2.02982 6.57544 3.38397 8.03912C4.15614 8.87374 5.04565 9.73171 5.93302 10.5876C6.46475 11.1005 6.99571 11.6126 7.50018 12.1185C8.00466 11.6126 8.53562 11.1005 9.06735 10.5876C9.95471 9.73171 10.8442 8.87374 11.6164 8.03912C12.9705 6.57544 13.8752 5.17017 13.8752 4.24297C13.8752 2.53175 12.5388 1.15723 10.8752 1.15723C9.77697 1.15723 8.86282 1.75833 7.97552 3.20183C7.8724 3.36942 7.69301 3.471 7.50018 3.471C7.30736 3.471 7.12797 3.36942 7.02484 3.20183Z"
                                  fill="#455867"/>
                        </svg>

                        <?php echo esc_html($lstCurrentListing->getFavoriteCount()); ?>

                        <div class="listivo-notice__content">
                            <?php echo esc_html(tdf_string('added_to_favorites')); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="listivo-panel-listing-card__actions">
            <div class="listivo-panel-listing-card__buttons">
                <a
                        class="listivo-panel-listing-card__action"
                        href="<?php echo esc_url($lstCurrentListing->getUrl()) ?>"
                        target="_blank"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16" fill="none">
                        <path d="M1.40301 0C0.631356 0 0 0.631357 0 1.40301V12.6271C0 13.3988 0.631356 14.0301 1.40301 14.0301H5.275C4.9453 13.6092 4.6927 13.1392 4.51732 12.6271H1.40301V1.40301H9.8211V5.63261L11.2241 5.92034V1.40301C11.2241 0.631357 10.5928 0 9.8211 0H1.40301ZM2.80603 3.50754V4.91055H8.41809V3.50754H2.80603ZM2.80603 6.31357V7.71658H5.275C5.69591 7.14134 6.23591 6.66432 6.86025 6.31357H2.80603ZM9.47035 7.01507C8.5591 7.01507 7.7121 7.33389 7.05069 7.87415C6.16982 8.57804 5.61206 9.66561 5.61206 10.8734C5.61206 11.0178 5.62062 11.1628 5.63809 11.305C5.85355 13.2299 7.49114 14.7317 9.47035 14.7317C10.2803 14.7317 11.0324 14.479 11.6543 14.0493L13.008 15.403L14 14.411L12.6463 13.0574C13.076 12.4354 13.3286 11.6833 13.3286 10.8734C13.3286 8.74909 11.5946 7.01507 9.47035 7.01507ZM9.8211 8.45234C11.0189 8.62083 11.9256 9.62449 11.9256 10.8734C11.9256 12.2426 10.8396 13.3286 9.47035 13.3286C8.22351 13.3286 7.21949 12.4153 7.04795 11.2241H9.8211V8.45234ZM2.80603 9.11959V10.5226H4.22959C4.25064 10.0316 4.34896 9.56154 4.51732 9.11959H2.80603Z"
                              fill="#2A3946"/>
                    </svg>

                    <?php echo esc_html(tdf_string('view')); ?>
                </a>

                <a
                        class="listivo-panel-listing-card__action"
                        href="<?php echo esc_url($lstCurrentListing->getEditUrl()); ?>"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="16" viewBox="0 0 15 16" fill="none">
                        <path d="M1.70809 0C0.771452 0 0 0.771452 0 1.70809V11.9566C0 12.8933 0.771452 13.6647 1.70809 13.6647H4.58382V12.526H1.70809C1.38757 12.526 1.13873 12.2771 1.13873 11.9566V1.70809C1.13873 1.38757 1.38757 1.13873 1.70809 1.13873H6.83236V4.55491H10.2485V5.69363H11.3873V3.74979L7.63748 0H1.70809ZM7.97109 1.94384L9.44343 3.41618H7.97109V1.94384ZM12.7617 6.83681C12.3873 6.8392 12.0137 6.98483 11.7342 7.2705L6.46984 12.6261L5.66694 16L9.03864 15.1971L9.15207 15.0859L14.3964 9.93495C14.9703 9.37409 14.9748 8.43609 14.4076 7.86878L13.7982 7.25938C13.5143 6.97552 13.1379 6.83441 12.7617 6.83681ZM12.7684 7.96886C12.8477 7.96836 12.9285 7.99991 12.993 8.0645L13.6024 8.67389C13.7298 8.80121 13.7302 8.994 13.6002 9.12093V9.12316L8.46928 14.1607L7.20378 14.4632L7.50403 13.1999L12.546 8.06895L12.5482 8.06672C12.6112 8.00193 12.6891 7.96937 12.7684 7.96886Z"
                              fill="#2A3946"/>
                    </svg>

                    <?php echo esc_html(tdf_string('edit')); ?>
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
                            class="listivo-panel-listing-card__action listivo-panel-listing-card__action--delete"
                            slot-scope="props"
                            @click.prevent="props.onDelete"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16" fill="none">
                            <path d="M3.69231 2.96154H4.19231V2.46154V1.84135C4.19231 1.10787 4.80018 0.5 5.53365 0.5H8.00481C8.73828 0.5 9.34615 1.10787 9.34615 1.84135V2.46154V2.96154H9.84615H13.0385V3.19231H12.3077H11.8077V3.69231V14.1538C11.8077 14.8921 11.1998 15.5 10.4615 15.5H3.07692C2.33864 15.5 1.73077 14.8921 1.73077 14.1538V3.69231V3.19231H1.23077H0.5V2.96154H3.69231ZM8.61539 2.96154H9.11539V2.46154V1.84135C9.11539 1.21905 8.62711 0.730769 8.00481 0.730769H5.53365C4.91136 0.730769 4.42308 1.21905 4.42308 1.84135V2.46154V2.96154H4.92308H8.61539ZM2.46154 3.19231H1.96154V3.69231V14.1538C1.96154 14.7761 2.45463 15.2692 3.07692 15.2692H10.4615C11.0838 15.2692 11.5769 14.7761 11.5769 14.1538V3.69231V3.19231H11.0769H2.46154ZM4.42308 13.0385H4.19231V5.42308H4.42308V13.0385ZM6.88462 13.0385H6.65385V5.42308H6.88462V13.0385ZM9.34615 13.0385H9.11539V5.42308H9.34615V13.0385Z"
                                  fill="#2A3946" stroke="#2A3946"/>
                        </svg>

                        <?php echo esc_html(tdf_string('delete')); ?>
                    </button>
                </lst-delete-model>
            </div>

            <?php if ($lstCurrentListing->isDraft()) : ?>
                <div class="listivo-panel-listing-card__button">
                    <a
                            class="listivo-button listivo-button--primary-1"
                        <?php if (tdf_settings()->paymentsEnabled()) : ?>
                            href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_SELECT_PACKAGE)); ?>?id=<?php echo esc_attr($lstCurrentListing->getId()); ?>"
                        <?php else : ?>
                            href="<?php echo esc_url(tdf_action_url('listivo/panel/model/publish')); ?>&id=<?php echo esc_attr($lstCurrentListing->getId()); ?>"
                        <?php endif; ?>
                    >
                        <span>
                            <?php echo esc_html(tdf_string('publish')); ?>

                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                 fill="none">
                                <path d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49605 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455586 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z"
                                      fill="#FDFDFE"/>
                            </svg>
                        </span>
                    </a>
                </div>
            <?php endif; ?>

            <?php if (!$lstCurrentListing->isFeatured() && $lstCurrentListing->isPublished() && tdf_settings()->paymentsEnabled()) : ?>
                <div class="listivo-panel-listing-card__button">
                    <a
                            class="listivo-button listivo-button--primary-1"
                            href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_PROMOTE)); ?>?id=<?php echo esc_attr($lstCurrentListing->getId()); ?>"
                    >
                        <span>
                            <?php echo esc_html(tdf_string('promote')); ?>

                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                 fill="none">
                                <path d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49605 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455586 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z"
                                      fill="#FDFDFE"/>
                            </svg>
                        </span>
                    </a>
                </div>
            <?php endif; ?>

            <?php if ($lstCurrentListing->isFeatured() && $lstCurrentListing->isPublished() && tdf_settings()->paymentsEnabled()) : ?>
                <div class="listivo-panel-listing-card__button">
                    <a
                            class="listivo-button listivo-button--primary-1"
                            href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_EXTEND)); ?>?id=<?php echo esc_attr($lstCurrentListing->getId()); ?>"
                    >
                        <span>
                            <?php echo esc_html(tdf_string('extend')); ?>

                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                 fill="none">
                                <path d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49605 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455586 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z"
                                      fill="#FDFDFE"/>
                            </svg>
                        </span>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>