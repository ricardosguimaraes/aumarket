<?php


namespace Tangibledesign\Framework\Models\Field;


use Tangibledesign\Framework\Models\Field\Helpers\HasDisplayValueWithFieldName;
use Tangibledesign\Framework\Models\Field\Helpers\HasDisplayValueWithFieldNameInterface;
use Tangibledesign\Framework\Search\Field\NumberSearchField;
use Tangibledesign\Framework\Search\HasQueryModifier;
use Tangibledesign\Framework\Search\Query\NumberQueryModifier;
use Tangibledesign\Framework\Search\QueryModifier\QueryModifier;
use Tangibledesign\Framework\Search\Searchable;
use Tangibledesign\Framework\Search\SearchField;
use Tangibledesign\Framework\Models\Field\Helpers\HasInputPlaceholder;
use Tangibledesign\Framework\Models\Field\Helpers\HasInputPlaceholderInterface;
use Tangibledesign\Framework\Models\Field\Helpers\HasSlug;
use Tangibledesign\Framework\Models\Field\Helpers\HasSlugInterface;
use Tangibledesign\Framework\Models\Field\Helpers\HasTextAfterValue;
use Tangibledesign\Framework\Models\Field\Helpers\HasTextBeforeValue;
use Tangibledesign\Framework\Models\Field\Helpers\SimpleTextValue;

/**
 * Class NumberField
 * @package Tangibledesign\Framework\Models\Field
 */
class NumberField extends Field implements HasSlugInterface, HasInputPlaceholderInterface, SimpleTextValue, Searchable, HasQueryModifier, HasDisplayValueWithFieldNameInterface, HasRestApiValue
{
    use HasSlug;
    use HasInputPlaceholder;
    use HasTextBeforeValue;
    use HasTextAfterValue;
    use HasDisplayValueWithFieldName;

    public const DECIMAL_PLACES = 'decimal_places';
    public const HIDE_THOUSANDS_SEPARATOR = 'hide_thousands_separator';

    /**
     * @param int $decimalPlaces
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setDecimalPlaces($decimalPlaces): void
    {
        $this->setMeta(self::DECIMAL_PLACES, (int)$decimalPlaces);
    }

    /**
     * @return int
     */
    public function getDecimalPlaces(): int
    {
        $decimalPlaces = (int)$this->getMeta(self::DECIMAL_PLACES);

        if ($decimalPlaces < 0) {
            return 0;
        }

        return $decimalPlaces;
    }

    /**
     * @param int $hideThousandsSeparator
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setHideThousandsSeparator($hideThousandsSeparator): void
    {
        $this->setMeta(self::HIDE_THOUSANDS_SEPARATOR, (int)$hideThousandsSeparator);
    }

    /**
     * @return bool
     */
    public function hideThousandsSeparator(): bool
    {
        return !empty((int)$this->getMeta(self::HIDE_THOUSANDS_SEPARATOR));
    }

    /**
     * @return array
     */
    public function getSettingKeys(): array
    {
        return array_merge(parent::getSettingKeys(), [
            self::SLUG,
            self::INPUT_PLACEHOLDER,
            self::TEXT_BEFORE_VALUE,
            self::TEXT_AFTER_VALUE,
            self::DECIMAL_PLACES,
            self::HIDE_THOUSANDS_SEPARATOR,
            self::DISPLAY_VALUE_WITH_FIELD_NAME,
        ]);
    }

    /**
     * @param Fieldable $fieldable
     * @return string
     */
    public function getValue(Fieldable $fieldable): string
    {
        if (!$this->isValueVisible()) {
            return '';
        }

        return $fieldable->getMeta($this->getKey());
    }

    /**
     * @param Fieldable $fieldable
     * @param mixed $value
     * @return bool
     */
    public function setValue(Fieldable $fieldable, $value): bool
    {
        return $fieldable->setMeta($this->getKey(), $this->formattedToRaw($value));
    }

    /**
     * @param string $value
     * @return string
     * @noinspection PhpMissingParamTypeInspection
     */
    private function formattedToRaw($value): string
    {
        return (string)str_replace(tdf_settings()->getDecimalSeparator(), '.', $value);
    }

    /**
     * @param $value
     * @return string
     */
    public function rawToFormatted($value): string
    {
        if ($value === '') {
            return '';
        }

        return number_format(
            (float)$value,
            $this->getDecimalPlaces(),
            tdf_settings()->getDecimalSeparator(),
            $this->getThousandsSeparator()
        );
    }

    /**
     * @return string
     */
    private function getThousandsSeparator(): string
    {
        if ($this->hideThousandsSeparator()) {
            return '';
        }

        return tdf_settings()->getThousandsSeparator();
    }

    /**
     * @param $value
     * @return string
     */
    public function getFormattedValue($value): string
    {
        if ($value === '') {
            return $value;
        }

        return $this->getFormattedWithoutName($value);
    }

    /**
     * @param $value
     * @return string
     */
    public function getFormattedWithoutName($value): string
    {
        if ($value === '') {
            return $value;
        }

        $value = $this->rawToFormatted($value);


        if (!empty($this->getTextBeforeValue())) {
            $value = $this->getTextBeforeValue() . $value;
        }

        if (!empty($this->getTextAfterValue())) {
            $value .= $this->getTextAfterValue();
        }

        return $value;
    }

    /**
     * @param Fieldable $fieldable
     * @param bool $label
     * @return array|string[]
     */
    public function getSimpleTextValue(Fieldable $fieldable, bool $label = false): array
    {
        $value = $this->getValue($fieldable);
        if (empty($value)) {
            return [];
        }

        $value = $this->getFormattedValue($value);
        if (empty($value)) {
            return [];
        }

        if (!$label) {
            return [$value];
        }

        return [$this->getName() . ': ' . $value];
    }

    /**
     * @param array $config
     * @return SearchField
     */
    public function getSearchField(array $config): SearchField
    {
        return new NumberSearchField($this, $config);
    }

    /**
     * @return QueryModifier
     */
    public function getQueryModifier(): QueryModifier
    {
        return new NumberQueryModifier($this);
    }

    /**
     * @return string
     */
    public function getTypeLabel(): string
    {
        return tdf_admin_string('number');
    }

    /**
     * @return int[]
     */
    public function getAdditionalJsonData(): array
    {
        return [
            'decimalPlaces' => $this->getDecimalPlaces(),
        ];
    }

    /**
     * @param Fieldable $fieldable
     * @return mixed|string
     */
    public function getRestApiValue(Fieldable $fieldable)
    {
        return $this->getSimpleTextValue($fieldable);
    }

}