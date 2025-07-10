<?php

namespace Tangibledesign\Framework\Models\Field;

use Tangibledesign\Framework\Models\Currency;
use Tangibledesign\Framework\Models\Field\Helpers\HasInputPlaceholder;
use Tangibledesign\Framework\Models\Field\Helpers\HasInputPlaceholderInterface;
use Tangibledesign\Framework\Models\Field\Helpers\HasSlug;
use Tangibledesign\Framework\Models\Field\Helpers\HasSlugInterface;
use Tangibledesign\Framework\Models\Field\Helpers\HasTextAfterValue;
use Tangibledesign\Framework\Models\Field\Helpers\HasTextBeforeValue;
use Tangibledesign\Framework\Models\Field\Helpers\SimpleTextValue;
use Tangibledesign\Framework\Search\Field\SalarySearchField;
use Tangibledesign\Framework\Search\HasQueryModifier;
use Tangibledesign\Framework\Search\Query\SalaryQueryModifier;
use Tangibledesign\Framework\Search\QueryModifier\QueryModifier;
use Tangibledesign\Framework\Search\Searchable;
use Tangibledesign\Framework\Search\SearchField;
use Tangibledesign\Framework\Search\Sortable;

class SalaryField extends Field implements HasSlugInterface, HasInputPlaceholderInterface, SimpleTextValue, Searchable, Sortable, HasQueryModifier, HasRestApiValue
{
    use HasSlug;
    use HasInputPlaceholder;
    use HasTextBeforeValue;
    use HasTextAfterValue;

    public function getSettingKeys(): array
    {
        return array_merge(parent::getSettingKeys(), [
            self::SLUG,
            self::INPUT_PLACEHOLDER,
            self::TEXT_BEFORE_VALUE,
            self::TEXT_AFTER_VALUE,
        ]);
    }

    public function getValue(Fieldable $fieldable): array
    {
        if (!$this->isValueVisible()) {
            return [];
        }

        $values = [];

        foreach (tdf_currencies() as $currency) {
            $key = $this->getValueKey($currency);

            $values[$key] = $this->rawToFormatted($fieldable->getMeta($key), $currency);
        }

        return $values;
    }

    /**
     * @param  Fieldable  $fieldable
     * @return array
     */
    public function getRawValue(Fieldable $fieldable): array
    {
        if (!$this->isValueVisible()) {
            return [];
        }

        $values = [];

        foreach (tdf_currencies() as $currency) {
            $key = $this->getValueKey($currency);

            $values[$key] = $fieldable->getMeta($key);
        }

        return $values;
    }

    /**
     * @param  Fieldable  $fieldable
     * @return array
     */
    public function getRawValues(Fieldable $fieldable): array
    {

        $values = [];

        foreach (tdf_currencies() as $currency) {
            $key = $this->getValueKey($currency);

            $values[$key] = $fieldable->getMeta($key);
        }

        return $values;
    }

    /**
     * @param  Fieldable  $fieldable
     * @param  mixed  $value
     * @return bool
     */
    public function setValue(Fieldable $fieldable, $value): bool
    {
        foreach (tdf_currencies() as $currency) {
            $key = $this->getValueKey($currency);

            $fieldable->setMeta(
                $key,
                $this->formattedToRaw(($value[$key] ?? ''), $currency)
            );
        }

        return true;
    }

    /**
     * @param  Currency  $currency
     * @return string
     */
    public function getValueKey(Currency $currency): string
    {
        return $this->getKey().'_'.$currency->getKey();
    }

    /**
     * @param  Fieldable  $fieldable
     * @param  Currency|null  $currency
     * @return string
     */
    public function getValueByCurrency(Fieldable $fieldable, ?Currency $currency = null): string
    {
        if ($currency === null) {
            $currency = tdf_app('current_currency');
        }

        $value = $this->getValue($fieldable);
        $valueKey = $this->getValueKey($currency);

        $valueByCurrency = $value[$valueKey] ?? '';
        if (empty($valueByCurrency)) {
            return '';
        }

        if (!empty($this->getTextBeforeValue())) {
            $valueByCurrency = $this->getTextBeforeValue().$valueByCurrency;
        }

        if (!empty($this->getTextAfterValue())) {
            $valueByCurrency .= $this->getTextAfterValue();
        }

        return $valueByCurrency;
    }

    /**
     * @param  Fieldable  $fieldable
     * @param  Currency|null  $currency
     * @return mixed|string
     */
    public function getRawValueByCurrency(Fieldable $fieldable, ?Currency $currency = null)
    {
        if ($currency === null) {
            $currency = tdf_app('current_currency');
        }

        $value = $this->getRawValues($fieldable);
        $valueKey = $this->getValueKey($currency);

        return $value[$valueKey] ?? '';
    }

    /**
     * @param  string  $value
     * @param  Currency  $currency
     * @return string
     * @noinspection PhpMissingParamTypeInspection
     */
    public function rawToFormatted($value, Currency $currency): string
    {
        if (empty($value)) {
            return '';
        }

        if ($currency->isIndian()) {
            $value = $currency->formatIndia($value);
        } else {
            $value = number_format(
                (float) $value,
                $currency->getDecimalPlaces(),
                $currency->getDecimalSeparator(),
                $currency->getThousandsSeparator()
            );
        }

        return $currency->format($value);
    }

    /**
     * @param  string  $value
     * @param  Currency  $currency
     * @return string
     * @noinspection PhpMissingParamTypeInspection
     */
    public function formattedToRaw($value, Currency $currency): string
    {
        if ($currency->isIndian()) {
            $tempValue = str_replace([$currency->getSign(), ','], '', $value);
        } else {
            $tempValue = str_replace([$currency->getSign(), $currency->getThousandsSeparator()], '', $value);
        }

        return (string)str_replace($currency->getDecimalSeparator(), '.', trim($tempValue));
    }

    /**
     * @param  Fieldable  $fieldable
     * @param  bool  $label
     * @return array|string[]
     */
    public function getSimpleTextValue(Fieldable $fieldable, bool $label = false): array
    {
        $value = $this->getValueByCurrency($fieldable);
        if (empty($value)) {
            return [];
        }

        return [$value];
    }

    /**
     * @param  array  $config
     * @return SearchField
     */
    public function getSearchField(array $config): SearchField
    {
        return new SalarySearchField($this, $config);
    }

    /**
     * @return QueryModifier
     */
    public function getQueryModifier(): QueryModifier
    {
        return new SalaryQueryModifier($this);
    }

    /**
     * @return string
     */
    public function getTypeLabel(): string
    {
        return tdf_admin_string('salary');
    }

    /**
     * @param  Fieldable  $fieldable
     * @param  Currency|null  $currency
     * @return string
     */
    public function getHtmlValue(Fieldable $fieldable, ?Currency $currency = null): string
    {
        if ($currency === null && !tdf_current_currency()) {
            return '';
        }

        if ($currency === null) {
            /** @noinspection CallableParameterUseCaseInTypeContextInspection */
            $currency = tdf_current_currency();
        }


        $key = $this->getValueKey($currency);


        $value = $this->rawToFormatted($fieldable->getMeta($key), $currency, true);
        if (empty($value)) {
            return '';
        }

        if (!empty($this->getTextBeforeValue())) {
            $value = '<span class="'.tdf_prefix().'-before-value">'.$this->getTextBeforeValue().'</span>'.$value;
        }

        if (!empty($this->getTextAfterValue())) {
            $value .= '<span class="'.tdf_prefix().'-after-value">'.$this->getTextAfterValue().'</span>';
        }

        return $value;
    }

    /**
     * @param  Fieldable  $fieldable
     * @return mixed
     */
    public function getRestApiValue(Fieldable $fieldable)
    {
        return $this->getSimpleTextValue($fieldable);
    }

}