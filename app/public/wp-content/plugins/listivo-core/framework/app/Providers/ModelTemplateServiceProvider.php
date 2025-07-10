<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;

class ModelTemplateServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function initiation(): void
    {
        $this->container['model_single_template_type'] = static function () {
            return apply_filters(tdf_prefix().'/templates/modelSingle/type', 'model_single');

        };

        $this->container['model_single_template_name'] = static function () {
            return apply_filters(tdf_prefix().'/templates/modelSingle/name', 'Model Archive');
        };

        $this->container['model_archive_template_type'] = static function () {
            return apply_filters(tdf_prefix().'/templates/modelArchive/type', 'model_archive');
        };

        $this->container['model_archive_template_name'] = static function () {
            return apply_filters(tdf_prefix().'/templates/modelArchive/name', 'model_archive');
        };
    }

}