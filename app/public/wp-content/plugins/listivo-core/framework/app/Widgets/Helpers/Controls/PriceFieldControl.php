<?php

namespace Tangibledesign\Framework\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Field\PriceField;

trait PriceFieldControl
{
    use Control;

    protected function addPriceFieldControl(): void
    {
        $options = $this->getPriceFieldOptions();

        if (empty($options)) {
            $this->addNoPriceFieldsControl();
            return;
        }

        if (count($options) === 1) {
            $this->addHiddenPriceField(key($options));
            return;
        }

        $this->add_control(
            'price_field',
            [
                'label' => tdf_admin_string('price_field'),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $options,
            ]
        );
    }

    private function addNoPriceFieldsControl(): void
    {
        $this->add_control(
            'no_price_fields',
            [
                'label' => tdf_admin_string('create_price_field'),
                'type' => Controls_Manager::HEADING,
            ]
        );
    }

    /**
     * @param int $priceFieldId
     * @noinspection PhpMissingParamTypeInspection
     */
    private function addHiddenPriceField($priceFieldId): void
    {
        $this->add_control(
            'price_field',
            [
                'label' => tdf_admin_string('price_field'),
                'type' => Controls_Manager::HIDDEN,
                'default' => $priceFieldId,
            ]
        );
    }

    /**
     * @return array
     */
    private function getPriceFieldOptions(): array
    {
        $options = [];

        foreach (tdf_fields() as $field) {
            if ($field instanceof PriceField) {
                $options[$field->getId()] = $field->getName();
            }
        }

        return $options;
    }

    /**
     * @return Collection|PriceField[]
     */
    public function getPriceFields(): Collection
    {
        $priceFieldIds = $this->get_settings_for_display('price_field');
        if (empty($priceFieldIds) || !is_array($priceFieldIds)) {
            return tdf_price_fields();
        }

        return tdf_collect($priceFieldIds)->map(static function ($priceFieldId) {
            $priceFieldId = (int)$priceFieldId;

            return tdf_price_fields()->find((static function ($priceField) use ($priceFieldId) {
                return $priceField->getId() === $priceFieldId;
            }));
        })->filter(static function ($priceField) {
            return $priceField !== false;
        });
    }

}