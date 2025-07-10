<?php


namespace Tangibledesign\Framework\Providers;


use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Helpers\VerifyNonce;

/**
 * Class EmbedPreviewServiceProvider
 * @package Tangibledesign\Framework\Providers
 */
class EmbedPreviewServiceProvider extends ServiceProvider
{
    use VerifyNonce;

    public function afterInitiation(): void
    {
        add_action('admin_post_' . tdf_prefix() . '/embedPreview', [$this, 'preview']);
        add_action('admin_post_nopriv_' . tdf_prefix() . '/embedPreview', [$this, 'preview']);

        add_filter('oembed_result', static function ($data, $url) {
            if (strpos($url, 'facebook') !== false && strpos($url, 'videos') !== false) {
                return '<iframe src="https://www.facebook.com/plugins/video.php?href=' . urlencode($url) . '" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share" allowFullScreen="true"></iframe>';
            }

            return $data;
        }, 10, 2);
    }

    public function preview(): void
    {
        if (!$this->verifyNonce($_POST['nonce'] ?? '', tdf_prefix() . '_embed_preview')) {
            return;
        }

        if (empty($_POST['url'])) {
            return;
        }

        $preview = wp_oembed_get(trim($_POST['url']));

        if ($preview === false && strpos($_POST['url'], '.mp4') !== false) {
            echo '<video controls src="' . $_POST['url'] . '"></video>';
            return;
        }

        echo wp_oembed_get(trim($_POST['url']));
    }

}