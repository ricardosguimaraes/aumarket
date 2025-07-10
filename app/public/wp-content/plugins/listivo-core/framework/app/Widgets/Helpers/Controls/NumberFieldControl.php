<?php


namespace Tangibledesign\Framework\Widgets\Helpers\Controls;


use Elementor\Controls_Manager;
use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Field\NumberField;

/**
 * Trait NumberFieldControl
 * @package Tangibledesign\Framework\Widgets\Helpers\Controls
 */
trait NumberFieldControl
{
    use Control;

    protected function addNumberFieldControl(): void
    {
        $options = $this->getNumberFieldOptions();

        if (empty($options)) {
            $this->addNoNumberFieldControl();
            return;
        }

        if (count($options) === 1) {
            $this->addHiddenNumberField(key($options));
            return;
        }

        $this->add_control(
            'number_field',
            [
                'label' => tdf_admin_string('number_field'),
                'type' => Controls_Manager::SELECT,
                'options' => $options,
                'default' => key($options),
            ]
        );
    }

    /**
     * @return array
     */
    private function getNumberFieldOptions(): array
    {
        $options = [];

        foreach (tdf_fields() as $field) {
            if ($field instanceof NumberField) {
                $options[$field->getId()] = $field->getName();
            }
        }

        return $options;
    }

    /**
     * @param int $numberFieldId
     * @noinspection PhpMissingParamTypeInspection
     */
    private function addHiddenNumberField($numberFieldId): void
    {
        $this->add_control(
            'number_field',
            [
                'label' => tdf_admin_string('number_field'),
                'type' => Controls_Manager::HIDDEN,
                'default' => $numberFieldId,
            ]
        );
    }

    private function addNoNumberFieldControl(): void
    {
        $this->add_control(
            'no_number_field',
            [
                'label' => tdf_admin_string('create_number_field'),
                'type' => Controls_Manager::HEADING,
            ]
        );
    }

    /**
     * @return NumberField|false
     */
    public function getNumberField()
    {
        $fieldId = (int)$this->get_settings_for_display('number_field');

        if (empty($fieldId)) {
            return false;
        }

        return tdf_fields()->find(static function ($field) use ($fieldId) {
            /* @var Field $field */
            return $field->getId() === $fieldId && $field instanceof NumberField;
        });
    }

}