<?php


namespace Tangibledesign\Framework\Search\Field;


use Tangibledesign\Framework\Models\Field\NumberField;

/**
 * Class NumberSearchField
 * @package Tangibledesign\Framework\Search\Field
 */
class NumberSearchField extends BaseSearchField
{
    public const CONTROL = 'number_control';
    public const CONTROL_SELECT = 'select';
    public const CONTROL_RADIO = 'radio';
    public const CONTROL_TEXT_INPUT_RANGE = 'text_input_range';
    public const PLACEHOLDER = 'number_placeholder';
    public const PLACEHOLDER_FROM = 'number_placeholder_from';
    public const PLACEHOLDER_TO = 'number_placeholder_to';
    public const COMPARE_TYPE = 'number_compare_type';
    public const COMPARE_TYPE_GREATER = 'greater';
    public const COMPARE_TYPE_LESS = 'less';
    public const COMPARE_TYPE_EQUAL = 'equal';
    public const VALUES = 'number_values';
    public const ADD_GREATER_THAN_VALUE = 'number_add_greater_than_value';

    /**
     * @var array
     */
    protected $field;

    /**
     * @var array
     */
    protected $config;

    /**
     * NumberSearchField constructor.
     * @param NumberField $field
     * @param array $config
     */
    public function __construct(NumberField $field, array $config)
    {
        $this->field = $field;

        $this->config = $config;
    }

    /**
     * @return string
     */
    public function getControl(): string
    {
        return $this->config[self::CONTROL] ?? self::CONTROL_TEXT_INPUT_RANGE;
    }

    /**
     * @return string
     */
    public function getPlaceholder(): string
    {
        $placeholder = $this->config[self::PLACEHOLDER] ?? '';

        if (empty($placeholder)) {
            return $this->field->getName();
        }

        return $placeholder;
    }

    /**
     * @return string
     */
    public function getPlaceholderFrom(): string
    {
        $placeholder = $this->config[self::PLACEHOLDER_FROM] ?? '';

        if (empty($placeholder)) {
            return tdf_string('min') . ' ' . $this->field->getName();
        }

        return $placeholder;
    }

    /**
     * @return string
     */
    public function getPlaceholderTo(): string
    {
        $placeholder = $this->config[self::PLACEHOLDER_TO] ?? '';

        if (empty($placeholder)) {
            return tdf_string('max') . ' ' . $this->field->getName();
        }

        return $placeholder;
    }

    /**
     * @return string
     */
    public function getCompareType(): string
    {
        return $this->config[self::COMPARE_TYPE] ?? self::COMPARE_TYPE_GREATER;
    }

    /**
     * @return string
     */
    public function getSelectCompareType(): string
    {
        $compareType = $this->getCompareType();

        if ($compareType === self::COMPARE_TYPE_GREATER) {
            return '_from';
        }

        if ($compareType === self::COMPARE_TYPE_LESS) {
            return '_to';
        }

        return '';
    }

    /**
     * @return array
     */
    private function getNumberValues(): array
    {
        $values = explode(',', $this->config[self::VALUES]);
        if (!is_array($values) || empty($values)) {
            return [];
        }

        return tdf_collect($values)->map(static function ($value) {
            return trim($value);
        })->values();
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        $options = [];

        foreach ($this->getNumberValues() as $value) {
            $options[] = [
                'name' => $this->getFormattedValue($this->field->getFormattedWithoutName($value)),
                'value' => $value,
                'compareType' => $this->getCompareType(),
            ];
        }

        if (!$this->addGreaterThanValue()) {
            return $options;
        }

        return $this->getGreaterThanValue($options);
    }

    /**
     * @param $value
     * @return string
     */
    private function getFormattedValue($value): string
    {
        $compareType = $this->getCompareType();

        if ($this->getCompareType() === self::COMPARE_TYPE_GREATER) {
            return $value . '+';
        }

        if ($compareType === self::COMPARE_TYPE_LESS) {
            return '< ' . $value;
        }

        return $value;
    }

    /**
     * @param array $values
     * @return array
     */
    private function getGreaterThanValue(array $values): array
    {
        $option = end($values);
        if (!$option) {
            return $values;
        }

        $values[] = [
            'name' => $this->field->getFormattedWithoutName($option['value']) . '+',
            'value' => $option['value'],
            'compareType' => self::COMPARE_TYPE_GREATER,
        ];

        return $values;
    }

    /**
     * @param mixed $value
     * @return string
     */
    private function formatValue($value): string
    {
        if (empty($value)) {
            return $value;
        }

        if (!empty($this->field->getTextBeforeValue())) {
            $value = $this->field->getTextBeforeValue() . $value;
        }

        if (!empty($this->field->getTextAfterValue())) {
            $value .= $this->field->getTextAfterValue();
        }

        return $value;
    }

    /**
     * @return bool
     */
    public function addGreaterThanValue(): bool
    {
        return !empty($this->config[self::ADD_GREATER_THAN_VALUE]) && $this->getCompareType() === self::COMPARE_TYPE_LESS;
    }

    /**
     * @return bool
     */
    public function isSelectControl(): bool
    {
        return $this->getControl() === self::CONTROL_SELECT;
    }

    /**
     * @return bool
     */
    public function isRadioControl(): bool
    {
        return $this->getControl() === self::CONTROL_RADIO;
    }

    /**
     * @return bool
     */
    public function isTextInputRangeControl(): bool
    {
        return $this->getControl() === self::CONTROL_TEXT_INPUT_RANGE;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return parent::jsonSerialize() + [
                'name' => $this->field->getName(),
                'displayBefore' => $this->field->getTextBeforeValue(),
                'displayAfter' => $this->field->getTextAfterValue(),
            ];
    }

}