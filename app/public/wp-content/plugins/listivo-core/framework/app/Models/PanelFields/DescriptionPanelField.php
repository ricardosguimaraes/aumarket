<?php

namespace Tangibledesign\Framework\Models\PanelFields;

use Tangibledesign\Framework\Models\Model;

class DescriptionPanelField extends PanelField
{
    public function getKey(): string
    {
        return 'description';
    }

    public function getLabel(): string
    {
        return tdf_string('description');
    }

    protected function getTemplate(): string
    {
        return 'description';
    }

    public function update(Model $model, array $data = []): void
    {
        $description = $data['description'] ?? '';

        $model->setDescription($description);
    }

    public function isSingleValue(): bool
    {
        return false;
    }

    public function isRequired(): bool
    {
        return tdf_settings()->descriptionRequired();
    }

    public function validate(array $data): bool
    {
        if (!tdf_settings()->descriptionRequired()) {
            return true;
        }

        return !empty($data['description']);
    }

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
            ],
        ];
    }
}