<?php

namespace Tangibledesign\Framework\Models\Field;

interface HasRestApiValue
{
    /**
     * @return mixed
     */
    public function getRestApiValue(Fieldable $fieldable);

}