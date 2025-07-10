<?php

namespace Tangibledesign\Framework\Models\Field;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Attachment;

class AttachmentsField extends Field implements HasRestApiValue
{
    public const MAX_FILE_NUMBER = 'max_file_number';
    public const MAX_FILE_SIZE = 'max_file_size';

    /**
     * @param  int  $number
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setMaxFileNumber($number): void
    {
        $this->setMeta(self::MAX_FILE_NUMBER, (int)$number);
    }

    /**
     * @return int
     */
    public function getMaxFileNumber(): int
    {
        $number = (int)$this->getMeta(self::MAX_FILE_NUMBER);

        if (empty($number)) {
            return 5;
        }

        return $number;
    }

    public function setMaxFileSize($fileSize): void
    {
        $this->setMeta(self::MAX_FILE_SIZE, (int)$fileSize);
    }

    public function getMaxFileSize(): int
    {
        $fileSize = $this->getMeta(self::MAX_FILE_SIZE);

        if (empty($fileSize)) {
            return 8;
        }

        return $fileSize;
    }

    /**
     * @return array
     */
    public function getSettingKeys(): array
    {
        return array_merge(parent::getSettingKeys(), [
            self::MAX_FILE_SIZE,
            self::MAX_FILE_NUMBER,
        ]);
    }

    /**
     * @param  Fieldable  $fieldable
     * @return array
     */
    public function getValue(Fieldable $fieldable): array
    {
        if (!$this->isValueVisible()) {
            return [];
        }

        $attachmentIds = $fieldable->getMeta($this->getKey());

        if (!is_array($attachmentIds)) {
            return [];
        }

        return array_map(static function ($id) {
            return (int)$id;
        }, $attachmentIds);
    }

    /**
     * @param  Fieldable  $fieldable
     * @param  mixed  $value
     * @return bool
     */
    public function setValue(Fieldable $fieldable, $value): bool
    {
        return $fieldable->setMeta($this->getKey(), $value);
    }

    /**
     * @param  Fieldable  $fieldable
     * @return Collection|Attachment[]
     */
    public function getAttachments(Fieldable $fieldable): Collection
    {
        return tdf_collect($this->getValue($fieldable))
            ->map(static function ($attachmentId) {
                return tdf_post_factory()->create($attachmentId);
            })->filter(static function ($attachment) {
                return $attachment !== false && $attachment !== null;
            });
    }

    /**
     * @return string
     */
    public function getTypeLabel(): string
    {
        return tdf_admin_string('attachments');
    }

    public function getRestApiValue(Fieldable $fieldable)
    {
        $value = [];

        foreach ($this->getAttachments($fieldable) as $attachment) {
            $value[] = $attachment->getUrl();
        }

        return $value;
    }

}