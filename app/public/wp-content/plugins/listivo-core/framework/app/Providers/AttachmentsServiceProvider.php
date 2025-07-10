<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Attachment;

class AttachmentsServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('admin_post_nopriv_' . tdf_prefix() . '/attachments/info', [$this, 'info']);
        add_action('admin_post_' . tdf_prefix() . '/attachments/info', [$this, 'info']);

        add_action('admin_post_nopriv_' . tdf_prefix() . '/attachments/upload', [$this, 'upload']);
        add_action('admin_post_' . tdf_prefix() . '/attachments/upload', [$this, 'upload']);
    }

    public function info(): void
    {
        if (empty($_POST['attachments']) || !is_array($_POST['attachments'])) {
            return;
        }

        echo json_encode(tdf_query_attachments()->in($_POST['attachments'])->get()->map(static function ($attachment) {
            /* @var Attachment $attachment */
            return [
                'mcID' => $attachment->getId(),
                'name' => $attachment->getName(),
                'url' => $attachment->getIconUrl(),
                'src' => $attachment->getIconUrl(),
                'size' => $attachment->getFilesSize(),
            ];
        })->values(), JSON_THROW_ON_ERROR);
    }

    public function upload(): void
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], tdf_prefix() . '_upload_attachment')) {
            return;
        }

        echo esc_html(self::uploadAttachment());
    }

    /**
     * @return int
     * @noinspection DuplicatedCode
     */
    public static function uploadAttachment(): int
    {
        $file = wp_handle_upload($_FILES['file'], ['test_form' => false]);

        $attachment = [
            'guid' => $file['url'],
            'post_mime_type' => $file['type'],
            'post_title' => preg_replace('/\.[^.]+$/', '', basename($file['url'])),
            'post_content' => '',
            'post_status' => 'inherit'
        ];

        $attachmentId = wp_insert_attachment($attachment, $file['file']);

        if (is_wp_error($attachmentId)) {
            return 0;
        }

        update_post_meta($attachmentId, tdf_prefix() . '_source', 'panel');

        require_once(ABSPATH . 'wp-admin/includes/image.php');

        $attachmentData = wp_generate_attachment_metadata($attachmentId, $file['file']);
        wp_update_attachment_metadata($attachmentId, $attachmentData);

        return $attachmentId;
    }

}