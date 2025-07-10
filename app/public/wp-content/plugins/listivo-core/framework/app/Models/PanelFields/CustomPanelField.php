<?php

namespace Tangibledesign\Framework\Models\PanelFields;

use Tangibledesign\Framework\Models\Field\AttachmentsField;
use Tangibledesign\Framework\Models\Field\EmbedField;
use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Field\GalleryField;
use Tangibledesign\Framework\Models\Field\Helpers\HasInputPlaceholderInterface;
use Tangibledesign\Framework\Models\Field\LinkField;
use Tangibledesign\Framework\Models\Field\LocationField;
use Tangibledesign\Framework\Models\Field\NumberField;
use Tangibledesign\Framework\Models\Field\PriceField;
use Tangibledesign\Framework\Models\Field\RichTextField;
use Tangibledesign\Framework\Models\Field\SalaryField;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Field\TextField;
use Tangibledesign\Framework\Models\Model;

abstract class CustomPanelField extends PanelField
{
    /**
     * @var Field
     */
    protected $field;

    /**
     * @param Field $field
     * @param array $config
     * @param null $model
     */
    public function __construct(Field $field, array $config = [], $model = null)
    {
        parent::__construct($config, $model);

        $this->field = $field;
    }

    public function getId(): int
    {
        return $this->field->getId();
    }

    public function getKey(): string
    {
        return $this->field->getKey();
    }

    public function getLabel(): string
    {
        return $this->field->getName();
    }

    public function getField(): Field
    {
        return $this->field;
    }

    /**
     * @param array $data
     *
     * @return array|false
     */
    protected function getAttributeData(array $data = [])
    {
        if (!isset($data['attributes'])) {
            return false;
        }

        foreach ($data['attributes'] as $attribute) {
            if ((int)$attribute['id'] === $this->getField()->getId()) {
                return $attribute;
            }
        }

        return false;
    }

    /**
     * @param $field
     * @param array $config
     * @return false|CustomPanelField
     */
    public static function create($field, array $config = [])
    {
        if ($field instanceof TaxonomyField) {
            return new TaxonomyPanelField($field, $config);
        }

        if ($field instanceof PriceField) {
            return new PricePanelField($field, $config);
        }

        if ($field instanceof NumberField) {
            return new NumberPanelField($field, $config);
        }

        if ($field instanceof EmbedField) {
            return new EmbedPanelField($field, $config);
        }

        if ($field instanceof TextField) {
            return new TextPanelField($field, $config);
        }

        if ($field instanceof GalleryField) {
            return new GalleryPanelField($field, $config);
        }

        if ($field instanceof LocationField) {
            return new LocationPanelField($field, $config);
        }

        if ($field instanceof AttachmentsField) {
            return new AttachmentsPanelField($field, $config);
        }

        if ($field instanceof RichTextField) {
            return new RichTextPanelField($field, $config);
        }

        if ($field instanceof SalaryField) {
            return new SalaryPanelField($field, $config);
        }

        if ($field instanceof LinkField) {
            return new LinkPanelField($field, $config);
        }

        return false;
    }

    public function isRequired(): bool
    {
        return $this->field->isRequired();
    }

    public function getPlaceholder(): string
    {
        if (!$this->field instanceof HasInputPlaceholderInterface) {
            return '';
        }

        return $this->field->getInputPlaceholder();
    }

    /**
     * @param Model $model
     *
     * @return mixed
     */
    abstract public function getModelAttribute(Model $model);

    public function visibleByUserRole(string $userRole): bool
    {
        return $this->field->isVisibleOnFrontendPanelForUserRole($userRole);
    }

}