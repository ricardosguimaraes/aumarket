<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Addons\WPAllImport;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Field\AttachmentsField;
use Tangibledesign\Framework\Models\Field\EmbedField;
use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Field\GalleryField;
use Tangibledesign\Framework\Models\Field\LinkField;
use Tangibledesign\Framework\Models\Field\LocationField;
use Tangibledesign\Framework\Models\Field\NumberField;
use Tangibledesign\Framework\Models\Field\PriceField;
use Tangibledesign\Framework\Models\Field\RichTextField;
use Tangibledesign\Framework\Models\Field\TextField;

class WPAllImportServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('admin_footer', static function () {
            if (!defined('PMXI_VERSION')) {
                return;
            }
            ?>
            <script>
                jQuery(document).ready(function () {
                    if (jQuery('input[name=records_per_request]').length > 0) {
                        jQuery('input[name=records_per_request]').val(1)
                    }

                    if (jQuery('.wpallimport-featured-images .wpallimport-collapsed-content-inner').length > 0) {
                        jQuery('.wpallimport-featured-images .wpallimport-collapsed-content-inner').prepend('<a href="<?php echo esc_url(apply_filters('tdf/wpAllImporter/imagesDocUrl', '')); ?>" target="_blank" class="<?php echo esc_attr(tdf_prefix()); ?>-wp-allimport-doc-link">Click here to read <?php echo esc_html(tdf_app('name')); ?> Documentation - How to Import Images?</a>')
                    }

                    if (jQuery('[rel=taxonomies_hints]').length > 0) {
                        jQuery('[rel=taxonomies_hints]').after('<div style="margin: 10px 90px 20px 0; font-size: 18px; line-height: 28px;"><i class="fas fa-info-circle"></i> <strong><?php echo esc_html(tdf_app('name')); ?> has its own Taxonomy Hierarchy System</strong>. If you have some kind of hierarchy in your database (e.g. Make > Model) you can Connect Terms (Parent/Child) just after import this way - <a target="_blank" href="<?php echo esc_url(apply_filters('tdf/wpAllImporter/parentChildDocUrl', '')); ?>/">click here</a>.</div>')
                    }
                });
            </script>
            <?php
        });

        add_action('init', function () {
            if (!defined('PMXI_VERSION')) {
                return;
            }

            $addon = new WPAllImport('Custom Fields: Text Fields, Number Fields, Price, Location, Embed', tdf_prefix());
            $addon->run(['themes' => [tdf_app('name')]]);

            tdf_ordered_fields()->each(function ($field) use ($addon) {
                /* @var Field $field */
                if ($field instanceof TextField || $field instanceof NumberField || $field instanceof RichTextField || $field instanceof LinkField) {
                    $this->addRegularField($field, $addon);
                } elseif ($field instanceof PriceField) {
                    $this->addPriceField($field, $addon);
                } elseif ($field instanceof GalleryField) {
                    $this->addGalleryField($field, $addon);
                } elseif ($field instanceof AttachmentsField) {
                    $this->addAttachmentField($field, $addon);
                } elseif ($field instanceof LocationField) {
                    $this->addLocationField($field, $addon);
                } elseif ($field instanceof EmbedField) {
                    $this->addEmbedField($field, $addon);
                }
            });

            $addon->set_import_function([$this, 'import']);
        }, 100);

        add_filter('wp_all_import_config_options', static function ($options) {
            $options['chunk_size'] = 1;
            $options['log_storage'] = 1;
            $options['large_feed_limit'] = 1;

            return $options;
        });

        add_action('pmxi_after_xml_import', static function () {
            do_action(tdf_prefix() . '/bugs/featured');
        }, 10, 2);
    }

    /**
     * @param int $postId
     * @param array $data
     * @param $importOptions
     * @param $article
     * @noinspection PhpUnusedParameterInspection
     */
    public function import(int $postId, array $data, $importOptions, $article): void
    {
        if (tdf_number_fields()->isNotEmpty()) {
            foreach (tdf_number_fields() as $numberField) {
                /* @var NumberField $numberField */
                if (isset($data[$numberField->getKey()])) {
                    update_post_meta($postId, $numberField->getKey(), $numberField->getFormattedValue($data[$numberField->getKey()]));
                }
            }
        }

        if (tdf_text_fields()->isNotEmpty()) {
            foreach (tdf_text_fields() as $textField) {
                /* @var TextField $textField */
                if (isset($data[$textField->getKey()])) {
                    update_post_meta($postId, $textField->getKey(), $data[$textField->getKey()]);
                }
            }
        }

        if (tdf_link_fields()->isNotEmpty()) {
            foreach (tdf_link_fields() as $linkField) {
                /* @var LinkField $linkField */
                if (isset($data[$linkField->getKey()])) {
                    update_post_meta($postId, $linkField->getKey(), $data[$linkField->getKey()]);
                }
            }
        }


        if (tdf_rich_text_fields()->isNotEmpty()) {
            foreach (tdf_rich_text_fields() as $richTextField) {
                /* @var RichTextField $richTextField */
                if (isset($data[$richTextField->getKey()])) {
                    update_post_meta($postId, $richTextField->getKey(), $data[$richTextField->getKey()]);
                }
            }
        }

        if (tdf_price_fields()->isNotEmpty()) {
            foreach (tdf_price_fields() as $priceField) {
                /* @var PriceField $priceField */
                foreach (tdf_currencies() as $currency) {
                    $valueKey = $priceField->getValueKey($currency);

                    if (isset($data[$valueKey])) {
                        update_post_meta($postId, $valueKey, $priceField->formattedToRaw($data[$valueKey], $currency));
                    }
                }
            }
        }

        if (tdf_location_fields()->isNotEmpty()) {
            foreach (tdf_location_fields() as $locationField) {
                /* @var LocationField $locationField */
                $locationFieldKey = $locationField->getKey();
                if (isset($data[$locationFieldKey . '_address'], $data[$locationFieldKey . '_lat'], $data[$locationFieldKey . '_lng'])) {
                    update_post_meta($postId, $locationFieldKey . '_address', $data[$locationFieldKey . '_address']);
                    update_post_meta($postId, $locationFieldKey . '_lat', $data[$locationFieldKey . '_lat']);
                    update_post_meta($postId, $locationFieldKey . '_lng', $data[$locationFieldKey . '_lng']);
                }
            }
        }

        if (tdf_embed_fields()->isNotEmpty()) {
            foreach (tdf_embed_fields() as $embedField) {
                /* @var EmbedField $embedField */
                $embedFieldKey = $embedField->getKey();

                if (
                    isset($data[$embedField->getKey() . '_embed'], $data[$embedFieldKey . '_url'])
                    && (!empty($data[$embedField->getKey() . '_embed']) || !empty($data[$embedFieldKey . '_url']))
                ) {
                    update_post_meta($postId, $embedFieldKey, [
                        'embed' => $data[$embedFieldKey . '_embed'],
                        'url' => $data[$embedFieldKey . '_url'],
                    ]);
                }
            }
        }
    }

    /**
     * @param Field $field
     * @param WPAllImport $rapidAddon
     */
    public function addRegularField(Field $field, WPAllImport $rapidAddon): void
    {
        $rapidAddon->add_field($field->getKey(), $field->getName(), 'text');
    }

    /**
     * @param PriceField $priceField
     * @param WPAllImport $rapidAddon
     */
    public function addPriceField(PriceField $priceField, WPAllImport $rapidAddon): void
    {
        foreach (tdf_currencies() as $currency) {
            $valueKey = $priceField->getValueKey($currency);

            $rapidAddon->add_field($valueKey, $priceField->getName() . ' (' . $currency->getSign() . ')', 'text');
        }
    }

    /**
     * @param GalleryField $galleryField
     * @param WPAllImport $rapidAddon
     * @noinspection PhpUnusedParameterInspection
     */
    public function addGalleryField(GalleryField $galleryField, WPAllImport $rapidAddon): void
    {
        $rapidAddon->import_images($galleryField->getKey(), $galleryField->getName() . ' (' . tdf_app('name') . ' Field)', 'images', static function ($postId, $attachmentId, $imageFilepath, $importOptions) use ($galleryField) {
            $value = get_post_meta($postId, $galleryField->getKey(), true);
            if (!is_array($value)) {
                $value = [];
            }

            $value[] = $attachmentId;

            update_post_meta($postId, $galleryField->getKey(), $value);
        });
    }

    /**
     * @param AttachmentsField $attachmentField
     * @param WPAllImport $rapidAddon
     * @noinspection PhpUnusedParameterInspection
     */
    public function addAttachmentField(AttachmentsField $attachmentField, WPAllImport $rapidAddon): void
    {
        $rapidAddon->import_files($attachmentField->getKey(), $attachmentField->getName() . ' (' . tdf_app('name') . ' Field)', static function ($postId, $attachmentId, $imageFilepath, $importOptions) use ($attachmentField) {
            $value = get_post_meta($postId, $attachmentField->getKey(), true);
            if (!is_array($value)) {
                $value = [];
            }

            $value[] = $attachmentId;

            update_post_meta($postId, $attachmentField->getKey(), $value);
        });
    }

    /**
     * @param LocationField $locationField
     * @param WPAllImport $rapidAddon
     */
    public function addLocationField(LocationField $locationField, WPAllImport $rapidAddon): void
    {
        $rapidAddon->add_field($locationField->getKey() . '_lat', $locationField->getName() . ' - Latitude', 'text');

        $rapidAddon->add_field($locationField->getKey() . '_lng', $locationField->getName() . ' - Longitude', 'text');

        $rapidAddon->add_field($locationField->getKey() . '_address', $locationField->getName() . ' - Address', 'text');
    }

    /**
     * @param EmbedField $embedField
     * @param WPAllImport $rapidAddon
     */
    public function addEmbedField(EmbedField $embedField, WPAllImport $rapidAddon): void
    {
        $rapidAddon->add_field($embedField->getKey() . '_embed', $embedField->getName() . ' - embed code (e.g. iframe)', 'text');

        $rapidAddon->add_field($embedField->getKey() . '_url', $embedField->getName() . ' - embed url (e.g. https://****.com )', 'text');
    }

}