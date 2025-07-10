<?php


namespace Tangibledesign\Framework\Models\Template;


use Tangibledesign\Framework\Models\Template\Helpers\HasLayout;
use Tangibledesign\Framework\Models\Template\Helpers\HasLayoutInterface;

/**
 * Class UserTemplate
 * @package Tangibledesign\Framework\Models\Template
 */
class UserTemplate extends Template implements HasLayoutInterface
{
    use HasLayout;
}