<?php


namespace Tangibledesign\Listivo\Widgets\General;


use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\HasPhone;

/**
 * Class PhoneV2Widget
 * @package Tangibledesign\Listivo\Widgets\General
 */
class PhoneV2Widget extends BaseGeneralWidget
{
    use HasPhone;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'phone_v2';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Phone V2', 'listivo-core');
    }

    /**
     * @return string
     */
    protected function getSelector(): string
    {
        return '.' . tdf_prefix() . '-phone-with-icon';
    }

}