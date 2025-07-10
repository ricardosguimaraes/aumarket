<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Field\Helpers\SimpleTextValue;
use Tangibledesign\Framework\Models\Field\NumberField;
use Tangibledesign\Framework\Models\Field\PriceField;
use Tangibledesign\Framework\Models\Field\SalaryField;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Field\TextField;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextareaControl;

class CompareAreaWidget extends BaseGeneralWidget
{
    use TextareaControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'compare_area';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Compare Listings', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addTextControl('Aenean porta vehicula felis, malesuada maximus justo egestas euismod dignissim. Praesent maximus condimentum maximus.');

        $this->addFieldsControl();

        $this->endControlsSection();
    }

    private function addFieldsControl(): void
    {
        $fields = new Repeater();

        $fields->add_control(
            'field',
            [
                'label' => esc_html__('Field', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => $this->getFieldsControlOptions(),
            ]
        );

        $this->add_control(
            'fields',
            [
                'label' => esc_html__('Fields', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $fields->get_controls(),
                'prevent_empty' => false,
            ]
        );
    }

    /**
     * @return array
     */
    private function getFieldsControlOptions(): array
    {
        $options = [];

        foreach (tdf_ordered_fields()->filter(static function ($field) {
            return $field instanceof TaxonomyField
                || $field instanceof PriceField
                || $field instanceof SalaryField
                || $field instanceof TextField
                || $field instanceof NumberField;
        }) as $field) {
            /* @var Field $field */
            $options[$field->getKey()] = $field->getName();
        }

        return $options;
    }

    /**
     * @return Collection|Field[]
     */
    public function getFields(): Collection
    {
        $fields = $this->get_settings_for_display('fields');
        if (empty($fields) || !is_array($fields)) {
            return tdf_collect();
        }

        return tdf_collect($fields)
            ->map(static function ($field) {
                return $field['field'];
            })
            ->map(static function ($fieldKey) {
                return tdf_fields()->find(static function ($field) use ($fieldKey) {
                    /* @var Field $field */
                    return $field->getKey() === $fieldKey &&
                        (
                            $field instanceof TaxonomyField
                            || $field instanceof PriceField
                            || $field instanceof SalaryField
                            || $field instanceof NumberField
                            || $field instanceof TextField
                        );
                });
            })->filter(static function ($field) {
                return $field !== false && $field !== null;
            });
    }

    /**
     * @param  SimpleTextValue  $field
     * @return Collection|false
     */
    public function getValues(SimpleTextValue $field)
    {
        $values = tdf_collect();

        foreach (tdf_app('compareModels') as $lstListing) {
            /* @var Model $lstListing */
            $values[] = implode(', ', $field->getSimpleTextValue($lstListing));
        }

        $check = $values->find(static function ($value) {
            return !empty($value);
        });

        if (!$check) {
            return false;
        }

        return $values;
    }


    public function getBreakpoints(): array
    {
        return [
            'mobile' => 767,
            'tablet' => 1024,
        ];
    }

    public function getItemsToShow(): array
    {
        return [
            'mobile' => 1,
            'tablet' => 1,
            'desktop' => 2,
        ];
    }
}