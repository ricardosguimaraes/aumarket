<?php

namespace Tangibledesign\Listivo\Widgets\Listing;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Field\LinkField;
use Tangibledesign\Framework\Widgets\Helpers\BaseModelSingleWidget;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\ButtonTypeControl;

class ListingLinkFieldWidget extends BaseModelSingleWidget
{
    use ButtonTypeControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'listing_link_field';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Ad Link Field', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->addContentSection();

        $this->addLinkStyleSection();
    }

    private function addContentSection(): void
    {
        $this->startContentControlsSection();

        $this->add_control(
            'field',
            [
                'label' => esc_html__('Field', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => $this->getOptions(),
            ]
        );

        $this->add_control(
            'type',
            [
                'label' => esc_html__('Type', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'button' => esc_html__('Button', 'listivo-core'),
                    'link' => esc_html__('Link', 'listivo-core'),
                ],
                'default' => 'button',
            ]
        );

        $this->addButtonTypeControl('primary_1', '', [
            'condition' => [
                'type' => 'button',
            ]
        ]);

        $this->add_control(
            'text',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'nofollow',
            [
                'label' => esc_html__('Nofollow', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        $type = $this->get_settings_for_display('type');
        if (empty($type)) {
            return 'button';
        }

        return $type;
    }

    /**
     * @return bool
     */
    public function isButtonType(): bool
    {
        return $this->getType() === 'button';
    }

    /**
     * @return bool
     */
    public function isLinkType(): bool
    {
        return $this->getType() === 'link';
    }

    /**
     * @return array
     */
    private function getOptions(): array
    {
        $options = [];

        foreach (tdf_app('link_fields') as $linkField) {
            /* @var LinkField $linkField */
            $options[$linkField->getKey()] = $linkField->getName();
        }

        return $options;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        $listing = $this->getModel();
        if (!$listing) {
            return '';
        }

        $field = $this->getField();
        if (!$field instanceof LinkField) {
            return '';
        }

        $value = $field->getValue($listing);
        if (empty($value)) {
            return '';
        }

        if (strpos($value, 'http') === false) {
            $value = 'https://' . $value;
        }

        return $value;
    }

    /**
     * @return Field|false
     */
    private function getField()
    {
        $fieldKey = $this->get_settings_for_display('field');
        if (empty($fieldKey)) {
            return false;
        }

        return tdf_fields()->find(static function ($field) use ($fieldKey) {
            /* @var Field $field */
            return $field->getKey() === $fieldKey;
        });
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return (string)$this->get_settings_for_display('text');
    }

    private function addLinkStyleSection(): void
    {
        $this->startStyleControlsSection('link_style', esc_html__('Link', 'listivo-core'));

        $this->start_controls_tabs('link_style_tabs');

        $this->start_controls_tab('link_style_normal_tab', [
            'label' => esc_html__('Normal', 'listivo-core'),
        ]);

        $this->add_control(
            'link_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-link-field__link' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'link_typo',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-listing-link-field__link',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('link_style_hover_tab', [
            'label' => esc_html__('Hover', 'listivo-core'),
        ]);

        $this->add_control(
            'link_hover_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-link-field__link:hover' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'link_hover_typo',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-listing-link-field__link:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->endControlsSection();
    }

    /**
     * @return bool
     */
    public function nofollow(): bool
    {
        return !empty((int)$this->get_settings_for_display('nofollow'));
    }

}