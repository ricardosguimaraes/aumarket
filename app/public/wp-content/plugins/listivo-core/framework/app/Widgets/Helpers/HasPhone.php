<?php

namespace Tangibledesign\Framework\Widgets\Helpers;

trait HasPhone
{
    public function getPhone(): string
    {
        return tdf_settings()->getPhone();
    }

    public function getPhoneUrl(): string
    {
        return apply_filters(tdf_prefix() . '/phoneUrl', $this->getPhone(), null);
    }
}