<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

$cardAttributeIds = tdf_settings()->getListingCardAttributeIds();
?>
<div id="tdf-card" class="tdf-content-section">
    <div class="tdf-content-section__left">
        <h2><?php esc_html_e('Listing Card', 'listivo-core'); ?></h2>
    </div>

    <div class="tdf-content-section__right">
        <div class="tdf-field">
            <label for="<?php echo esc_attr(SettingKey::LISTING_CARD_ATTRIBUTES); ?>">
                <i class="fas fa-list"></i> <?php esc_html_e('Fields displayed on the cards', 'listivo-core'); ?>
            </label>

            <select
                    name="<?php echo esc_attr(SettingKey::LISTING_CARD_ATTRIBUTES); ?>[]"
                    id="<?php echo esc_attr(SettingKey::LISTING_CARD_ATTRIBUTES); ?>"
                    class="tdf-selectize tdf-selectize-init"
                    multiple
            >
                <?php foreach (tdf_settings()->getListingCardAttributes() as $field) : ?>
                    <option
                            value="<?php echo esc_attr($field->getId()); ?>"
                            selected
                    >
                        <?php echo esc_html($field->getName()); ?>
                    </option>
                <?php endforeach; ?>

                <?php foreach (tdf_simple_text_value_fields() as $field) :
                    if (in_array($field->getId(), $cardAttributeIds, true)) {
                        continue;
                    }
                    ?>
                    <option value="<?php echo esc_attr($field->getId()); ?>">
                        <?php echo esc_html($field->getName()); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="tdf-field">
            <label for="<?php echo esc_attr(SettingKey::LISTING_CARD_LABEL); ?>">
                <?php esc_html_e('Card Labels', 'listivo-core'); ?>
            </label>

            <select
                    name="<?php echo esc_attr(SettingKey::LISTING_CARD_LABEL); ?>[]"
                    id="<?php echo esc_attr(SettingKey::LISTING_CARD_LABEL); ?>"
                    class="tdf-selectize tdf-selectize-init"
                    multiple
            >
                <?php
                $labelOptions = tdf_settings()->getListingCardLabel();
                foreach ($labelOptions as $option) :
                    if ($option === 'featured') : ?>
                        <option value="featured" selected>
                            <?php esc_html_e('Featured', 'listivo-core'); ?>
                        </option>
                    <?php else :
                        $taxonomy = tdf_taxonomy_fields()->find(static function ($taxonomy) use ($option) {
                            /* @var  \Tangibledesign\Framework\Models\Field\TaxonomyField $taxonomy */
                            return $taxonomy->getId() === $option;
                        });

                        if ($taxonomy) :?>
                            <option
                                    value="<?php echo esc_attr($taxonomy->getId()); ?>"
                                    selected
                            >
                                <?php echo esc_html($taxonomy->getName()); ?>
                            </option>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>

                <?php if (!in_array('featured', $labelOptions, true)) : ?>
                    <option value="featured">
                        <?php esc_html_e('Featured', 'listivo-core'); ?>
                    </option>
                <?php endif; ?>

                <?php foreach (tdf_taxonomy_fields() as $taxonomyField) : ?>
                    <?php if (!in_array($taxonomyField->getId(), $labelOptions, true)) : ?>
                        <option value="<?php echo esc_attr($taxonomyField->getId()); ?>">
                            <?php echo esc_html($taxonomyField->getName()); ?>
                        </option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>

        <?php if (tdf_currency_fields()->count() === 1) : ?>
            <input
                    type="hidden"
                    name="<?php echo esc_attr(SettingKey::LISTING_CARD_MAIN_VALUE_FIELDS); ?>"
                    value="<?php echo esc_attr(tdf_currency_fields()->first()->getId()); ?>"
            >
        <?php else : ?>
            <div class="tdf-field">
                <label for="<?php echo esc_attr(SettingKey::LISTING_CARD_MAIN_VALUE_FIELDS); ?>">
                    <i class="fas fa-coins"></i> <?php esc_html_e('Price/Salary Field', 'listivo-core'); ?>
                </label>

                <select
                        id="<?php echo esc_attr(SettingKey::LISTING_CARD_MAIN_VALUE_FIELDS); ?>"
                        name="<?php echo esc_attr(SettingKey::LISTING_CARD_MAIN_VALUE_FIELDS); ?>[]"
                        class="tdf-selectize tdf-selectize-init"
                        multiple
                >
                    <?php foreach (tdf_currency_fields() as $field) : ?>
                        <option
                                value="<?php echo esc_attr($field->getId()); ?>"
                            <?php if (in_array($field->getId(), tdf_settings()->getListingCardMainFieldIds(), true)) : ?>
                                selected
                            <?php endif; ?>
                        >
                            <?php echo esc_html($field->getName()); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>

        <?php if (tdf_gallery_fields()->count() === 1) : ?>
            <input
                    type="hidden"
                    name="<?php echo esc_attr(SettingKey::LISTING_CARD_GALLERY_FIELD); ?>"
                    value="<?php echo esc_attr(tdf_gallery_fields()->first()->getId()); ?>"
            >
        <?php else : ?>
            <div class="tdf-field">
                <label for="<?php echo esc_attr(SettingKey::LISTING_CARD_GALLERY_FIELD); ?>">
                    <?php esc_html_e('Gallery Field', 'listivo-core'); ?>
                </label>

                <select
                        name="<?php echo esc_attr(SettingKey::LISTING_CARD_GALLERY_FIELD); ?>"
                        id="<?php echo esc_attr(SettingKey::LISTING_CARD_GALLERY_FIELD); ?>"
                        class="tdf-selectize tdf-selectize-init"
                >
                    <?php foreach (tdf_gallery_fields() as $galleryField) : ?>
                        <option
                                value="<?php echo esc_attr($galleryField->getId()); ?>"
                            <?php if (tdf_settings()->getListingCardGalleryFieldId() === $galleryField->getId()) : ?>
                                selected
                            <?php endif; ?>
                        >
                            <?php echo esc_html($galleryField->getName()); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>

        <div class="tdf-field">
            <label for="<?php echo esc_attr(SettingKey::LISTING_CARD_LOCATION); ?>">
                <i class="fas fa-map-marker-alt"></i> <?php esc_html_e('Type of location (cards/single listing page)', 'listivo-core'); ?>
            </label>

            <select
                    name="<?php echo esc_attr(SettingKey::LISTING_CARD_LOCATION); ?>[]"
                    id="<?php echo esc_attr(SettingKey::LISTING_CARD_LOCATION); ?>"
                    class="tdf-selectize tdf-selectize-init"
                    multiple
            >
                <?php foreach (tdf_settings()->getSelectedListingCardLocationFields() as $field) : ?>
                    <option
                            value="<?php echo esc_attr($field['id']); ?>"
                            selected
                    >
                        <?php echo esc_html($field['label']); ?>
                    </option>
                <?php endforeach; ?>

                <?php if (!in_array('user_location', tdf_settings()->getListingCardLocation(), true)): ?>
                    <option value="user_location">
                        <?php esc_attr_e('User Location', 'listivo-core'); ?>
                    </option>
                <?php endif; ?>

                <?php foreach (tdf_settings()->getNotSelectedListingCardLocationFields() as $field): ?>
                    <option value="<?php echo esc_attr($field->getId()); ?>">
                        <?php echo esc_html($field->getName()); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="tdf-checkbox">
            <input
                    name="<?php echo esc_attr(SettingKey::LISTING_CARD_SHOW_USER); ?>"
                    id="<?php echo esc_attr(SettingKey::LISTING_CARD_SHOW_USER); ?>"
                    type="checkbox"
                    value="1"
                <?php if (tdf_settings()->showUserOnCard()) : ?>
                    checked
                <?php endif; ?>
            >

            <label for="<?php echo esc_attr(SettingKey::LISTING_CARD_SHOW_USER); ?>">
                <?php esc_html_e('Display user name and avatar', 'listivo-core'); ?>
            </label>
        </div>

        <div class="tdf-checkbox">
            <input
                    name="<?php echo esc_attr(SettingKey::LISTING_CARD_GALLERY); ?>"
                    id="<?php echo esc_attr(SettingKey::LISTING_CARD_GALLERY); ?>"
                    type="checkbox"
                    value="1"
                <?php if (tdf_settings()->isListingCardGalleryEnabled()) : ?>
                    checked
                <?php endif; ?>
            >

            <label for="<?php echo esc_attr(SettingKey::LISTING_CARD_GALLERY); ?>">
                <?php esc_html_e('Gallery', 'listivo-core'); ?>
            </label>
        </div>


        <div class="tdf-field">
            <label for="<?php echo esc_attr(SettingKey::LISTING_CARD_GALLERY_IMAGE_NUMBER); ?>">
                <?php esc_html_e('Max Image Number', 'listivo-core'); ?>
            </label>

            <input
                    name="<?php echo esc_attr(SettingKey::LISTING_CARD_GALLERY_IMAGE_NUMBER); ?>"
                    id="<?php echo esc_attr(SettingKey::LISTING_CARD_GALLERY_IMAGE_NUMBER); ?>"
                    type="text"
                    value="<?php echo esc_attr(tdf_app('card_max_number_of_images')); ?>"
            >
        </div>

        <div class="tdf-field">
            <label for="<?php echo esc_attr(SettingKey::LISTING_CARD_IMAGE_SIZE); ?>">
                <?php esc_html_e('Standard Card Image Size', 'listivo-core'); ?>
            </label>

            <select
                    name="<?php echo esc_attr(SettingKey::LISTING_CARD_IMAGE_SIZE); ?>"
                    id="<?php echo esc_attr(SettingKey::LISTING_CARD_IMAGE_SIZE); ?>"
                    class="tdf-selectize tdf-selectize-init"
            >
                <?php foreach (tdf_app('image_sizes') as $size => $data) : ?>
                    <option
                            value="<?php echo esc_attr($size); ?>"
                        <?php if (tdf_settings()->getListingCardImageSize() === $size) : ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php echo esc_html($size); ?> (<?php echo esc_html($data['width'] . 'x' . $data['height']); ?>)
                    </option>
                <?php endforeach; ?>
            </select>

            <div>
                <?php esc_html_e('This option change image size and proportion on the standard listing card. It do not change "Row Card". If you need custom thumbnail size, please read this article:', 'listivo-core'); ?>

                <a target="_blank" href="https://support.listivotheme.com/support/solutions/articles/101000373834">
                    <?php esc_html_e('How do I create a thumbnail size?', 'listivo-core'); ?>
                </a>
            </div>
        </div>

        <?php tdf_load_view('dashboard/partials/save_changes_button'); ?>
    </div>
</div>