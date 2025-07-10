<?php


namespace Tangibledesign\Framework\Widgets\Helpers\Controls;


use Elementor\Controls_Manager;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\PriceField;
use Tangibledesign\Framework\Models\Field\SalaryField;

trait CurrencyFieldsControl
{
    use Control;

    protected function addCurrencyFieldsControl(): void
    {
        $options = $this->getCurrencyFieldsControlOptions();

        if (empty($options)) {
            return;
        }

        if (count($options) === 1) {
            $this->addHiddenCurrencyFieldControl(key($options));
            return;
        }

        $this->add_control(
            'currency_field',
            [
                'label' => tdf_admin_string('field'),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $options,
            ]
        );
    }

    /**
     * @param int $currencyFieldId
     * @noinspection PhpMissingParamTypeInspection
     */
    private function addHiddenCurrencyFieldControl($currencyFieldId): void
    {
        $this->add_control(
            'currency_field',
            [
                'label' => tdf_admin_string('field'),
                'type' => Controls_Manager::HIDDEN,
                'default' => $currencyFieldId,
            ]
        );
    }

    /**
     * @return array
     */
    private function getCurrencyFieldsControlOptions(): array
    {
        $options = [];

        foreach (tdf_currency_fields() as $field) {
            $options[$field->getId()] = $field->getName();
        }

        return $options;
    }

    /**
     * @return Collection|PriceField[]|SalaryField[]
     */
    public function getCurrencyFields(): Collection
    {
        $fieldIds = $this->get_settings_for_display('currency_field');
        if (empty($fieldIds) || !is_array($fieldIds)) {
            return tdf_currency_fields();
        }

        return tdf_collect($fieldIds)->map(static function ($fieldId) {
            return tdf_currency_fields()->find((static function ($currencyField) use ($fieldId) {
                return $currencyField->getId() === (int)$fieldId;
            }));
        })->filter(static function ($currencyField) {
            return $currencyField !== false;
        });
    }

}