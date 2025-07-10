<?php

namespace Tangibledesign\Framework\Models\Field\Helpers;

use Tangibledesign\Framework\Models\Field\Fieldable;

interface SimpleTextValue
{

    public function getId(): int;

    public function getName(): string;

    public function getSimpleTextValue(Fieldable $fieldable, bool $label = false): array;

}