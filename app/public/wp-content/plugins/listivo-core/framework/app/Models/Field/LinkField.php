<?php

namespace Tangibledesign\Framework\Models\Field;

use Tangibledesign\Framework\Models\Field\Helpers\HasInputPlaceholder;
use Tangibledesign\Framework\Models\Field\Helpers\HasInputPlaceholderInterface;

class LinkField extends Field implements HasInputPlaceholderInterface, HasRestApiValue
{
    use HasInputPlaceholder;

    public function getTypeLabel(): string
    {
        return tdf_admin_string('link');
    }

    public function getValue(Fieldable $fieldable): string
    {
        if (!$this->isValueVisible()) {
            return '';
        }

        return (string)$fieldable->getMeta($this->getKey());
    }

    /**
     * @param Fieldable $fieldable
     * @param string $value
     * @return bool
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setValue(Fieldable $fieldable, $value): bool
    {
        return $fieldable->setMeta($this->getKey(), (string)$value);
    }

    /**
     * @param Fieldable $fieldable
     * @return string
     * @noinspection PhpMissingReturnTypeInspection
     * @noinspection ReturnTypeCanBeDeclaredInspection
     */
    public function getRestApiValue(Fieldable $fieldable)
    {
        return $this->getValue($fieldable);
    }

    public function getSettingKeys(): array
    {
        return array_merge(parent::getSettingKeys(), [
            self::INPUT_PLACEHOLDER,
        ]);
    }
}