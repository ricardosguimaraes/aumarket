<?php

namespace Tangibledesign\Listivo\Elementor;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Tab_Base;

class ListingRowTab extends Tab_Base
{
    /**
     * @return string
     */
    public function get_id(): string
    {
        return 'listivo-listing-row';
    }

    /**
     * @return string
     */
    public function get_title(): string
    {
        return esc_html__('Listivo Listing Row', 'listivo-core');
    }

    /**
     * @return string
     */
    public function get_group(): string
    {
        return 'theme-style';
    }

    /**
     * @return string
     */
    public function get_icon(): string
    {
        return 'eicon-button';
    }

    protected function register_tab_controls(): void
    {
        $this->start_controls_section(
            'listivo_listing_row',
            [
                'label' => esc_html__('Listivo Listing Row', 'listivo-core'),
                'tab' => $this->get_id(),
            ]
        );

        $this->addImageSizeControl();

        $this->end_controls_section();
    }

    private function addImageSizeControl(): void
    {
        $this->add_control(
            'listivo_listing_row_image_size',
            [
                'label' => esc_html__('Image Size', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => tdf_app('image_size_options'),
                'default' => tdf_prefix() . '_360_240',
            ]
        );
    }

}