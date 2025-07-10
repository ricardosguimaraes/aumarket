<?php


namespace Tangibledesign\Framework\Widgets\Helpers\Controls;


use Elementor\Controls_Manager;
use Tangibledesign\Framework\Models\Field\EmbedField;
use Tangibledesign\Framework\Models\Field\Field;

/**
 * Trait EmbedFieldControl
 * @package Tangibledesign\Framework\Widgets\Helpers\Controls
 */
trait EmbedFieldControl
{
    use Control;

    protected function addEmbedFieldControl(): void
    {
        $options = $this->getEmbedFieldOptions();

        if (empty($options)) {
            $this->addNoEmbedFieldControl();
            return;
        }

        if (count($options) === 1) {
            $this->addHiddenEmbedFieldControl(key($options));
            return;
        }

        $this->add_control(
            'embed_field',
            [
                'label' => tdf_admin_string('embed_field'),
                'type' => Controls_Manager::SELECT,
                'options' => $options,
                'default' => key($options),
            ]
        );
    }

    /**
     * @param int $embedFieldId
     * @noinspection PhpMissingParamTypeInspection
     */
    private function addHiddenEmbedFieldControl($embedFieldId): void
    {
        $this->add_control(
            'embed_field',
            [
                'label' => tdf_admin_string('embed_field'),
                'type' => Controls_Manager::HIDDEN,
                'default' => $embedFieldId,
            ]
        );
    }

    private function addNoEmbedFieldControl(): void
    {
        $this->add_control(
            'no_embed_field',
            [
                'label' => tdf_admin_string('create_embed_field'),
                'type' => Controls_Manager::HEADING,
            ]
        );
    }

    /**
     * @return array
     */
    private function getEmbedFieldOptions(): array
    {
        $options = [];

        foreach (tdf_fields() as $field) {
            if ($field instanceof EmbedField) {
                $options[$field->getId()] = $field->getName();
            }
        }

        return $options;
    }

    /**
     * @return EmbedField|false
     */
    public function getEmbedField()
    {
        $fieldId = (int)$this->get_settings_for_display('embed_field');
        if (empty($fieldId)) {
            return false;
        }

        $field = tdf_fields()->find(static function ($field) use ($fieldId) {
            /* @var Field $field */
            return $field->getId() === $fieldId;
        });

        if ($field instanceof EmbedField) {
            return $field;
        }

        if (tdf_embed_fields()->count() === 1) {
            return tdf_embed_fields()->first();
        }

        return false;
    }

}