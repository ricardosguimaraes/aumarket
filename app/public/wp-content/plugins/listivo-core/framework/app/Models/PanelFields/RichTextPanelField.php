<?php

namespace Tangibledesign\Framework\Models\PanelFields;

use Tangibledesign\Framework\Models\Field\RichTextField;
use Tangibledesign\Framework\Models\Model;

class RichTextPanelField extends CustomPanelField
{
    /**
     * @var RichTextField
     */
    protected $field;

    /**
     * @return string
     */
    protected function getTemplate(): string
    {
        return 'rich_text';
    }

    /**
     * @param Model $model
     * @param array $data
     */
    public function update(Model $model, array $data = []): void
    {
        $attribute = $this->getAttributeData($data);
        $field = $this->getField();
        /* @var RichTextField $field */
        $field->setValue($model, $attribute['value'] ?? '');
    }

    /**
     * @return bool
     */
    public function isSingleValue(): bool
    {
        return false;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function validate(array $data): bool
    {
        if (!$this->isRequired()) {
            return true;
        }

        $attribute = $this->getAttributeData($data);

        return $attribute && isset($attribute['value']) && !empty($attribute['value']);
    }

    /**
     * @return array
     */
    public function getEditorConfig(): array
    {
        return [
            'media_buttons' => false,
            'quicktags' => false,
            'teeny' => true,
            'wpautop' => false,
            'tinymce' => [
                'plugins' => 'colorpicker, lists, fullscreen, image, wordpress, wpeditimage, wplink, textcolor',
                'toolbar1' => 'forecolor, bold, italic, underline, strikethrough, bullist, numlist, alignleft, aligncenter, alignright, undo, redo, link, fullscreen',
            ]
        ];
    }

    /**
     * @param Model $model
     * @return mixed
     */
    public function getModelAttribute(Model $model)
    {
        return [
            'id' => $this->field->getId(),
            'value' => $this->field->getValue($model),
        ];
    }

}