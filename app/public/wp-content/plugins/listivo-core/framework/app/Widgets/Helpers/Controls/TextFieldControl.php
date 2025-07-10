<?php


namespace Tangibledesign\Framework\Widgets\Helpers\Controls;


use Elementor\Controls_Manager;
use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Field\TextField;

/**
 * Trait TextFieldControl
 * @package Tangibledesign\Framework\Widgets\Helpers\Controls
 */
trait TextFieldControl
{
    use Control;

    protected function addTextFieldControl(): void
    {
        $options = $this->getTextFieldOptions();

        if (empty($options)) {
            $this->addNoTextFieldControl();
            return;
        }

        if (count($options) === 1) {
            $this->addHiddenTextFieldControl(key($options));
            return;
        }

        $this->add_control(
            'text_field',
            [
                'label' => tdf_admin_string('text_field'),
                'type' => Controls_Manager::SELECT,
                'options' => $options,
                'default' => key($options),
            ]
        );
    }

    /**
     * @param int $textFieldId
     * @noinspection PhpMissingParamTypeInspection
     */
    private function addHiddenTextFieldControl($textFieldId): void
    {
        $this->add_control(
            'text_field',
            [
                'label' => tdf_admin_string('text_field'),
                'type' => Controls_Manager::HIDDEN,
                'default' => $textFieldId,
            ]
        );
    }

    private function addNoTextFieldControl(): void
    {
        $this->add_control(
            'no_text_field',
            [
                'label' => tdf_admin_string('create_text_field'),
                'type' => Controls_Manager::HEADING,
            ]
        );
    }

    /**
     * @return array
     */
    private function getTextFieldOptions(): array
    {
        $options = [];

        foreach (tdf_fields() as $field) {
            if ($field instanceof TextField) {
                $options[$field->getId()] = $field->getName();
            }
        }

        return $options;
    }

    /**
     * @return TextField|false
     */
    public function getTextField()
    {
        $fieldId = (int)$this->get_settings_for_display('text_field');

        if (empty($fieldId)) {
            return false;
        }

        return tdf_fields()->find(static function ($field) use ($fieldId) {
            /* @var Field $field */
            return $field->getId() === $fieldId && $field instanceof TextField;
        });
    }

}