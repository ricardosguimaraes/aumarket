<?php


namespace Tangibledesign\Framework\Search\Field;


use Tangibledesign\Framework\Models\Field\TextField;

/**
 * Class TextSearchField
 * @package Tangibledesign\Framework\Search\Field
 */
class TextSearchField extends BaseSearchField
{
    public const PLACEHOLDER = 'text_placeholder';

    /**
     * @var TextField
     */
    protected $field;

    /**
     * @var array
     */
    protected $config;

    /**
     * TextSearchField constructor.
     * @param TextField $field
     * @param array $config
     */
    public function __construct(TextField $field, array $config)
    {
        $this->field = $field;

        $this->config = $config;
    }
    
    /**
     * @return string
     */
    public function getPlaceholder(): string
    {
        $placeholder = $this->config[self::PLACEHOLDER] ?? '';

        if (empty($placeholder)) {
            return $this->field->getName();
        }

        return $placeholder;
    }

}