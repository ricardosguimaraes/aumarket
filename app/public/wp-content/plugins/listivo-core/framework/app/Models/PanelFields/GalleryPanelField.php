<?php

namespace Tangibledesign\Framework\Models\PanelFields;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\GalleryField;
use Tangibledesign\Framework\Models\Model;

class GalleryPanelField extends CustomPanelField
{
    /**
     * @var GalleryField
     */
    protected $field;

    protected function getTemplate(): string
    {
        return 'gallery';
    }

    public function update(Model $model, array $data = []): void
    {
        $imageIds = $this->getValue($data);

        global $wpdb;
        $table = $wpdb->prefix . 'posts';

        foreach ($imageIds as $imageId) {
            update_post_meta($imageId, tdf_prefix() . '_gallery', $model->getId());

            $wpdb->update($table,
                [
                    'post_parent' => $model->getId(),
                ],
                [
                    'ID' => $imageId,
                ]
            );
        }

        $this->field->setValue($model, $imageIds);
    }

    private function getValue(array $data): array
    {
        $attributeData = $this->getAttributeData($data);
        if ($attributeData === false || !isset($attributeData['value']) || !is_array($attributeData['value'])) {
            return [];
        }

        return Collection::make($attributeData['value'])
            ->map(static function ($imageId) {
                $image = get_post($imageId);
                if (!$image) {
                    return false;
                }

                return (int)$imageId;
            })
            ->filter(static function ($imageId) {
                return $imageId !== false && $imageId !== null;
            })
            ->values();
    }

    public function isSingleValue(): bool
    {
        return false;
    }

    public function getDropZoneConfig(): array
    {
        return [
            'url' => tdf_action_url(tdf_prefix() . '/images/upload'),
            'thumbnailWidth' => 200,
            'addRemoveLinks' => true,
            'dictDefaultMessage' => '',
            'parallelUploads' => 1,
            'acceptedFiles' => 'image/jpeg,image/png,image/gif,image/webp',
            'maxFiles' => $this->field->getMaxImageNumber(),
            'maxFilesize' => $this->field->getMaxFileSize(),
            'timeout' => 180000,
            'maxThumbnailFilesize' => $this->field->getMaxFileSize(),
            'dictFileTooBig' => str_replace(['[currentFilesize]', '[maxFilesize]'], ['{{filesize}}', '{{maxFilesize}}'], tdf_string('dropzone_too_big')),
            'dictMaxFilesExceeded' => tdf_string('dropzone_max_files_exceeded'),
        ];
    }

    public function validate(array $data): bool
    {
        if (!$this->isRequired()) {
            return true;
        }

        return !empty($this->getValue($data));
    }

    /**
     * @param Model $model
     * @return mixed
     */
    public function getModelAttribute(Model $model)
    {
        return [
            'id' => $this->field->getId(),
            'value' => tdf_collect($this->field->getValue($model))
                ->map(static function ($imageId) {
                    $image = get_post($imageId);
                    if (!$image) {
                        return false;
                    }

                    return $imageId;
                })
                ->filter(static function ($image) {
                    return !empty($image);
                })
                ->values()
        ];
    }
}