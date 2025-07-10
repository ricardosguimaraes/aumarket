<?php


namespace Tangibledesign\Framework\Widgets\Helpers\Controls;


use Elementor\Controls_Manager;

/**
 * Trait HtmlTagControl
 * @package Tangibledesign\Framework\Widgets\Helpers\Controls
 */
trait HtmlTagControl
{
    use Control;

    /**
     * @param string $default
     */
    protected function addHtmlTagControl($default = 'h1'): void
    {
        $this->add_control(
            'html_tag',
            [
                'label' => tdf_admin_string('html_tag'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'div' => 'DIV',
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                ],
                'default' => $default,
            ]
        );
    }

    /**
     * @return string
     */
    public function getHtmlTag(): string
    {
        $htmlTag = $this->get_settings_for_display('html_tag');

        if (empty($htmlTag)) {
            return 'h1';
        }

        return $htmlTag;
    }

}