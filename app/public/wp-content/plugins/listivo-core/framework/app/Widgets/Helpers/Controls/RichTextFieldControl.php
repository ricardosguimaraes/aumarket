<?php


namespace Tangibledesign\Framework\Widgets\Helpers\Controls;


use Elementor\Controls_Manager;
use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Field\RichTextField;

/**
 * Trait RichTextFieldControl
 * @package Tangibledesign\Framework\Widgets\Helpers\Controls
 */
trait RichTextFieldControl
{
    use Control;

    protected function addRichTextFieldControl(): void
    {
        $options = $this->getRichTextFieldOptions();

        if (empty($options)) {
            $this->addNoRichTextFieldControl();
            return;
        }

        if (count($options) === 1) {
            $this->addHiddenRichTextField(key($options));
            return;
        }

        $this->add_control(
            'rich_text_field',
            [
                'label' => tdf_admin_string('rich_text_field'),
                'type' => Controls_Manager::SELECT,
                'options' => $options,
                'default' => key($options),
            ]
        );
    }

    /**
     * @return array
     */
    private function getRichTextFieldOptions(): array
    {
        $options = [];

        foreach (tdf_fields() as $field) {
            if ($field instanceof RichTextField) {
                $options[$field->getId()] = $field->getName();
            }
        }

        return $options;
    }

    /**
     * @param int $richTextFieldId
     * @noinspection PhpMissingParamTypeInspection
     */
    private function addHiddenRichTextField($richTextFieldId): void
    {
        $this->add_control(
            'rich_text_field',
            [
                'label' => tdf_admin_string('rich_text_field'),
                'type' => Controls_Manager::HIDDEN,
                'default' => $richTextFieldId,
            ]
        );
    }

    private function addNoRichTextFieldControl(): void
    {
        $this->add_control(
            'no_rich_text_field',
            [
                'label' => tdf_admin_string('create_rich_text_field'),
                'type' => Controls_Manager::HEADING,
            ]
        );
    }

    /**
     * @return RichTextField|false
     */
    public function getRichTextField()
    {
        $fieldId = (int)$this->get_settings_for_display('rich_text_field');

        if (empty($fieldId)) {
            return false;
        }

        return tdf_fields()->find(static function ($field) use ($fieldId) {
            /* @var Field $field */
            return $field->getId() === $fieldId && $field instanceof RichTextField;
        });
    }

}