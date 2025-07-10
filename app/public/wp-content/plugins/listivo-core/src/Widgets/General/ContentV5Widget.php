<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Models\Image;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextareaControl;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\HeadingV2Controls;

class ContentV5Widget extends BaseGeneralWidget
{
    use HeadingV2Controls;
    use TextareaControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'content_v5';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Content section V5', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addImageControl();

        $this->addHeadingControls();

        $this->addTextControl();

        $this->addQuoteControl();

        $this->addFeaturesControl();

        $this->addAwardControls();

        $this->endControlsSection();
    }

    private function addQuoteControl(): void
    {
        $this->add_control(
            'quote',
            [
                'label' => esc_html__('Quote', 'listivo-core'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );
    }

    /**
     * @return string
     */
    public function getQuote(): string
    {
        return (string)$this->get_settings_for_display('quote');
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
     * @return Image|false
     */
    public function getImage()
    {
        $image = $this->get_settings_for_display('image');
        if (empty($image['id'])) {
            return false;
        }

        return tdf_image_factory()->create((int)$image['id']);
    }

    private function addFeaturesControl(): void
    {
        $features = new Repeater();

        $features->add_control(
            'feature',
            [
                'label' => esc_html__('Feature', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'features',
            [
                'label' => esc_html__('Features', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $features->get_controls(),
                'prevent_empty' => false,
            ]
        );
    }

    /**
     * @return array
     */
    public function getFeatures(): array
    {
        $features = $this->get_settings_for_display('features');
        if (empty($features) || !is_array($features)) {
            return [];
        }

        return tdf_collect($features)
            ->map(static function ($feature) {
                return $feature['feature'];
            })
            ->filter(static function ($feature) {
                return !empty($feature);
            })->values();
    }

    private function addAwardControls(): void
    {
        $this->add_control(
            'award_heading',
            [
                'label' => esc_html__('Info box', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'award_value',
            [
                'label' => esc_html__('Value', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'award_text',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );
    }

    /**
     * @return string
     */
    public function getAwardValue(): string
    {
        return (string)$this->get_settings_for_display('award_value');
    }

    /**
     * @return string
     */
    public function getAwardText(): string
    {
        return (string)$this->get_settings_for_display('award_text');
    }

}