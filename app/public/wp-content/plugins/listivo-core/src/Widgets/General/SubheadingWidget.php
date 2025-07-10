<?php


namespace Tangibledesign\Listivo\Widgets\General;


use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;

/**
 * Class SubheadingWidget
 * @package Tangibledesign\Listivo\Widgets\General
 */
class SubheadingWidget extends BaseGeneralWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'subheading';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Subheading', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addTextControl();

        $this->addDecorationControl();

        $this->endControlsSection();
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return (string)$this->get_settings_for_display('text');
    }

    private function addTextControl(): void
    {
        $this->add_control(
            'text',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );
    }

    private function addDecorationControl(): void
    {
        $this->add_control(
            'decoration',
            [
                'label' => esc_html__('Decoration', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none' => esc_html__('None', 'listivo-core'),
                    'arrow_left_down' => esc_html__('Arrow Left-Down', 'listivo-core'),
                    'arrow_left_up' => esc_html__('Arrow Left-Up', 'listivo-core'),
                    'arrow_right_down' => esc_html__('Arrow Right-Down', 'listivo-core'),
                    'arrow_right_up' => esc_html__('Arrow Right-Up', 'listivo-core'),
                ],
                'default' => 'none',
            ]
        );
    }

    /**
     * @param string $class
     * @return string
     */
    public function getDecorationClass(string $class): string
    {
        $decoration = $this->get_settings_for_display('decoration');
        if ($decoration === 'arrow_left_down') {
            return $class . '--left-down';
        }

        if ($decoration === 'arrow_left_up') {
            return $class . '--left-up';
        }

        if ($decoration === 'arrow_right_down') {
            return $class . '--right-down';
        }

        if ($decoration === 'arrow_right_up') {
            return $class . '--right-up';
        }

        return '';
    }

}