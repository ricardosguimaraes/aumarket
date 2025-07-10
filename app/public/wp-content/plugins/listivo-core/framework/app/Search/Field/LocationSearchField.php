<?php

namespace Tangibledesign\Framework\Search\Field;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\LocationField;

class LocationSearchField extends BaseSearchField
{
    public const PLACEHOLDER = 'location_placeholder';
    public const ASK_FOR_LOCATION = 'location_ask_for_location';
    public const SHOW_MY_LOCATION_BUTTON = 'location_show_my_location_button';
    public const SHOW_RADIUS = 'location_show_radius';
    public const RADIUS_PLACEHOLDER = 'location_radius_placeholder';
    public const RADIUS_VALUES = 'location_radius_values';
    public const DEFAULT_RADIUS = 'location_default_radius';

    protected $field;

    protected $config;

    public function __construct(LocationField $field, array $config)
    {
        $this->field = $field;

        $this->config = $config;
    }

    public function getPlaceholder(): string
    {
        if (empty($this->config[self::PLACEHOLDER])) {
            return $this->field->getName();
        }

        return $this->config[self::PLACEHOLDER];
    }

    public function askForLocation(): bool
    {
        return !empty($this->config[self::ASK_FOR_LOCATION]);
    }

    public function showMyLocationButton(): bool
    {
        return !empty($this->config[self::SHOW_MY_LOCATION_BUTTON]);
    }

    public function showRadiusControl(): bool
    {
        return !empty($this->config[self::SHOW_RADIUS]);
    }

    public function getRadiusPlaceholder(): string
    {
        if (empty($this->config[self::RADIUS_PLACEHOLDER])) {
            return tdf_string('distance');
        }

        return $this->config[self::RADIUS_PLACEHOLDER];
    }

    public function getRadiusOptions(): array
    {
        $unit = tdf_settings()->getMapRadiusUnit();

        return Collection::make($this->getRadiusValues())->map(function ($value) use ($unit) {
            return [
                'label' => '+' . $value . ' ' . tdf_string($unit),
                'value' => $this->calcRadiusValue($value, $unit),
            ];
        })->values();
    }

    public function getRadiusValues(): array
    {
        if (empty($this->config[self::RADIUS_VALUES])) {
            return $this->getDefaultRadiusValues();
        }

        $values = explode(',', $this->config[self::RADIUS_VALUES]);
        if (empty($values) || !is_array($values)) {
            return $this->getDefaultRadiusValues();
        }

        return Collection::make($values)->map(static function ($value) {
            return (int)$value;
        })->values();
    }

    private function getDefaultRadiusValues(): array
    {
        return [10, 20, 30, 40, 50, 75, 100, 150, 200, 250, 500];
    }

    public function getDefaultRadiusOption(): array
    {
        $unit = tdf_settings()->getMapRadiusUnit();
        $value = $this->getDefaultRadiusValue();

        if ($value === '') {
            return [
                'label' => '+' . $value . ' ' . tdf_string($unit),
                'value' => tdf_settings()->getDefaultMapRadiusValue(),
            ];
        }

        return [
            'label' => '+' . $value . ' ' . tdf_string($unit),
            'value' => $this->calcRadiusValue($value, $unit),
        ];
    }

    /**
     * @return int|string
     */
    private function getDefaultRadiusValue()
    {
        if (!isset($this->config[self::DEFAULT_RADIUS])) {
            return '';
        }

        $value = $this->config[self::DEFAULT_RADIUS];
        if ($value === '') {
            return '';
        }

        return (int)$value;
    }

    private function calcRadiusValue(int $value, string $unit): int
    {
        if ($unit === 'km') {
            return $value * 1000;
        }

        return $value * 1609;
    }

    public function jsonSerialize(): array
    {
        $data = [
            'name' => $this->field->getName(),
            'countries' => $this->field->getRestrictedCountries(),
            'defaultRadius' => tdf_settings()->getDefaultMapRadiusValue(),
        ];

        if (!empty($this->field->getSearchType())) {
            $data['searchTypes'] = [$this->field->getSearchType()];
        }

        return parent::jsonSerialize() + $data;
    }

}