<?php

namespace Tangibledesign\Framework\Actions\Images;

class UploadImageAction
{
    public function execute(string $key, string $source = 'panel'): ?int
    {
        $file = $this->handleUpload($key);
        if (!$file) {
            return null;
        }

        $imageId = $this->insertAttachment($file);
        if (is_wp_error($imageId)) {
            return null;
        }

        $this->updateAttachmentMeta($imageId, $source);

        if (!empty($file['file'])) {
            $this->updateAttachmentMetadata($imageId, $file['file']);
        }

        return $imageId;
    }

    private function handleUpload(string $key): ?array
    {
        return wp_handle_upload($_FILES[$key], ['test_form' => false]);
    }

    private function insertAttachment(array $file): ?int
    {
        return wp_insert_attachment([
            'guid' => $file['url'],
            'post_mime_type' => $file['type'],
            'post_title' => preg_replace('/\.[^.]+$/', '', basename($file['url'])),
            'post_content' => '',
            'post_status' => 'inherit'
        ], $file['file']);
    }

    private function updateAttachmentMeta(int $imageId, string $source): void
    {
        update_post_meta($imageId, tdf_prefix() . '_source', $source);
    }

    private function updateAttachmentMetadata(int $imageId, string $filePath): void
    {
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        wp_update_attachment_metadata($imageId, wp_generate_attachment_metadata($imageId, $filePath));
    }
}