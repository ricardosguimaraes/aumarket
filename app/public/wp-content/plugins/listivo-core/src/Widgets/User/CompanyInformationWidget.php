<?php

namespace Tangibledesign\Listivo\Widgets\User;

use Tangibledesign\Framework\Widgets\Helpers\BaseUserWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextControls;
use Tangibledesign\Framework\Widgets\Helpers\HasModel;
use Tangibledesign\Framework\Widgets\Helpers\ModelSingleWidget;

class CompanyInformationWidget extends BaseUserWidget implements ModelSingleWidget
{
    use HasModel;
    use TextControls;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'company_information';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Company Information', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->addTextControls('.listivo-company-information');

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    /**
     * @return string
     */
    public function getCompanyInformation(): string
    {
        if (!tdf_settings()->isCompanyInformationEnabled()) {
            return '';
        }

        $user = $this->getUser();
        if (!$user || !$user->isBusinessAccount()) {
            return '';
        }

        return $user->getCompanyInformation();
    }

}