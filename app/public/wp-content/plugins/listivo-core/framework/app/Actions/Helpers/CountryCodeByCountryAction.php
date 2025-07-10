<?php

namespace Tangibledesign\Framework\Actions\Helpers;

class CountryCodeByCountryAction
{

    public function execute(string $country): string
    {
        $list = tdf_app('phone_codes_by_country_code');

        return (string)($list[$country] ?? '');
    }

}