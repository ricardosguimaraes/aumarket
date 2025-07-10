<?php


namespace Tangibledesign\Framework\Widgets\Helpers\Controls;


use Elementor\Controls_Manager;

/**
 * Trait IncludeExcludedControl
 * @package Tangibledesign\Framework\Widgets\Helpers\Controls
 */
trait IncludeExcludedControl
{
    use Control;

    protected function addIncludeExcludedControl(): void
    {
        $this->add_control(
            'include_excluded',
            [
                'label' => tdf_admin_string('include_excluded'),
                'label_block' => true,
                'description' => tdf_admin_string('include_excluded_desc'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );
    }

    /**
     * @return bool
     */
    public function includeExcluded(): bool
    {
        return !empty($this->get_settings_for_display('include_excluded'));
    }

}