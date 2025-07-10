<?php

namespace Tangibledesign\Listivo\Widgets\Listing;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\Helpers\SimpleTextValue;
use Tangibledesign\Framework\Widgets\Helpers\BaseModelSingleWidget;

class ListingAttributesV2Widget extends BaseModelSingleWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'listing_attributes_v2';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Ad Attributes V2', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->add_responsive_control(
            'columns',
            [
                'label' => esc_html__('Columns', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'repeat(1, 1fr)' => esc_html__('1', 'listivo-core'),
                    'repeat(2, 1fr)' => esc_html__('2', 'listivo-core'),
                    'repeat(3, 1fr)' => esc_html__('3', 'listivo-core'),
                    'repeat(4, 1fr)' => esc_html__('4', 'listivo-core'),
                    'repeat(5, 1fr)' => esc_html__('5', 'listivo-core'),
                    'repeat(6, 1fr)' => esc_html__('6', 'listivo-core'),
                ],
                'default' => 'repeat(1, 1fr)',
                'desktop_default' => 'repeat(1, 1fr)',
                'mobile_default' => 'repeat(1, 1fr)',
                'selectors' => [
                    '{{WRAPPER}} .listivo-attributes-v2' => 'grid-template-columns: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'columns_gap',
            [
                'label' => esc_html__('Columns Gap (px)', 'listivo-core'),
                'description' => esc_html__('Columns Gap works only if element contains more than one column',
                    'listivo-core'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                    'size' => 32,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-attributes-v2' => 'grid-column-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'rows_gap',
            [
                'label' => esc_html__('Rows Gap (px)', 'listivo-core'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                    'size' => 15,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-attributes-v2' => 'grid-row-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'limit_at_start',
            [
                'label' => esc_html__('Limit number of attributes at start', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'label_block' => true,
                'default' => '',
            ]
        );

        $this->addFieldsControl();

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    private function addFieldsControl(): void
    {
        $fields = new Repeater();

        $options = $this->getFieldOptions();

        $fields->add_control(
            'id',
            [
                'label' => esc_html__('Field', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => $options,
                'default' => !empty($options) ? key($options) : null,
            ]
        );

        $this->add_control(
            'fields',
            [
                'label' => esc_html__('Fields', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $fields->get_controls(),
            ]
        );
    }

    /**
     * @return array
     */
    private function getFieldOptions(): array
    {
        $options = [];

        foreach (tdf_simple_text_value_fields() as $field) {
            $options[$field->getId()] = $field->getName();
        }

        return $options;
    }

    /**
     * @return Collection
     */
    public function getAttributes(): Collection
    {
        $listing = $this->getModel();
        if (!$listing) {
            return tdf_collect();
        }

        $fields = $this->get_settings_for_display('fields');
        if (!is_array($fields) || empty($fields)) {
            return tdf_collect();
        }

        return tdf_collect($fields)
            ->map(static function (array $field) use ($listing) {
                $fieldId = (int)$field['id'];
                $simpleTextValueField = tdf_simple_text_value_fields()
                    ->find(static function ($field) use ($fieldId) {
                        /* @var SimpleTextValue $field */
                        return $field->getId() === $fieldId;
                    });

                if (!$simpleTextValueField instanceof SimpleTextValue) {
                    return false;
                }

                $value = $simpleTextValueField->getSimpleTextValue($listing);
                if (empty($value)) {
                    return false;
                }

                $field['value'] = implode(', ', $value);
                $field['label'] = $simpleTextValueField->getName();

                return $field;
            })->filter(static function ($field) {
                return $field !== false && $field !== null;
            });
    }

    protected function render(): void
    {
        $columnClasses = [
            'listivo-grid__element',
            'listivo-grid__element--'.$this->get_settings_for_display('columns'),
            'listivo-grid__element--tablet-'.$this->get_settings_for_display('columns_tablet'),
            'listivo-grid__element--mobile-'.$this->get_settings_for_display('columns_mobile'),
        ];

        $this->add_render_attribute('column', 'class', implode(' ', $columnClasses));

        parent::render();
    }

    /**
     * @return bool
     */
    public function showTeaser(): bool
    {
        return $this->getInitialLimit() > 0 && $this->getInitialLimit() < count($this->getAttributes());
    }

    /**
     * @return int
     */
    public function getInitialLimit(): int
    {
        return (int)$this->get_settings_for_display('limit_at_start');
    }

    /**
     * @return Collection
     */
    public function getTeaserAttributes(): Collection
    {
        if ($this->getAttributes()->count() <= $this->getInitialLimit()) {
            return $this->getAttributes();
        }

        return $this->getAttributes()->slice(0, $this->getInitialLimit());
    }

}