<?php


namespace Tangibledesign\Framework\Widgets\Helpers\Controls;


use Elementor\Controls_Manager;
use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Field\LocationField;

/**
 * Trait LocationFieldControl
 * @package Tangibledesign\Framework\Widgets\Helpers\Controls
 */
trait LocationFieldControl
{
    use Control;

    protected function addLocationFieldControl(): void
    {
        $options = $this->getLocationFieldOptions();
        if (empty($options)) {
            $this->addNoLocationFieldsControl();
            return;
        }

        if (count($options) === 1) {
            $this->addHiddenLocationFieldControl(key($options));
            return;
        }

        $this->add_control(
            'location_field',
            [
                'label' => tdf_admin_string('location_field'),
                'type' => Controls_Manager::SELECT,
                'options' => $options,
                'default' => key($options),
            ]
        );
    }

    private function addNoLocationFieldsControl(): void
    {
        $this->add_control(
            'no_location_fields',
            [
                'label' => tdf_admin_string('create_location_field'),
                'type' => Controls_Manager::HEADING,
            ]
        );
    }

    /**
     * @param int $locationFieldId
     * @noinspection PhpMissingParamTypeInspection
     */
    private function addHiddenLocationFieldControl($locationFieldId): void
    {
        $this->add_control(
            'location_field',
            [
                'label' => tdf_admin_string('location_field'),
                'type' => Controls_Manager::HIDDEN,
                'default' => $locationFieldId,
            ]
        );
    }

    /**
     * @return array
     */
    private function getLocationFieldOptions(): array
    {
        $options = [];

        foreach (tdf_location_fields() as $field) {
            $options[$field->getId()] = $field->getName();
        }

        foreach (tdf_text_fields() as $field) {
            $options[$field->getId()] = $field->getName();
        }

        return $options;
    }

    /**
     * @return LocationField|false
     */
    public function getLocationField()
    {
        $locationFieldId = (int)$this->get_settings_for_display('location_field');
        if (empty($locationFieldId)) {
            return false;
        }
        
        return tdf_fields()->find(static function ($field) use ($locationFieldId) {
            /* @var Field $field */
            return $field->getId() === $locationFieldId && $field instanceof LocationField;
        });
    }

}