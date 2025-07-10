<?php


namespace Tangibledesign\Framework\Models\Field;


use Tangibledesign\Framework\Models\Field\Helpers\HasInputPlaceholder;
use Tangibledesign\Framework\Models\Field\Helpers\HasInputPlaceholderInterface;

/**
 * Class EmbedField
 * @package Tangibledesign\Framework\Models\Field
 */
class EmbedField extends Field implements HasInputPlaceholderInterface, HasRestApiValue
{
    use HasInputPlaceholder;

    public const ALLOW_RAW_HTML = 'allow_raw_html';
    public const URL = 'url';
    public const EMBED = 'embed';

    /**
     * @param int $allow
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setAllowRawHtml($allow): void
    {
        $this->setMeta(self::ALLOW_RAW_HTML, (int)$allow);
    }

    /**
     * @return bool
     */
    public function allowRawHtml(): bool
    {
        return !empty((int)$this->getMeta(self::ALLOW_RAW_HTML));
    }

    /**
     * @return array
     */
    public function getSettingKeys(): array
    {
        return array_merge(parent::getSettingKeys(), [
            self::ALLOW_RAW_HTML,
            self::INPUT_PLACEHOLDER,
        ]);
    }

    /**
     * @param Fieldable $fieldable
     * @return string[]
     */
    public function getValue(Fieldable $fieldable): array
    {
        if (!$this->isValueVisible()) {
            return [
                self::URL => '',
                self::EMBED => '',
            ];
        }

        $value = $fieldable->getMeta($this->getKey());

        if (!is_array($value) || !isset($value[self::URL], $value[self::EMBED])) {
            return [
                self::URL => '',
                self::EMBED => '',
            ];
        }

        return $value;
    }

    /**
     * @param Fieldable $fieldable
     * @param array $value
     * @return bool
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setValue(Fieldable $fieldable, $value): bool
    {
        return $fieldable->setMeta($this->getKey(), $value);
    }

    /**
     * @param Fieldable $fieldable
     * @return string
     */
    public function getEmbedCode(Fieldable $fieldable): string
    {
        $value = $this->getValue($fieldable);

        if ((!isset($value[self::EMBED]) || empty($value[self::EMBED])) && $this->allowRawHtml()) {
            return $value[self::URL] ?? '';
        }

        return $value[self::EMBED] ?? '';
    }

    /**
     * @return string
     */
    public function getTypeLabel(): string
    {
        return tdf_admin_string('embed');
    }

    /**
     * @param Fieldable $fieldable
     * @return mixed|string[]
     */
    public function getRestApiValue(Fieldable $fieldable)
    {
        return $this->getValue($fieldable);
    }

}