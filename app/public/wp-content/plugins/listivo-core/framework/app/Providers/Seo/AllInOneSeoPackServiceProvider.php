<?php

namespace TangibleDesign\Framework\Providers\Seo;

use AIOSEO\Plugin\Common\Meta\Description;
use AIOSEO\Plugin\Common\Meta\Title;

class AllInOneSeoPackServiceProvider extends BaseSeoServiceProvider
{
    public function afterInitiation(): void
    {
        parent::afterInitiation();

        add_filter('aioseo_title', [$this, 'termTitle']);
        add_filter('aioseo_description', [$this, 'termDescription']);
    }

    /**
     * @param string $title
     * @return string
     * @noinspection PhpMissingParamTypeInspection
     */
    public function termTitle($title): string
    {
        remove_filter('aioseo_title', [$this, 'termTitle']);

        if (!is_tax()) {
            return (string)$title;
        }

        if (tdf_settings()->searchOverrideTitleTag()) {
            return $this->getFullTitle();
        }

        $term = $this->getCurrentBreadcrumbTerm();
        if (!$term) {
            return (string)$title;
        }

        /** @noinspection PhpParamsInspection */
        return (new Title())->getTermTitle($term);
    }

    /**
     * @param string $description
     * @return string
     * @noinspection PhpMissingParamTypeInspection
     */
    public function termDescription($description): string
    {
        remove_filter('aioseo_description', [$this, 'termDescription']);

        if (!is_tax()) {
            return (string)$description;
        }

        $term = $this->getCurrentBreadcrumbTerm();
        if (!$term) {
            return (string)$description;
        }

        /** @noinspection PhpParamsInspection */
        return (new Description())->getTermDescription($term);
    }

}