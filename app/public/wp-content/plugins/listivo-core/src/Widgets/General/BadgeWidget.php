<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\ImageControl;

class BadgeWidget extends BaseGeneralWidget
{
    use ImageControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'badge';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Badge', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addImageControl();

        $this->addValueControl();

        $this->addLabelControl();

        $this->endControlsSection();
    }

    private function addValueControl(): void
    {
        $this->add_control(
            'value',
            [
                'label' => esc_html__('Value', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        $value = $this->get_settings_for_display('value');
        if (empty($value)) {
            return '';
        }

        return (string)$value;
    }

    private function addLabelControl(): void
    {
        $this->add_control(
            'label',
            [
                'label' => esc_html__('Label', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        $label = $this->get_settings_for_display('label');
        if (empty($label)) {
            return '';
        }

        return (string)$label;
    }

}