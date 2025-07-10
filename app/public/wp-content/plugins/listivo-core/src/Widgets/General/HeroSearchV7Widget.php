<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Repeater;

class HeroSearchV7Widget extends HeroSearchWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'hero_search_v7';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Hero Search V7', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addHeadingControl();

        $this->addTextControl();

        $this->addTermsControl();

        $this->addFormLabelControl();

        $fields = new Repeater();

        $this->addSearchFieldsControls($fields);

        $this->add_control(
            'fields',
            [
                'label' => esc_html__('Fields', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $fields->get_controls(),
                'prevent_empty' => false,
                'title_field' => "<# "
                    ."let labels = ".json_encode($this->getFieldOptions())."; "
                    ."let label = labels[field]; "
                    ."#>"
                    ."{{{ label }}}",
            ]
        );

        $this->endControlsSection();
    }

    private function addFormLabelControl(): void
    {
        $this->add_control(
            'form_label',
            [
                'label' => esc_html__('Form label', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );
    }

    /**
     * @return string
     */
    public function getFormLabel(): string
    {
        return (string)$this->get_settings_for_display('form_label');
    }

}