<?php

namespace Tangibledesign\Listivo\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\Helpers\SimpleTextValue;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Widgets\Helpers\Controls\Control;

trait ListingAttributesControl
{
    use Control;

    /**
     * @return Model|false
     */
    abstract public function getModel();

    private function addFieldsControl(): void
    {
        $fields = new Repeater();

        $options = $this->getFieldOptions();

        $fields->add_control(
            'id',
            [
                'label' => esc_html__('Field', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => $options,
            ]
        );

        $fields->add_control(
            'show_label',
            [
                'label' => esc_html__('Display Label', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );

        $fields->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'listivo-core'),
                'type' => Controls_Manager::ICONS,
            ]
        );

        $this->add_control(
            'fields',
            [
                'label' => esc_html__('Fields', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $fields->get_controls(),
            ]
        );
    }

    private function getFieldOptions(): array
    {
        $options = [];

        foreach (tdf_simple_text_value_fields() as $field) {
            $options[$field->getId()] = $field->getName();
        }

        return $options;
    }

    public function getAttributes(): Collection
    {
        $listing = $this->getModel();
        if (!$listing) {
            return tdf_collect();
        }

        $fields = $this->get_settings_for_display('fields');
        if (!is_array($fields) || empty($fields)) {
            return tdf_collect();
        }

        return tdf_collect($fields)->map(static function (array $field) use ($listing) {
            $fieldId = (int)$field['id'];

            $simpleTextValueField = tdf_simple_text_value_fields()->find(static function ($field) use ($fieldId) {
                /* @var SimpleTextValue $field */
                return $field->getId() === $fieldId;
            });

            if (!$simpleTextValueField instanceof SimpleTextValue) {
                return false;
            }

            $value = $simpleTextValueField->getSimpleTextValue($listing);
            if (empty($value)) {
                return false;
            }

            $field['value'] = $value;
            $field['label'] = $simpleTextValueField->getName();

            return $field;
        })->filter(static function ($field) {
            return $field !== false && $field !== null;
        });
    }
}