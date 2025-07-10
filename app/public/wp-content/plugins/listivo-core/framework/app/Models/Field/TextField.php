<?php


namespace Tangibledesign\Framework\Models\Field;


use Tangibledesign\Framework\Models\Field\Helpers\HasDisplayValueWithFieldName;
use Tangibledesign\Framework\Models\Field\Helpers\HasDisplayValueWithFieldNameInterface;
use Tangibledesign\Framework\Search\Field\TextSearchField;
use Tangibledesign\Framework\Search\HasQueryModifier;
use Tangibledesign\Framework\Search\Query\TextQueryModifier;
use Tangibledesign\Framework\Search\QueryModifier\QueryModifier;
use Tangibledesign\Framework\Search\Searchable;
use Tangibledesign\Framework\Search\SearchField;
use Tangibledesign\Framework\Models\Field\Helpers\HasInputPlaceholder;
use Tangibledesign\Framework\Models\Field\Helpers\HasInputPlaceholderInterface;
use Tangibledesign\Framework\Models\Field\Helpers\HasSlug;
use Tangibledesign\Framework\Models\Field\Helpers\HasSlugInterface;
use Tangibledesign\Framework\Models\Field\Helpers\SimpleTextValue;

/**
 * Class TextField
 * @package Tangibledesign\Framework\Models\Field
 */
class TextField extends Field implements HasSlugInterface, HasInputPlaceholderInterface, SimpleTextValue, Searchable, HasQueryModifier, HasDisplayValueWithFieldNameInterface, HasRestApiValue
{
    use HasSlug;
    use HasInputPlaceholder;
    use HasDisplayValueWithFieldName;

    public const COMPARE_LOGIC = 'compare_logic';
    public const COMPARE_LOGIC_LIKE = 'like';
    public const COMPARE_LOGIC_EQUAL = 'equal';

    /**
     * @param  string  $value
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setCompareLogic($value): void
    {
        $this->setMeta(self::COMPARE_LOGIC, (string) $value);
    }

    /**
     * @return string
     */
    public function getCompareLogic(): string
    {
        $value = (string) $this->getMeta(self::COMPARE_LOGIC);

        if (empty($value)) {
            return self::COMPARE_LOGIC_LIKE;
        }

        return $value;
    }

    /**
     * @return array
     */
    public function getSettingKeys(): array
    {
        return array_merge(parent::getSettingKeys(), [
            self::SLUG,
            self::INPUT_PLACEHOLDER,
            self::COMPARE_LOGIC,
            self::DISPLAY_VALUE_WITH_FIELD_NAME,
        ]);
    }

    /**
     * @param  Fieldable  $fieldable
     * @return string
     */
    public function getValue(Fieldable $fieldable): string
    {
        if (!$this->isValueVisible()) {
            return '';
        }

        return (string) $fieldable->getMeta($this->getKey());
    }

    /**
     * @param  Fieldable  $fieldable
     * @param  string  $value
     * @return bool
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setValue(Fieldable $fieldable, $value): bool
    {
        return $fieldable->setMeta($this->getKey(), (string) $value);
    }

    /**
     * @param  Fieldable  $fieldable
     * @param  bool  $label
     * @return array|string[]
     */
    public function getSimpleTextValue(Fieldable $fieldable, bool $label = false): array
    {
        $value = $this->getValue($fieldable);
        if (empty($value)) {
            return [];
        }

        if (!$label) {
            return [$value];
        }

        return [$this->getName().': '.$value];
    }

    /**
     * @param  array  $config
     * @return SearchField
     */
    public function getSearchField(array $config): SearchField
    {
        return new TextSearchField($this, $config);
    }

    /**
     * @return QueryModifier
     */
    public function getQueryModifier(): QueryModifier
    {
        return new TextQueryModifier($this);
    }

    /**
     * @return string
     */
    public function getTypeLabel(): string
    {
        return tdf_admin_string('text');
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