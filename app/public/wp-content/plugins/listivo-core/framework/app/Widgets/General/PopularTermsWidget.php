<?php


namespace Tangibledesign\Framework\Widgets\General;


use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\PopularTermsControls;

/**
 * Class PopularTermsWidget
 * @package Tangibledesign\Framework\Widgets\General
 */
abstract class PopularTermsWidget extends BaseGeneralWidget
{
    use PopularTermsControls;

    public const TAXONOMIES = 'taxonomies';
    public const RANDOMIZE = 'randomize';
    public const RANDOMIZE_LIMIT = 'randomize_limit';
    public const RANDOMIZE_LIMIT_DEFAULT = 12;

}