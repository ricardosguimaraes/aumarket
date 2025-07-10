<?php

namespace Tangibledesign\Framework\Providers\Images;

use JsonException;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Image;

class ImageServiceProvider extends ServiceProvider
{
    public function initiation(): void
    {
        $this->container['image_sizes'] = static function () {
            if (($imageSizes = get_transient(tdf_prefix() . '/imageSizes')) !== false) {
                return $imageSizes;
            }

            global $_wp_additional_image_sizes;

            $sizes = get_intermediate_image_sizes();
            $output = [];

            foreach ($sizes as $size) {
                $output[$size]['width'] = (int)get_option("{$size}_size_w");
                $output[$size]['height'] = (int)get_option("{$size}_size_h");
                $output[$size]['crop'] = get_option("{$size}_crop") ?: false;
            }

            if (isset($_wp_additional_image_sizes) && count($_wp_additional_image_sizes)) {
                $output = array_merge($output, $_wp_additional_image_sizes);
            }

            set_transient(tdf_prefix() . '/imageSizes', $output, HOUR_IN_SECONDS);

            return $output;
        };

        $this->container['image_size_options'] = static function () {
            $options = [];

            foreach (tdf_app('image_sizes') as $imageKey => $imageSize) {
                $options[$imageKey] = $imageSize['width'] . 'x' . $imageSize['height'] . (!empty($imageSize['crop']) ? ' (Crop)' : '');
            }

            return $options;
        };
    }

    public function afterInitiation(): void
    {
        add_action('after_setup_theme', [$this, 'registerSizes']);
        add_action('admin_post_' . tdf_prefix() . '/images/info', [$this, 'info']);
    }

    /**
     * @throws JsonException
     */
    public function info(): void
    {
        if (empty($_POST['gallery']) || !is_array($_POST['gallery'])) {
            return;
        }

        echo json_encode(tdf_query_images()->in($_POST['gallery'])->orderByIn()->get()->map(static function ($image) {
            /* @var Image $image */
            return [
                'mcID' => $image->getId(),
                'name' => $image->getName(),
                'url' => $image->getImageUrl(),
                'size' => $image->getFilesSize(),
            ];
        })->values(), JSON_THROW_ON_ERROR);
    }

    public function registerSizes(): void
    {
        foreach (apply_filters(tdf_prefix() . '/images/sizes', []) as $size) {
            add_image_size($size['key'], $size['width'], $size['height'], $size['crop']);
        }
    }
}