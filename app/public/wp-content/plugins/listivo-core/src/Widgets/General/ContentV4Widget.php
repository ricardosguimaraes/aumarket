<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Image;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextareaControl;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\HeadingV2Controls;

class ContentV4Widget extends BaseGeneralWidget
{
    use HeadingV2Controls;
    use TextareaControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'content_v4';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Content Section V4', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addImageControl();

        $this->addHeadingControls();

        $this->addTextControl();

        $this->addAttributesControl();

        $this->addAwardBoxControls();

        $this->endControlsSection();
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

    private function addAttributesControl(): void
    {
        $attributes = new Repeater();

        $attributes->add_control(
            'value',
            [
                'label' => esc_html__('Value', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $attributes->add_control(
            'after_value',
            [
                'label' => esc_html__('After Value', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $attributes->add_control(
            'label',
            [
                'label' => esc_html__('Label', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'attributes',
            [
                'label' => esc_html__('Attributes', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $attributes->get_controls(),
                'prevent_empty' => false,
            ]
        );
    }

    /**
     * @return Collection
     */
    public function getAttributes(): Collection
    {
        $attributes = $this->get_settings_for_display('attributes');
        if (empty($attributes) || !is_array($attributes)) {
            return tdf_collect();
        }

        return tdf_collect($attributes)
            ->map(static function ($attribute) {
                if (empty($attribute['value']) || empty($attribute['label'])) {
                    return false;
                }

                return $attribute;
            })
            ->filter(static function ($attribute) {
                return $attribute !== false;
            });
    }

    private function addAwardBoxControls(): void
    {
        $this->add_control(
            'info_box',
            [
                'label' => esc_html__('Info box', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'award_image',
            [
                'label' => esc_html__('Image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'award_heading',
            [
                'label' => esc_html__('Heading', 'listivo-core'),
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
    public function getAwardImage(): string
    {
        $image = $this->get_settings_for_display('award_image');

        return $image['url'] ?? '';
    }

    /**
     * @return string
     */
    public function getAwardHeading(): string
    {
        return $this->get_settings_for_display('award_heading');
    }

    /**
     * @return string
     */
    public function getAwardText(): string
    {
        return $this->get_settings_for_display('award_text');
    }

}