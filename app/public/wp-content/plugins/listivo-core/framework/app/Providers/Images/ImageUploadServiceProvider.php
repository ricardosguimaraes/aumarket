<?php

namespace Tangibledesign\Framework\Providers\Images;

use Tangibledesign\Framework\Actions\Images\UploadImageAction;
use Tangibledesign\Framework\Core\ServiceProvider;

class ImageUploadServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('admin_post_' . tdf_prefix() . '/images/upload', [$this, 'upload']);
        add_action('admin_post_nopriv_' . tdf_prefix() . '/images/upload', [$this, 'upload']);
    }

    public function upload(): void
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], tdf_prefix() . '_upload_image')) {
            return;
        }

        echo (new UploadImageAction())->execute('file', $this->getSource());
    }

    private function getSource(): string
    {
        return $_POST['source'] ?? 'panel';
    }
}