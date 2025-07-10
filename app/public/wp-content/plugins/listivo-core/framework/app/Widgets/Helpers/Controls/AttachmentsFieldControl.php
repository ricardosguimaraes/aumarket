<?php


namespace Tangibledesign\Framework\Widgets\Helpers\Controls;


use Elementor\Controls_Manager;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Attachment;
use Tangibledesign\Framework\Models\Field\AttachmentsField;
use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Field\Fieldable;

/**
 * Trait AttachmentsFieldControl
 * @package Tangibledesign\Framework\Widgets\Helpers\Controls
 */
trait AttachmentsFieldControl
{
    use Control;

    protected function addAttachmentsFieldControl(): void
    {
        $options = $this->getAttachmentsFieldOptions();

        if (empty($options)) {
            $this->addNoAttachmentsFieldsControl();
            return;
        }

        if (count($options) === 1) {
            $this->addHiddenAttachmentsFieldControl(key($options));
            return;
        }

        $this->add_control(
            'attachments_field',
            [
                'label' => tdf_admin_string('attachments_field'),
                'type' => Controls_Manager::SELECT,
                'options' => $options,
                'default' => key($options),
            ]
        );
    }

    private function addNoAttachmentsFieldsControl(): void
    {
        $this->add_control(
            'no_attachments_fields',
            [
                'label' => tdf_admin_string('create_attachments_field'),
                'type' => Controls_Manager::HEADING,
            ]
        );
    }

    /**
     * @param int $attachmentsFieldId
     * @noinspection PhpMissingParamTypeInspection
     */
    private function addHiddenAttachmentsFieldControl($attachmentsFieldId): void
    {
        $this->add_control(
            'attachments_field',
            [
                'label' => tdf_admin_string('attachments_field'),
                'type' => Controls_Manager::HIDDEN,
                'default' => $attachmentsFieldId,
            ]
        );
    }

    /**
     * @return array
     */
    private function getAttachmentsFieldOptions(): array
    {
        $options = [];

        foreach (tdf_fields() as $field) {
            if ($field instanceof AttachmentsField) {
                $options[$field->getId()] = $field->getName();
            }
        }

        return $options;
    }

    /**
     * @return AttachmentsField|false
     */
    public function getAttachmentsField()
    {
        $attachmentsFieldId = (int)$this->get_settings_for_display('attachments_field');
        if (empty($attachmentsFieldId)) {
            return false;
        }

        return tdf_fields()->find(static function ($field) use ($attachmentsFieldId) {
            /* @var Field $field */
            return $field->getId() === $attachmentsFieldId;
        });
    }

    /**
     * @return Collection|Attachment[]
     */
    protected function getAttachmentFieldAttachments(Fieldable $fieldable): Collection
    {
        $attachmentsField = $this->getAttachmentsField();
        if (!$attachmentsField) {
            return tdf_collect();
        }

        $attachmentIds = $attachmentsField->getValue($fieldable);
        if (empty($attachmentIds)) {
            return tdf_collect();
        }

        return tdf_query_attachments()->in($attachmentIds)->get();
    }

}