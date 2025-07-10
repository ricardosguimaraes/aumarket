<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\HeadingV2Controls;

class MailchimpNewsletterFormWidget extends BaseGeneralWidget
{
    use HeadingV2Controls;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'mailchimp_newsletter_form';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Mailchimp Newsletter Form', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addHeadingControls();

        $this->addTextControl();

        $this->addImageControl();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addBackgroundControl();

        $this->endControlsSection();
    }

    private function addTextControl(): void
    {
        $this->add_control(
            'text',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return (string)$this->get_settings_for_display('text');
    }

    private function addImageControl(): void
    {
        $this->add_control(
            'image',
            [
                'label' => esc_html__('Image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );
    }

    /**
     * @return array
     */
    public function getImage(): array
    {
        $image = $this->get_settings_for_display('image');
        if (!is_array($image)) {
            return ['url' => '', 'image_id' => 0];
        }

        return $image;
    }

    private function addBackgroundControl(): void
    {
        $this->add_responsive_control(
            'background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-form-with-image-section' => 'background-color: {{VALUE}};',
                ]
            ]
        );
    }

}