<?php

namespace Tangibledesign\Framework\Providers\Elementor;

use Tangibledesign\Framework\Core\ServiceProvider;

class ElementorSettingsServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('admin_init', [$this, 'checkSettings']);
    }

    public function checkSettings(): void
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        $this->setExperiments();

        $this->setDomOptimization();

        $this->setUnfilteredFilesUpload();

        $this->setColorSchemes();

        $this->setTypographySchemes();

        $this->setCssPrintMethod();

        $this->setSupportedPostTypes();
    }

    private function setExperiments(): void
    {
        $experiments = [
            'elementor_experiment-e_font_icon_svg',
        ];

        foreach ($experiments as $key) {
            update_option($key, 'inactive');
        }
    }

    private function setDomOptimization(): void
    {
        update_option('elementor_experiment-e_dom_optimization', 'active');
    }

    private function setUnfilteredFilesUpload(): void
    {
        update_option('elementor_unfiltered_files_upload', '1');
    }

    private function setColorSchemes(): void
    {
        $disableColors = get_option('elementor_disable_color_schemes');
        if ($disableColors !== 'yes') {
            update_option('elementor_disable_color_schemes', 'yes');
        }
    }

    private function setTypographySchemes(): void
    {
        $disableTypography = get_option('elementor_disable_typography_schemes');
        if ($disableTypography !== 'yes') {
            update_option('elementor_disable_typography_schemes', 'yes');
        }
    }

    private function setCssPrintMethod(): void
    {
        update_option('elementor_css_print_method', 'internal');
    }

    private function setSupportedPostTypes(): void
    {
        $supportedPostTypes = get_option('elementor_cpt_support', ['page', 'post']);
		if(!is_array($supportedPostTypes)) {
			$supportedPostTypes = [];
		}

        if (!in_array(tdf_prefix() . '_template', $supportedPostTypes, true)) {
            $supportedPostTypes[] = tdf_prefix() . '_template';
        }

        if (!in_array('page', $supportedPostTypes, true)) {
            $supportedPostTypes[] = 'page';
        }

        if (!in_array('post', $supportedPostTypes, true)) {
            $supportedPostTypes[] = 'post';
        }

        if (!in_array('tdf_model', $supportedPostTypes, true)) {
            $supportedPostTypes[] = 'tdf_model';
        }

        update_option('elementor_cpt_support', $supportedPostTypes);
    }
}