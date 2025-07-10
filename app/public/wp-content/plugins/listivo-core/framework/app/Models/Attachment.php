<?php

namespace Tangibledesign\Framework\Models;

use Tangibledesign\Framework\Models\Post\Post;
use WP_Error;

/**
 * Class Attachment
 * @package Tangibledesign\Framework\Models
 */
class Attachment extends Post
{
    public function getUrl(): string
    {
        $url = wp_get_attachment_url($this->getId());
        if ($url instanceof WP_Error) {
            return '';
        }

        return $url;
    }

    public function getFileName(): string
    {
        return basename($this->getFile());
    }

    public function getFile(): string
    {
        return get_attached_file($this->getId());
    }

    /**
     * @return false|string
     */
    public function getType()
    {
        $url = $this->getUrl();
        if (!$url) {
            return false;
        }

        $type = wp_check_filetype($this->getUrl());

        return $type['ext'] ?? false;
    }

    public function getIconUrl(): string
    {
        $type = $this->getType();

        if (!$type) {
            return get_template_directory_uri() . '/assets/img/other_file_type.svg';
        }

        if ($type === 'pdf') {
            return get_template_directory_uri() . '/assets/img/pdf.svg';
        }

        if ($type === 'png') {
            return get_template_directory_uri() . '/assets/img/png.svg';
        }

        if ($type === 'jpg' || $type === 'jpeg') {
            return get_template_directory_uri() . '/assets/img/jpg.svg';
        }

        if ($type === 'doc') {
            return get_template_directory_uri() . '/assets/img/doc.svg';
        }

        if ($type === 'zip') {
            return get_template_directory_uri() . '/assets/img/zip.svg';
        }

        if ($type === 'xls') {
            return get_template_directory_uri() . '/assets/img/xls.svg';
        }

        return get_template_directory_uri() . '/assets/img/other_file_type.svg';
    }

    public function getAssignedPostId(): ?int
    {
        $parentId = wp_get_post_parent_id($this->getId());
        if ($parentId) {
            return $parentId;
        }

        return null;
    }

    public function getFilesSize(): int
    {
        $fileSize = filesize($this->getFile());
        if ($fileSize === false) {
            return 0;
        }

        return $fileSize;
    }
}