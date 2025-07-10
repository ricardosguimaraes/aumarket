<?php

namespace Tangibledesign\Listivo\Widgets\Listing;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\Helpers\SimpleTextValue;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Widgets\Helpers\BaseModelSingleWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SimpleLabelControl;

class ListingAttributesV4Widget extends BaseModelSingleWidget
{
    use SimpleLabelControl;

    public function getKey(): string
    {
        return 'listing_attributes_v4';
    }

    public function getName(): string
    {
        return esc_html__('Ad Attributes V4', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addLabelControl(esc_html__('Ad Attributes', 'listivo-core'));

        $this->addAttributesControl();

        $this->endControlsSection();

        $this->addStyleSection();

        $this->addVisibilitySection();
    }

    private function addAttributesControl(): void
    {
        $fields = new Repeater();

        $fields->add_control(
            'field',
            [
                'label' => esc_html__('Field', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => $this->getOptions(),
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

    private function getOptions(): array
    {
        $fields = [];

        foreach (tdf_simple_text_value_fields() as $field) {
            $fields[$field->getKey()] = $field->getName();
        }

        return $fields;
    }

    /**
     * @return Collection|SimpleTextValue[]
     */
    public function getFields(): Collection
    {
        $fields = $this->get_settings_for_display('fields');

        return tdf_collect($fields)->map(function ($fieldValue) {
            return tdf_simple_text_value_fields()->find(static function ($field) use ($fieldValue) {
                return $field->getKey() === $fieldValue['field'];
            });
        })->filter(static function ($field) {
            return $field !== false && $field !== null;
        });
    }

    public function getValues(Model $model): Collection
    {
        return $this->getFields()->map(static function ($field) use ($model) {
            /** @var SimpleTextValue $field */
            return [
                'name' => $field->getName(),
                'value' => $field->getSimpleTextValue($model),
            ];
        })->filter(static function ($field) {
            return !empty($field['value']);
        });
    }

    private function addStyleSection(): void
    {
        $this->startStyleControlsSection();

        $this->addLabelStyleControls('.listivo-listing-attributes-v4__label');

        $this->add_control(
            'columns_heading',
            [
                'label' => esc_html__('Columns', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label' => esc_html__('Columns', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'grid-template-columns: repeat(1, 1fr)' => '1',
                    'grid-template-columns: repeat(2, 1fr)' => '2',
                    'grid-template-columns: repeat(3, 1fr)' => '3',
                ],
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-attributes-v4__list' => '{{VALUE}}',
                ],
                'default' => 'grid-template-columns: repeat(1, 1fr)',
            ]
        );

        $this->add_responsive_control(
            'gap_between_columns',
            [
                'label' => esc_html__('Gap Between Columns (px)', 'listivo-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-attributes-v4__list' => 'grid-column-gap: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'gap_between_rows',
            [
                'label' => esc_html__('Gap Between Rows (px)', 'listivo-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-attributes-v4__list' => 'grid-row-gap: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'attribute_label',
            [
                'label' => esc_html__('Attribute Label', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'attribute_label_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-attribute-v4__label' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'attribute_label_typography',
                'selector' => '{{WRAPPER}} .listivo-listing-attribute-v4__label',
            ]
        );

        $this->add_control(
            'attribute_value',
            [
                'label' => esc_html__('Attribute Value', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'attribute_value_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-attribute-v4__value' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'attribute_value_typography',
                'selector' => '{{WRAPPER}} .listivo-listing-attribute-v4__value',
            ]
        );

        $this->endControlsSection();
    }

}