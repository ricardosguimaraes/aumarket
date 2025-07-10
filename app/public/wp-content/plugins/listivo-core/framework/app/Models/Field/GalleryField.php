<?php


namespace Tangibledesign\Framework\Models\Field;


use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Image;

class GalleryField extends Field implements HasRestApiValue
{
    public const MAX_IMAGE_NUMBER = 'max_image_number';
    public const MAX_FILE_SIZE = 'max_file_size';

    /**
     * @param int $number
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setMaxImageNumber($number): void
    {
        $this->setMeta(self::MAX_IMAGE_NUMBER, (int)$number);
    }

    /**
     * @return int
     */
    public function getMaxImageNumber(): int
    {
        $number = (int)$this->getMeta(self::MAX_IMAGE_NUMBER);

        if (empty($number)) {
            return 20;
        }

        return $number;
    }

    /**
     * @param int $fileSize
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setMaxFileSize($fileSize): void
    {
        $this->setMeta(self::MAX_FILE_SIZE, (int)$fileSize);
    }

    /**
     * @return int
     */
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
            self::MAX_IMAGE_NUMBER,
            self::MAX_FILE_SIZE,
        ]);
    }

    /**
     * @param Fieldable $fieldable
     * @return array
     */
    public function getValue(Fieldable $fieldable): array
    {
        if (!$this->isValueVisible()) {
            return [];
        }

        $value = $fieldable->getMeta($this->getKey());
        if (!is_array($value) || empty($value)) {
            return [];
        }

        return array_map(static function ($imageId) {
            return (int)$imageId;
        }, $value);
    }

    /**
     * @param Fieldable $fieldable
     * @param mixed $value
     * @return bool
     */
    public function setValue(Fieldable $fieldable, $value): bool
    {
        return $fieldable->setMeta($this->getKey(), $value);
    }

    /**
     * @param Fieldable $fieldable
     * @param int $limit
     * @return Collection|Image[]
     */
    public function getImages(Fieldable $fieldable, int $limit = 0): Collection
    {
        $values = tdf_collect($this->getValue($fieldable));
        if ($values->isEmpty()) {
            return tdf_collect();
        }

        $query = tdf_query_images()
            ->in($values->values())
            ->orderByIn();

        if (!empty($limit)) {
            $query->take($limit);
        }

        return $query->get();
    }

    /**
     * @param Fieldable $fieldable
     * @return Image|false
     */
    public function getImage(Fieldable $fieldable)
    {
        $value = $this->getValue($fieldable);
        if (empty($value)) {
            return false;
        }

        return tdf_image_factory()->create($value[0]);
    }

    /**
     * @param Fieldable $fieldable
     * @param string $size
     * @return string
     */
    public function getImageUrl(Fieldable $fieldable, string $size = 'full'): string
    {
        $image = $this->getImage($fieldable);
        if (!$image) {
            return '';
        }

        return $image->getImageUrl($size);
    }

    /**
     * @return string
     */
    public function getTypeLabel(): string
    {
        return tdf_admin_string('gallery');
    }

    /**
     * @param Fieldable $fieldable
     * @return array
     */
    public function getRestApiValue(Fieldable $fieldable)
    {
        $value = [];

        foreach ($this->getImages($fieldable) as $image) {
            $value[] = $image->getImageUrl();
        }

        return $value;
    }

}