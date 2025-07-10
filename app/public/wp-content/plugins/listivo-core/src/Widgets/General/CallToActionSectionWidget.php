<?php


namespace Tangibledesign\Listivo\Widgets\General;


use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Models\Image;
use Tangibledesign\Framework\Models\Page;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TypographyControl;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;


/**
 * Class CallToActionSectionWidget
 * @package Tangibledesign\Listivo\Widgets\General
 */
class CallToActionSectionWidget extends BaseGeneralWidget
{
    use TypographyControl;

    public const SMALL_TEXT = 'small_text';
    public const TEXT = 'text';
    public const ACTION = 'action';
    public const ACTION_LABEL = 'action_label';
    public const ACTION_ICON = 'action_icon';
    public const MAIN_IMAGE = 'main_image';
    public const FIRST_IMAGE = 'first_image';
    public const SECOND_IMAGE = 'second_image';
    public const CUSTOM_URL = 'custom_url';

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'call_to_action_section';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Call To Action Section', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addSmallTextControl();

        $this->addTextControl();

        $this->addMainImageControl();

        $this->addFirstImageControl();

        $this->addSecondImageControl();

        $this->addActionLabelControl();

        $this->addActionIconControl();

        $this->addActionControl();

        $this->addCustomUrlControl();

        $this->endControlsSection();
    }

    public function addMainImageControl(): void
    {
        $this->add_control(
            self::MAIN_IMAGE,
            [
                'label' => esc_html__('Background Image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );
    }

    /**
     * @return Image|false
     */
    public function getMainImage()
    {
        $image = $this->get_settings_for_display(self::MAIN_IMAGE);
        if (!isset($image['id'])) {
            return false;
        }

        return tdf_image_factory()->create((int)$image['id']);
    }

    public function addFirstImageControl(): void
    {
        $this->add_control(
            self::FIRST_IMAGE,
            [
                'label' => esc_html__('First Image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );
    }

    /**
     * @return Image|false
     */
    public function getFirstImage()
    {
        $image = $this->get_settings_for_display(self::FIRST_IMAGE);
        if (!isset($image['id'])) {
            return false;
        }

        return tdf_image_factory()->create((int)$image['id']);
    }

    public function addSecondImageControl(): void
    {
        $this->add_control(
            self::SECOND_IMAGE,
            [
                'label' => esc_html__('Second Image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );
    }

    /**
     * @return Image|false
     */
    public function getSecondImage()
    {
        $image = $this->get_settings_for_display(self::SECOND_IMAGE);
        if (!isset($image['id'])) {
            return false;
        }

        return tdf_image_factory()->create((int)$image['id']);
    }

    private function addTextControl(): void
    {
        $this->add_control(
            self::TEXT,
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
        return (string)$this->get_settings_for_display(self::TEXT);
    }

    private function addSmallTextControl(): void
    {
        $this->add_control(
            self::SMALL_TEXT,
            [
                'label' => esc_html__('Small Text', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'small_text_typography',
                'label' => esc_html__('Small Text Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-cta__small-text',
                'fields_options' => [
                    'typography' => [
                        'default' => 'yes'
                    ],
                    'font_family' => [
                        'default' => 'Alex Brush',
                    ],
                ]
            ]
        );
    }

    /**
     * @return string
     */
    public function getSmallText(): string
    {
        return (string)$this->get_settings_for_display(self::SMALL_TEXT);
    }

    private function addActionControl(): void
    {
        $this->add_control(
            self::ACTION,
            [
                'label' => esc_html__('Action', 'listivo-core'),
                'type' => SelectRemoteControl::TYPE,
                'source' => admin_url('admin-post.php?action=listivo/widget/callToActionSection/options'),
            ]
        );
    }

    private function addCustomUrlControl(): void
    {
        $this->add_control(
            self::CUSTOM_URL,
            [
                'label' => esc_html__('Custom Url', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
                'default' => '#',
                'condition' => [
                    self::ACTION => self::CUSTOM_URL,
                ]
            ]
        );
    }

    private function addActionLabelControl(): void
    {
        $this->add_control(
            self::ACTION_LABEL,
            [
                'label' => esc_html__('Button - Text', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );
    }

    /**
     * @return string
     */
    public function getActionLabel(): string
    {
        $label = (string)$this->get_settings_for_display(self::ACTION_LABEL);
        if (empty($label)) {
            return $this->getDefaultActionLabel();
        }

        return $label;
    }

    private function addActionIconControl(): void
    {
        $this->add_control(
            self::ACTION_ICON,
            [
                'label' => esc_html__('Button - Icon', 'listivo-core'),
                'type' => Controls_Manager::ICONS,
            ]
        );
    }

    /**
     * @return string
     */
    public function getActionIcon(): string
    {
        $icon = $this->get_settings_for_display(self::ACTION_ICON);

        if ($icon['library'] === 'svg') {
            return $icon['value']['url'] ?? '';
        }

        return $icon['value'] ?? '';
    }

    /**
     * @return string
     */
    public function getIconType(): string
    {
        $icon = $this->get_settings_for_display(self::ACTION_ICON);
        return $icon['library'];
    }

    /**
     * @return bool
     */
    public function isSvgIcon(): bool
    {
        return $this->getIconType() === 'svg';
    }

    /**
     * @return string
     */
    public function getActionUrl(): string
    {
        $action = $this->get_settings_for_display(self::ACTION);

        if ($action === 'listing_archive') {
            return (string)get_post_type_archive_link(tdf_model_post_type());
        }

        if ($action === 'custom_url') {
            return (string)$this->get_settings_for_display(self::CUSTOM_URL);
        }

        $page = tdf_post_factory()->create((int)$action);
        if (!$page instanceof Page) {
            return '';
        }

        return $page->getUrl();
    }

    /**
     * @return string
     */
    private function getDefaultActionLabel(): string
    {
        $action = $this->get_settings_for_display(self::ACTION);

        if ($action === 'custom_url') {
            return tdf_string('label');
        }

        if ($action === 'listing_archive') {
            return tdf_string('listings');
        }

        $page = tdf_post_factory()->create((int)$action);
        if (!$page instanceof Page) {
            return tdf_string('label');
        }

        return $page->getName();
    }

}