<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextareaControl;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\HeadingV2Controls;

class MailchimpNewsletterFormV5Widget extends BaseGeneralWidget
{
    use HeadingV2Controls;
    use TextareaControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'mailchimp_newsletter_form_v5';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Mailchimp Newsletter Form V5', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addFirstImageControl();

        $this->addSecondImageControl();

        $this->addHeadingControls();

        $this->addTextControl();

        $this->endControlsSection();

        $this->addHeadingStyleSection();
    }

    protected function addFirstImageControl(): void
    {
        $this->add_control(
            'first_image',
            [
                'label' => esc_html__('First image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );
    }

    /**
     * @return string
     */
    public function getFirstImage(): string
    {
        $image = $this->get_settings_for_display('first_image');

        return $image['url'] ?? '';
    }

    protected function addSecondImageControl(): void
    {
        $this->add_control(
            'second_image',
            [
                'label' => esc_html__('Second image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );
    }

    /**
     * @return string
     */
    public function getSecondImage(): string
    {
        $image = $this->get_settings_for_display('second_image');

        return $image['url'] ?? '';
    }

}