<?php

namespace Tangibledesign\Framework\Models\Template;

use Tangibledesign\Framework\Models\Template\Helpers\HasLayout;
use Tangibledesign\Framework\Models\Template\Helpers\HasLayoutInterface;

class ModelSingleTemplate extends Template implements HasLayoutInterface
{
    use HasLayout;
}