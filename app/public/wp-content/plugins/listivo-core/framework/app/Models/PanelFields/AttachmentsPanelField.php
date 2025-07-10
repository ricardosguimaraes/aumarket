<?php

namespace Tangibledesign\Framework\Models\PanelFields;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\AttachmentsField;
use Tangibledesign\Framework\Models\Model;

class AttachmentsPanelField extends CustomPanelField
{
    /**
     * @var AttachmentsField
     */
    protected $field;

    /**
     * @return string
     */
    protected function getTemplate(): string
    {
        return 'attachments';
    }

    /**
     * @param Model $model
     * @param array $data
     */
    public function update(Model $model, array $data = []): void
    {
        $attachmentIds = $this->getValue($data);

        global $wpdb;
        $table = $wpdb->prefix . 'posts';

        foreach ($attachmentIds as $attachmentId) {
            update_post_meta($attachmentId, tdf_prefix() . '_attachments', $model->getId());

            $wpdb->update($table,
                [
                    'post_parent' => $model->getId(),
                ],
                [
                    'ID' => $attachmentId,
                ]
            );
        }

        $this->field->setValue($model, $attachmentIds);
    }

    /**
     * @param array $data
     *
     * @return array
     */
    private function getValue(array $data): array
    {
        $attribute = $this->getAttributeData($data);

        if ($attribute === false || !isset($attribute['value']) || !is_array($attribute['value'])) {
            return [];
        }

        return Collection::make($attribute['value'])->map(static function ($attachmentId) {
            return (int)$attachmentId;
        })->values();
    }

    /**
     * @return bool
     */
    public function isSingleValue(): bool
    {
        return false;
    }

    /**
     * @return array
     */
    public function getDropZoneConfig(): array
    {
        return [
            'url' => tdf_action_url(tdf_prefix() . '/attachments/upload'),
            'thumbnailWidth' => 200,
            'addRemoveLinks' => true,
            'dictDefaultMessage' => '<i class="fas fa-paperclip"></i> ' . esc_attr(tdf_string('add_attachments')),
            'parallelUploads' => 1,
            'maxFiles' => $this->field->getMaxFileNumber(),
            'maxFilesize' => $this->field->getMaxFileSize(),
            'timeout' => 180000,
            'dictFileTooBig' => str_replace(['[currentFilesize]', '[maxFilesize]'], ['{{filesize}}', '{{maxFilesize}}'], tdf_string('dropzone_too_big')),
        ];
    }

    /**
     * @param array $data
     *
     * @return bool
     */
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
            'value' => $this->field->getValue($model)
        ];
    }

}