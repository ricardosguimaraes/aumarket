<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;

class PhoneBoxWidget extends BaseGeneralWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'phone_box';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Phone box', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->add_control(
            'phone',
            [
                'label' => esc_html__('Phone', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->endControlsSection();
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        $phone = (string)$this->get_settings_for_display('phone');
        if (empty($phone)) {
            return tdf_settings()->getPhone();
        }

        return $phone;
    }

    /**
     * @return string
     */
    public function getPhoneUrl(): string
    {
        return (string)apply_filters(tdf_prefix() . '/phoneUrl', $this->getPhone());
    }

}