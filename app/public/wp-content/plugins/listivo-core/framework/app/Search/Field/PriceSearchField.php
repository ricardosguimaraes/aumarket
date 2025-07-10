<?php


namespace Tangibledesign\Framework\Search\Field;


use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Currency;
use Tangibledesign\Framework\Models\Field\PriceField;

/**
 * Class PriceSearchField
 * @package Tangibledesign\Framework\Search\Field
 */
class PriceSearchField extends BaseSearchField
{
    public const CONTROL = 'price_control';
    public const CONTROL_TEXT_INPUT_RANGE = 'text_input_range';
    public const CONTROL_SELECT = 'select';
    public const CONTROL_SELECT_RANGE = 'select_range';
    public const CONTROL_RADIO = 'radio';
    public const COMPARE_TYPE = 'price_compare_type';
    public const COMPARE_TYPE_LESS = 'less';
    public const COMPARE_TYPE_GREATER = 'greater';
    public const PLACEHOLDER = 'price_placeholder';
    public const PLACEHOLDER_FROM = 'price_placeholder_from';
    public const PLACEHOLDER_TO = 'price_placeholder_to';
    public const PRICE_VALUES = 'price_values_';
    public const PRICE_VALUES_FROM = 'price_values_from_';
    public const PRICE_VALUES_TO = 'price_values_to_';

    /**
     * @var PriceField
     */
    protected $field;

    /**
     * @var array
     */
    protected $config;

    /**
     * PriceSearchField constructor.
     * @param PriceField $field
     * @param array $config
     */
    public function __construct(PriceField $field, array $config)
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
    public function getCompareType(): string
    {
        return $this->config[self::COMPARE_TYPE] ?? self::COMPARE_TYPE_GREATER;
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
    public function isSelectRangeControl(): bool
    {
        return $this->getControl() === self::CONTROL_SELECT_RANGE;
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
    public function getSelectOptions(): array
    {
        return $this->getOptions(self::PRICE_VALUES);
    }

    /**
     * @return array
     */
    public function getSelectFromOptions(): array
    {
        return $this->getOptions(self::PRICE_VALUES_FROM);
    }

    /**
     * @return array
     */
    public function getSelectToOptions(): array
    {
        return $this->getOptions(self::PRICE_VALUES_TO, self::COMPARE_TYPE_LESS);
    }

    /**
     * @param string $key
     * @param string $compare
     * @return array
     */
    private function getOptions(string $key, string $compare = ''): array
    {
        $options = [];

        $currency = tdf_app('current_currency');
        if (!$currency instanceof Currency) {
            return $options;
        }

        $key .= $currency->getKey();

        return $this->getSelectOptionValues($key)
            ->map(function ($value) use ($currency, $compare) {
                return [
                    'name' => $this->getFormattedValue($this->field->rawToFormatted($value, $currency), $compare),
                    'value' => $value,
                ];
            })
            ->values();
    }

    /**
     * @param $value
     * @param string $compareType
     * @return string
     */
    private function getFormattedValue($value, string $compareType = ''): string
    {
        if (empty($compareType)) {
            $compareType = $this->getCompareType();
        }

        if ($compareType === self::COMPARE_TYPE_GREATER) {
            return $value . '+';
        }

        if ($compareType === self::COMPARE_TYPE_LESS) {
            return '< ' . $value;
        }

        return $value;
    }

    /**
     * @param string $key
     * @return Collection
     */
    private function getSelectOptionValues(string $key): Collection
    {
        if (!isset($this->config[$key])) {
            return tdf_collect();
        }

        $values = explode(',', $this->config[$key]);
        if (!is_array($values) || empty($values)) {
            return tdf_collect();
        }

        return tdf_collect($values)->map(static function ($value) {
            return trim($value);
        });
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return parent::jsonSerialize() + [
                'currencySign' => tdf_current_currency()->getSign(),
                'currencySignPosition' => tdf_current_currency()->getSignPosition(),
                'displayBefore' => $this->field->getTextBeforeValue(),
                'displayAfter' => $this->field->getTextAfterValue(),
            ];
    }

}