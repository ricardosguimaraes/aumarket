<?php

namespace Tangibledesign\Framework\Models\User\Helpers;

use Tangibledesign\Framework\Models\Helpers\HasMeta;

trait HasBusinessInformation
{
    use HasMeta;

    /**
     * @param  string  $companyInformation
     * @return void
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setCompanyInformation($companyInformation): void
    {
        $this->setMeta(UserSettingKey::COMPANY_INFORMATION, (string)$companyInformation);
    }

    /**
     * @return string
     */
    public function getCompanyInformation(): string
    {
        if (!$this->isBusinessAccount() || !tdf_settings()->isCompanyInformationEnabled()) {
            return '';
        }

        return (string)$this->getMeta(UserSettingKey::COMPANY_INFORMATION);
    }

    /**
     * @return bool
     */
    public function hasCompanyInformation(): bool
    {
        return !empty($this->getCompanyInformation());
    }

}