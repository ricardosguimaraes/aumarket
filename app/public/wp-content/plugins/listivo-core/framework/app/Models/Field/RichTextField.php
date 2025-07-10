<?php

namespace Tangibledesign\Framework\Models\Field;

use Tangibledesign\Framework\Models\Field\Helpers\HasInputPlaceholder;
use Tangibledesign\Framework\Models\Field\Helpers\HasInputPlaceholderInterface;

class RichTextField extends Field
{
    use HasInputPlaceholder;

    public const SIMPLE_EDITOR = 'simple_editor';

    public function getValue(Fieldable $fieldable): string
    {
        if (!$this->isValueVisible()) {
            return '';
        }

        return (string)$fieldable->getMeta($this->getKey());
    }

    public function setValue(Fieldable $fieldable, $value): bool
    {
        return $fieldable->setMeta($this->getKey(), $value);
    }

    public function getSettingKeys(): array
    {
        return array_merge(parent::getSettingKeys(), [
            self::INPUT_PLACEHOLDER,
            self::SIMPLE_EDITOR,
        ]);
    }

    public function getTypeLabel(): string
    {
        return tdf_admin_string('rich_text');
    }

    /**
     * @param int $enable
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setSimpleEditor($enable): void
    {
        $this->setMeta(self::SIMPLE_EDITOR, (int)$enable);
    }

    public function isSimpleEditorEnabled(): bool
    {
        return !empty((int)$this->getMeta(self::SIMPLE_EDITOR));
    }
}