<?php

namespace Tangibledesign\Framework\Models\PanelFields;

use Tangibledesign\Framework\Models\Model;

class NamePanelField extends PanelField
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'name';
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return apply_filters(tdf_prefix().'/modelForm/name', tdf_string('name'));
    }

    /**
     * @return string
     */
    protected function getTemplate(): string
    {
        return 'name';
    }

    /**
     * @param  Model  $model
     * @param  array  $data
     */
    public function update(Model $model, array $data = []): void
    {
        // TODO: Implement update() method.
    }

    /**
     * @return bool
     */
    public function isSingleValue(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return tdf_settings()->getAutoGenerateModelTitleFields()->isEmpty() || !tdf_settings()->nameRequired();
    }

    /**
     * @param  array  $data
     * @return bool
     */
    public function validate(array $data): bool
    {
        if (!$this->isRequired()) {
            return true;
        }

        return isset($data['name']) && !empty($data['name']);
    }

}