<?php

namespace Tangibledesign\Listivo\Providers\Blog;

use Tangibledesign\Framework\Core\ServiceProvider;

class BlogCardSettingsServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function initiation(): void
    {
        $this->container['blog_card_default_image_size'] = static function () {
            return [
                'key' => 'listivo_360_240',
                'width' => 360,
                'height' => 240,
            ];
        };

        $this->container['blog_card_image_size'] = static function () {
            if (!tdf_current_kit()) {
                return tdf_app('blog_card_default_image_size');
            }

            /** @noinspection NullPointerExceptionInspection */
            $imageSizeKey = tdf_current_kit()->get_settings_for_display('listivo_blog_card_image_size');
            if (empty($imageSizeKey)) {
                return tdf_app('blog_card_default_image_size');
            }

            foreach (tdf_app('image_sizes') as $key => $imageSize) {
                if ($imageSizeKey === $key) {
                    return [
                        'key' => $key,
                        'width' => $imageSize['width'],
                        'height' => $imageSize['height'],
                    ];
                }
            }

            return tdf_app('blog_card_default_image_size');
        };

        $this->container['blog_card_hide_user'] = static function () {
            if (!tdf_current_kit()) {
                return false;
            }

            /** @noinspection NullPointerExceptionInspection */
            return !empty(tdf_current_kit()->get_settings_for_display('blog_card_hide_user'));
        };

        $this->container['blog_card_hide_publish_date'] = static function () {
            if (!tdf_current_kit()) {
                return false;
            }

            /** @noinspection NullPointerExceptionInspection */
            return !empty(tdf_current_kit()->get_settings_for_display('blog_card_hide_publish_date'));
        };
    }

}