<?php

namespace Tangibledesign\Framework\Models;

use Tangibledesign\Framework\Models\Term\Term;

class Currency extends Term
{
    public const NAME = 'name';
    public const SIGN = 'sign';
    public const SIGN_POSITION = 'sign_position';
    public const SIGN_POSITION_BEFORE = 'before';
    public const SIGN_POSITION_AFTER = 'after';
    public const FORMAT = 'format';
    public const FORMAT_1 = '###,###,###.##';
    public const FORMAT_2 = '#########.##';
    public const FORMAT_3 = '###.###.###,##';
    public const FORMAT_4 = '### ### ###,## ';
    public const FORMAT_5 = '###,###,###';
    public const FORMAT_6 = '### ### ###.##';
    public const FORMAT_7 = '###.###.###';
    public const FORMAT_8 = '##,##,##,###.##';
    public const FORMAT_9 = '### ### ###';
    public const FORMAT_10 = '###\'###\'###';
    public const DYNAMIC_DECIMAL = 'dynamic_decimal';

    public function getSettingKeys(): array
    {
        return [
            self::NAME,
            self::SIGN,
            self::SIGN_POSITION,
            self::FORMAT,
            self::DYNAMIC_DECIMAL,
        ];
    }

    /**
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setFormat($format): void
    {
        $this->setMeta(self::FORMAT, $format);
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        $format = $this->getMeta(self::FORMAT);

        if (empty($format)) {
            return self::FORMAT_1;
        }

        return (string)$format;
    }

    public function setDynamicDecimal($enabled): void
    {
        $this->setMeta(self::DYNAMIC_DECIMAL, (int)$enabled);
    }

    public function dynamicDecimal(): bool
    {
        return !empty((int)$this->getMeta(self::DYNAMIC_DECIMAL));
    }

    /**
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setSign($sign): void
    {
        $this->setMeta(self::SIGN, $sign);
    }

    public function getSign(): string
    {
        $sign = $this->getMeta(self::SIGN);

        if (empty($sign)) {
            return '$';
        }

        return (string)$sign;
    }

    /**
     * @param string $name
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setName($name): void
    {
        $this->setMeta(self::NAME, $name);
    }

    public function getName(): string
    {
        $name = $this->getMeta(self::NAME);

        if (empty($name)) {
            return 'USD';
        }

        return (string)$name;
    }

    /**
     * @param string $signPosition
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setSignPosition($signPosition): void
    {
        $this->setMeta(self::SIGN_POSITION, $signPosition);
    }

    /**
     * @return string
     */
    public function getSignPosition(): string
    {
        $signPosition = $this->getMeta(self::SIGN_POSITION);

        if (empty($signPosition)) {
            return self::SIGN_POSITION_BEFORE;
        }

        return (string)$signPosition;
    }

    public function isSignPositionBefore(): bool
    {
        return $this->getSignPosition() === self::SIGN_POSITION_BEFORE;
    }

    public function isSignPositionAfter(): bool
    {
        return $this->getSignPosition() === self::SIGN_POSITION_AFTER;
    }

    public function isInteger(): bool
    {
        $format = $this->getFormat();

        if (in_array($format, [
            self::FORMAT_5,
            self::FORMAT_7,
            self::FORMAT_8,
            self::FORMAT_9,
            self::FORMAT_10,
        ], true)) {
            return true;
        }

        return false;
    }

    public function isFloat(): bool
    {
        return !$this->isInteger();
    }

    /**
     * @param string $price
     * @return float|int
     * @noinspection PhpMissingParamTypeInspection
     */
    public function parseValue($price)
    {
        if ($price === '') {
            return $price;
        }

        if ($this->isInteger()) {
            return (int)$price;
        }

        return (double)number_format((double)$price, $this->getDecimalPlaces(), '.', '');
    }

    public function getDecimalPlaces(): int
    {
        $format = $this->getFormat();

        if (in_array($format, [
            self::FORMAT_5,
            self::FORMAT_7,
            self::FORMAT_8,
            self::FORMAT_9,
            self::FORMAT_10,
        ], true)) {
            return (int)apply_filters(tdf_prefix() . '/currency/' . $this->getID() . '/decimalPlaces', 0);
        }

        return (int)apply_filters(tdf_prefix() . '/currency/' . $this->getID() . '/decimalPlaces', 2);
    }

    public function getDecimalSeparator(): string
    {
        $format = $this->getFormat();

        if (in_array($format, [
            self::FORMAT_1,
            self::FORMAT_2,
            self::FORMAT_6,
        ], true)) {
            return (string)apply_filters(tdf_prefix() . '/price/decimalSeparator', '.');
        }

        if (in_array($format, [
            self::FORMAT_3,
            self::FORMAT_4,
        ], true)) {
            return (string)apply_filters(tdf_prefix() . '/price/decimalSeparator', ',');
        }

        return (string)apply_filters(tdf_prefix() . '/price/decimalSeparator', '');
    }

    public function getThousandsSeparator(): string
    {
        $format = $this->getFormat();

        if (in_array($format, [
            self::FORMAT_1,
            self::FORMAT_5,
        ], true)) {
            return (string)apply_filters(tdf_prefix() . '/currency/' . $this->getID() . '/thousandsSeparator', ',');
        }

        if (in_array($format, [
            self::FORMAT_3,
            self::FORMAT_7,
        ], true)) {
            return (string)apply_filters(tdf_prefix() . '/currency/' . $this->getID() . '/thousandsSeparator', '.');
        }

        if (in_array($format, [
            self::FORMAT_4,
            self::FORMAT_6,
            self::FORMAT_9,
        ], true)) {
            return (string)apply_filters(tdf_prefix() . '/currency/' . $this->getID() . '/thousandsSeparator', ' ');
        }

        if ($format === self::FORMAT_10) {
            return (string)apply_filters(tdf_prefix() . '/currency/' . $this->getID() . '/thousandsSeparator', '\'');
        }

        return (string)apply_filters(tdf_prefix() . '/currency/' . $this->getID() . '/thousandsSeparator', '');
    }

    public function jsonSerialize(): array
    {
        return parent::jsonSerialize() + [
                self::SIGN => $this->getSign(),
                self::SIGN_POSITION => $this->getSignPosition(),
                self::FORMAT => $this->getFormat(),
                'decimal_separator' => $this->getDecimalSeparator(),
                'decimal_places' => $this->getDecimalPlaces(),
                'thousands_separator' => $this->getThousandsSeparator(),
            ];
    }

    public static function getFormats(): array
    {
        return [
            self::FORMAT_5 => tdf_admin_string('currency_format_5'),
            self::FORMAT_7 => tdf_admin_string('currency_format_7'),
            self::FORMAT_10 => tdf_admin_string('currency_format_10'),
            self::FORMAT_9 => tdf_admin_string('currency_format_9'),
            self::FORMAT_1 => tdf_admin_string('currency_format_1'),
            self::FORMAT_3 => tdf_admin_string('currency_format_3'),
            self::FORMAT_4 => tdf_admin_string('currency_format_4'),
            self::FORMAT_6 => tdf_admin_string('currency_format_6'),
            self::FORMAT_2 => tdf_admin_string('currency_format_2'),
            self::FORMAT_8 => tdf_admin_string('currency_format_8'),
        ];
    }

    public function format(string $price): string
    {
        if ($this->getDecimalPlaces() > 0 && $this->dynamicDecimal()) {
            $price = preg_replace('/' . preg_quote($this->getDecimalSeparator() . '00', '/') . '$/', '', $price);
        }

        $sign = $this->getSign();
        if (empty($sign)) {
            return $price;
        }

        if ($this->getSignPosition() === 'before') {
            return $sign . $price;
        }

        return $price . $sign;
    }

    public function formatHtml(string $price): string
    {
        if ($this->getDecimalPlaces() > 0 && $this->dynamicDecimal()) {
            $price = preg_replace('/' . preg_quote($this->getDecimalSeparator() . '00', '/') . '$/', '', $price);
        }

        $sign = $this->getSign();
        if (empty($sign)) {
            return $price;
        }

        if ($this->getSignPosition() === 'before') {
            return '<span class="' . tdf_prefix() . '-currency-sign">' . $sign . '</span>' . $price;
        }

        return $price . '<span class="' . tdf_prefix() . '-currency-sign">' . $sign . '</span>';
    }

    public function isIndian(): bool
    {
        return $this->getFormat() === self::FORMAT_8;
    }

    public function formatIndia(string $value): string
    {
        if (strpos($value, '.') !== false) {
            [$whole, $decimal] = explode('.', $value);
        } else {
            $whole = $value;
            $decimal = '00';
        }

        if (strlen($whole) < 4) {
            return $whole;
        }

        $lastThree = substr($whole, -3);
        $restUnits = substr($whole, 0, -3);
        $restUnits = strrev(implode(',', str_split(strrev($restUnits), 2)));

        return $restUnits . ',' . $lastThree;
    }
}