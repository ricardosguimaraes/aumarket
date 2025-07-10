<?php

namespace Tangibledesign\Listivo\Widgets\PrintModel;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\Helpers\SimpleTextValue;
use Tangibledesign\Framework\Widgets\Helpers\Controls\MarginControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SimpleLabelControl;

class PrintListingAttributesWidget extends BasePrintModelWidget
{
    use SimpleLabelControl;
    use MarginControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'print_listing_attributes';
    }

    public function getName(): string
    {
        return esc_html__('Listing Attributes', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addLabelControl();

        $this->addFieldsControl();

        $this->addMarginControl('.listivo-print-attributes');

        $this->endControlsSection();
    }

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
                'default' => !empty($options) ? key($options) : null,
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

    /**
     * @return array
     */
    private function getFieldOptions(): array
    {
        $options = [];

        foreach (tdf_simple_text_value_fields() as $field) {
            $options[$field->getId()] = $field->getName();
        }

        return $options;
    }

    /**
     * @return Collection
     */
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

        return tdf_collect($fields)
            ->map(static function (array $field) use ($listing) {
                $fieldId = (int)$field['id'];
                $simpleTextValueField = tdf_simple_text_value_fields()
                    ->find(static function ($field) use ($fieldId) {
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

                $field['value'] = implode(', ', $value);
                $field['label'] = $simpleTextValueField->getName();

                return $field;
            })->filter(static function ($field) {
                return $field !== false && $field !== null;
            });
    }

}