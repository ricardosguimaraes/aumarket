<?php

namespace Tangibledesign\Framework\Models;

use JsonSerializable;

class Image extends Attachment implements JsonSerializable
{
    public function getImageUrl(string $size = 'full'): string
    {
        $url = wp_get_attachment_image_url($this->getId(), $size);
        if (!$url) {
            $url = wp_get_attachment_image_url($this->getId(), 'full');
        }

        if (!$url) {
            return '';
        }

        return $url;
    }

    public function getAlt(): string
    {
        return (string)$this->getMeta('_wp_attachment_image_alt');
    }

    public function getWidth(): int
    {
        $data = wp_get_attachment_image_src($this->getId(), 'full');

        if (!$data) {
            return 0;
        }

        return $data[1];
    }

    public function getHeight(): int
    {
        $data = wp_get_attachment_image_src($this->getId(), 'full');

        if (!$data) {
            return 0;
        }

        return $data[2];
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'width' => $this->getWidth(),
            'height' => $this->getHeight(),
            'url' => $this->getImageUrl(),
        ];
    }

    public function getSrcset(string $size): string
    {
        $srcset = wp_get_attachment_image_srcset($this->getId(), $size);
        if ($srcset === false) {
            return '';
        }

        return $srcset;
    }

    public function delete(): void
    {
        wp_delete_attachment($this->getId());
    }
}