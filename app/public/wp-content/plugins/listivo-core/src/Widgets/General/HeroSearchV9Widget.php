<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Widgets\Helpers\Controls\ImageControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextareaControl;

class HeroSearchV9Widget extends HeroSearchWidget
{
    use ImageControl;
    use TextareaControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'hero_search_v9';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Hero Search V9', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addImageControl();

        $this->addMobileImageControl();

        $this->addHeadingControl();

        $this->addTextControl();

        $this->addTermsControl();

        $this->addFieldsControl();

        $this->endControlsSection();
    }

    private function addMobileImageControl(): void
    {
        $this->add_control(
            'mobile_image',
            [
                'label' => esc_html__('Mobile image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );
    }

    /**
     * @return string
     */
    public function getMobileImage(): string
    {
        $image = $this->get_settings_for_display('mobile_image');

        return $image['url'] ?? '';
    }

    private function addFieldsControl(): void
    {
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
    }

}